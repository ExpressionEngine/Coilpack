<?php

namespace Expressionengine\Coilpack;

class NavOutput extends TemplateOutput
{
    public function render(callable $callback, $entries = null)
    {
        $output = '';
        $entries = is_null($entries) ? $this->array : $entries;

        foreach ($entries as $item) {
            $output .= $callback(
                $item,
                $this->render($callback, $item['children']),
                $item['depth']
            );
        }

        return $output;
    }
}
