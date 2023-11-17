<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;
use Illuminate\Support\Str;

class Generic extends Fieldtype
{
    private $handler = null;

    private $settings;

    public function __construct(string $name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getHandler()
    {
        if ($this->handler) {
            return $this->handler;
        }

        ee()->load->library('api');
        ee()->legacy_api->instantiate('channel_fields');
        ee()->api_channel_fields->include_handler($this->name);
        if (empty(ee()->api_channel_fields->custom_fields)) {
            ee()->api_channel_fields->fetch_custom_channel_fields();
        }

        $this->handler = ee()->api_channel_fields->setup_handler($this->id ?: $this->name, true);

        if ($this->settings) {
            $this->handler->_init(['settings' => $this->settings]);
        }

        return $this->handler;
    }

    public function withSettings($settings)
    {
        $this->settings = $settings;

        return parent::withSettings($settings);
    }

    public function apply(FieldContent $content, array $parameters = [])
    {
        $handler = clone $this->getHandler();

        // Set entry data on handler
        $handler->_init(array_merge($this->settings ?? [], [
            'content_id' => $content->entry_id,
        ]));
        $handler->row = $content->entry->toArray();

        $data = $content->getAttribute('data');

        // Run pre_process if it exists
        if (method_exists($handler, 'pre_process')) {
            $data = $handler->pre_process($data);
        }

        $output = \Expressionengine\Coilpack\Facades\Coilpack::isolateTemplateLibrary(function ($template) use ($handler, $data, $parameters) {
            $output = $handler->replace_tag($data, $parameters);
            // If the Fieldtype stored data for us in the template library that is preferable to the generated output
            return $template->get_data() ?: $output;
        });

        return FieldtypeOutput::for($this)->value($output);
    }

    public function defineModifiers(): array
    {
        $default = [
            new Modifiers\Generic($this, [
                'name' => 'attr_safe',
                'description' => 'Make content safe for use in an HTML attribute',
                'parameters' => [
                    new Parameter([
                        'name' => 'double_encode',
                        'type' => 'boolean',
                        'defaultValue' => false,
                        'description' => 'Whether or not to double encode already-encoded entities',
                    ]),
                    new Parameter([
                        'name' => 'end_char',
                        'type' => 'string',
                        'defaultValue' => '&#8230;',
                        'description' => 'Character to append when a limit terminates the content',
                    ]),
                    new Parameter([
                        'name' => 'limit',
                        'type' => 'integer',
                        'defaultValue' => 500,
                        'description' => 'Number of characters to limit to (retains whole words)',
                    ]),
                    new Parameter([
                        'name' => 'unicode_punctuation',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Whether HTML entities for ’, ‘, ”, “, —, …, or non-breaking spaces should be decoded to the normal unicode characters',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'censor',
                'description' => 'Censor naughty words, using the site’s Word Censorship settings',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'currency',
                'description' => 'Format a number as currency',
                'parameters' => [
                    new Parameter([
                        'name' => 'code',
                        'type' => 'string',
                        'defaultValue' => 'USD',
                        'description' => 'International currency code',
                    ]),
                    new Parameter([
                        'name' => 'decimals',
                        'type' => 'integer',
                        'defaultValue' => null,
                        'description' => 'Decimal precision',
                    ]),
                    new Parameter([
                        'name' => 'locale',
                        'type' => 'string',
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'decrypt',
                'description' => 'Decrypt the content',
                'parameters' => [
                    new Parameter([
                        'name' => 'encode',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Base64-decode the content (necessary for safe transport, e.g. submitted in a form)',
                    ]),
                    new Parameter([
                        'name' => 'key',
                        'type' => 'string',
                        'defaultValue' => null,
                        'description' => 'Custom encryption key to use',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'encrypt',
                'description' => 'Encrypt the content',
                'parameters' => [
                    new Parameter([
                        'name' => 'encode',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Base64-decode the content (necessary for safe transport, e.g. submitted in a form)',
                    ]),
                    new Parameter([
                        'name' => 'key',
                        'type' => 'string',
                        'defaultValue' => null,
                        'description' => 'Custom encryption key to use',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'form_prep',
                'description' => 'Make the content safe to use as the value of a form field.',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'json',
                'description' => 'Encode the content for JSON output.',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'length',
                'description' => 'Outputs the length of the content in characters.',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'limit',
                'description' => 'Limits the content to the specified number of characters',
                'parameters' => [
                    new Parameter([
                        'name' => 'characters',
                        'type' => 'integer',
                        'defaultValue' => 500,
                        'description' => 'Number of characters to limit to',
                    ]),
                    new Parameter([
                        'name' => 'end_char',
                        'type' => 'string',
                        'defaultValue' => '&#8230;',
                        'description' => 'Character to append when a limit terminates the content',
                    ]),
                    new Parameter([
                        'name' => 'preserve_words',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Retain whole words',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'number_format',
                'description' => 'Formats a number using typical options.',
                'parameters' => [
                    new Parameter([
                        'name' => 'decimals',
                        'type' => 'integer',
                        'defaultValue' => 0,
                        'description' => 'Number of decimal precision',
                    ]),
                    new Parameter([
                        'name' => 'decimal_point',
                        'type' => 'string',
                        'defaultValue' => '.',
                        'description' => 'Character to use as the decimal point',
                    ]),
                    new Parameter([
                        'name' => 'thousands_separator',
                        'type' => 'string',
                        'defaultValue' => ',',
                        'description' => 'Character to use as the thousands separator',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'ordinal',
                'description' => 'Formats a number with its ordinal suffix.',
                'parameters' => [
                    new Parameter([
                        'name' => 'locale',
                        'type' => 'string',
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'raw_content',
                'description' => 'Output the raw, unparsed content of the variable',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'replace',
                'description' => 'Formats a number with its ordinal suffix.',
                'parameters' => [
                    new Parameter([
                        'name' => 'case_sensitive',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Whether the Find pattern is treated as case-sensitive. Has no impact if the regex= parameter is used, since the regex pattern will define case-sensitivity',
                    ]),
                    new Parameter([
                        'name' => 'find',
                        'type' => 'string',
                        'defaultValue' => '',
                        'description' => 'The text to search for',
                    ]),
                    new Parameter([
                        'name' => 'regex',
                        'type' => 'boolean',
                        'defaultValue' => false,
                        'description' => 'Whether the Find pattern should be handled as a regular expression',
                    ]),
                    new Parameter([
                        'name' => 'replace',
                        'type' => 'string',
                        'defaultValue' => '',
                        'description' => 'The text to replace the Find pattern with',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'rot13',
                'description' => 'Perform a ROT13 substitution cypher to the content',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'spellout',
                'description' => 'Spellout numeric values',
                'parameters' => [
                    new Parameter([
                        'name' => 'capitalize',
                        'type' => 'string',
                        'defaultValue' => 'none',
                        'description' => 'One of ucfirst (uppercase first letter) or ucwords (uppercase first letter of each word)',
                    ]),
                    new Parameter([
                        'name' => 'locale',
                        'type' => 'string',
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ]),

                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'trim',
                'description' => 'Returns a string with whitespace stripped from its beginning and its end.',
                'parameters' => [
                    new Parameter([
                        'name' => 'characters',
                        'type' => 'string',
                        'defaultValue' => '\n\r\t\v\0',
                        'description' => 'Remove specified characters',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'url',
                'description' => 'Normalize a URL to use in markup. Primarily to make sure it contains a valid protocol.',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'url_decode',
                'description' => 'URL decode the contents.',
                'parameters' => null,
            ]),
            new Modifiers\Generic($this, [
                'name' => 'url_encode',
                'description' => 'URL encode the contents.',
                'parameters' => [
                    new Parameter([
                        'name' => 'plus_encoded_spaces',
                        'type' => 'boolean',
                        'defaultValue' => false,
                        'description' => 'Whether or not to encode spaces as + instead of %20',
                    ]),
                ],
            ]),
            new Modifiers\Generic($this, [
                'name' => 'url_slug',
                'description' => 'Create a URL slug from the content.',
                'parameters' => [
                    new Parameter([
                        'name' => 'lowercase',
                        'type' => 'boolean',
                        'defaultValue' => true,
                        'description' => 'Whether to force a lowercase URL slug',
                    ]),
                    new Parameter([
                        'name' => 'remove_stopwords',
                        'type' => 'boolean',
                        'defaultValue' => false,
                        'description' => 'Whether to remove common words',
                    ]),
                    new Parameter([
                        'name' => 'separator',
                        'type' => 'string',
                        'defaultValue' => '-',
                        'description' => 'The character to use as a word separator',
                    ]),
                ],
            ]),
        ];

        $default = collect($default)->keyBy('name');

        // @todo Cache this statically
        return collect(get_class_methods($this->getHandler()))->map(function ($method) use ($default) {
            if (Str::startsWith($method, 'replace_') && $method !== 'replace_tag') {
                $name = substr($method, 8);

                if ($default->has($name)) {
                    return null;
                }

                return new Modifiers\Generic($this, [
                    'name' => $name,
                ]);
            }

            return null;
        })->filter()->keyBy('name')->merge($default)->toArray();
    }
}
