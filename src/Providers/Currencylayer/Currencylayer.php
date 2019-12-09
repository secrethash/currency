<?php
namespace Clippedcode\Currency\Providers\Currencylayer;

// Personal Resources
use Clippedcode\Currency\ {
    Config,
    Engine\Backbone
};

use Gilbitron\Util\SimpleCache;

class Currencylayer extends Backbone {

    /**
     * Cache Name
     * 
     * @var const 
     */
    const CACHE = 'CurrencyConvo.currency.currencylayer';

    /**
     * Converter Function
     * 
     * @access public
     * @var float Amount
     * @var string From: USD, GBP, INR, etc.
     * @var string To: INR, USD, GBP, etc.
     */
    public function convert(float $amount, string $from, string $to)
    {
        $config = new Config;
        $config = json_decode(json_encode($config->value));
        $cache = new SimpleCache();
        $cache_data = $cache->get_cache(base64_encode(self::CACHE));
        if(!$cache_data)
        {
            $cache->cache_time = $config->cache;
            $cache->cache_path = $config->cache_path;
            if (!file_exists($config->cache_path))
            {
                mkdir($config->cache_path, 766);
            }

            $url = sprintf($config->api->currencylayer->provider, $config->api->currencylayer->key, $from.','.$to);
            $rawdata = self::curl($url);
            $data = json_decode($rawdata, true);

            if ($data['success']===true)
            {
                $toRate = $data['quotes']['USD'.$to];
                $fromRate = $data['quotes']['USD'.$from];

                if($config->cache)
                {
                   $cache->set_cache(base64_encode(self::CACHE), $rawdata); # setting Cache
                }
                return self::calculate($toRate, $fromRate, $amount);
            }

            return false;
        }
        else
        {
            $data = json_decode($cache_data, true);
            $toRate = $data['quotes']['USD'.$to];
            $fromRate = $data['quotes']['USD'.$from];
            return self::calculate($toRate, $fromRate, $amount);
        }
        
    }

    /**
     * Caculator for the Output of Conversion
     * 
     * @access protected
     * @var float toRate
     * @var float fromRate
     * @var float amount
     */
    protected function calculate($toRate, $fromRate, $amount)
    {
        // code
        $converted = ($toRate / $fromRate) * $amount;
        $resque =  round($converted, 2);
        return $resque;
    }

    /**
     * cURL for Conversion Rates
     * 
     * @var string url
     * @access protected
     */
    protected function curl($url)
    {
        $req = curl_init();
        $timeout = 0;
        curl_setopt ($req, CURLOPT_URL, $url);
        curl_setopt ($req, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt ($req, CURLOPT_USERAGENT,
                    "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($req, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($req);
        curl_close($req);
        return $rawdata;
    }
}