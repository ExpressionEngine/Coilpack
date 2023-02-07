<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Collection;

abstract class Fieldtype
{
    public $name;

    public $id;

    private $modifiers;

    public function __construct(string $name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Apply the fieldtype to the data in provided
     *
     * @param  FieldContent  $content
     * @return FieldtypeOutput
     */
    abstract public function apply(FieldContent $content, array $parameters = []);

    public function parameters(ChannelField $field = null)
    {
        return [];
    }

    /**
     * Retrieve a collection of Modifiers for this Fieldtype
     *
     * @return Illuminate\Support\Collection
     */
    final public function modifiers(): Collection
    {
        if (is_null($this->modifiers)) {
            $modifiers = $this->bootModifiers();
            $this->modifiers = collect($modifiers)->keyBy('name');
        }

        return clone $this->modifiers;
    }

    /**
     * Setup the list of Modifiers for this Fieldtype
     *
     * @return Modifier[]
     */
    public function bootModifiers(): array
    {
        return [];
    }

    /**
     * Determine whether the given modifier exists on this fieldtype
     *
     * @param  string  $name
     * @return bool
     */
    public function hasModifier($name)
    {
        return $this->modifiers()->has($name);
    }

    /**
     * Call a modifier on the given field content
     *
     * @param  FieldtypeOutput  $content
     * @param  string  $name
     * @param  array  $parameters
     * @return FieldtypeOutput
     */
    public function callModifier(FieldtypeOutput $content, string $name, array $parameters = [])
    {
        if ($this->hasModifier($name) && $this->modifiers()->get($name) instanceof Modifier) {
            return $this->modifiers()->get($name)->handle($content, $parameters);
        }
    }

    /**
     * The GraphQL Type that represents this Fieldtype
     *
     * @return Rebing\GraphQL\Support\Type|string
     */
    public function graphType()
    {
        return \GraphQL\Type\Definition\Type::string();
    }
}
