<?php

namespace Expressionengine\Coilpack\View;

use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class FileViewFinder extends \Illuminate\View\FileViewFinder
{

    /**
     * Get the path to a template with a named path.
     *
     * @param  string  $name
     * @return string
     */
    protected function findNamespacedView($name)
    {
        [$namespace, $view] = $this->parseNamespaceSegments($name);

        // We are treating the 'ee' namespace specially to avoid adding extra
        // file options and lookups on non-expressionengine view files
        if($namespace === 'ee') {
            return $this->findInPathsForEE($view, $this->hints[$namespace]);
        }

        return $this->findInPaths($view, $this->hints[$namespace]);
    }

    /**
     * Find the given view in the list of paths.
     *
     * @param  string  $name
     * @param  array  $paths
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function findInPathsForEE($name, $paths)
    {
        foreach ((array) $paths as $path) {
            foreach ($this->getPossibleViewFilesForEE($name) as $file) {
                if ($this->files->exists($viewPath = $path . '/' . $file)) {
                    return $viewPath;
                }
            }
        }

        throw new InvalidArgumentException("View [{$name}] not found.");
    }


    /**
     * Get an array of possible view files.
     *
     * @param  string  $name
     * @return array
     */
    protected function getPossibleViewFilesForEE($name)
    {
        // @todo remove this check after changes are made to api_template_structure
        // in core and the alpha is over, we'll just require the EE version that has this
        if (method_exists(ee()->api_template_structure, 'all_file_extensions')) {
            $extensions = array_keys(ee()->api_template_structure->all_file_extensions());
        } else {
            $extensions = array_map(function ($extension) {
                return '.' . $extension;
            }, $this->extensions);
        }

        // Replace all dots with forward slashes unless the dot is part of .group
        $files = array_map(function ($extension) use ($name) {
            return preg_replace('/[.](?!group)/', '/', $name)  . $extension;
        }, $extensions);

        // The second to last segment could be a group folder
        if(!str_contains($name, '.group')) {
            $files = array_merge($files, array_map(function($path) {
                return substr_replace($path, '.group/', strrpos($path, '/'), 1);
            }, $files));
        }

        // Allow site short name to be omitted from the name
        $siteShortName = ee()->config->item('site_short_name');
        if (!str_contains($name, $siteShortName)) {
            $files = array_merge($files, array_map(function ($path) use ($siteShortName) {
                return $siteShortName .'/'. $path;
            }, $files));
        }

        return $files;
    }
}
