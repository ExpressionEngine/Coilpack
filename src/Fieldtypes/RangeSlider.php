<?php

namespace Expressionengine\Coilpack\Fieldtypes;

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
}
