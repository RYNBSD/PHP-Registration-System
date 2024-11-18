<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/env.php";

function cipher_check_iv_key_length()
{
  $key_length = openssl_cipher_key_length(CIPHER_METHOD);
  if ($key_length !== strlen(CIPHER_KEY)) throw new UnexpectedValueException("Invalid cipher key length");

  $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
  if ($iv_length !== strlen(CIPHER_IV)) throw new UnexpectedValueException("Invalid cipher iv length");
}

function cipher(string $data): string
{
  cipher_check_iv_key_length();
  return openssl_encrypt($data, CIPHER_METHOD, CIPHER_KEY, 0, CIPHER_IV);
}

function decipher(string $data): false|string
{
  cipher_check_iv_key_length();
  return openssl_decrypt($data, CIPHER_METHOD, CIPHER_KEY, 0, CIPHER_IV);
}
