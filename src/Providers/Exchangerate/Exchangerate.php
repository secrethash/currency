<?php
namespace Secrethash\Currency\Providers\Exchangerate;

use Secrethash\Currency\Engine\Backbone;
use Gilbitron\Util\SimpleCache;
use Secrethash\Currency\Config;

class Exchangerate extends Backbone {

    /**
     * Cache Name
     * 
     * @var const 
     */
    const CACHE = 'CurrencyConvo.currency.exchangerate';
    
    /**
     * Converter Function
     * 
     * @access public
     * @var float Amount
     * @var string From: USD, GBP, INR, etc.
     * @var string To: INR, USD, GBP, etc.
     */
    public function convert($amount, $from, $to)
    {
        $config = new Config;
        $config = json_decode(json_encode($config->value));
        $cache = new SimpleCache();
        $cache_data = $cache->get_cache(base64_encode(self::CACHE));
        if (!$cache_data)
        {
            $cache->cache_time = $config->cache;
            $cache->cache_path = $config->cache_path;
            if (!file_exists($config->cache_path))
            {
                mkdir($config->cache_path, 766);
            }
            
            $url = sprintf($config->api->exchangerate->provider, $config->api->exchangerate->key, $from, $to);
            $rawdata = $cache->do_curl($url);
            $data = json_decode($rawdata, true);

            if ($data['result']==='success')
            {
                $resque = Self::calculate($data['rate'], $amount);
                if($config->cache)
                {
                   $cache->set_cache(base64_encode(self::CACHE), $rawdata);
                }
                return $resque;
            } 
            elseif ($data['result']==='error') {
                return false;
            }

        }
        else
        {
            $data = json_decode($cache_data, true);
            return Self::calculate($data['rate'], $amount);
        }

        return false;
    }

    /**
     * Calculation of the converted currency
     * @access protected
     * @return float
     */
    protected function calculate($rate, $amount)
    {
        // code
        $conv = $amount * $rate;
        $resque = round($conv, 2);
        return $resque;
    }

}
