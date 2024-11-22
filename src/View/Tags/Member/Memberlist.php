<?php

namespace Expressionengine\Coilpack\View\Tags\Member;

use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;
use Expressionengine\Coilpack\View\Traits\CreatesHtmlForm;

class Memberlist extends AddonTag
{
    use CreatesHtmlForm, InteractsWithAddon {
        CreatesHtmlForm::run as parentRun;
        CreatesHtmlForm::open as parentOpen;
    }

    protected $signature = 'member:memberlist';

    public function run()
    {
        $this->setArgument('paginate', 'hidden');
        $this->setArgument('tagdata', '{!-- coilpack:fake --}');
        $tagResult = parent::run()->toArray();

        // Cast member dates
        $dates = [
            'last_visit',
            'last_activity',
            'join_date',
            'last_entry_date',
            'last_comment_date',
            'last_forum_post_date',
        ];

        foreach ($tagResult['member_rows'] ?? [] as $key => $row) {
            foreach ($dates as $date) {
                if (isset($row[$date]) && ! empty($row[$date])) {
                    $tagResult['member_rows'][$key][$date] = \Carbon\Carbon::createFromTimestamp($row[$date]);
                }
            }
        }

        $this->setFormAttributes($tagResult);

        return $this;
    }
}
