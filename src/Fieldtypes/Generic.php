<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;

class Generic extends Fieldtype
{
    private $handler = null;

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

        return $this->handler;
    }

    public function apply(FieldContent $content, array $parameters = [])
    {
        $handler = $this->getHandler();

        $data = $content->getAttribute('data');

        $output = \Expressionengine\Coilpack\Facades\Coilpack::isolateTemplateLibrary(function ($template) use ($handler, $data, $parameters) {
            $output = $handler->replace_tag($data, $parameters);
            // If the Fieldtype stored data for us in the template library that is preferable to the generated output
            return $template->get_data() ?: $output;
        });

        return FieldtypeOutput::make($output);
    }

    public function modifiers()
    {
        $default = [
            'attr_safe' => new Modifiers\Generic($this, [
                'name' => 'attr_safe',
                'description' => 'Make content safe for use in an HTML attribute',
                'parameters' => [
                    'double_encode' => [
                        'type' => Type::boolean(),
                        'defaultValue' => false,
                        'description' => 'Whether or not to double encode already-encoded entities',
                    ],
                    'end_char' => [
                        'type' => Type::string(),
                        'defaultValue' => '&#8230;',
                        'description' => 'Character to append when a limit terminates the content',
                    ],
                    'limit' => [
                        'type' => Type::int(),
                        'defaultValue' => 500,
                        'description' => 'Number of characters to limit to (retains whole words)',
                    ],
                    'unicode_punctuation' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Whether HTML entities for ’, ‘, ”, “, —, …, or non-breaking spaces should be decoded to the normal unicode characters',
                    ],
                ],
            ]),
            'censor' => new Modifiers\Generic($this, [
                'name' => 'censor',
                'description' => 'Censor naughty words, using the site’s Word Censorship settings',
                'parameters' => null,
            ]),
            'currency' => new Modifiers\Generic($this, [
                'name' => 'currency',
                'description' => 'Format a number as currency',
                'parameters' => [
                    'code' => [
                        'type' => Type::string(),
                        'defaultValue' => 'USD',
                        'description' => 'International currency code',
                    ],
                    'decimals' => [
                        'type' => Type::int(),
                        'defaultValue' => null,
                        'description' => 'Decimal precision',
                    ],
                    'locale' => [
                        'type' => Type::string(),
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ],
                ],
            ]),
            'decrypt' => new Modifiers\Generic($this, [
                'name' => 'decrypt',
                'description' => 'Decrypt the content',
                'parameters' => [
                    'encode' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Base64-decode the content (necessary for safe transport, e.g. submitted in a form)',
                    ],
                    'key' => [
                        'type' => Type::string(),
                        'defaultValue' => null,
                        'description' => 'Custom encryption key to use',
                    ],
                ],
            ]),
            'encrypt' => new Modifiers\Generic($this, [
                'name' => 'encrypt',
                'description' => 'Encrypt the content',
                'parameters' => [
                    'encode' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Base64-decode the content (necessary for safe transport, e.g. submitted in a form)',
                    ],
                    'key' => [
                        'type' => Type::string(),
                        'defaultValue' => null,
                        'description' => 'Custom encryption key to use',
                    ],
                ],
            ]),
            'form_prep' => new Modifiers\Generic($this, [
                'name' => 'form_prep',
                'description' => 'Make the content safe to use as the value of a form field.',
                'parameters' => null,
            ]),
            'json' => new Modifiers\Generic($this, [
                'name' => 'json',
                'description' => 'Encode the content for JSON output.',
                'parameters' => null,
            ]),
            'length' => new Modifiers\Generic($this, [
                'name' => 'length',
                'description' => 'Outputs the length of the content in characters.',
                'parameters' => null,
            ]),
            'limit' => new Modifiers\Generic($this, [
                'name' => 'limit',
                'description' => 'Limits the content to the specified number of characters',
                'parameters' => [
                    'characters' => [
                        'type' => Type::int(),
                        'defaultValue' => 500,
                        'description' => 'Number of characters to limit to',
                    ],
                    'end_char' => [
                        'type' => Type::string(),
                        'defaultValue' => '&#8230;',
                        'description' => 'Character to append when a limit terminates the content',
                    ],
                    'preserve_words' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Retain whole words',
                    ],
                ],
            ]),
            'number_format' => new Modifiers\Generic($this, [
                'name' => 'number_format',
                'description' => 'Formats a number using typical options.',
                'parameters' => [
                    'decimals' => [
                        'type' => Type::int(),
                        'defaultValue' => 0,
                        'description' => 'Number of decimal precision',
                    ],
                    'decimal_point' => [
                        'type' => Type::string(),
                        'defaultValue' => '.',
                        'description' => 'Character to use as the decimal point',
                    ],
                    'thousands_separator' => [
                        'type' => Type::string(),
                        'defaultValue' => ',',
                        'description' => 'Character to use as the thousands separator',
                    ],
                ],
            ]),
            'ordinal' => new Modifiers\Generic($this, [
                'name' => 'ordinal',
                'description' => 'Formats a number with its ordinal suffix.',
                'parameters' => [
                    'locale' => [
                        'type' => Type::string(),
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ],
                ],
            ]),
            'raw_content' => new Modifiers\Generic($this, [
                'name' => 'raw_content',
                'description' => 'Output the raw, unparsed content of the variable',
                'parameters' => null,
            ]),
            'replace' => new Modifiers\Generic($this, [
                'name' => 'replace',
                'description' => 'Formats a number with its ordinal suffix.',
                'parameters' => [
                    'case_sensitive' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Whether the Find pattern is treated as case-sensitive. Has no impact if the regex= parameter is used, since the regex pattern will define case-sensitivity',
                    ],
                    'find' => [
                        'type' => Type::string(),
                        'defaultValue' => '',
                        'description' => 'The text to search for',
                    ],
                    'regex' => [
                        'type' => Type::boolean(),
                        'defaultValue' => false,
                        'description' => 'Whether the Find pattern should be handled as a regular expression',
                    ],
                    'replace' => [
                        'type' => Type::string(),
                        'defaultValue' => '',
                        'description' => 'The text to replace the Find pattern with',
                    ],
                ],
            ]),
            'rot13' => new Modifiers\Generic($this, [
                'name' => 'rot_13',
                'description' => 'Perform a ROT13 substitution cypher to the content',
                'parameters' => null,
            ]),
            'spellout' => new Modifiers\Generic($this, [
                'name' => 'spellout',
                'description' => 'Spellout numeric values',
                'parameters' => [
                    'capitalize' => [
                        'type' => Type::string(),
                        'defaultValue' => 'none',
                        'description' => 'One of ucfirst (uppercase first letter) or ucwords (uppercase first letter of each word)',
                    ],
                    'locale' => [
                        'type' => Type::string(),
                        'defaultValue' => 'en_US.UTF-8',
                        'description' => 'The ICU locale ID',
                    ],

                ],
            ]),
            'trim' => new Modifiers\Generic($this, [
                'name' => 'trim',
                'description' => 'Returns a string with whitespace stripped from its beginning and its end.',
                'parameters' => [
                    'characters' => [
                        'type' => Type::string(),
                        'defaultValue' => '\n\r\t\v\0',
                        'description' => 'Remove specified characters',
                    ],
                ],
            ]),
            'url' => new Modifiers\Generic($this, [
                'name' => 'url',
                'description' => 'Normalize a URL to use in markup. Primarily to make sure it contains a valid protocol.',
                'parameters' => null,
            ]),
            'url_decode' => new Modifiers\Generic($this, [
                'name' => 'url_decode',
                'description' => 'URL decode the contents.',
                'parameters' => null,
            ]),
            'url_encode' => new Modifiers\Generic($this, [
                'name' => 'url_encode',
                'description' => 'URL encode the contents.',
                'parameters' => [
                    'plus_encoded_spaces' => [
                        'type' => Type::boolean(),
                        'defaultValue' => false,
                        'description' => 'Whether or not to encode spaces as + instead of %20',
                    ],
                ],
            ]),
            'url_slug' => new Modifiers\Generic($this, [
                'name' => 'url_slug',
                'description' => 'Create a URL slug from the content.',
                'parameters' => [
                    'lowercase' => [
                        'type' => Type::boolean(),
                        'defaultValue' => true,
                        'description' => 'Whether to force a lowercase URL slug',
                    ],
                    'remove_stopwords' => [
                        'type' => Type::boolean(),
                        'defaultValue' => false,
                        'description' => 'Whether to remove common words',
                    ],
                    'separator' => [
                        'type' => Type::string(),
                        'defaultValue' => '-',
                        'description' => 'The character to use as a word separator',
                    ],
                ],
            ]),
        ];

        // @todo Cache this statically
        return collect(get_class_methods($this->getHandler()))->flatMap(function ($method) use ($default) {
            if (Str::startsWith($method, 'replace_') && $method !== 'replace_tag') {
                $name = substr($method, 8);

                if (array_key_exists($name, $default)) {
                    return [];
                }

                return [
                    substr($method, 8) => new Modifiers\Generic($this, [
                        'name' => $name,
                    ]),
                ];
            }

            return [];
        })->filter()->merge($default)->toArray();
    }
}
