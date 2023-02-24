<?php

namespace Expressionengine\Coilpack\View\Tags\Structure;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\TypedParameter as Parameter;
use Expressionengine\Coilpack\View\Tags\Channel\Entries as ChannelEntriesTag;

class Entries extends ChannelEntriesTag
{
    use InteractsWithAddon;

    private $structure = null;

    public function __construct()
    {
        parent::__construct();

        $this->query = ChannelEntry::query();

        // Might want to wrap this in try/catch in case structure is not installed but this tag is called
        $this->structure = $this->getAddonModuleInstance('structure');
    }

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
            new Parameter([
                'name' => 'parent_id',
                'type' => 'string',
                'description' => 'Limit the entries to children of a specific Entry ID',
            ]),
            new Parameter([
                'name' => 'include_hidden',
                'type' => 'boolean',
                'description' => 'Allow hidden entries to be displayed',
                'defaultValue' => false,
            ]),
        ]);
    }

    public function getIncludeHiddenArgument($value)
    {
        return ($value === true || $value == 'y') ? 'y' : 'n';
    }

    public function dynamic()
    {
        $uricount = ee()->uri->total_segments();

        // Let's iterate through all the segment URIs for the trigger word
        for ($x = 1; $x <= $uricount; $x++) {
            if (ee()->uri->segment($x) == $this->cat_trigger) {
                $this->cat = ee()->uri->segment($x + 1);

                break;
            }
        }

        return $this;
    }

    public function run()
    {
        // This code is adapted from the Structure Mod's entries() function
        if (is_numeric($this->getArgument('parent_id')->value)) {
            $child_ids = $this->structure->sql->get_child_entries(
                $this->getArgument('parent_id')->value,
                $this->getArgument('category')->value ?: $this->getArgument('category_id')->value,
                $this->getArgument('include_hidden')
            );

            $fixed_order = ($child_ids !== false && is_array($child_ids) && count($child_ids) > 0) ? $child_ids : false;

            if ($fixed_order) {
                $this->setArgument('fixed_order', $fixed_order);
            } else {
                $this->setArgument('entry_id', '-1'); // No results
            }
        }

        return parent::run();
    }
}
