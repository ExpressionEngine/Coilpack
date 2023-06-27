<?php

namespace Expressionengine\Coilpack\View\Tags\Comment;

use Expressionengine\Coilpack\TemplateOutput;
use Expressionengine\Coilpack\View\AddonTag;

class Preview extends AddonTag
{
    protected $signature = 'comment:preview';

    public function run()
    {
        $entry_id = (isset($_POST['entry_id'])) ? $_POST['entry_id'] : ee()->uri->query_string;

        if (! is_numeric($entry_id) or empty($_POST['comment'])) {
            return TemplateOutput::make()->value([]);
        }

        /** ----------------------------------------
        /**  Instantiate Typography class
        /** ----------------------------------------*/
        ee()->load->library('typography');
        ee()->typography->initialize(
            [
                'parse_images' => false,
                'allow_headings' => false,
                'encode_email' => false,
                'word_censor' => (ee()->config->item('comment_word_censoring') == 'y') ? true : false,
            ]
        );

        ee()->db->select('channels.comment_text_formatting, channels.comment_html_formatting, channels.comment_allow_img_urls, channels.comment_auto_link_urls, channels.comment_max_chars');
        ee()->db->where('channel_titles.channel_id = '.ee()->db->dbprefix('channels').'.channel_id');
        ee()->db->where('channel_titles.entry_id', $entry_id);
        ee()->db->from(['channels', 'channel_titles']);

        $query = ee()->db->get();

        if ($query->num_rows() == 0) {
            return TemplateOutput::make()->value([]);
        }

        /** -------------------------------------
        /**  Check size of comment
        /** -------------------------------------*/
        if ($query->row('comment_max_chars') != '' and $query->row('comment_max_chars') != 0) {
            if (strlen($_POST['comment']) > $query->row('comment_max_chars')) {
                $str = str_replace('%n', strlen($_POST['comment']), ee()->lang->line('cmt_too_large'));

                $str = str_replace('%x', $query->row('comment_max_chars'), $str);

                return ee()->output->show_user_error('submission', $str);
            }
        }

        $formatting = 'none';

        if ($query->num_rows()) {
            $formatting = $query->row('comment_text_formatting');
        }

        //
        // -------------------------------------------

        /** ----------------------------------------
        /**  Set defaults based on member data as needed
        /** ----------------------------------------*/
        $data = [
            'name' => ee()->input->post('name', true),
            'email' => ee()->input->post('email', true), // this is just for preview, actual submission will validate the email address
            'url' => ee()->input->post('url', true),
            'location' => ee()->input->post('location', true),
            'comment_date' => ee()->localize->now,
        ];

        if (ee()->session->userdata('member_id') != 0) {
            $data['name'] = ee()->session->userdata('screen_name') ? ee()->session->userdata('screen_name') : ee()->session->userdata('username');
            $data['email'] = ee()->session->userdata('email');
        }

        $data['logged_in'] = (ee()->session->userdata('member_id') == 0) ? false : true;
        $data['logged_out'] = (ee()->session->userdata('member_id') != 0) ? false : true;

        // Prep the URL
        if ($data['url'] != '') {
            ee()->load->helper('url');
            $data['url'] = ee('Format')->make('Text', $data['url'])->url();
        }

        $data['email_encoded'] = ee()->typography->encode_email($data['email'], '', 0);

        // -------------------------------------------
        // 'comment_preview_comment_format' hook.
        //  - Play with the tagdata contents of the comment preview
        //
        if (ee()->extensions->active_hook('comment_preview_comment_format') === true) {
            $data['comment'] = ee()->extensions->call('comment_preview_comment_format', $query->row());
            if (ee()->extensions->end_script === true) {
                return TemplateOutput::make()->value([]);
            }
        } else {
            $data['comment'] = ee()->typography->parse_type(
                ee()->input->post('comment'),
                [
                    'text_format' => $query->row('comment_text_formatting'),
                    'html_format' => $query->row('comment_html_formatting'),
                    'auto_links' => $query->row('comment_auto_link_urls'),
                    'allow_img_url' => $query->row('comment_allow_img_urls'),
                ]
            );
        }

        return TemplateOutput::make()->value($data);
    }
}
