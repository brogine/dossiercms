<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public function getName()
    {
    	return empty($this->profile->name) ? $this->username : $this->profile->name;
    }
}