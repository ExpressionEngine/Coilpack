<?php

namespace Expressionengine\Coilpack\Models\Member;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\Permission\Permission;
use Expressionengine\Coilpack\Models\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Member
 *
 * A member of the website.  Represents the user functionality
 * provided by the Member module.  This is a single user of
 * the website.
 */
class Member extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $primaryKey = 'member_id';

    protected $table = 'members';

    protected $casts = [
        'cp_homepage_channel' => 'json',
    ];

    protected static $_relationships = [
        'PrimaryRole' => [
            'type' => 'belongsTo',
            'model' => 'Role',
            'to_key' => 'role_id',
            'from_key' => 'role_id',
        ],
        'Roles' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => [
                'table' => 'members_roles',
            ],
            'weak' => true,
        ],
        'RoleGroups' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'RoleGroup',
            'pivot' => [
                'table' => 'members_role_groups',
            ],
            'weak' => true,
        ],
        'AuthoredChannelEntries' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntry',
            'to_key' => 'author_id',
        ],

        'UploadedFiles' => [
            'type' => 'hasMany',
            'model' => 'File',
            'to_key' => 'uploaded_by_member_id',
            'weak' => true,
        ],
        'ModifiedFiles' => [
            'type' => 'hasMany',
            'model' => 'File',
            'to_key' => 'modified_by_member_id',
            'weak' => true,
        ],
        'VersionedChannelEntries' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntryVersion',
            'to_key' => 'author_id',
        ],
        'ChannelEntryAutosaves' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntryAutosave',
            'to_key' => 'author_id',
        ],
        'Comments' => [
            'type' => 'hasMany',
            'model' => 'Comment',
            'to_key' => 'author_id',
        ],

        'SiteStatsIfLastMember' => [
            'type' => 'hasOne',
            'model' => 'Stats',
            'to_key' => 'recent_member_id',
            'weak' => true,
        ],
        'CommentSubscriptions' => [
            'type' => 'hasMany',
            'model' => 'CommentSubscription',
        ],
        'NewsView' => [
            'type' => 'hasOne',
            'model' => 'MemberNewsView',
        ],
        'AuthoredConsentRequests' => [
            'type' => 'hasMany',
            'model' => 'ConsentRequestVersion',
            'to_key' => 'author_id',
            'weak' => true,
        ],
        'ConsentAuditLogs' => [
            'type' => 'hasMany',
            'model' => 'ConsentAuditLog',
        ],
        'Consents' => [
            'type' => 'hasMany',
            'model' => 'Consent',
        ],

        'RememberMe' => [
            'type' => 'hasMany',
        ],
        'Session' => [
            'type' => 'hasMany',
        ],
        'Online' => [
            'type' => 'hasMany',
            'model' => 'OnlineMember',
        ],
    ];

    public function channelEntries()
    {
        return $this->hasMany(ChannelEntry::class, 'author_id');
    }

    public function data()
    {
        return $this->hasOne(MemberData::class, 'member_id', 'member_id')->customFields();
    }

    public function primaryRole()
    {
        return $this->belongsTo(Role\Role::class, 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role\Role::class, 'members_roles', 'member_id', 'role_id');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role\MemberRole::class, 'member_id', 'role_id');
    }

    public function roleGroups()
    {
        return $this->belongsToMany(Role\RoleGroup::class, 'members_role_groups', 'member_id', 'group_id');
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'member_id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function __get($key)
    {
        // First we check if the model actually has a value for this attribute
        $value = parent::__get($key);

        // If we're trying to get a $key that corresponds to a Field::$field_name
        // we will forward the check to the entry's data

        if (is_null($value) && app(FieldtypeManager::class)->hasField($key, 'member')) {
            $this->getRelationValue('data');
            $value = ($this->data && $this->data->fields()->has($key)) ? $this->data->fields()->get($key) : new FieldContent([
                'field' => app(FieldtypeManager::class)->getField($key, 'member'),
                'data' => null,
                'entry' => $this,
            ]);
        }

        return $value;
    }
}
