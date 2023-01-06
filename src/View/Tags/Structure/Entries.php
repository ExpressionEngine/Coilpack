<?php

namespace Expressionengine\Coilpack\View\Tags\Structure;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\Tags\Channel\Entries as ChannelEntriesTag;

class Entries extends ChannelEntriesTag
{
    use InteractsWithAddon;

    protected $parameters = [
        'category' => '',
        'parent_id' => false,
        'include_hidden' => 'n',
    ];

    private $structure = null;

    public function __construct()
    {
        $this->query = ChannelEntry::query();

        // Might want to wrap this in try/catch in case structure is not installed but this tag is called
        $this->structure = $this->getAddonModuleInstance('structure');
    }

    // public function setParentIdParameter($id)
    // {
    //     $this->parent_id = $id;

    //     return $id;
    // }

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
        if (is_numeric($this->getParameter('parent_id'))) {
            $child_ids = $this->structure->sql->get_child_entries(
                $this->getParameter('parent_id'),
                $this->getParameter('category'),
                $this->getParameter('include_hidden')
            );
            $fixed_order = $child_ids !== false && is_array($child_ids) && count($child_ids) > 0 ? $child_ids : false;

            if ($fixed_order) {
                $this->setFixedOrderParameter($fixed_order);
            } else {
                $this->setEntryIdParameter('-1'); // No results
            }
        }

        return parent::run();
    }
}
