<?php

namespace Expressionengine\Coilpack\Contracts;

use Expressionengine\Coilpack\Models\Channel\ChannelField;

interface GeneratesGraphType
{
    public function generateGraphType(ChannelField $field);
}
