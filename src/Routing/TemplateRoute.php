<?php

namespace Expressionengine\Coilpack\Routing;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class TemplateRoute {

    public function __construct()
    {

    }

    // public function templates($segment, $path, callable $callback = null)
    // {
    public function __invoke($segment, $path, callable $callback = null)
    {
        $path = trim($path);
        $viewPath = null;
        // $segment = (empty($segment) || in_array($segment, ['/','\\'])) ? null : $segment;

        $viewFinder = View::getFinder();
        $namespacePaths = $viewFinder->getHints();

        if ($viewFinder->hasHintInformation($path)) {
            $namespace = explode($viewFinder::HINT_PATH_DELIMITER, $path)[0];
            $namespacePaths = $namespacePaths[$namespace];

            // It's possible that multiple view paths are registered to a namespace
            // and we are ignoring that right now
            if (count($namespacePaths) > 1) {
                throw new \Exception('Path contains a package reference with multiple view paths');
            }

            $viewPath = str_replace(
                $namespace . $viewFinder::HINT_PATH_DELIMITER,
                realpath($namespacePaths[0]) . DIRECTORY_SEPARATOR,
                $path
            );
        }

        if (!$viewPath) {
            foreach (array_merge(Arr::flatten(array_values($namespacePaths)), config('view.paths')) as $vp) {
                $vp = realpath($vp);
                if (strpos($path, $vp) === 0) {
                    $viewPath = $vp;
                }
            }
        }

        if (is_null($viewPath)) {
            throw new \Exception("Route::templates() was given path '$path' but this is not registered as a view path.");
        }

        $extensions = $viewFinder->getExtensions();
        usort($extensions, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        // travel the $path and create routes
        $templates = array();
        $directoryIterator = new \RecursiveDirectoryIterator($viewPath, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($iterator as $item) {
            // Note SELF_FIRST, so array keys are in place before values are pushed.

            $subPath = $iterator->getSubPathName();
            $hiddenFile = (Str::startsWith($subPath, '_') || Str::contains($subPath, [DIRECTORY_SEPARATOR . '_']));
            $hiddenFolder = Str::startsWith($subPath, ['layouts/']);
            $supportedExtension = in_array($item->getExtension(), $extensions);

            if ($supportedExtension && !$hiddenFile && !$hiddenFolder) {

                $directory = str_replace('\\', '/', dirname($subPath));

                $filename = $item->getBasename();
                foreach ($extensions as $extension) {
                    $filename = str_replace(".$extension", '', $filename);
                }

                // $view = str_replace('/', '.', $path . "." . $directory) . "." . $filename;
                $view = str_replace('/', '.', implode('.', array_filter([
                    $path,
                    $directory,
                    $filename
                ])));

                if (in_array($directory, ['home'])) {
                    $directory = null;
                }

                if (in_array($filename, ['index'])) {
                    $filename = null;
                }

                $url = str_replace('//', '/', implode('/', array_filter([
                    $segment,
                    $directory,
                    $filename
                ])));

                $templates[$url] = [
                    'path' => $subPath,
                    'file' => $item,
                    'view' => $view
                ];
            }
        }

        // sort templates
        // Most specific routes need to be specified first
        uksort($templates, function ($a, $b) {
            $aDepth = substr_count($a, DIRECTORY_SEPARATOR);
            $bDepth = substr_count($b, DIRECTORY_SEPARATOR);
            if ($aDepth > $bDepth) {
                return -1;
            } else if ($bDepth > $aDepth) {
                return 1;
            } else {
                return (strlen($a) >= strlen($b)) ? -1 : 1;
            }
        });

        foreach ($templates as $url => $template) {

            Route::any("$url/{any?}", function () use ($template, $callback) {
                if ($callback) {
                    $callback();
                }
                return view($template['view']);
            })
            ->where('any', '^(?!themes\/|admin\.php|images\/).*');
        }
    }
}