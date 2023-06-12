<?php

namespace App\Policies;

class PermissionNames
{
    const CREATE_COMPANY = "create_company";
    const CREATE_COMPANY_CEO_ACCOUNT= "create_company_ceo_account";
    const CREATE_SUPPER_ADMIN_USER= "create_super_admin_user";
    const VIEW_REPORTS = "view_reports";
    const CREATE_NEW_USER = "create_new_user";
    const CHOOSE_POINTER = "choose_pointer";
    const  RENEW_SUBS = "renew_subs";
    const  UPDATE_SETTINGS = "update_settings";
    const  UPDATE_COMPANY_INFO = "change_company_info";
    const  PERMISSION_NAMES = [
        self::CREATE_COMPANY,
        self::CREATE_COMPANY_CEO_ACCOUNT,
        self::CREATE_SUPPER_ADMIN_USER,
        self::VIEW_REPORTS,
        self::CREATE_NEW_USER,
        self::CHOOSE_POINTER,
        self::RENEW_SUBS,
        self::UPDATE_SETTINGS,
        self::UPDATE_COMPANY_INFO];
    const COMPANY_CEO_PERMISSIONS = [
        self::CHOOSE_POINTER,
        self::UPDATE_COMPANY_INFO,
        self::RENEW_SUBS,
        self::CREATE_NEW_USER,
        self::UPDATE_SETTINGS];
    const PRIZENT_CEO_PERMISSIONS = [
        self::CREATE_COMPANY,
        self::CREATE_COMPANY_CEO_ACCOUNT,
        self::CREATE_SUPPER_ADMIN_USER,
        self::VIEW_REPORTS,
        self::CHOOSE_POINTER,
        self::UPDATE_COMPANY_INFO,
        self::RENEW_SUBS,
        self::CREATE_NEW_USER,
        self::UPDATE_SETTINGS
    ];
}
