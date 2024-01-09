<?php

/**
 * Setting Facade File
 * 
 * @category IPPanel Laravel
 * @package  Laravel
 * @author   Mohammad Maleki <malekii24@outlook.com>
 * @license  MIT https://github.com/mlk9/ippanel-laravel/blob/main/LICENSE
 * @link     https://github.com/mlk9/ippanel-laravel
 */


namespace Mlk9\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Mlk9\Sms Methods
 *
 * @method   static mixed getCredit() 
 * @method   static boolean sendMessage(string $text,array|string $recipients) 
 * @method   static boolean sendPatternMessage(string $code_pattern,string $recipient,array $entries = []) 
 * 
 * @category IPPanel Laravel
 * @package  Laravel
 * @author   Mohammad Maleki <malekii24@outlook.com>
 * @license  MIT https://github.com/mlk9/ippanel-laravel/blob/main/LICENSE
 * @link     https://github.com/mlk9/ippanel-laravel
 */
class Sms extends Facade
{
    /**
     * Define facade function
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return static::class;
    }
}
