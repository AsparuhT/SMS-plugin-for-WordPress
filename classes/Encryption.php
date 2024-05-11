<?php

/**
 * Encryption Class
 * 
 * This class provides methods for encrypting and decrypting data using the specified encryption method and key.
 * 
 * Parameters:
 *     $data: The plaintext data to encrypt.
 *     $method: The encryption method/algorithm to use (e.g., "AES-256-CBC").
 *     $key: The encryption key.
 *     $options (optional): Additional options (default is 0).
 *     $iv (optional): The initialization vector (IV) for encryption (required for some algorithms).
 *     $tag (optional): A variable to store the authentication tag (required for some algorithms).
 *     $aad (optional): Additional authenticated data (required for some algorithms).
 *     $tag_length (optional): The length of the authentication tag (required for some algorithms).
 */
class Encryption
{
    private static $method = "aes-256-cbc"; // Encryption Method
    private static $key = "Vladimir2021";  // Add your unique KEY string here

    /**
     * Encrypts the encoded message.
     *
     * The initialization vector ($iv) is passed with the $encryptedData. The encrypted code may not be decoded from
     * a decoding function that does not know the Encryption Method.
     *
     * @param string $data The plaintext data to encrypt.
     * @return string The encrypted data.
     */
    public static function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$method));
        $encryptedData = openssl_encrypt($data, self::$method, self::$key, 0, $iv);
        return base64_encode($iv . $encryptedData);
    }

    /**
     * Decrypts the encoded message.
     *
     * It will only decrypt data encoded by the same class.
     *
     * @param string $encryptedData The encrypted data.
     * @return string The decrypted plaintext data.
     */
    public static function decrypt($encryptedData)
    {
        $decodedData = base64_decode($encryptedData);
        $iv = substr($decodedData, 0, openssl_cipher_iv_length(self::$method));
        $encryptedData = substr($decodedData, openssl_cipher_iv_length(self::$method));
        return openssl_decrypt($encryptedData, self::$method, self::$key, 0, $iv);
    }
}
