<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Support\Parameter;

class Rte extends Generic
{
    public function parameters(Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'text_only',
                'type' => 'boolean',
                'description' => 'Remove all HTML tags from the content',
            ]),
            new Parameter([
                'name' => 'remove_images',
                'type' => 'boolean',
                'description' => 'Only remove images from the content',
            ]),
            new Parameter([
                'name' => 'images_only',
                'type' => 'boolean',
                'description' => 'Remove everything except images from the content',
            ]),
        ];
    }
}
