<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    /**
     * Encrypt a message using Laravel's built-in encryption.
     *
     * @param string $message The message to encrypt
     * @return string The encrypted message
     */
    public function encryptMessage(string $message): string
    {
        return Crypt::encryptString($message);
    }

    /**
     * Decrypt a message using Laravel's built-in decryption.
     *
     * @param string $encryptedMessage The encrypted message to decrypt
     * @return string The decrypted message
     */
    public function decryptMessage(string $encryptedMessage): string
    {
        return Crypt::decryptString($encryptedMessage);
    }

    /**
     * Decrypt a message using a specific decryption key.
     * This method is not recommended as it requires passing the key with the message.
     *
     * @param string $encryptedMessage The encrypted message to decrypt
     * @param string $key The decryption key
     * @return string The decrypted message
     */
    public function decryptMessageWithKey(string $encryptedMessage, string $key): string
    {
        // Placeholder for decryption logic with a specific key
        // This method should be implemented if we choose to use a custom decryption approach
        return "Decrypted message here"; 
    }
}
