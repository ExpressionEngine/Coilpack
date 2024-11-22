<?php

namespace Expressionengine\Coilpack\View\Tags\Member;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Member\Member;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;

class CustomProfileData extends AddonTag
{
    use InteractsWithAddon;

    protected $signature = 'member:custom_profile_data';

    public function run()
    {
        $profileData = parent::run();

        // Add custom fields as Coilpack Field Models
        $member = Member::find($profileData['member_id']);

        foreach (app(FieldtypeManager::class)->allFields('member') as $field) {
            $profileData[$field->m_field_name] = $member->{$field->m_field_name};
        }

        // Cast member dates
        $dates = [
            'last_visit',
            'last_activity',
            'join_date',
            'last_entry_date',
            'last_comment_date',
            'last_forum_post_date',
        ];

        foreach ($dates as $date) {
            if (isset($profileData[$date]) && ! empty($profileData[$date])) {
                $profileData[$date] = \Carbon\Carbon::createFromTimestamp($profileData[$date]);
            }
        }

        $profileData['local_time'] = \Carbon\Carbon::now()->timezone($member->timezone ?? 'UTC');

        return $profileData;
    }
}
