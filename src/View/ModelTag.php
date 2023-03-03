<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Support\Parameter;

abstract class ModelTag extends IterableTag
{
    protected $query;

    protected $takeFirst = false;

    public function defineParameters(): array
    {
        return [
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of results',
            ]),
            new Parameter([
                'name' => 'offset',
                'type' => 'integer',
                'description' => 'Offsets the display by X number of results',
            ]),
            new Parameter([
                'name' => 'page',
                'type' => 'integer',
                'description' => 'Which page of results to show',
                'defaultValue' => 1,
            ]),
            new Parameter([
                'name' => 'per_page',
                'type' => 'integer',
                'description' => 'How many results to show on each page',
                'defaultValue' => 10,
            ]),
        ];
    }

    public function getLimitArgument($count)
    {
        $this->query->take($count);

        if ($count == 1 && ! $this->hasArgument('offset')) {
            $this->takeFirst = true;
        }

        return $count;
    }

    public function run()
    {
        if ($this->hasArgument('page') || $this->hasArgument('per_page')) {
            return $this->query->paginate($this->getArgument('per_page')->value, ['*'], 'page', $this->getArgument('page')->value);
        }

        if ($this->hasArgument('offset')) {
            $this->query->skip($this->getArgument('offset'));
        } elseif ($this->hasArgument('limit')) {
            // If we have a limit but no offset we'll handle this as requesting the 'first' record
            return $this->query->first();
        }

        if ($this->hasArgument('limit')) {
            $this->query->take($this->getArgument('limit'));
        }

        return $this->query->get();
    }

    public function __call($method, $arguments)
    {
        $result = $this->query->{$method}(...$arguments);

        if ($result instanceof $this->query) {
            return $this;
        }

        return $result;
    }
}
