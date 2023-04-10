<?php

namespace Expressionengine\Coilpack\View\Tags\Email;

use Expressionengine\Coilpack\Models\Addon\Action;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\FormTag;

class ContactForm extends FormTag
{
    use InteractsWithAddon;

    protected $_user_recipients = false;

    protected $arguments = [
        'recipients' => null,
        'channel' => null,
    ];

    protected $attributes;

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
            new Parameter([
                'name' => 'markdown',
                'type' => 'boolean',
                'description' => 'Enable processing of markdown in the message field',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'replyto',
                'type' => 'boolean',
                'description' => 'Use the sender email address in the Reply-To field',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'recipients',
                'type' => 'string',
                'description' => 'Comma separated list of email addresses',
            ]),
            new Parameter([
                'name' => 'user_recipients',
                'type' => 'boolean',
                'description' => 'Whether the form will accept recipients from user input via a \'to\' field',
                'defaultValue' => false,
            ]),
        ]);
    }

    public function __construct()
    {
        $this->addonInstance = $this->getAddonInstance('email');

        // Load the form helper and session library
        ee()->load->helper('form');
        ee()->load->library('session');

        // Conditionals
        $data = [
            'logged_in' => (ee()->session->userdata('member_id') != 0),
            'logged_out' => (ee()->session->userdata('member_id') == 0),
            'captcha' => null,
        ];

        if ($this->addonInstance->use_captchas == 'y' && ee()->config->item('use_recaptcha') == 'y') {
            $captcha = ee('Captcha')->create();
            $data['captcha'] = $captcha;
        }

        // Process default variables
        $postVars = ['message', 'name', 'to', 'from', 'subject', 'required'];
        foreach ($postVars as $key) {
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

        foreach ($memberVars as $key => $value) {
            $data[$key] = \form_prep(ee()->functions->encode_ee_tags($value, true));
        }

        $data['current_time'] = \Carbon\Carbon::now();

        $this->attributes = $data;
    }

    public function open($data = [])
    {
        // Recipient Email Checking
        $this->_user_recipients = $this->getArgument('user_recipients')->value;

        $recipients = $this->getArgument('recipients')->value;

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
            'replyto' => $this->getArgument('replyto')->value ? 'yes' : 'no',
            'markdown' => $this->encrypt(($this->getArgument('markdown')) ? 'y' : 'n'),
        ];

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

            $table = (! is_numeric($entry_id)) ? 'ct.url_title' : 'ct.entry_id';

            $query = ee()->db->select('m.username, m.email, m.screen_name')
            ->from(['channel_titles ct', 'members m'])
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

    public function __isset($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function __get($key)
    {
        return (array_key_exists($key, $this->attributes)) ? $this->attributes[$key] : null;
    }
}
