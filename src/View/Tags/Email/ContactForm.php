<?php

namespace Expressionengine\Coilpack\View\Tags\Email;

use Expressionengine\Coilpack\View\FormTag;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\Models\Addon\Action;

class ContactForm extends FormTag
{
    use InteractsWithAddon;

    protected $_user_recipients = false;

    protected $parameters = [
        'recipients' => null,
        'channel' => null,
        'formId' => 'contact_form',
    ];

    protected $attributes;

    public function __construct()
    {
        $this->addonInstance = $this->getAddonInstance('email');

        // Load the form helper and session library
        ee()->load->helper('form');
        ee()->load->library('session');

        // Conditionals
        $data = array(
            'logged_in' => (ee()->session->userdata('member_id') != 0),
            'logged_out' => (ee()->session->userdata('member_id') == 0),
            'captcha' => null,
        );

        if ($this->addonInstance->use_captchas == 'y' && ee()->config->item('use_recaptcha') == 'y') {
            $captcha = ee('Captcha')->create();
            $data['captcha'] = $captcha;
        }

        // Process default variables
        $postVars = ['message', 'name', 'to', 'from', 'subject', 'required'];
        foreach($postVars as $key ) {
            // Adding slashes since they removed in _setup_form
            $var = addslashes(
                \form_prep(
                    ee()->functions->encode_ee_tags(
                        ee()->input->post($key, true),
                        true
                    ),
                    $key
                )
            );

            $data[$key] = $var;
        }

        $memberVars = [
            'member_name' => (ee()->session->userdata['screen_name'] != '') ? ee()->session->userdata['screen_name'] : ee()->session->userdata['username'],
            'member_email' => (ee()->session->userdata['email'] == '') ? '' : ee()->session->userdata['email'],
        ];

        foreach($memberVars as $key => $value) {
            $data[$key] = \form_prep(ee()->functions->encode_ee_tags($value, true));
        }

        $data['current_time'] = \Carbon\Carbon::now();

        // Create form
        // return $this->_setup_form(
        //     $tagdata,
        //     $recipients,
        //     array(
        //         'form_id' => 'contact_form',
        //         'markdown' => \get_bool_from_string(ee()->TMPL->fetch_param('markdown'))
        //     )
        // );

        $this->attributes = $data;
    }

    public function setUserRecipientsParameter($enable) {
        return \get_bool_from_string($enable);
    }

    public function open($data = array())
    {
        // Recipient Email Checking
        $this->_user_recipients = \get_bool_from_string(
            ee()->TMPL->fetch_param('user_recipients', 'no')
        );

        $recipients = $this->recipients;

        // No email left behind act
        if (! $this->_user_recipients && empty($recipients)) {
            $recipients = ee()->config->item('webmaster_email');
        }

        // Clean and check emails, if any
        if ($recipients != '') {
            $array = $this->addonInstance->validate_recipients($recipients);

            // Put together into string again
            $recipients = implode(',', $array['approved']);
        }

        $data = [
            'ACT' => Action::fetch_action_id('Email', 'send_email'),
            'PRV' => '', // We are not handling previews
            'recipients' => $this->encrypt($recipients),
            'user_recipients' => $this->encrypt(($this->_user_recipients) ? 'y' : 'n'),
            'replyto' => $this->replyTo,
            'markdown' => $this->encrypt(($this->markdown) ? 'y' : 'n')
        ];

        if ($this->name && preg_match("#^[a-zA-Z0-9_\-]+$#i", $this->name, $match)) {
            $data['name'] = $this->name;
        }

        return parent::open(['hidden_fields' => $data]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function loadAuthorData()
    {
        if (ee()->uri->query_string != '') {
            $entry_id = ee()->uri->query_string;

            if ($channel != '') {
                ee()->db->join('channels c', 'c.channel_id = ct.channel_id', 'left');
                ee()->functions->ar_andor_string($channel, 'c.channel_name');
            }

            $table = (!is_numeric($entry_id)) ? 'ct.url_title' : 'ct.entry_id';

            $query = ee()->db->select('m.username, m.email, m.screen_name')
            ->from(array('channel_titles ct', 'members m'))
            ->where('m.member_id = ct.author_id', '', false)
            ->where($table, $entry_id)
                ->get();

            if ($query->num_rows() == 0) {
                $author_name = '';
            } else {
                $author_name = ($query->row('screen_name') != '') ? $query->row('screen_name') : $query->row('username');
            }

            $author_email = ($query->num_rows() == 0) ? '' : $query->row('email');
        }
    }

    public function __get($key)
    {
        return (array_key_exists($key, $this->attributes)) ? $this->attributes[$key] : null;
    }

}
