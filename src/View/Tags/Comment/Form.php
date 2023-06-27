<?php

namespace Expressionengine\Coilpack\View\Tags\Comment;

use Expressionengine\Coilpack\Models\Addon\Action;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\FormTag;

class Form extends FormTag
{
    use InteractsWithAddon;

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
            new Parameter([
                'name' => 'entry_id',
                'type' => 'string',
                'description' => 'Display a comment form for a specific channel entry',
            ]),
            new Parameter([
                'name' => 'preview',
                'type' => 'string',
                'description' => 'Which template path should be used for comment previews',
            ]),
            new Parameter([
                'name' => 'url_title',
                'type' => 'string',
                'description' => 'Display a comment form for a specific channel entry by its URL title',
            ]),
            new Parameter([
                'name' => 'channel',
                'type' => 'string',
                'description' => 'Specify which channel to associate with the submitted comment',
            ]),
        ]);
    }

    public function getChannelArgument($value)
    {
        return new FilterArgument($value);
    }

    public function getEntryStatusArgument($value)
    {
        $value = str_replace(['Open', 'Closed'], ['open', 'closed'], $value);

        return new FilterArgument($value);
    }

    public function __construct()
    {
        // Load the form helper and session library
        ee()->load->helper('form');
        ee()->load->library('session');

        $this->addonInstance = $this->getAddonInstance('email');

        // Conditionals
        $data = [
            'logged_in' => (ee()->session->userdata('member_id') != 0),
            'logged_out' => (ee()->session->userdata('member_id') == 0),
            'captcha' => ee('Captcha')->shouldRequireCaptcha() ? ee('Captcha')->create() : null,
        ];

        // Process default variables
        $postVars = ['screen_name' => 'name', 'email', 'url', 'location', 'comment', 'save_info', 'notify_me'];
        foreach ($postVars as $userKey => $key) {
            $userKey = is_numeric($userKey) ? $key : $userKey;
            // Adding slashes since they removed in _setup_form
            $var = addslashes(
                \form_prep(
                    ee()->functions->encode_ee_tags(
                        ee()->input->post($key, true) ?: (ee()->session->userdata[$userKey] ?? null),
                        true
                    ),
                    $key
                )
            );

            $data[$key] = $var;
        }

        if (! isset($_POST['PRV'])) {
            $data['save_info'] = (! isset(ee()->session->userdata['notify_by_default'])) ? ee()->input->cookie('save_info') : ee()->session->userdata['notify_by_default'];
        }

        if (empty($data['notify_me']) && ! isset($_POST['PRV'])) {
            $data['notify_me'] = (ee()->input->cookie('notify_me')) ?: ee()->session->userdata('notify_by_default', 'n') == 'y';
        }

        // Default URL value
        $data['url'] = $data['url'] ?: 'http://';
        $data['notify_me'] = $data['notify_me'] === true || $data['notify_me'] == 'yes';
        $data['save_info'] = $data['save_info'] === true || $data['save_info'] == 'yes';

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
        $data = [
            'ACT' => Action::fetch_action_id('Comment', 'insert_new_comment'),
            'RET' => $this->encrypt($this->hasArgument('return') ? $this->getArgument('return')->value : ee()->uri->uri_string),
            'PRV' => (isset($_POST['PRV'])) ? $_POST['PRV'] : $this->getArgument('preview')->value,
            'entry_id' => $this->entry->entry_id ?? '',
        ];

        return parent::open(['hidden_fields' => $data]);
    }

    public function close()
    {
        $res = parent::close();
        /**
         * 'comment_form_end' hook.
         *  Modify, add, etc. something to the comment form at end of processing
         */
        if (ee()->extensions->active_hook('comment_form_end') === true) {
            $res = ee()->extensions->call('comment_form_end', $res);
            if (ee()->extensions->end_script === true) {
                return $res;
            }
        }

        return $res;
    }

    public function run()
    {
        $entry = $this->findEntry();

        /** ----------------------------------------
        /**  Smart Notifications? Mark comments as read.
        /** ----------------------------------------*/
        if ($entry && ee()->session->userdata('smart_notifications') == 'y') {
            ee()->load->library('subscription');
            ee()->subscription->init('comment', ['entry_id' => $entry->entry_id], true);
            ee()->subscription->mark_as_read();
        }

        $attributes = [
            'entry' => $entry,
            'comments_disabled' => $entry ? $this->commentsDisabledForEntry($entry) : null,
            'comments_expired' => $entry ? $this->commentsExpiredForEntry($entry) : null,
        ];

        $this->attributes = array_merge($this->attributes, $attributes);

        return parent::run();
    }

    protected function findEntry()
    {
        // Figure out the right entry ID
        // Order of precedence: POST, entry_id=, url_title=, $qstring
        $where = array_filter([
            'entry_id' => $_POST['entry_id'] ?? $this->getArgument('entry_id')->value,
            'url_title' => $this->getArgument('url_title')->value,
        ]);

        if (empty($where)) {
            $qstring = ee()->uri->query_string;

            /** --------------------------------------
            /**  Remove page number
            /** --------------------------------------*/
            if (preg_match("#(^|/)P(\d+)(/|$)#", $qstring, $match)) {
                $qstring = trim(reduce_double_slashes(str_replace($match['0'], '/', $qstring)), '/');
            }

            // If there is a slash in the entry ID we'll kill everything after it.
            $entry_id = trim($qstring);
            $entry_id = preg_replace('#/.+#', '', $entry_id);

            $where = ! is_numeric($entry_id) ? ['url_title' => $entry_id] : ['entry_id' => $entry_id];
        }

        $query = ChannelEntry::where(array_key_first($where), current($where))
            ->whereIn('site_id', ee()->TMPL->site_ids);

        $query->when($this->hasArgument('channel'), function ($query) {
            $query->whereHas('channel', function ($query) {
                $this->getArgument('channel')->addQuery($query, 'channel_name');
                $query->whereIn('site_id', ee()->TMPL->site_ids);
            });
        });

        $query->when($this->hasArgument('entry_status'), function ($query) {
            $this->getArgument('entry_status')->addQuery($query, 'entry_status');

            if (stristr($this->getArgument('entry_status')->value, 'closed') === false) {
                $query->where('status', '!=', 'closed');
            }
        }, function ($query) {
            $query->where('status', '!=', 'closed');
        });

        return $query->first();
    }

    /**
     * Check whether comments are disabled for the given entry
     *
     * @return bool
     */
    protected function commentsDisabledForEntry(ChannelEntry $entry)
    {
        return $entry->allow_comments == false
            || $entry->channel->comment_system_enabled == false
            || ee()->config->item('enable_comments') != 'y'
            || ! ee('Permission')->can('post_comments');
    }

    /**
     * Check whether comments are expired for the given entry
     *
     * @return bool
     */
    protected function commentsExpiredForEntry(ChannelEntry $entry)
    {
        if (ee()->config->item('comment_moderation_override') === 'y' || $entry->comment_expiration_date <= 0) {
            return false;
        }

        return ee()->localize->now > $entry->comment_expiration_date;
    }
}
