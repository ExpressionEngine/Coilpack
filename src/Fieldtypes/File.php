<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;
use GraphQL\Type\Definition\Type;

class File extends Generic
{
    public function apply(FieldContent $content, array $parameters = [])
    {
        if (empty($content->getAttribute('data'))) {
            return null;
        }

        $handler = $this->getHandler();
        $data = $handler->pre_process($content->data);
        $string = $data['url'];

        if (isset($parameters['wrap'])) {
            $string = $handler->_wrap_it($data, $parameters['wrap'], $data['path'].$data['filename'].'.'.$data['extension']);
        }

        return FieldtypeOutput::for($this)->value($data)->string($string);
    }

    public function defineModifiers(): array
    {
        return [
            new Modifiers\File($this, [
                'name' => 'manipulation',
                'description' => 'Perform a pre-defined manipulation on the file',
                'parameters' => new Parameter([
                    'name' => 'name',
                    'type' => 'string',
                    'description' => 'Manipulation name',
                ]),
            ]),
            new Modifiers\File($this, [
                'name' => 'rotate',
                'description' => 'Rotate a file',
                'parameters' => [
                    new Parameter([
                        'name' => 'angle',
                        'type' => 'string',
                        'description' => 'Rotation angle',
                    ]),
                ],
            ]),
            new Modifiers\File($this, [
                'name' => 'resize',
                'description' => 'Resize a file',
                'parameters' => [
                    new Parameter([
                        'name' => 'height',
                        'type' => 'integer',
                        'description' => 'Height to resize to, px',
                    ]),
                    new Parameter([
                        'name' => 'width',
                        'type' => 'integer',
                        'description' => 'Width to resize to, px',
                    ]),
                    new Parameter([
                        'name' => 'quality',
                        'type' => 'integer',
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ]),
                    new Parameter([
                        'name' => 'maintain_ratio',
                        'type' => 'boolean',
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ]),
                    // new Parameter([
                    //    'name' => // ,
                    //     'type' => 'enum')
                    // ]
                ],
            ]),
            new Modifiers\File($this, [
                'name' => 'resize_crop',
                'description' => 'Resize and Crop a file',
                'parameters' => [
                    new Parameter([
                        'name' => 'resize_height',
                        'type' => 'integer',
                        'description' => 'Height to resize to, px',
                    ]),
                    new Parameter([
                        'name' => 'resize_width',
                        'type' => 'integer',
                        'description' => 'Width to resize to, px',
                    ]),
                    new Parameter([
                        'name' => 'resize_quality',
                        'type' => 'integer',
                        'description' => 'Resized Image quality, %',
                        'defaultValue' => 75,
                    ]),
                    new Parameter([
                        'name' => 'resize_maintain_ratio',
                        'type' => 'boolean',
                        'description' => 'Keep image ratio when resizing (yes/no)',
                        'defaultValue' => true,
                    ]),
                    new Parameter([
                        'name' => 'crop_height',
                        'type' => 'integer',
                        'description' => 'Height to crop to, px',
                    ]),
                    new Parameter([
                        'name' => 'crop_width',
                        'type' => 'integer',
                        'description' => 'Width to crop to, px',
                    ]),
                    new Parameter([
                        'name' => 'crop_quality',
                        'type' => 'integer',
                        'description' => 'Cropped Image quality, %',
                        'defaultValue' => 75,
                    ]),
                    new Parameter([
                        'name' => 'crop_maintain_ratio',
                        'type' => 'boolean',
                        'description' => 'Keep image ratio when cropping (yes/no)',
                        'defaultValue' => true,
                    ]),
                    new Parameter([
                        'name' => 'crop_x',
                        'type' => 'integer',
                        'description' => 'Horizontal crop offset, px',
                        'defaultValue' => 0,
                    ]),
                    new Parameter([
                        'name' => 'crop_y',
                        'type' => 'integer',
                        'description' => 'Vertical crop offset, px',
                        'defaultValue' => 0,
                    ]),
                ],
            ]),
            new Modifiers\File($this, [
                'name' => 'crop',
                'description' => 'Crop a file',
                'parameters' => [
                    new Parameter([
                        'name' => 'height',
                        'type' => 'integer',
                        'description' => 'Height to crop to, px',
                    ]),
                    new Parameter([
                        'name' => 'width',
                        'type' => 'integer',
                        'description' => 'Width to crop to, px',
                    ]),
                    new Parameter([
                        'name' => 'quality',
                        'type' => 'integer',
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ]),
                    new Parameter([
                        'name' => 'maintain_ratio',
                        'type' => 'boolean',
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ]),
                    new Parameter([
                        'name' => 'x',
                        'type' => 'integer',
                        'description' => 'Horizontal offset, px',
                        'defaultValue' => 0,
                    ]),
                    new Parameter([
                        'name' => 'y',
                        'type' => 'integer',
                        'description' => 'Vertical offset, px',
                        'defaultValue' => 0,
                    ]),
                ],
            ]),
            new Modifiers\File($this, [
                'name' => 'webp',
                'description' => 'Convert a file to WEBP format',
                'parameters' => [
                    new Parameter([
                        'name' => 'height',
                        'type' => 'integer',
                        'description' => 'Height to resize to, px',
                    ]),
                    new Parameter([
                        'name' => 'width',
                        'type' => 'integer',
                        'description' => '',
                    ]),
                    new Parameter([
                        'name' => 'quality',
                        'type' => 'integer',
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ]),
                    new Parameter([
                        'name' => 'maintain_ratio',
                        'type' => 'boolean',
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ]),
                    // new Parameter([
                    // 'name' => // ,
                    //     'type' => 'enum')
                    // ]
                ],
            ]),
        ];
    }

    public function graphType()
    {
        return 'Fieldtypes__File';
    }
}
