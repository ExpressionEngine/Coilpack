<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;

class Date extends Generic
{
    public function apply(FieldContent $content, array $parameters = [])
    {
        $data = parent::apply($content, $parameters);

        // If the fieldtype has already processed and changed the $data so that
        // it is no longer a unix timestamp we will end the processing here
        if(!is_numeric((string) $data)) {
            return $data;
        }

        // If we still have a timestamp we will attempt to apply our parameters to a Carbon instance
        $date = \Carbon\Carbon::createFromTimestamp((string) $data);

        if (! $date instanceof \Carbon\Carbon) {
            return null;
        }

        $parameters['timezone'] = $parameters['timezone'] ?? 'SYSTEM';

        if ($parameters['timezone'] === 'SYSTEM') {
            $parameters['timezone'] = ee()->config->item('default_site_timezone') ?: date_default_timezone_get();
        }

        if (in_array($parameters['timezone'], \DateTimeZone::listIdentifiers())) {
            $date->setTimezone($parameters['timezone']);
        }

        if ($parameters['relative'] ?? false) {
            $data->string($date->diffForHumans());
        } elseif (isset($parameters['format'])) {
            $data->string($date->format($parameters['format']));
        }

        return $data;
    }

    public function parametersForField(?Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'format',
                'type' => 'string',
                'description' => 'Specify the format for this date',
            ]),
            new Parameter([
                'name' => 'relative',
                'type' => 'boolean',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'timezone',
                'type' => 'string',
                'description' => 'Timezone defaults to UTC. Use "SYSTEM" for the value set in ExpressionEngine',
            ]),
        ];
    }
}
