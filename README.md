![Currency Tool](https://raw.githubusercontent.com/clippedcode/currency/master/display.jpg)
# Introduction

Smart Currency PHP Library utilizes the Smart Caching and Certain API providers to convert currency without having the need to pay anything. It saves your quotas of free plans of the API Providers. Smart Currency makes your currency conversions smarter with a "Self-drive" Mode. It utilizes Composer to manage it as a Package and helps you to use the library from your own private repository too.

You don't need to Pay Anything to any Currency Exchange API providers, all you need is their Free/Basic Accounts and feed the Smart Currency Library with your API Keys. It will smartly convert the amount to your desired Currency. We have built a self-drive mode to help you to cut the chase, just complete your configuration file with `"selfdrive"=>true` and run the Currency Conversion like a charm.

# Usage
![Just a Show-off](https://raw.githubusercontent.com/clippedcode/currency/master/just-a-showoff.png)
Currency Conversion with Smart Currency Library is as simple as:
```php
$currency = new Clippedcode\Currency\Currency;

echo $currency->convert(100, 'USD', 'INR');
```
**Follow the Steps:**
1. Require the composer autoloader:
```php
<?php
require ('vendor/autoload.php’);
```
2. Call the Package:
```php
$currency = new Clippedcode\Currency\Currency;
$currency->convert(100, 'USD’, 'INR’);
$currency->convertWith('exchangerate’, 100, 'INR’, 'USD’);
```

# Roadmap
- [ ] Laravel Service Provider
- [ ] Laravel Publish Config
- [ ] Publishing Configuration file
- [x] Smart Caching (via [gilbitron/PHP-SimpleCache](https://github.com/gilbitron/PHP-SimpleCache))
- [x] Self-Drive Mode
- [x] Composer Project
- [x] Extensive Providers

# Installation
Just run:
```bash
composer require clippedcode/currency
```
# Function explained:
### 1. convert();
 ```php
convert(int $amount, string $from, string $to)
```
 Three Parameters, namely - Amount, From, To
-   `$amount`: *(Type: Integer)* Accepts the amount to convert.    
-   `$from`: *(Type: String)* Accepts String with Currency Code (ex: `USD` or `INR`)
-   `$to`: *(Type: String)* Accepts String with Currency Code (ex: `USD` or `INR`)
### 2. convertWith();
```php
convertWith(string $provider, int $amount, string $from, string $to)
```
Same as `convert()` except an additional provider parameter.
-   `$provider`: *(Type: String)* API Service Provider that is Available (ex: `exchangerate` or `currencylayer`).
-   `$amount`: *(Type: Integer)* Amount to be converted
-   `$from`: *(Type: String)* Accepts String with Currency Code (ex: `USD` or `INR`)
-   `$to`: *(Type: String)* Accepts String with Currency Code (ex: `USD` or `INR`)
