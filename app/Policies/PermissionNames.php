<?php

namespace App\Policies;

class PermissionNames
{
    const CREATE_NEW_USER= "create_new_user";
    const CHOOSE_POINTER = "choose_pointer";
    const  RENEW_SUBS = "renew_subs";
    const  UPDATE_SETTINGS = "update_settings";
    const  UPDATE_COMPANY_INFO = "change_company_info";
    const  PERMISSION_NAMES = [self::CREATE_NEW_USER, self::CHOOSE_POINTER, self::RENEW_SUBS, self::UPDATE_SETTINGS,self::UPDATE_COMPANY_INFO];

}
