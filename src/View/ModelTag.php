<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Support\Arguments\Argument;
use Expressionengine\Coilpack\Support\Arguments\ListArgument;
use Expressionengine\Coilpack\Support\Parameter;

abstract class ModelTag extends IterableTag
{
    protected $query;

    // protected $takeFirst = false;

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
            new Parameter([
                'name' => 'with',
                'type' => 'string',
                'description' => 'A pipe separated list of relationships to eager load',
                'defaultValue' => null,
            ]),
            new Parameter([
                'name' => 'cache',
                'type' => 'integer',
                'description' => 'Number of seconds to cache results',
                'defaultValue' => null,
            ]),
        ];
    }

    public function getWithArgument($value)
    {
        return new ListArgument($value);
    }

    public function run()
    {
        $cacheKey = null;

        if ($this->hasArgument('cache')) {
            $cacheKey = $this->getCacheKey();

            if (ee()->cache->get($cacheKey) !== false) {
                return ee()->cache->get($cacheKey);
            }
        }

        if ($this->hasArgument('with')) {
            $this->query->with($this->getArgument('with')->terms->map->value->toArray());
        }

        if ($this->hasArgument('page') || $this->hasArgument('per_page')) {
            return $this->cache($cacheKey,
                $this->query->paginate(
                    $this->hasArgument('limit') ? $this->getArgument('limit')->value : $this->getArgument('per_page')->value,
                    ['*'],
                    'page',
                    $this->hasArgument('page') ? $this->getArgument('page')->value : null
                )
            );
        }

        if ($this->hasArgument('offset')) {
            $this->query->skip($this->getArgument('offset')->value);
        }

        if ($this->hasArgument('limit')) {
            $this->query->take($this->getArgument('limit')->value);
        }

        return $this->cache($cacheKey, $this->query->get());
    }

    public function __call($method, $arguments)
    {
        $result = $this->query->{$method}(...$arguments);

        if ($result instanceof $this->query) {
            return $this;
        }

        return $result;
    }

    protected function cache($key, $result)
    {
        if (! is_null($key)) {
            ee()->cache->save($key, $result, (int) $this->getArgument('cache')->value);
        }

        return $result;
    }

    protected function getCacheKey()
    {
        $class = implode('.', array_slice(explode('\\', static::class), -2, 2));
        $prefix = $this->hasArgument('cache_prefix') ? $this->getArgument('cache_prefix')->value : null;

        $arguments = $this->getArguments();
        unset($arguments['cache'], $arguments['cache_prefix']);

        foreach ($arguments as $key => $value) {
            if ($value instanceof Argument) {
                $arguments[$key] = $value->value;
            }
        }

        return implode(':', array_filter([
            'coilpack',
            strtolower($class),
            $prefix,
            md5(json_encode($arguments)),
        ]));
    }
}
