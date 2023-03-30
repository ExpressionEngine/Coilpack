<?php

namespace Expressionengine\Coilpack\View;

abstract class FormTag extends Tag
{
    protected $formId;

    protected $formClass;

    protected $allowAttachments = false;

    protected $charset;

    protected $return;

    protected $redirect;

    public function setFormClassParameter($class)
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
            'id' => $this->formId,
            'class' => $this->formClass,
            'enctype' => ($this->allow_attachments) ? 'multipart/form-data' : '',
            'hidden_fields' => [
                '_token' => $token,
                'RET' => $this->return ?: ee()->uri->uri_string,
                'URI' => (ee()->uri->uri_string == '')
                ? 'index'
                : ee()->uri->uri_string,
                'charset' => $this->charset,
                'allow_attachments' => $this->encrypt('allow_attachments_'.($this->allow_attachments ? 'y' : 'n')),
                'redirect' => $this->redirect,
            ],
        ];

        $data = array_merge_recursive($defaults, $data);

        $form = ee()->functions->form_declaration($data);
        $form = str_replace('{csrf_token}', $token, $form);

        return $form;
    }

    public function close()
    {
        return '</form>';
    }

    public function run()
    {
        return $this->open();
    }

    /**
     * Encrypt a given string of data
     *
     * @param  string  $data Raw data to encrypt
     * @return string encrypted and base64 encoded string of data
     */
    protected function encrypt($data)
    {
        return ee('Encrypt')->encode($data, ee()->config->item('session_crypt_key'));
    }

    /**
     * Decrypt a given string of data, assumed to be base64_encoded
     *
     * @param  string  $data Base64 encoded encrypted string of data
     * @return string Decrypted data
     */
    protected function decrypt($data)
    {
        return ee('Encrypt')->decode($data, ee()->config->item('session_crypt_key'));
    }
}
