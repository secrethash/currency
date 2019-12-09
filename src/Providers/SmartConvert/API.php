<?php
namespace Clippedcode\Currency\Providers\SmartConvert;

use Clippedcode\Currency\ {
    Config,
    Engine\Backbone,
    // Providers
    Providers\Currencylayer\Currencylayer,
    Providers\Exchangerate\Exchangerate
};

class API extends Backbone {

    /**
     * Configuration
     * 
     * @access protected
     */
    protected $config;

    /**
     * Initializing the Class
     */
    public function __construct()
    {
        $config = new Config;
        $this->config = json_decode(json_encode($config->all()));
    }

    /**
     * Converts using Smart Conversion
     * 
     * @return float
     */
    public function convert($amount, $from, $to)
    {
        if ($this->config->api->currencylayer->key != NULL)
        {
            $conv = Currencylayer::convert($amount, $from, $to);

            if(!$conv)
            {
                if ($config->api->exchangerate->key != NULL)
                {
                    return Exchangerate::convert($amount, $from, $to);
                }
                return false;
            }

            return $conv;
        }
        elseif ($config->api->exchangerate->key != NULL)
        {
            return Exchangerate::convert($amount, $from, $to);
        }

        return false;
    }
}