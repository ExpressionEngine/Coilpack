<?php

namespace Expressionengine\Coilpack\Controllers;

use Expressionengine\Coilpack\Bootstrap;
use ExpressionEngine\Core;
use Illuminate\Routing\Controller;

class FallbackController extends Controller
{
    public function __construct()
    {
        if (! $this->isAssetRequest()) {
            $this->middleware('coilpack');
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

        $path = request()->path();
        $adminPrefix = trim(app('router')->getRoutes()->getByName('coilpack.admin')->getPrefix(), '/').'/';
        $pieces = explode('/', strpos($path, $adminPrefix) === 0 ? substr($path, strlen($adminPrefix)) : $path);

        return in_array($pieces[0], $assetFolders);
    }
}
