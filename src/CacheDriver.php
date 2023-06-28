<?php

namespace Expressionengine\Coilpack;

use Cache;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class CacheDriver
{
    protected $repository;

    public function __construct(CacheRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Look for a value in the cache. If it exists, return the data
     * if not, return FALSE
     *
     * @param  string  $key 	Key name
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE for
     *		local or global scoping of the cache item
     * @return	mixed	value matching $key or FALSE on failure
     */
    public function get($key, $scope = Cache::LOCAL_SCOPE)
    {
        $repository = $this->repository;

        if ($repository->supportsTags() && $scope === Cache::LOCAL_SCOPE) {
            $repository = $repository->tags($this->_namespaced_key('', $scope));
        } else {
            $key = $this->_namespaced_key($key, $scope);
        }

        return $repository->has($key) ? $this->unwrapData($repository->get($key)) : false;
    }

    /**
     * Save value to cache
     *
     * @param  string  $key		Key name
     * @param  mixed  $data		Data to store
     * @param  int  $ttl = 60	Cache TTL (in seconds)
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE for
     *		local or global scoping of the cache item
     * @return	bool	TRUE on success, FALSE on failure
     */
    public function save($key, $data, $ttl = 60, $scope = Cache::LOCAL_SCOPE)
    {
        // In ExpressionEngine $ttl = 0 means cache forever
        // but in Laravel this means remove from cache, so we will translate to null
        $ttl = ((int) $ttl <= 0) ? null : (int) $ttl;

        if ($this->repository->supportsTags() && $scope === Cache::LOCAL_SCOPE) {
            return $this->repository->tags($this->_namespaced_key('', $scope))->put($key, $this->wrapData($data, $ttl), $ttl);
        }

        return $this->repository->put($this->_namespaced_key($key, $scope), $this->wrapData($data, $ttl), $ttl);
    }

    /**
     * Delete from cache
     *
     * To clear a particular namespace, pass in the namespace with a trailing
     * slash like so:
     *
     * ee()->cache->delete('/namespace_name/');
     *
     * @param  string  $key	Key name
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE for
     *		local or global scoping of the cache item
     * @return	bool	TRUE on success, FALSE on failure
     */
    public function delete($key, $scope = Cache::LOCAL_SCOPE)
    {
        if ($this->repository->supportsTags() && $scope === Cache::LOCAL_SCOPE) {
            return $this->repository->tags($this->_namespaced_key('', $scope))->forget($key);
        }

        return $this->repository->forget($this->_namespaced_key($key, $scope));
    }

    /**
     * Clean the cache
     *
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE for
     *		local or global scoping of the cache item
     * @return	bool	TRUE on success, FALSE on failure
     */
    public function clean($scope = Cache::LOCAL_SCOPE)
    {
        if ($this->repository->supportsTags() && $scope === Cache::LOCAL_SCOPE) {
            return $this->repository->tags($this->_namespaced_key('', $scope))->clear();
        }

        return $this->repository->clear();
    }

    /**
     * Cache Info
     *
     * @return	mixed	array containing cache info on success OR FALSE on failure
     */
    public function cache_info()
    {
        return null;
    }

    /**
     * Get Cache Metadata
     *
     * @param  string  $key	Key to get cache metadata on
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE for
     *		local or global scoping of the cache item
     * @return	mixed	cache item metadata
     */
    public function get_metadata($key, $scope = Cache::LOCAL_SCOPE)
    {
        $repository = $this->repository;

        if ($repository->supportsTags() && $scope === Cache::LOCAL_SCOPE) {
            $repository = $repository->tags($this->_namespaced_key('', $scope));
        } else {
            $key = $this->_namespaced_key($key, $scope);
        }

        if (! $repository->has($key)) {
            return false;
        }

        $data = $repository->get($key);

        $data = is_array($data) ? $data : compact('data');
        $data = array_merge(array_fill_keys(['ttl', 'time', 'data'], null), $data);

        // Convert a 'forever ttl' of null back to 0 for ExpressionEngine
        $data['expire'] = $data['time'] ? ($data['time'] + $data['ttl'] ?: 0) : null;
        $data['mtime'] = $data['time'];

        return $data;
    }

    /**
     * Wrap $data in an array with extra metadata to store
     *
     * @param  mixed  $data
     * @param  mixed  $ttl
     * @return array
     */
    protected function wrapData($data, $ttl)
    {
        return [
            'time' => ee()->localize->now,
            'ttl' => $ttl,
            'data' => $data,
        ];
    }

    /**
     * Extract the data key from a given $data array
     *
     * @param  mixed  $data
     * @return mixed
     */
    protected function unwrapData($data)
    {
        return (is_array($data) && array_key_exists('data', $data)) ? $data['data'] : $data;
    }

    /**
     * If a namespace was specified, prefixes the key with it
     *
     * For the file driver, namespaces will be actual folders
     *
     * @param  string  $key	Key name
     * @param  const  $scope	Cache::LOCAL_SCOPE or Cache::GLOBAL_SCOPE
     *		 for local or global scoping of the cache item
     * @return	string	Key prefixed with namespace
     */
    protected function _namespaced_key($key, $scope = Cache::LOCAL_SCOPE)
    {
        // Make sure the key doesn't begin or end with a namespace separator or
        // directory separator to force the last segment of the key to be the
        // file name and so we can prefix a directory reliably
        $key = trim($key, Cache::NAMESPACE_SEPARATOR.DIRECTORY_SEPARATOR);

        // Sometime class names are used as keys, replace class namespace
        // slashes with underscore to prevent filesystem issues
        $key = str_replace('\\', '_', $key);

        // Replace all namespace separators with the system's directory separator
        $key = str_replace(Cache::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $key);

        // For locally-cached items, separate by site name
        if ($scope == Cache::LOCAL_SCOPE) {
            $key = (! empty(ee()->config->item('site_short_name')) ? ee()->config->item('site_short_name').DIRECTORY_SEPARATOR : '').$key;
        }

        return $key;
    }
}
