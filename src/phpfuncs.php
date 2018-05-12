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