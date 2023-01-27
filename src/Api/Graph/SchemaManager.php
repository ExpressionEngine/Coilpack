<?php

namespace Expressionengine\Coilpack\Api\Graph;

class SchemaManager
{
    protected $queries = [
        'channel_entry' => Queries\ChannelEntryQuery::class,
        'channel_entries' => Queries\ChannelEntriesQuery::class,
        'category' => Queries\CategoryQuery::class,
        'categories' => Queries\CategoriesQuery::class,
        'members' => Queries\MembersQuery::class,
        'me' => Queries\MemberCurrentQuery::class,
        'variables' => Queries\VariablesQuery::class,
    ];

    protected $types = [
        'Category' => Types\Category::class,
        'Channel' => Types\Channel::class,
        'ChannelEntry' => Types\ChannelEntry::class,
        'Member' => Types\Member::class,
        'Status' => Types\Status::class,
        'Variables' => Types\Variables::class,
        'KeyedValue' => Types\KeyedValue::class,
        'Fieldtypes__File' => Types\Fieldtypes\File::class,
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
        config()->set(['graphql.graphiql.display' => false]);
    }

    public function addQuery($className, $alias = null)
    {
        if ($alias) {
            if (array_key_exists($alias, $this->queries)) {
                throw new \Exception("Unable to add query. A query is already registered for the alias '$alias'.");
            }

            $this->queries[$alias] = $className;
        } else {
            $this->queries[] = $className;
        }
    }

    public function getQueries()
    {
        return $this->queries;
    }

    public function addType($className, $alias = null)
    {
        if ($alias) {
            if (array_key_exists($alias, $this->types)) {
                throw new \Exception("Unable to add type. A type is already registered for the alias '$alias'.");
            }

            $this->types[$alias] = $className;
        } else {
            $this->types[] = $className;
        }
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

    public function getMiddleware()
    {
        return $this->middleware;
    }
}
