<?php

    $keyGlobal = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    function encrypt($string)
    {
      $secret_key = $GLOBALS['keyGlobal'];
      // Create the initialization vector for added security.
      $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
      $encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
      return  base64_encode($encrypted_string);
    
    }

    function decrypt($encrypted_string)
    {
       $secret_key  = $GLOBALS['keyGlobal'];
      // Create the initialization vector for added security.
      $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
      // Decrypt $string
      $decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $encrypted_string, MCRYPT_MODE_CBC, $iv);
      return $decrypted_string;
    }

?>