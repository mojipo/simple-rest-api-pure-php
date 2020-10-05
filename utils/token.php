<?php

/**
 * This is a token generator & validator like JWT but more simpler. 
 * It use a random SALT for generate and validate signature.
 */


// Edit with your custom salt!
define('SALT', '6fe6f886d2148c5d97e4bfc0741fc218');
// Expire time, default is 1 hour (3600 sec)
define('EXPIRE', '3600');


/**
 * @desc Generate a valid token for 1 hour for the given $userID
 * @param int $userID - the ID of user in database
 * @return string - A valid token for the user
 */
function generate_token($userID)
{

    $expire = time() + EXPIRE; // 1 hour
    $signature = md5($userID . $expire . SALT);
    $token = $userID . '.' . $expire . '.' . $signature;

    $encoded = bin2hex($token);

    return $encoded;
}

/**
 * @desc Validate a given $token
 * @param string $token - A token generated with generate_token()
 * @return int - Zero for failure or user ID for success
 */
function validate_token($token)
{

    if (strlen($token) % 2 == 0) {

        $decoded = hex2bin($token);
        if (preg_match('/([0-9]+).([0-9]+).([0-9a-z]{32})/', $decoded, $r)) {
            $userID = $r[1];
            $expire = $r[2];
            $signature = $r[3];

            if ($expire < time()) {
                return 0; // Expired
            } else {
                if ($signature <>  md5($userID . $expire . SALT)) {
                    return 0; // Invalid signature
                } else {
                    return $userID;
                }
            }
        } else {
            return 0; // Token manipulated
        }
    } else {
        return 0; // Token length is wrong
    }
}
