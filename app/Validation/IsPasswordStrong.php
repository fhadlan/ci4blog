<?php

namespace App\Validation;

class IsPasswordStrong
{
     public function is_password_strong($password): bool
     {
        $password = trim($password);
        if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",$password)){
            return false;
        }
        return true;
     }
}
