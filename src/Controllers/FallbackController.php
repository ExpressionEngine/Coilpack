<?php

namespace Expressionengine\Coilpack\Controllers;

use Expressionengine\Coilpack\Bootstrap;
use ExpressionEngine\Core;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class FallbackController extends Controller
{
    public function __construct()
    {
        if (! $this->isAssetRequest()) {
            $this->middleware('web');
        }
    }

    public function index()
    {
        if ($this->isAssetRequest()) {
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

    private function isAssetRequest()
    {
        $assetFolders = [
            'themes',
            'images',
        ];

        return in_array(Request::segment(1), $assetFolders);
    }
}
