<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use GraphQL\Type\Definition\Type;

class File extends Generic
{
    public function apply(FieldContent $content, array $parameters = [])
    {
        $handler = $this->getHandler();
        $data = $handler->pre_process($content->data);
        $string = $data['url'];

        if (isset($parameters['wrap'])) {
            $string = $handler->_wrap_it($data, $parameters['wrap'], $data['path'].$data['filename'].'.'.$data['extension']);
        }

        return FieldtypeOutput::make($data)->string($string);
    }

    public function modifiers()
    {
        return [
            'rotate' => new Modifiers\File($this, [
                'name' => 'rotate',
                'description' => 'Rotate a file',
                'parameters' => [
                    'angle' => [
                        'type' => Type::string(),
                        'description' => 'Rotation angle',
                    ],
                ],
                // 'graphql' => [
                //     // 'type' =>
                // ]
            ]),
            'resize' => new Modifiers\File($this, [
                'name' => 'resize',
                'description' => 'Resize a file',
                'parameters' => [
                    'height' => [
                        'type' => Type::int(),
                        'description' => 'Height to resize to, px',
                    ],
                    'width' => [
                        'type' => Type::int(),
                        'description' => 'Width to resize to, px',
                    ],
                    'quality' => [
                        'type' => Type::int(),
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ],
                    'maintain_ratio' => [
                        'type' => Type::boolean(),
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ],
                    // 'master_dimension' => [
                    //     'type' => Type::enum()
                    // ]
                ],
            ]),
            'resize_crop' => new Modifiers\File($this, [
                'name' => 'resize_crop',
                'description' => 'Resize and Crop a file',
                'parameters' => [
                    'resize_height' => [
                        'type' => Type::int(),
                        'description' => 'Height to resize to, px',
                    ],
                    'resize_width' => [
                        'type' => Type::int(),
                        'description' => 'Width to resize to, px',
                    ],
                    'resize_quality' => [
                        'type' => Type::int(),
                        'description' => 'Resized Image quality, %',
                        'defaultValue' => 75,
                    ],
                    'resize_maintain_ratio' => [
                        'type' => Type::boolean(),
                        'description' => 'Keep image ratio when resizing (yes/no)',
                        'defaultValue' => true,
                    ],
                    'crop_height' => [
                        'type' => Type::int(),
                        'description' => 'Height to crop to, px',
                    ],
                    'crop_width' => [
                        'type' => Type::int(),
                        'description' => 'Width to crop to, px',
                    ],
                    'crop_quality' => [
                        'type' => Type::int(),
                        'description' => 'Cropped Image quality, %',
                        'defaultValue' => 75,
                    ],
                    'crop_maintain_ratio' => [
                        'type' => Type::boolean(),
                        'description' => 'Keep image ratio when cropping (yes/no)',
                        'defaultValue' => true,
                    ],
                    'crop_x' => [
                        'type' => Type::int(),
                        'description' => 'Horizontal crop offset, px',
                        'defaultValue' => 0,
                    ],
                    'crop_y' => [
                        'type' => Type::int(),
                        'description' => 'Vertical crop offset, px',
                        'defaultValue' => 0,
                    ],
                ],
            ]),
            'crop' => new Modifiers\File($this, [
                'name' => 'crop',
                'description' => 'Crop a file',
                'parameters' => [
                    'height' => [
                        'type' => Type::int(),
                        'description' => 'Height to crop to, px',
                    ],
                    'width' => [
                        'type' => Type::int(),
                        'description' => 'Width to crop to, px',
                    ],
                    'quality' => [
                        'type' => Type::int(),
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ],
                    'maintain_ratio' => [
                        'type' => Type::boolean(),
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ],
                    'x' => [
                        'type' => Type::int(),
                        'description' => 'Horizontal offset, px',
                        'defaultValue' => 0,
                    ],
                    'y' => [
                        'type' => Type::int(),
                        'description' => 'Vertical offset, px',
                        'defaultValue' => 0,
                    ],
                ],
            ]),
            'webp' => new Modifiers\File($this, [
                'name' => 'webp',
                'description' => 'Convert a file to WEBP format',
                'parameters' => [
                    'height' => [
                        'type' => Type::int(),
                        'description' => 'Height to resize to, px',
                    ],
                    'width' => [
                        'type' => Type::int(),
                        'description' => '',
                    ],
                    'quality' => [
                        'type' => Type::int(),
                        'description' => 'Image quality, %',
                        'defaultValue' => 75,
                    ],
                    'maintain_ratio' => [
                        'type' => Type::boolean(),
                        'description' => 'Keep image ratio (yes/no)',
                        'defaultValue' => true,
                    ],
                    // 'master_dimension' => [
                    //     'type' => Type::enum()
                    // ]
                ],
            ]),
        ];
    }

    public function graphType()
    {
        return 'Fieldtypes\\File';
    }
}
