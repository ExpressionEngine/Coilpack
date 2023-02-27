<?php

namespace Expressionengine\Coilpack\Api\Graph\Support;

use Expressionengine\Coilpack\View\Tag;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TagQuery extends Query
{
    /**
     * The Tag being used in this Query
     *
     * @var Tag
     */
    protected $tag;

    /**
     * The name of this Query
     *
     * @var string
     */
    protected $name;

    public function __construct(Tag $tag, $name)
    {
        $this->tag = $tag;
        $this->name = $name;
    }

    public function type(): Type
    {
        return $this->tag->toGraphQL()['type'];
    }

    public function args(): array
    {
        if ($this->tag->toGraphQL()['args'] ?? false) {
            return $this->tag->toGraphQL()['args'];
        }

        return $this->tag->parameters()->flatMap(function ($parameter) {
            $parameter->prefix = $this->name;

            return [
                $parameter->name => $parameter->toGraphQL(),
            ];
        })->toArray();
    }

    protected function getMiddleware(): array
    {
        return array_merge($this->tag->toGraphQL()['middleware'] ?? [], $this->middleware);
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, \Closure $getSelectFields)
    {
        if ($this->tag->toGraphQL()['resolve'] ?? false) {
            return $this->tag->toGraphQL()['resolve']($args);
        }

        return $this->tag->arguments($args)->run();
    }
}
