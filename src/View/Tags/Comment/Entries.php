<?php

namespace Expressionengine\Coilpack\View\Tags\Comment;

use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\View\AddonTag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Entries extends AddonTag implements ConvertsToGraphQL
{
    protected $signature = 'comment:entries';

    public function defineParameters(): array
    {
        return [
            new Parameter([
                'name' => 'author_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Member ID',
            ]),
            new Parameter([
                'name' => 'channel',
                'type' => 'string',
                'description' => 'From which channel to show the entries',
            ]),
            new Parameter([
                'name' => 'comment_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Comment ID',
            ]),
            new Parameter([
                'name' => 'dynamic',
                'type' => 'boolean',
                'description' => 'Dynamically list entries for the current page',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'entry_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Entry ID',
            ]),
            new Parameter([
                'name' => 'entry_status',
                'type' => 'string',
                'description' => 'Limit entries to the specified Entry Status',
            ]),
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of entries',
            ]),
            new Parameter([
                'name' => 'orderby',
                'type' => 'string',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'The sort order (asc/desc)',
            ]),
            new Parameter([
                'name' => 'status',
                'type' => 'string',
                'description' => 'Restrict to entries with a particular status',
            ]),
            new Parameter([
                'name' => 'site',
                'type' => 'string',
                'description' => 'Restrict entries to a particular Site ID',
                'defaultValue' => ee()->config->item('site_id'),
            ]),
            new Parameter([
                'name' => 'url_title',
                'type' => 'string',
                'description' => 'Limits the query by an entry\'s url_title',
            ]),
        ];
    }

    public function toGraphQL(): array
    {
        $type = new GeneratedType([
            'name' => 'CommentEntry',
            'description' => '',
            'fields' => [
                'allow_comments' => [
                    'type' => Type::boolean(),
                ],
                'author' => [
                    'type' => Type::string(),
                ],
                'author_id' => [
                    'type' => Type::int(),
                ],
                'avatar' => [
                    'type' => Type::boolean(),
                ],
                'avatar_image_height' => [
                    'type' => Type::int(),
                ],
                'avatar_image_width' => [
                    'type' => Type::int(),
                ],
                'avatar_url' => [
                    'type' => Type::string(),
                ],
                'can_moderate_comment' => [
                    'type' => Type::boolean(),
                ],
                'channel_id' => [
                    'type' => Type::int(),
                ],
                'channel_short_name' => [
                    'type' => Type::string(),
                ],
                'channel_title' => [
                    'type' => Type::string(),
                ],
                'channel_url' => [
                    'type' => Type::string(),
                ],
                'comment' => [
                    'type' => Type::string(),
                ],
                'comment_auto_path' => [
                    'type' => Type::string(),
                ],
                'comment_date' => [
                    'type' => Type::string(),
                ],
                'comment_entry_id_auto_path' => [
                    'type' => Type::string(),
                ],
                'comment_expiration_date' => [
                    'type' => Type::string(),
                ],
                'comment_id' => [
                    'type' => Type::int(),
                ],
                'comment_site_id' => [
                    'type' => Type::int(),
                ],
                'comment_stripped' => [
                    'type' => Type::string(),
                ],
                'comment_url' => [
                    'type' => Type::string(),
                ],
                'comment_url_title_auto_path' => [
                    'type' => Type::string(),
                ],
                'comments_disabled' => [
                    'type' => Type::boolean(),
                ],
                'comments_expired' => [
                    'type' => Type::boolean(),
                ],
                'edit_date' => [
                    'type' => Type::string(),
                ],
                'editable' => [
                    'type' => Type::boolean(),
                ],
                'email' => [
                    'type' => Type::string(),
                ],
                'entry_author_id' => [
                    'type' => Type::int(),
                ],
                'entry_id' => [
                    'type' => Type::int(),
                ],
                'group_id' => [
                    'type' => Type::int(),
                ],
                'ip_address' => [
                    'type' => Type::string(),
                ],
                'is_ignored' => [
                    'type' => Type::boolean(),
                ],
                'location' => [
                    'type' => Type::string(),
                ],
                'member_group_id' => [
                    'type' => Type::int(),
                ],
                'primary_role_id' => [
                    'type' => Type::int(),
                ],
                'name' => [
                    'type' => Type::string(),
                ],
                'permalink' => [
                    'type' => Type::string(),
                ],
                'signature' => [
                    'type' => Type::string(),
                ],
                'signature_image' => [
                    'type' => Type::boolean(),
                ],
                'signature_image_height' => [
                    'type' => Type::string(),
                ],
                'signature_image_url' => [
                    'type' => Type::string(),
                ],
                'signature_image_width' => [
                    'type' => Type::string(),
                ],
                'status' => [
                    'type' => Type::string(),
                ],
                'title' => [
                    'type' => Type::string(),
                ],
                'url' => [
                    'type' => Type::string(),
                ],
                'url_title' => [
                    'type' => Type::string(),
                ],
                'username' => [
                    'type' => Type::string(),
                ],
                'url_as_author' => [
                    'type' => Type::string(),
                ],
                'url_or_email' => [
                    'type' => Type::string(),
                ],
                'url_or_email_as_author' => [
                    'type' => Type::string(),
                ],
                'url_or_email_as_link' => [
                    'type' => Type::string(),
                ],
            ],
        ]);

        \Expressionengine\Coilpack\Facades\GraphQL::addType($type, 'CommentEntry');

        return [
            'type' => Type::listOf(GraphQL::type('CommentEntry')),
        ];
    }
}
