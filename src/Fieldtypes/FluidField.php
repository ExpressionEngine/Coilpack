<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Fields;
use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use Expressionengine\Coilpack\Api\Graph\Support\GeneratedUnionType;
use Expressionengine\Coilpack\Contracts\GeneratesGraphType;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Presenters\FluidFieldPresenter;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\FieldGroupContent;

class FluidField extends Fieldtype implements GeneratesGraphType, ListsGraphType
{
    protected $presenter;

    public function __construct(string $name, $id = null)
    {
        parent::__construct($name, $id);
        $this->presenter = new FluidFieldPresenter;
    }

    public function apply(FieldContent $content, array $parameters = [])
    {
        $data = $this->presenter->present($content, $parameters);

        return FieldtypeOutput::for($this)->value($data);
    }

    public function generateGraphType(ChannelField $field)
    {
        $groupIds = $field->field_settings['field_channel_field_groups'] ?? [];
        $fieldIds = $field->field_settings['field_channel_fields'] ?? [];
        $fields = collect($groupIds)->reduce(function ($carry, $group) {
            return $carry->merge(app(FieldtypeManager::class)->fieldsForFieldGroup($group));
        }, collect())->merge(collect($fieldIds)->reduce(function ($carry, $field) {
            return $carry->push(app(FieldtypeManager::class)->getField($field));
        }, collect()));

        $fields = collect($field->field_settings['field_channel_fields'] ?? [])->map(function ($id) {
            return app(FieldtypeManager::class)->getField($id);
        });

        $groups = collect($field->field_settings['field_channel_field_groups'] ?? [])->map(function ($id) {
            $fields = app(FieldtypeManager::class)->fieldsForFieldGroup($id);

            if ($fields->isEmpty()) {
                return null;
            }

            return (object) [
                'group' => $fields->first()->fieldGroups->find($id),
                'fields' => $fields,
            ];
        })->filter()->keyBy(function ($group) {
            return $group->group->short_name;
        });

        if (! config('coilpack.graphql.prefer_union_types')) {
            return new GeneratedType([
                'fields' => function () use ($fields, $groups) {
                    $fields = $fields->flatmap(function ($field) {
                        return [
                            $field->field_name => new Fields\Fieldtype([
                                'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: \GraphQL\Type\Definition\Type::string(),
                                'field' => $field,
                                'selectable' => false,
                                'is_relation' => false,
                                'resolve' => function ($root, array $args) use ($field) {
                                    if (! $root->field || $root->field->field_name != $field->field_name) {
                                        return null;
                                    }

                                    return $root;
                                },
                            ]),
                        ];
                    })->merge($groups->flatMap(function ($group) {
                        $name = "{$group->group->short_name}";
                        $typeDefinition = new GeneratedType([
                            'name' => $name,
                            'fields' => function () use ($group) {
                                $fields = $group->fields->flatmap(function ($field) {
                                    return [
                                        $field->field_name => new Fields\Fieldtype([
                                            'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: \GraphQL\Type\Definition\Type::string(),
                                            'field' => $field,
                                            'selectable' => false,
                                            'is_relation' => false,
                                            'resolve' => function ($root, array $args) use ($field) {
                                                if ($root->field->field_name != $field->field_name) {
                                                    return null;
                                                }

                                                return $root;
                                            },
                                        ]),
                                    ];
                                })->toArray();

                                $fields['_field_name'] = [
                                    'type' => \GraphQL\Type\Definition\Type::string(),
                                    'resolve' => function ($root, array $args) {
                                        return $root->_field_name ?? $root->field->field_name;
                                    },
                                ];

                                $fields['_field_type'] = [
                                    'type' => \GraphQL\Type\Definition\Type::string(),
                                    'resolve' => function ($root, array $args) {
                                        return $root->_field_type ?? $root->field->field_type;
                                    },
                                ];

                                return $fields;
                            },
                        ]);

                        GraphQL::addType($typeDefinition, $name);

                        return [
                            $name => [
                                'type' => \GraphQL\Type\Definition\Type::listOf(GraphQL::type($name)),
                                'resolve' => function ($root, array $args) use ($group) {
                                    if ($root->_field_type != 'field_group' || $root->_field_name != $group->group->short_name) {
                                        return null;
                                    }

                                    return $root->fields;
                                },
                            ],
                        ];
                    }))
                        ->toArray();

                    $fields['_field_name'] = [
                        'type' => \GraphQL\Type\Definition\Type::string(),
                        'resolve' => function ($root, array $args) {
                            return $root->_field_name ?? $root->field->field_name;
                        },
                    ];

                    $fields['_field_type'] = [
                        'type' => \GraphQL\Type\Definition\Type::string(),
                        'resolve' => function ($root, array $args) {
                            return $root->_field_type ?? $root->field->field_type;
                        },
                    ];

                    return $fields;
                },
            ]);
        }

        /**
         * If we are configured to prefer union types we set up the individual field
         * Types and then move on to creating the Union Type
         */
        $fields = $fields->merge($groups->map->fields->flatten())->filter(function ($field) use ($groups) {
            if ($conflictingName = $groups->has($field->field_name)) {
                app('log')->warning(vsprintf('Fluid Field skipping GraphQL type for "%s" field due to conflict with group name.', [
                    $field->field_name,
                ]));
            }

            return ! $conflictingName;
        });

        $fields->each(function ($field) {
            $name = "fluid__{$field->field_name}";

            if (GraphQL::hasType($name)) {
                return;
            }

            $typeDefinition = new GeneratedType([
                'name' => $name,
                'fields' => function () use ($field) {
                    return [
                        'content' => new Fields\Fieldtype([
                            'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: \GraphQL\Type\Definition\Type::string(),
                            'field' => $field,
                            'selectable' => false,
                            'is_relation' => false,
                            'resolve' => function ($root, array $args) {
                                return $root;
                            },
                        ]),
                    ];
                },
            ]);
            GraphQL::addType($typeDefinition, $name);
        });

        return new GeneratedUnionType([
            'types' => function () use ($fields, $groups) {
                $fields = $fields->flatmap(function ($field) {
                    $name = "fluid__{$field->field_name}";

                    return [
                        $name => GraphQL::type($name),
                    ];
                });

                $fields = $fields->merge($groups->flatMap(function ($group) {
                    $groupName = "fluid__{$group->group->short_name}";

                    if (! GraphQL::hasType($groupName)) {
                        $typeDefinition = new GeneratedType([
                            'name' => $groupName,
                            'fields' => function () use ($group, $groupName) {
                                $groupFieldsName = "{$groupName}_fields";
                                $fieldsType = new GeneratedUnionType([
                                    'name' => $groupFieldsName,
                                    'types' => function () use ($group) {
                                        return $group->fields->flatmap(function ($field) {
                                            $name = "fluid__{$field->field_name}";

                                            return [
                                                $name => GraphQL::type($name),
                                            ];
                                        })->toArray();
                                    },
                                    'resolveType' => function ($value) {
                                        if (! $value instanceof FieldContent) {
                                            return null;
                                        }

                                        return GraphQL::type("fluid__{$value->field->field_name}");
                                    },
                                ]);

                                GraphQL::addType($fieldsType, $groupFieldsName);

                                return [
                                    'name' => [
                                        'type' => \GraphQL\Type\Definition\Type::string(),
                                        'resolve' => function ($root, array $args) {
                                            return $root->group_name;
                                        },
                                    ],
                                    'fields' => [
                                        'type' => \GraphQL\Type\Definition\Type::listOf(GraphQL::type($groupFieldsName)),
                                        'resolve' => function ($root, array $args) use ($group) {
                                            if (! $root instanceof FieldGroupContent && $root->short_name != $group->group->short_name) {
                                                return null;
                                            }

                                            return $root->fields()->toArray();
                                        },
                                    ],
                                ];
                            },

                        ]);
                        GraphQL::addType($typeDefinition, $groupName);
                    }

                    return [
                        $groupName => GraphQL::type($groupName),
                    ];
                }));

                return $fields->toArray();
            },
            'resolveType' => function ($value) {
                $name = '';

                if ($value instanceof FieldContent) {
                    $name = "fluid__{$value->field->field_name}";
                } elseif ($value instanceof FieldGroupContent) {
                    $name = "fluid__{$value->short_name}";
                }

                return GraphQL::hasType($name) ? GraphQL::type($name) : null;
            },
        ]);
    }
}
