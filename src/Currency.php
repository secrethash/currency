<?php
namespace Clippedcode\Currency;

/**
 * Smart Conversion Library that uses Online
 * convertors to convert currency using their
 * APIs. This Library is Developed and Maintained
 * by Shashwat Mishra <shashwat9630@gmail.com>
 * 
 * This Library is bounded by License(s) that are to be purchased
 * online @ clippedcode.com
 * Using this Library without any License is Strictly Prohibitted
 * and any such use is not legal.
 * Any license that is purchased from clippedcode.com is valid for
 * lifetime for that particular user for the use limited by the license's
 * Terms and Conditions. The support is limited as it is mentioned on the website.
 */

use Clippedcode\Currency\Config;
use Clippedcode\Currency\Providers\ {
    SmartConvert\API,
    Exchangerate\Exchangerate,
    Currencylayer\Currencylayer
};


class Currency {

    /**
     * Loading Configurations
     * 
     * @var config
     */
    protected $config;

    /**
     * Path to the Provider's Repository
     * 
     * @var _provider_path
     */
    protected $_provider_path;

    /**
     * Constant Variable
     */
    const PROVIDER = 'Providers';
    const DIR_SEPERATOR = '\\';
    const LIBRARY = 'Clippedcode\Currency';

    /**
     * Constructing the main function
     * 
     * @return mixed
     */
    public function __construct()
    {
        // Convert the Config to an Object
        $config = new Config;
        $this->config = (object) $config->value;
        // Load the Provider
        // self::getProvider();

    }

    /**
     * Performs Currency Conversions
     * 
     * @access public
     * @param  int $amount Amount to be converted
     * @param  string $from Currency Code to convert "from"
     * @param  string $to Currency code to convert "to" Default=INR
     * @return string Returns json data
     */
    public function convert($amount, $from, $to)
    {
        //
        
        if($from===$to)
        {
            return round($amount, 2);
        }

        if (!$this->config->selfdrive)
        {
            $getProvider = self::getProvider();
            if ($getProvider)
            {
                // $provider = ucfirst($this->config->default);
                $provider = new $this->_provider_path;
                return $provider::convert($amount, $from, $to);
            }
        }
        $smart = new API;
        return $smart->convert($amount, $from, $to);
    }

    /**
     * Convert using Specified Provider
     * 
     * @var string provider
     * @var float amount
     * @var string from
     * @var string to
     */
    public function convertWith($provider, $amount, $from, $to)
    {

        if($from===$to)
        {
            return round($amount, 2);
        }
        
        $getProvider = self::getProvider($provider);
        if ($getProvider)
        {
            $provider = new $this->_provider_path;
            return $provider::convert($amount, $from, $to);
        }
        return FALSE;
    }

    /**
     * Select the Provider
     * 
     * @return bool
     */
    public function getProvider($provider = '')
    {
        $definedProvider = empty($provider) ? ucfirst($this->config->default) : ucfirst($provider);
        $providerFile = self::PROVIDER.self::DIR_SEPERATOR.$definedProvider.self::DIR_SEPERATOR.$definedProvider;
        $path = self::LIBRARY.self::DIR_SEPERATOR.$providerFile;

        if(class_exists($path))
        {
            $this->_provider_path = self::LIBRARY.self::DIR_SEPERATOR.$providerFile;
            return true;
        }

        return false;
    }

    /**
     * Load the Provider
     * 
     * @return mixed
     */
    public function loadProvider($toPath)
    {
        if(file_exists($toPath))
        {
            require ($toPath);
        }
    }
}