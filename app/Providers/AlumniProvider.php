<?php

namespace App\Providers;

use App\Models\Alumni;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class AlumniProvider extends UserProvider {

    /**
     * Overrides the framework defaults validate credentials method 
     *
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials) {
        
        // $checkValidate = false;
        $plain = $credentials['password'];

        // $alumni = Alumni::where('pin', $plain)->first();

        // if($alumni){
        //     $checkValidate = true;
        // }
        // else{
        // $checkValidate = false;
        // }

        
        return $plain;
    }

}
