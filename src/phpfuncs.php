<?php

namespace JosephNC\PHPFuncs;

/**
* Returns the number of seconds/minutes/hour/days/weeks/months/year ago
* 
* @param string $time_1 The datetime to parse
* @param string $time_2 The datetime to parse
* @param boolean $complete Whether to return the full time ago. Default is false.
* @param boolean $past Whether to return time ago or remaining time. Default is true.
* 
* @return string    The time difference
* 
* @since 1.0
*/
function time_difference( $time_1, $time_2, $complete = false, $past = true )
{
    $time_1 = new DateTime( $time_1 ); // Initiate the DateInterval Class

    $time_2 = new DateTime( $time_2 ); // Initiate the DateInterval Class

    $diff = $time_1->diff( $time_2 );

    $diff->w = floor( $diff->d / 7 );

    $diff->d -= $diff->w * 7;

    $args = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    foreach ( $args as $key => &$value ) {

        if ( $diff->$key )
        	$value = $diff->$key . ' ' . $value . ( $diff->$key > 1 ? 's' : '' );
        else
        	unset( $args[$key] );
    }

    if ( ! $complete ) $args = array_slice( $args, 0, 1 );

    if ( $past === true )
        $return = ( $args ) ? implode( ', ', $args ) . ' ago' : 'just now';
    else
        $return = ( $args ) ? implode( ', ', $args ) : 'a moment';

    return $return;
}

/**
* Get IP Address
* 
* @return string|void   IP Address if found and void otherwise
*/
function real_ip()
{
    $header_checks = [
        'HTTP_CLIENT_IP',
        'HTTP_PRAGMA',
        'HTTP_XONNECTION',
        'HTTP_CACHE_INFO',
        'HTTP_XPROXY',
        'HTTP_PROXY',
        'HTTP_PROXY_CONNECTION',
        'HTTP_VIA',
        'HTTP_X_COMING_FROM',
        'HTTP_COMING_FROM',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'ZHTTP_CACHE_CONTROL',
        'REMOTE_ADDR'
    ];

    foreach ( $header_checks as $key ) {

        if ( array_key_exists( $key, $_SERVER ) === false ) continue;

        foreach ( explode( ',', $_SERVER[$key] ) as $ip ) {

            $ip = trim( $ip );

            // Filter the ip with filter functions
            return filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) !== false ? $ip : '127.0.0.1';
        }
    }

}

/**
* Check if 2 arrays are equal
* 
* @param array $array1
* @param array $array2
* 
* @return boolean   true if equal and false otherwise
*/
function is_array_equal( $array1, $array2 )
{
    if ( ! is_array( $array1 ) || ! is_array( $array2 ) ) return false;

    if ( array_diff_assoc( $array1, $array2 ) === array_diff_assoc( $array2, $array1 ) )
        return true;
    else
        return false;
}

/**
 * Handles PHP start session
 * @return boolean|void
 */
function start_session()
{
    if (php_sapi_name() === 'cli') return false;

    if (version_compare(phpversion(), '5.4.0', '>='))
        $started = session_status() === PHP_SESSION_ACTIVE ? true : false;
    else
        // This will eventually not run,
        // because the library requires PHP >= 5.6
        $started = session_id() === '' ? false : true; 

    if ($started === false) {
        ob_start();
        session_start();
    }
}

/**
* Create random string
*
* @param int $length The length of string to get. Default is 20
* @return string    The string generated.
*/
function get_random_string( $length = 20 )
{
    $chars = '56789abcdefghijklmABCDEFGHIJKLM01234nopqrstuvwxyzNOPQRSTUVWXYZ';

    $s = '';

    for ( $i = 0; $i < $length; $i++ )
        $s .= $chars[rand( 0, strlen( $chars ) - 1 )];

    return $s;
}

/**
* Returns Supported currencies
* @param string $currency Optional currency data to retrieve.
* @return object
*/
function currencies($currency = null)
{
    /**
    * List of support currencies for
    * 1 - This type of currency does not support decimals.
    *
    * @var object
    */
    $currencies = json_decode(json_encode([
        'AUD' => [
            'name'          => 'Australian Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ' ',
        ],

        'BRL' => [
            'name'          => 'Brazilian Real',
            'major'         => 'real',
            'minor'         => 'centavo',
            'symbol'        => 'R$',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => '.',
        ],

        'CAD' => [
            'name'          => 'Canadian Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'CNY' => [
            'name'          => 'Chinese Yuan Renminbi',
            'major'         => 'yuan renminbi',
            'minor'         => 'jiao',
            'symbol'        => '¥',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'CZK' => [
            'name'          => 'Czech Koruna',
            'major'         => 'koruna',
            'minor'         => 'haler',
            'symbol'        => 'Kč',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => '.',
        ],

        'DKK' => [
            'name'          => 'Danish Krone',
            'major'         => 'krone',
            'minor'         => 'øre',
            'symbol'        => 'kr',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => '.',
        ],

        'EUR' => [
            'name'          => 'Euro',
            'major'         => 'euro',
            'minor'         => 'cent',
            'symbol'        => '€',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'HKD' => [
            'name'          => 'Hong Kong Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'HUF' => [
            'name'          => 'Hungarian Forint',
            'major'         => 'forint',
            'minor'         => '',
            'symbol'        => 'Ft',
            'decimals'      => 0,
            'decimal_sep'   => '',
            'thousand_sep'  => '.',
        ], // 1

        'ILS' => [
            'name'          => 'Israeli New Shekel',
            'major'         => 'new shekel',
            'minor'         => 'agora',
            'symbol'        => '₪',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'JPY' => [
            'name'          => 'Japanese Yen',
            'major'         => 'yen',
            'minor'         => 'sen',
            'symbol'        => '¥',
            'decimals'      => 0,
            'decimal_sep'   => '',
            'thousand_sep'  => ',',
        ], // 1

        'MYR' => [
            'name'          => 'Malaysian Ringgit',
            'major'         => 'ringgit',
            'minor'         => 'sen',
            'symbol'        => 'RM',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'MXN' => [
            'name'          => 'Mexican Peso',
            'major'         => 'peso',
            'minor'         => 'centavo',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'NGN' => [
            'name'          => 'Nigerian Naira',
            'major'         => 'naira',
            'minor'         => 'kobo',
            'symbol'        => '₦',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'NZD' => [
            'name'          => 'New Zealand Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'NOK' => [
            'name'          => 'Norwegian Krone',
            'major'         => 'krone',
            'minor'         => 'øre',
            'symbol'        => 'kr',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => '.',
        ],

        'PHP' => [
            'name'          => 'Philippine Peso',
            'major'         => 'peso',
            'minor'         => 'centavo',
            'symbol'        => '₱',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'PLN' => [
            'name'          => 'Polish Zloty',
            'major'         => 'zloty',
            'minor'         => 'grosz',
            'symbol'        => 'zł',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => ' ',
        ],

        'GBP' => [
            'name'          => 'Pound Sterling',
            'major'         => 'pound',
            'minor'         => 'pence',
            'symbol'        => '£',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'RUB' => [
            'name'          => 'Russian Ruble',
            'major'         => 'ruble',
            'minor'         => 'kopeck',
            'symbol'        => '₽',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => '.',
        ],

        'SGD' => [
            'name'          => 'Singapore Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'SEK' => [
            'name'          => 'Swedish Krona',
            'major'         => 'krona',
            'minor'         => 'öre',
            'symbol'        => 'kr',
            'decimals'      => 2,
            'decimal_sep'   => ',',
            'thousand_sep'  => ' ',
        ],

        'CHF' => [
            'name'          => 'Swiss Franc',
            'major'         => 'franken',
            'minor'         => 'rappen',
            'symbol'        => 'CHF',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => "'",
        ],

        'TWD' => [
            'name'          => 'Taiwan New Dollar',
            'major'         => 'new dollar',
            'minor'         => 'cent',
            'symbol'        => 'NT$',
            'decimals'      => 0,
            'decimal_sep'   => '',
            'thousand_sep'  => ',',
        ], // 1

        'THB' => [
            'name'          => 'Thai baht',
            'major'         => 'baht',
            'minor'         => 'satang',
            'symbol'        => '฿',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],

        'USD' => [
            'name'          => 'United States Dollar',
            'major'         => 'dollar',
            'minor'         => 'cent',
            'symbol'        => '$',
            'decimals'      => 2,
            'decimal_sep'   => '.',
            'thousand_sep'  => ',',
        ],
    ]));

    if (! empty($currency) && isset($currencies->$currency)) {
        return $currencies->$currency;
    }

    return $currencies;
}

/**
* Formats a number as a currency string
*
* @param int|float(double) $number The number to be formatted
* @param string $code Currency to use(Alpha ISO 4217 Code) , will be replaced with symbol if symbol is true. Defaults to usd
* @param bool $symbol Whether to use the currency symbol or not
* @param string $position Where to place the currency/symbol. Accepts 'left', 'right', 'left_space', 'right_space'. Default 'left_space'
* @return string Returns the formatted string or false if $code is not a string
*/
function money_form($number, $code = 'usd', $symbol = false, $position = 'left_space')
{
    $code       = empty($code) ? 'usd' : $code;
    $position   = empty($position) ? 'left_space' : $position;

    $currency   = currencies(strtoupper($code));
    $number     = empty($number) ? 0.00 : floatval($number);
    $symbol     = $symbol ? $currency->symbol : $code;

    $decimals       = $currency->decimals;
    $decimal_sep    = $currency->decimal_sep;
    $thousand_sep   = $currency->thousand_sep;
    $number         = number_format($number, $decimals, $decimal_sep, $thousand_sep);

    switch ($position) {
        case 'left' :           $money = "$symbol$number"; break;
        case 'left_space' :     $money = "$symbol $number"; break;
        case 'right' :          $money = "$number$symbol"; break;
        case 'right_space' :    $money = "$number $symbol"; break;
        default :               $money = "$symbol$number"; break;
    }

    return $money;
}