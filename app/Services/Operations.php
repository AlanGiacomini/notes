<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations{
    public static function decryptValue($value){
        //check if the value is encrypted
        try {
           $value = Crypt::decrypt($value);
        }
        //DECRYPT EXCEPTION PEGA O ERRO DO DECRIPTADOR 
        catch (DecryptException $e) {
           return redirect()->route('home');
        }
        return $value;
     }
}