<?php
namespace Clippedcode\Currency;

class Config {

    public $value = array();

    public function __construct($key = '')
    {
        $config = require 'config/config.php';

        $this->value = $config;

        if (!empty($key))
        {
            return self::get($key);
        }
    }

    /**
     * Set Config Values
     * 
     * @access public
     */
    public function set($mixed, $value='')
    {
        if (is_array($mixed))
        {
            return self::setConfigValue($mixed);
        }
        else
        {
            return self::setConfigValue(array($mixed => $value));
        }
    }

    /**
     * Seting the Configuration Value
     * 
     * @return mixed
     */
    public function setConfigValue(array $array)
    {
        foreach ($array as $key => $value)
        {
            if(array_key_exists($key, $this->value))
            {
                $this->value[$key] = $value;
            } else { return FALSE; }
        }
        return TRUE;
    }

    /**
     * Get Configuration Value
     * 
     * @return mixed
     */
    public function get($key)
    {
        return $this->value[$key];
    }
    
    /**
     * Get All Configuration Values
     */
    public function all()
    {
        return $this->value;
    }

}