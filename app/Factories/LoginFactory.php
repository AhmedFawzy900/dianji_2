<?php

namespace App\Factories;

use App\Services\User\CreateUser;

class login {
    public function InitUser($user) {
        if(!$user) {
            // create User
            return new CreateUser();
        }
    }
}