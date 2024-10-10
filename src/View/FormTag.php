<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Support\Parameter;

abstract class FormTag extends Tag
{
    protected $attributes = [];

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
            new Parameter([
                'name' => 'name',
                'type' => 'string',
                'description' => 'A name attribute for the form tag',
            ]),
            new Parameter([
                'name' => 'form_id',
                'type' => 'string',
                'description' => 'An id attribute for the form tag',
            ]),
            new Parameter([
                'name' => 'form_class',
                'type' => 'string',
                'description' => 'A class attribute for the form tag',
            ]),
            new Parameter([
                'name' => 'form_attributes',
                'type' => 'array',
                'description' => 'Additional key/value attributes to add to the form tag',
            ]),
            new Parameter([
                'name' => 'allow_attachments',
                'type' => 'boolean',
                'description' => 'Allows file input on your form',
                'defaulValue' => false,
            ]),
            new Parameter([
                'name' => 'charset',
                'type' => 'string',
                'description' => 'Set the character set of the email being sent',
            ]),
            new Parameter([
                'name' => 'return',
                'type' => 'string',
                'description' => 'A path (or full URL) where the user should be directed after the form is submitted',
            ]),
            new Parameter([
                'name' => 'redirect',
                'type' => 'string',
                'description' => 'How long to display success message before redirect',
            ]),
        ]);
    }

    public function setFormClassArgument($class)
    {
        return (is_array($class)) ? implode(' ', $class) : (string) $class;
    }

    public function open($data = [])
    {
        // We're using EE's CSRF token and setting it up on Laravel's session
        // to satisfy Laravel's middleware as well as EE's CSRF check
        ee()->load->library('csrf');
        $token = ee()->csrf->get_user_token();

        if (request()->hasSession()) {
            request()->session()->put('_token', $token);
        }

        $defaults = [
            'id' => $this->getArgument('form_id')->value,
            'class' => $this->getArgument('form_class')->value,
            'enctype' => ($this->getArgument('allow_attachments')) ? 'multipart/form-data' : '',
            'hidden_fields' => [
                '_token' => $token,
                'RET' => $this->hasArgument('return') ? $this->getArgument('return')->value : ee()->uri->uri_string,
                'URI' => (ee()->uri->uri_string == '') ? 'index' : ee()->uri->uri_string,
                'charset' => $this->getArgument('charset')->value,
                'allow_attachments' => $this->encrypt('allow_attachments_'.($this->getArgument('allow_attachments')->value ? 'y' : 'n')),
                'redirect' => $this->getArgument('redirect')->value,
            ],
        ];

        if ($this->hasArgument('name') && preg_match("#^[a-zA-Z0-9_\-]+$#i", $this->getArgument('name')->value, $match)) {
            $defaults['name'] = $this->getArgument('name')->value;
        }

        // Merge $data onto $defaults and do a deeper merge only on 'hidden_fields' array
        $hidden = array_merge($defaults['hidden_fields'], $data['hidden_fields'] ?? []);
        $data = array_merge($defaults, $data);
        $data['hidden_fields'] = $hidden;

        $form = ee()->functions->form_declaration($data);
        $form = str_replace('{csrf_token}', $token, $form);

        if ($this->hasArgument('form_attributes')) {
            $attributes = collect($this->getArgument('form_attributes'))->map(function ($value, $key) {
                return ($value) ? "$key=\"$value\"" : $key;
            })->implode(' ');
            $form = str_replace('<form ', "<form $attributes ", $form);
        }

        return $form;
    }

    public function close()
    {
        return '</form>';
    }

    public function run()
    {
        return $this;
    }

    /**
     * Encrypt a given string of data
     *
     * @param  string  $data  Raw data to encrypt
     * @return string encrypted and base64 encoded string of data
     */
    protected function encrypt($data)
    {
        return ee('Encrypt')->encode($data, ee()->config->item('session_crypt_key'));
    }

    /**
     * Decrypt a given string of data, assumed to be base64_encoded
     *
     * @param  string  $data  Base64 encoded encrypted string of data
     * @return string Decrypted data
     */
    protected function decrypt($data)
    {
        return ee('Encrypt')->decode($data, ee()->config->item('session_crypt_key'));
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function __get($key)
    {
        return (array_key_exists($key, $this->attributes)) ? $this->attributes[$key] : null;
    }

    /**
     * Cast the tag to a string by invoking the open method
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->open();
    }
}
