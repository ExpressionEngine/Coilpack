<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use Expressionengine\Coilpack\Facades\Coilpack;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;

class RangeSlider extends Generic
{
    public function apply(FieldContent $content, $parameters = [])
    {
        return Coilpack::isolateTemplateLibrary(function ($template) use ($content, $parameters) {
            $handler = $this->getHandler();
            $data = $content->getAttribute('data');
            $string = $handler->replace_tag($data, $parameters);
            // Sending fake tagdata to force a call to template parser so we can get more data back
            $handler->replace_tag($data, $parameters, '{!-- coilpack:fake --}');
            $array = $template->get_data() ?: [];

            return FieldtypeOutput::for($this)->value($string)->array($array);
        });
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
                    'from' => [
                        'type' => \GraphQL\Type\Definition\Type::string(),
                        'resolve' => function ($root, array $args) {
                            return $root->from;
                        },
                    ],
                    'to' => [
                        'type' => \GraphQL\Type\Definition\Type::string(),
                        'resolve' => function ($root, array $args) {
                            return $root->to;
                        },
                    ],
                ];
            },
        ]);
    }
}
