<?php

namespace Expressionengine\Coilpack\Controllers\Cp;

use CP_Controller;

class Coilpack extends CP_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (! ee('Permission')->isSuperAdmin()) {
            show_error(lang('unauthorized_access'), 403);
        }
    }

    public function overview()
    {
        ee()->view->cp_page_title = 'Coilpack Overview';
        ee()->view->cp_breadcrumbs = [
            '' => 'Coilpack'
        ];

        ee()->cp->render('coilpack:overview', [
            'header' => [
                'title' => 'Coilpack',
            ],
            'versions' => [
                'Coilpack' => \Composer\InstalledVersions::getPrettyVersion('expressionengine/coilpack'),
                'Laravel' => \Composer\InstalledVersions::getPrettyVersion('laravel/framework'),
                'MySQL' => \Illuminate\Support\Facades\DB::connection('coilpack')->scalar('select version()'),
                'PHP' => phpversion(),
                'Twig' => \Composer\InstalledVersions::getPrettyVersion('twig/twig'),
            ],
        ]);
    }

    public function graphql()
    {
        ee()->view->cp_page_title = 'Coilpack GraphQL';
        ee()->view->cp_breadcrumbs = [
            ee('CP/URL')->make('coilpack/overview')->compile() => 'Coilpack',
            '' => 'GraphQL'
        ];

        ee()->cp->render('coilpack:graphql');
    }
}
