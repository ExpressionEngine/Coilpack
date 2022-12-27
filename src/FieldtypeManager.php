<?php

namespace Expressionengine\Coilpack;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;


class FieldtypeManager {

    private $booted = false;
    private $classMap = [];
    private $fields = [];
    private $fieldtypes;
    private $channels;
    private $categoryGroups;

    public function boot()
    {
        if($this->booted) {
            return $this;
        }

        // Load fields - constrain selects on relations, do not need full models
        $fields = Models\Channel\ChannelField::with([
            'channels' => function($query) {
                $query->select('channels.channel_id');
            },
            'fieldGroups.channels' => function($query) {
                $query->select('channels.channel_id');
            },
            'gridColumns',
        ])->get()->keyBy('field_name');

        // Load extra information for complex fields
        // $gridColumns = Models\Addon\Grid\Column::get();

        // Group fields by channel
        $channels = $fields->reduce(function($carry, $field) {
            $field->fieldGroups->map->channels
                ->merge($field->channels)
                ->flatten()
                ->each(function($channel) use($field, $carry) {
                    $carry->getOrPut($channel->channel_id, new Collection)->push($field);
                });

            return $carry;
        }, new Collection);

        $this->fields = [
            'channel' => $fields,
        ];

        // @todo lazy load member fields they aren't used as often
        // move all field loaders to a separate class and only boot them when needed
        // otherwise we're adding a lot of queries to a control panel page
        $this->loadMemberFields();
        $this->loadCategoryFields();

        $this->channels = $channels;
        $this->fieldtypes = Models\Addon\Fieldtype::get()->keyBy('name');

        return $this;
    }

    public function loadMemberFields()
    {
        if(array_key_exists('member', $this->fields) && !empty($this->fields['member'])) {
            return $this;
        }

        $memberFields = Models\Member\MemberField::get()->keyBy('m_field_name');
        $this->fields['member'] = $memberFields;

        return $this;
    }

    public function loadCategoryFields()
    {
        if (array_key_exists('category', $this->fields) && !empty($this->fields['category'])) {
            return $this;
        }

        $categoryFields = Models\Category\CategoryField::get()->keyBy('field_name');
        $this->fields['category'] = $categoryFields;

        // Group fields by category group
        $this->categoryGroups = $categoryFields->reduce(function ($carry, $field) {
            $carry->getOrPut($field->group_id, new Collection)->push($field);
            return $carry;
        }, new Collection);

        return $this;
    }

    public function hasField($field, $source = 'channel')
    {
        return $this->fields[$source]->has($field);
    }

    public function getField($field, $source = 'channel')
    {
        return $this->fields[$source]->get($field);
    }

    public function allFields($source = 'channel')
    {
        return $this->fields[$source];
    }

    public function allFieldtypes()
    {
        return $this->fieldtypes;
    }

    public function fieldsForChannel($channel)
    {
        if($channel instanceof \Expressionengine\Coilpack\Models\Channel\Channel) {
            $channel = $channel->getKey();
        }

        return $this->channels->get($channel) ?: collect([]);
    }

    public function fieldsForCategoryGroup($group)
    {
        if ($group instanceof \Expressionengine\Coilpack\Models\Category\CategoryGroup) {
            $group = $group->getKey();
        }

        return $this->categoryGroups->get($group) ?: collect([]);
    }


    public function register($fieldtype, $class)
    {
        $fieldtype = strtolower($fieldtype);
        $this->classMap[$fieldtype] = $class;
    }

    public function make($name, $id = null, $source = 'channel')
    {
        $name = strtolower($name);

        if(array_key_exists($name, $this->classMap)) {
            $class =  $this->classMap[$name];

            if(!class_exists($class)) {
                throw new \Exception("Fieldtype class '$class' was registered for '$name' but does not exist.");
            }

            // Check that the class extends \Expressionengine\Coilpack\Fieldtypes\Fieldtype
            return new $class($name, $id);
        }

        // If a specific binding does not exist look for a fallback
        // First, a Coilpack specific implementation for the field
        // And then finally our generic fieldtype class
        $class = __NAMESPACE__ . '\Fieldtypes\\' . Str::studly($name);
        $generic = __NAMESPACE__ . '\Fieldtypes\Generic';

        $instance = (class_exists($class)) ? new $class($name, $id) : new $generic($name, $id);
        $this->classMap[$name] = get_class($instance);

        return $instance;
    }

}