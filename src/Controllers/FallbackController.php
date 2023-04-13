<?php

namespace Expressionengine\Coilpack\Controllers;

use Expressionengine\Coilpack\Bootstrap;
use ExpressionEngine\Core;
use Illuminate\Support\Facades\Request;

class FallbackController
{
    public function index()
    {
        $assetFolders = [
            'themes',
            'images',
        ];

        if (in_array(Request::segment(1), $assetFolders)) {
            (new Bootstrap\LoadExpressionEngine)->asset()->bootstrapDependencies(app());

            return (new AssetController)();
        } else {
            $core = (new Bootstrap\LoadExpressionEngine)->page()->bootstrap(app());

            if (! $core) {
                return view('coilpack::incomplete');
            }

            $request = Core\Request::fromGlobals();

            return $core->runGlobal();
        }
    }
}
