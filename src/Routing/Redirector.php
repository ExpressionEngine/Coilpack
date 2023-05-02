<?php

namespace Expressionengine\Coilpack\Routing;

use Illuminate\Routing\Redirector as BaseRedirector;

class Redirector extends BaseRedirector
{
    /**
     * Create a new redirect response.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createRedirect($path, $status, $headers)
    {
        // Use the ExpressionEngine redirect() function behavior during CP requests
        if (defined('REQ') && REQ == 'CP') {
            return $this->invokeEERedirect($path, $status);
        }

        return parent::createRedirect($path, $status, $headers);
    }

    protected function invokeEERedirect($uri = '', $http_response_code = 302, $method = 'auto')
    {
        // Remove hard line breaks and carriage returns
        $uri = str_replace(["\n", "\r"], '', $uri);

        // Remove any and all line breaks
        while (stripos($uri, '%0d') !== false or stripos($uri, '%0a') !== false) {
            $uri = str_ireplace(['%0d', '%0a'], '', $uri);
        }

        if (! preg_match('#^https?://#i', $uri)) {
            $uri = ee()->config->site_url($uri);
        }

        // IIS environment likely? Use 'refresh' for better compatibility
        if (DIRECTORY_SEPARATOR != '/' && $method == 'auto') {
            $method = 'refresh';
        }

        switch ($method) {
            case 'refresh':
                header('Refresh:0;url='.$uri);

                break;
            default:
                header('Location: '.$uri, true, $http_response_code);

                break;
        }
        exit;
    }
}
