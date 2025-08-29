<?php 
namespace Config;
use App\Controllers\Users;

class CustomValidation{

    public function verify_old_pwd($old_password): bool 
    {
        $users = new Users();
        if(sizeof($users->checkPwd($old_password)) > 0)
            return true;

        return false;
	}

    public function valid_password($password) : bool
    {
        $users = new Users();
        return $users->valid_password($password);
    }
}