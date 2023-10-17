<?php

namespace Expressionengine\Coilpack;

class Response
{
    /**
     * Transform ee()->output data to a Laravel response.
     * This code is taken from EE_Output::_display() with some modifications
     *
     * @param  int  $status
     * @return Illuminate\Http\Response
     */
    public static function fromOutput($status = 200)
    {
        $output = ee()->output->final_output;

        // Generate No-Cache Headers

        if (ee()->config->item('send_headers') == 'y' && ee()->output->out_type != 'feed' && ee()->output->out_type != '404' && ee()->output->out_type != 'cp_asset') {
            ee()->output->set_status_header($status);

            if (! ee('Response')->hasHeader('Expires')) {
                ee()->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            }

            if (! ee('Response')->hasHeader('Last-Modified')) {
                ee()->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            }

            if (! ee('Response')->hasHeader('Pragma')) {
                ee()->output->set_header('Pragma: no-cache');
            }
        }

        // Content Type Headers
        // Also need to do some extra work for feeds

        switch (ee()->output->out_type) {
            case 'webpage':
                if (! ee('Response')->hasHeader('Content-Type')) {
                    ee()->output->set_header('Content-Type: text/html; charset='.ee()->config->item('charset'));
                }

                break;
            case 'css':
                if (! ee('Response')->hasHeader('Content-Type')) {
                    ee()->output->set_header('Content-type: text/css');
                }

                break;
            case 'js':
                if (! ee('Response')->hasHeader('Content-Type')) {
                    ee()->output->set_header('Content-type: text/javascript');
                }
                ee()->output->enable_profiler = false;

                break;
            case '404':
                ee()->output->set_status_header(404);
                ee()->output->set_header('Date: '.gmdate('D, d M Y H:i:s').' GMT');

                break;
            case 'xml':
                if (! ee('Response')->hasHeader('Content-Type')) {
                    ee()->output->set_header('Content-Type: text/xml');
                }
                $output = trim($output);

                break;
            case 'feed':
                ee()->output->_send_feed($output);

                break;
            default: // Likely a custom template type
                // -------------------------------------------
                // 'template_types' hook.
                //  - Provide information for custom template types.
                //
                $template_types = ee()->extensions->call('template_types', []);
                //
                // -------------------------------------------

                if (isset($template_types[ee()->output->out_type])) {
                    // Set custom headers as defined by the template_headers key,
                    // and replace any headers as necessary
                    if (isset($template_types[ee()->output->out_type]['template_headers'])) {
                        foreach ($template_types[ee()->output->out_type]['template_headers'] as $header) {
                            ee()->output->set_header($header, true);
                        }
                    }
                }

                break;
        }

        // Compress the output
        // We simply set the ci config value to true

        if (ee()->config->item('gzip_output') == 'y' and REQ == 'PAGE') {
            ee()->config->set_item('compress_output', true);
        }

        // Send FLOC headers
        if (REQ == 'PAGE' && ee()->config->item('enable_floc') !== 'y') {
            ee()->output->set_header('Permissions-Policy: interest-cohort=()');
        }

        // Parse query count
        if (REQ != 'CP') {
            $output = str_replace(LD.'total_queries'.RD, ee()->db->query_count, $output);
        }

        // Note:  We use globals because we can't use $CI =& get_instance()
        // since this function is sometimes called by the caching mechanism,
        // which happens before the CI super object is available.
        global $BM, $CFG;

        // --------------------------------------------------------------------

        // Set the output data
        if ($output == '') {
            $output = &ee()->output->final_output;
        }

        // --------------------------------------------------------------------

        // Do we need to write a cache file?
        if (ee()->output->cache_expiration > 0) {
            ee()->output->_write_cache($output);
        }

        // --------------------------------------------------------------------

        // Parse out the elapsed time and memory usage,
        // then swap the pseudo-variables with the data

        $elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

        if (ee()->output->parse_exec_vars === true) {
            $memory = (! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage() / 1024 / 1024, 2).'MB';

            $output = str_replace('{elapsed_time}', $elapsed, $output);
            $output = str_replace('{memory_usage}', $memory, $output);
        }

        // --------------------------------------------------------------------

        // // Is compression requested?
        // // if PHP errors have been output by our exception handler, we can't change encodings mid-stream, so also check for our error handling class having been loaded
        // if ($CFG->item('compress_output') === true && ee()->output->_zlib_oc == false) {
        //     // can't change encodings mid-stream, if we've already displayed PHP errors, we cannot Gzip the rest of the output
        //     $error_out = false;
        //     if (class_exists('EE_Exceptions')) {
        //         $exceptions = load_class('Exceptions', 'core');
        //         $error_out = $exceptions->hasOutputPhpErrors();
        //     }

        //     if (!$error_out && extension_loaded('zlib')) {
        //         if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) and strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
        //             ob_start('ob_gzhandler');
        //         }
        //     }
        // }

        // --------------------------------------------------------------------

        // // Are there any server headers to send?
        // if (count(ee()->output->headers) > 0) {
        //     foreach (ee()->output->headers as $header) {
        //         @header($header[0], $header[1]);
        //     }
        // }

        // --------------------------------------------------------------------
        // Include PRO stuff
        $inEEInstallMode = is_dir(SYSPATH.'ee/installer/') && (! defined('INSTALL_MODE') or INSTALL_MODE != false);
        if (! $inEEInstallMode) {
            $output = ee('pro:Dock')->buildOutput($output);
        }
        if (REQ == 'PAGE' || (REQ == 'ACTION' && ee('LivePreview')->hasEntryData())) {
            if (isset(ee()->TMPL) && is_object(ee()->TMPL) && in_array(ee()->TMPL->template_type, ['webpage'])) {
                $output = preg_replace("/\{frontedit_link\s+(.*)\}/sU", '', $output);
                $output = preg_replace("/\<\!--\s*(\/\/\s*)*disable\s*frontedit\s*--\>/sU", '', $output);
            }
        }
        // --------------------------------------------------------------------

        // Do we need to generate profile data?
        // If so, load the Profile service and run it.
        if (ee()->output->enable_profiler == true && (! (AJAX_REQUEST or ee('LivePreview')->hasEntryData()))) {
            $performance = [
                'database' => number_format(ee('Database')->currentExecutionTime(), 4),
                'benchmarks' => ee()->benchmark->getBenchmarkTimings(),
            ];

            $profiler = ee('Profiler')
                ->addSection('performance', $performance)
                ->addSection('variables', [
                    'server' => $_SERVER,
                    'cookie' => $_COOKIE,
                    'get' => $_GET,
                    'post' => $_POST,
                    'userdata' => ee()->session->all_userdata(),
                ])
                ->addSection('database', [ee('Database')]);

            // Add the template debugger to the output

            if (
                isset(ee()->TMPL) &&
                is_object(ee()->TMPL) &&
                isset(ee()->TMPL->debugging) &&
                ee()->TMPL->debugging === true &&
                ee()->TMPL->template_type != 'js'
            ) {
                $profiler->addSection('template', ee()->TMPL->log);
            }

            if (REQ == 'CP') {
                $output = str_replace('<div id="output_profiler"></div>', $profiler->render(), $output);
            } else {
                $output = ee()->output->add_to_foot($output, $profiler->render());
            }
        }

        if (REQ == 'PAGE') {
            /* -------------------------------------------
            /*  Hidden Configuration Variables
            /*  - remove_unparsed_vars => Whether or not to remove unparsed EE variables
            /*  This is most helpful if you wish for debug to be set to 0, as EE will not
            /*  strip out javascript.
            /* -------------------------------------------*/
            $remove_vars = (ee()->config->item('remove_unparsed_vars') == 'y');
            ee()->output->remove_unparsed_variables($remove_vars);

            if (
                ee()->config->item('debug') == 0 &&
                ee()->output->remove_unparsed_variables === true
            ) {
                $output = preg_replace('/'.LD."[^;\n]+?".RD.'/', '', $output);
            }

            // Garbage Collection
            ee()->core->_garbage_collection();
        }

        // --------------------------------------------------------------------

        log_message('debug', 'Final output sent to browser');
        log_message('debug', 'Total execution time: '.$elapsed);

        // This is a list of headers that we will not pass along
        // - Content-Length may have changed by the time we output
        $exclude = ['content-length'];

        // Transform headers that have already been set on the request
        // to the correct format ["header_name" => "value"]
        $headers = array_reduce(headers_list(), function ($carry, $header) use ($exclude) {
            $pieces = explode(': ', $header);
            if (count($pieces) !== 2) {
                return $carry;
            }
            if (! in_array(strtolower($pieces[0]), $exclude)) {
                $carry[$pieces[0]] = $pieces[1];
            }

            // Remove the already set header to avoid duplicates in the response
            header_remove($pieces[0]);

            return $carry;
        }, []);

        // Transform and set headers that have been assigned to the Output class
        // but not yet set on the request to be ["header_name" => "value"]
        foreach (ee()->output->headers as $row) {
            $header = explode(': ', $row[0]);
            $replace = $row[1];

            // If this header has not already been set, or if we are replacing it set the value
            if (! in_array(strtolower($header[0]), $exclude) && (! array_key_exists($header[0], $headers) || $replace)) {
                $headers[$header[0]] = $header[1];
            }
        }

        return new \Illuminate\Http\Response($output, $status, $headers);
    }
}
