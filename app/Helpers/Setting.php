<?php

namespace App\Helpers;

use App\Model\Setting as SettingModel;

class Setting
{
    /**
     * Get setting.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = false)
    {
        $setting = SettingModel::name($name)->first();

        if (!$setting) {
            return $default;
        }

        return unserialize($setting->value);
    }

    /**
     * Set setting.
     *
     * @param string $name
     * @param mixed $value
     * @return boolean
     */
    public function set($name, $value)
    {
        $setting = SettingModel::name($name)->first();
        $setting = ($setting) ? $setting : new SettingModel;
        $setting->name = $name;
        $setting->value = serialize($value);

        return $setting->save();
    }
}
