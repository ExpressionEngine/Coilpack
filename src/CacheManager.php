<?php

namespace Expressionengine\Coilpack;

class CacheManager
{
    protected $cache;

    protected $driver;

    protected $driverName;

    protected $nativeDrivers;

    public function __construct($cache)
    {
        $this->cache = $cache;

        $drivers = [ee()->config->item('cache_driver'), ee()->config->item('cache_driver_backup')];

        $this->nativeDrivers = $this->accessRestrictedProperty($this->cache, 'valid_drivers');

        while (is_null($this->driver) && ! empty($drivers)) {
            $this->driverName = array_shift($drivers);
            $this->driver = $this->{$this->driverName};
        }
    }

    /**
     * Get a cache driver instance for the given $driver name
     *
     * @param  string  $driver
     * @return mixed
     */
    public function __get($driver)
    {
        // If this isn't a recognized EE driver let's see if Laravel can handle it
        if (! $this->isNativeDriver($driver)) {
            try {
                $instance = app('cache')->driver($driver);

                return new CacheDriver($instance);
            } catch (\InvalidArgumentException $e) {
            }
        }

        return $this->cache->$driver;
    }

    /**
     * Check to see if a given $driver name is native to ExpressionEngine
     *
     * @param  string  $driver
     * @return bool
     */
    protected function isNativeDriver($driver)
    {
        return in_array($driver, $this->nativeDrivers);
    }

    protected function accessRestrictedProperty($object, $property)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue($object);
    }

    /**
     * Returns the name of the adapter currently in use
     *
     * @return	string	Name of adapter
     */
    public function get_adapter()
    {
        return $this->driverName;
    }

    /**
     * Returns HTML form for the Caching Driver setting on the General
     * Configuration screen, and also optionally an error message if the driver
     * selected cannot be used
     *
     * @return	string	HTML dropdown and optional error message
     */
    public function admin_setting()
    {
        $adapter = ee()->config->item('cache_driver');
        $current_adapter = $this->get_adapter();

        if (empty($adapter)) {
            $adapter = 'file';
        }

        $field = ['type' => 'radio'];

        $drivers = array_merge(array_keys(config('cache.stores')), $this->nativeDrivers);

        // Create options array fit for a dropdown
        foreach ($drivers as $driver) {
            $field['choices'][$driver] = \Illuminate\Support\Str::headline($driver);
        }

        // Rename dummy driver for presentation
        $field['choices']['dummy'] = lang('disable_caching');

        // If the driver we want to use isn't what we are using, build an error
        // message
        if ($adapter !== $current_adapter or ($this->isNativeDriver($current_adapter) && ! $this->$current_adapter->is_supported())) {
            $error_key = ($adapter == 'file')
            ? 'caching_driver_file_fail' : 'caching_driver_failover';

            $field['note'] = sprintf(lang($error_key), ucwords($adapter), ucwords($this->get_adapter()));
        }

        return $field;
    }

    public function __call($method, $arguments)
    {
        if ($this->isNativeDriver($this->driverName) || in_array($method, ['unique_key'])) {
            return $this->cache->$method(...$arguments);
        }

        return $this->driver->$method(...$arguments);
    }
}
