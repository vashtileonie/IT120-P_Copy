<?php

namespace App\Traits;

use App\Models\Config;

trait ConfigTrait
{
    /**
     * Returns the Config value according to Alias
     *
     * @param string $alias
     * @return mixed
     */
    protected function configValue(string $alias)
    {
        // find config
        $config = Config::where('field_alias', $alias)->first();

        // validate
        if (! is_null($config)) {
            return $config->config_value;
        }

        return null;
    }
}