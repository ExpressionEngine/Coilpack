<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Support\Parameter;

class Rte extends Generic
{
    public function parameters(ChannelField $field = null)
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
