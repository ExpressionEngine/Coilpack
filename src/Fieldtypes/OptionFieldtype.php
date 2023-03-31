<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;
use Rebing\GraphQL\Support\Facades\GraphQL;

class OptionFieldtype extends Generic
{
    public function apply(FieldContent $content, array $parameters = [])
    {
        $handler = $this->getHandler();

        $data = $content->getAttribute('data');

        // This function is loaded by a call to ee()->load->helper('custom_field');
        // but only in the fieldtypes that require it
        if (function_exists('decode_multi_field')) {
            $data = \decode_multi_field($data);
        }

        $data = (is_array($data)) ? $data : [$data];

        if (isset($parameters['limit'])) {
            $limit = intval($parameters['limit']);

            if (count($data) > $limit) {
                $data = array_slice($data, 0, $limit);
            }
        }

        $pairs = $handler->get_setting('value_label_pairs');
        $selected = [];

        if (! empty($pairs)) {
            foreach ($data as $key => $value) {
                if (isset($pairs[$value])) {
                    $selected[$value] = $pairs[$value];
                }
            }
        } else {
            $pairs = [];
            $selected = $data;
        }

        if (isset($parameters['markup']) && ($parameters['markup'] == 'ol' or $parameters['markup'] == 'ul')) {
            $string = '<'.$parameters['markup'].'>';

            foreach ($selected as $dv) {
                $string .= '<li>';
                $string .= $dv;
                $string .= '</li>';
            }

            $string .= '</'.$parameters['markup'].'>';
        } else {
            $string = implode(', ', $selected);
        }

        // $string = $handler->processTypograpghy($string);
        return FieldtypeOutput::for($this)->value($string)
            ->array(array_values($selected))
            ->object((object) [
                'options' => $pairs,
                'selected' => $selected,
            ]);
    }

    public function parameters(Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of selected items',
            ]),
            new Parameter([
                'name' => 'markup',
                'type' => 'string',
                'description' => 'Output value as an HTML list, you can use "ul" or "ol"',
            ]),
        ];
    }

    public function graphType()
    {
        return new GeneratedType([
            'fields' => function () {
                return [
                    'value' => [
                        'type' => \GraphQL\Type\Definition\Type::string(),
                        'resolve' => function ($root, array $args) {
                            return $root;
                        },
                    ],
                    'selected' => [
                        'type' => \GraphQL\Type\Definition\Type::listOf(GraphQL::type('KeyedValue')),
                        'resolve' => function ($root, array $args) {
                            return array_map(function ($value, $key) {
                                return compact('key', 'value');
                            }, $root->selected, array_keys($root->selected));
                        },
                    ],
                    'options' => [
                        'type' => \GraphQL\Type\Definition\Type::listOf(GraphQL::type('KeyedValue')),
                        'resolve' => function ($root, array $args) {
                            return array_map(function ($value, $key) {
                                return compact('key', 'value');
                            }, $root->options, array_keys($root->options));
                        },
                    ],
                ];
            },
        ]);
    }
}
