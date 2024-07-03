<?php

namespace Expressionengine\Coilpack\Api\Graph;

use Rebing\GraphQL\Support\Facades\GraphQL as RebingGraphQL;

class SchemaManager
{
    protected $queries = [
        'me' => Queries\MemberCurrentQuery::class,
        'members' => Queries\MembersQuery::class,
        'variables' => Queries\VariablesQuery::class,
    ];

    protected $types = [
        'Category' => Types\Category::class,
        'Channel' => Types\Channel::class,
        'ChannelEntry' => Types\ChannelEntry::class,
        'Fieldtypes__File' => Types\Fieldtypes\File::class,
        'KeyedValue' => Types\KeyedValue::class,
        'Member' => Types\Member::class,
        'NavItem' => Types\NavItem::class,
        'Status' => Types\Status::class,
        'Variables' => Types\Variables::class,
    ];

    protected $middleware = [
        \Expressionengine\Coilpack\Middleware\AuthenticateGraphQL::class,
    ];

    public function enable()
    {
        config()->set(['graphql.schemas.coilpack' => Schema::class]);
    }

    public function setAsDefault()
    {
        config()->set('graphql.default_schema', 'coilpack');
    }

    public function disableGraphiQL()
    {
        config()->set(['graphiql.enabled' => false]);
    }

    public function addQuery($className, $alias = null)
    {
        if ($alias) {
            $this->queries[$alias] = $className;
        } else {
            $this->queries[] = $className;
        }
    }

    public function getQueries()
    {
        return $this->queries;
    }

    public function addType($className, $alias)
    {
        $this->types[$alias] = $className;
        RebingGraphQL::addType($className, $alias);

        return RebingGraphQL::type($alias);
    }

    public function hasType($name)
    {
        return array_key_exists($name, $this->types);
    }

    public function type($name)
    {
        if (! array_key_exists($name, $this->types)) {
            throw new \Exception("Type '$name' not registered");
        }

        return RebingGraphQL::type($name);
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function addMiddleware($className)
    {
        if (! in_array($className, $this->middleware)) {
            $this->middleware[] = $className;
        }
    }

    public function paginate($typename, $customName = null)
    {
        return RebingGraphQL::paginate($typename, $customName);
    }

    public function simplePaginate($typename, $customName = null)
    {
        return RebingGraphQL::simplePaginate($typename, $customName);
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}
