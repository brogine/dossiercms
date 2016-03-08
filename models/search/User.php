<?php

namespace app\models\search;

use dektrium\user\models\UserSearch as BaseUser;

class User extends BaseUser
{
	public static function tableName()
    {
        return '{{%user}}';
    }
}