<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VigenereController extends Controller
{
    // Method to display the Vigenere form
    public function index()
    {
        return view('vigenere');
    }

    // Method to process the form submission
    public function process(Request $request)
    {
        // Get form inputs
        $action = $request->input('action');
        $message = strtoupper($request->input('message')); // Convert message to uppercase
        $key = strtoupper($request->input('key')); // Convert key to uppercase

        // Determine action: encrypt or decrypt
        if ($action === 'encrypt') {
            $result = $this->cipherText($message, $key);
        } elseif ($action === 'decrypt') {
            $result = $this->originalText($message, $key);
        }

        return $result;
    }

    // Encrypt message using Vigenere cipher
        private function cipherText($message, $key)
        {
            $key = $this->generateKey($message, $key);
            $cipherText = '';
            $messageLength = strlen($message);

            for ($i = 0; $i < $messageLength; $i++) {
                if ($message[$i] != ' ') {
                    // Encryption for uppercase letters
                    if (ctype_upper($message[$i])) {
                        $shift = ord($key[$i]) - ord('A');
                        $cipherText .= chr(((ord($message[$i]) - ord('A') + $shift) % 26) + ord('A'));
                    } else { // Encryption for lowercase letters
                        $shift = ord($key[$i]) - ord('a');
                        $cipherText .= chr(((ord($message[$i]) - ord('a') + $shift) % 26) + ord('a'));
                    }
                } else {
                    // Append the space character without shifting
                    $cipherText .= ' ';
                }
            }

            return $cipherText;
        }


   // Decrypt message using Vigenere cipher
    private function originalText($cipherText, $key)
    {
        $key = $this->generateKey($cipherText, $key);
        $originalText = '';
        $cipherLength = strlen($cipherText);

        for ($i = 0; $i < $cipherLength; $i++) {
            if ($cipherText[$i] != ' ') {
                // Decryption for uppercase letters
                if (ctype_upper($cipherText[$i])) {
                    $shift = ord($key[$i]) - ord('A');
                    $originalText .= chr(((ord($cipherText[$i]) - ord('A') - $shift + 26) % 26) + ord('A'));
                } else { // Decryption for lowercase letters
                    $shift = ord($key[$i]) - ord('a');
                    $originalText .= chr(((ord($cipherText[$i]) - ord('a') - $shift + 26) % 26) + ord('a'));
                }
            } else {
                // Append the space character
                $originalText .= ' ';
            }
        }

        return $originalText;
    }


        // Generate repeating key
        private function generateKey($message, $key)
        {
            $keyLength = strlen($key);
            $key = strtoupper($key);
            $messageLength = strlen($message);
            $newKey = '';
            $keyIndex = 0;

            for ($i = 0; $i < $messageLength; $i++) {
                if ($message[$i] != ' ') {
                    $newKey .= $key[$keyIndex % $keyLength];
                    $keyIndex++;
                } else {
                    $newKey .= ' ';
                }
            }

            return $newKey;
        }

}
