<?php


namespace Expressionengine\Coilpack\Models\Config;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Site\Site;

/**
 * Config Model
 */
class Config extends Model
{
    protected $primaryKey = 'config_id';
    protected $table = 'config';

    protected $casts = [
        'config_id' => 'integer',
        'site_id' => 'integer',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function set__value($value)
    {
        // exception for email_newline, which uses backslashes, and is not a path variable
        if ($this->key != 'email_newline') {
            $value = str_replace('\\', '/', $value);
        }

        $this->setRawProperty('value', $value);
    }

    public function get__parsed_value()
    {
        return parse_config_variables($this->getRawProperty('value'));
    }
}


