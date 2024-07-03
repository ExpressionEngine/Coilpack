<?php

namespace Expressionengine\Coilpack\Dependency;

use Expressionengine\Coilpack\Traits\CanAccessRestrictedClass;
use ExpressionEngine\Service\Sidebar\Navigation\NavigationSidebar as EENavigationSidebar;

class NavigationSidebar extends EENavigationSidebar
{
    use CanAccessRestrictedClass;

    public function render()
    {
        if (empty($this->items)) {
            $this->callRestrictedMethod($this, 'populateItems');
            if (ee('Permission')->isSuperAdmin()) {
                $section = $this->addSection('Coilpack');
                $section->addItem('Overview', ee('CP/URL', 'coilpack/overview'))->withIcon('list');
                $section->addItem('GraphQL', ee('CP/URL', 'coilpack/graphql'))->withIcon('sitemap');
            }
        }

        return parent::render();
    }
}
