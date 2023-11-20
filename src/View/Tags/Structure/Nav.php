<?php

namespace Expressionengine\Coilpack\View\Tags\Structure;

use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\NavOutput;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\Tag;
use GraphQL\Type\Definition\Type;

class Nav extends Tag implements ConvertsToGraphQL
{
    use InteractsWithAddon;

    private $structure = null;

    public function __construct()
    {
        // Might want to wrap this in try/catch in case structure is not installed but this tag is called
        $this->structure = $this->getAddonModuleInstance('structure');
    }

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
            new Parameter([
                'name' => 'start_from',
                'type' => 'string',
                'description' => 'Full URI used to indicate where to begin revealing children.',
                'defaultValue' => '/',
            ]),
            new Parameter([
                'name' => 'strict_start_from',
                'type' => 'boolean',
                'description' => 'Will NOT return a nav if there is no match to your "start_from" parameter. Normally, if there is no match, Structure returns the full nav starting from the base of your website.',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'mode',
                'type' => 'string',
                'description' => '',
                'defaultValue' => 'sub',
            ]),
            new Parameter([
                'name' => 'show_depth',
                'type' => 'integer',
                'description' => 'Reveals XX levels deep for ALL children pages of the current start_from parameter.',
                'defaultValue' => 2,
            ]),
            new Parameter([
                'name' => 'max_depth',
                'type' => 'integer',
                'description' => 'Only show up to X levels deep from the current start_from parameter.',
                'defaultValue' => -1,
            ]),
            new Parameter([
                'name' => 'status',
                'type' => 'string',
                'description' => 'Restrict pages by status. When prefixed with "not" all entries except those are available.',
                'defaultValue' => 'open',
            ]),
            new Parameter([
                'name' => 'include',
                'type' => 'string',
                'description' => 'Selectively show specific pages from the same level.',
            ]),
            new Parameter([
                'name' => 'exclude',
                'type' => 'string',
                'description' => 'Used to hide any single or multiple user defined entry numbers using the pipe character. All children under a specified ID will be hidden as well.',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'string',
                'description' => 'Allows you to show or not show expired entries within the navigation tree.',
                'defaultValue' => 'no',
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'string',
                'description' => 'Allows you to show or not show future entries within the navigation tree.',
                'defaultValue' => 'no',
            ]),
            new Parameter([
                'name' => 'override_hidden_state',
                'type' => 'string',
                'description' => 'Show all pages regardless of whether they\'re set to be hidden from the nav.',
                'defaultValue' => 'no',
            ]),
            new Parameter([
                'name' => 'site_url',
                'type' => 'string',
                'description' => 'Include the absolute site URL in your nav links instead of relative links.',
                'defaultValue' => 'no',
            ]),
            new Parameter([
                'name' => 'site_id',
                'type' => 'string',
                'description' => '',
                'defaultValue' => ee()->config->item('site_id'),
            ]),
        ]);
    }

    public function run()
    {
        $branch_entry_id = 0; // default to 'root'

        $start_from = $this->getArgument('start_from')->value;
        $strict_start_from = $this->getArgument('strict_start_from')->value;
        $uri = $this->structure->sql->get_uri();
        $current_id = $this->hasArgument('entry_id') ? $this->getArgument('entry_id')->value : array_search($uri, $this->structure->site_pages['uris']);

        if ($start_from != '/') {
            $start_from = $this->remove_double_slashes('/'.html_entity_decode($start_from).'/');

            $settings = $this->structure->sql->get_settings();
            $trailing_slash = isset($settings['add_trailing_slash']) && $settings['add_trailing_slash'] === 'y';

            if ($trailing_slash === false) {
                $start_from = rtrim($start_from, '/');
            }

            // find 'start_from' in pages
            $found_key = array_search($start_from, $this->structure->site_pages['uris']);

            if ($found_key !== false) {
                $branch_entry_id = $found_key;
            } elseif ($strict_start_from !== false) {
                return '';
            }
        }

        $start_from = $this->remove_double_slashes($start_from);

        $tree = $this->structure->sql->get_selective_data(
            $this->getArgument('site_id')->value,
            $current_id,
            $branch_entry_id,
            $this->getArgument('mode')->value,
            $this->getArgument('show_depth')->value,
            $this->getArgument('max_depth')->value,
            $this->getArgument('status')->value,
            $this->getArgument('include')->value,
            $this->getArgument('exclude')->value,
            $this->getArgument('show_overview')->value,
            $this->getArgument('rename_overview')->value,
            $this->getArgument('show_expired')->value,
            $this->getArgument('show_future')->value,
            $this->getArgument('override_hidden_state')->value,
            $this->getArgument('recursive_overview')->value,
            $this->getArgument('include_site_url')->value
        );

        if (count($tree) < 1) {
            return [];
        }

        // Add ChannelEntry Models to Tree
        $entries = ChannelEntry::whereIn('entry_id', array_keys($tree))->get();

        $parent = null;
        $structured = [];
        $tree = array_values($tree);

        foreach ($tree as $i => &$node) {
            $node['children'] = [];
            $node['entry'] = $entries->find($node['entry_id']);
            $node['hidden'] = $node['hidden'] === 'y';
            $node['active'] = ($node['entry_id'] == $current_id);
            $node['parent'] = $parent;
            $node['url'] = $node['uri'] ?? null;
            $node['uri'] = str_replace(ee()->functions->create_url(''), '', $node['uri'] ?? null);

            if ($parent) {
                $parent['children'][] = &$node;
            } else {
                $structured[] = &$node;
            }

            // Next is deeper start new parent
            if ($node['depth'] < @$tree[$i + 1]['depth']) {
                $parent = &$node;
            // Next is shallower reset parent
            } elseif ($node['depth'] > @$tree[$i + 1]['depth']) {
                $diff = (array_key_exists($i + 1, $tree)) ? $tree[$i]['depth'] - $tree[$i + 1]['depth'] : $tree[$i]['depth'] - 1;

                // Travel up parents by the difference in depth
                while ($diff > 0) {
                    $parent = &$parent['parent'];
                    $diff--;
                }
            }
        }

        return NavOutput::make('')->array($structured);
    }

    public function remove_double_slashes($str)
    {
        return preg_replace('#(^|[^:])//+#', '\\1/', $str);
    }

    public function toGraphQL(): array
    {
        return [
            'type' => Type::listOf(GraphQL::type('NavItem')),
        ];
    }
}
