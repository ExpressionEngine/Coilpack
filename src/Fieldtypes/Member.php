<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Presenters\MemberPresenter;
use Expressionengine\Coilpack\Models\FieldContent;

class Member extends Fieldtype implements ListsGraphType
{
    protected $presenter;

    public function __construct(string $name, $id = null)
    {
        parent::__construct($name, $id);
        $this->presenter = new MemberPresenter;
    }

    public function apply(FieldContent $content, $parameters = [])
    {
        $data = $this->presenter->present($content, $parameters);

        return FieldtypeOutput::for($this)->value($data);
    }

    public function parametersForField(?Field $field = null): array
    {
        return $this->presenter->defineParameters();
    }

    public function graphType()
    {
        return 'Member';
    }
}
