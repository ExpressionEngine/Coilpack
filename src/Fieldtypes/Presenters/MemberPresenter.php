<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\Member\Member;
use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;

class MemberPresenter extends Presenter
{
    use HasArgumentsAndParameters, Traits\QueriesRelationships;

    public function present(FieldContent $content, $arguments)
    {
        $query = $this->buildRelationshipQuery($content, new Member);

        return $query->get();
    }
}
