<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Illuminate\Support\Str;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use GraphQL\GraphQL;

class OptionFieldtype extends Generic
{

    public function apply(FieldContent $content, $parameters = [])
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

        if (!empty($pairs)) {
            foreach ($data as $key => $value) {
                if (isset($pairs[$value])) {
                    $data[$key] = $pairs[$value];
                }
            }
        }

        if (isset($parameters['markup']) && ($parameters['markup'] == 'ol' or $parameters['markup'] == 'ul')) {
            $string = '<' . $parameters['markup'] . '>';

            foreach ($data as $dv) {
                $string .= '<li>';
                $string .= $dv;
                $string .= '</li>';
            }

            $string .= '</' . $parameters['markup'] . '>';
        } else {
            $string = implode(', ', $data);
        }

        // $string = $handler->processTypograpghy($string);

        return FieldtypeOutput::make($string)->array($data);
    }

}
