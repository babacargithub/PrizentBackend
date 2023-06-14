<?php

namespace App\Policies;

class PermissionNames
{
    const CREATE_COMPANY = "CREER UNE SOCIETE";
    const CREATE_COMPANY_CEO_ACCOUNT= "CREER COMPTE DIRECTEUR SOCIETE";
    const CREATE_SUPPER_ADMIN_USER= "CREER COMPTE SUPER ADMIN";
    const VIEW_REPORTS = "VOIR RAPPORTS";
    const CREATE_NEW_USER = "CRER UN UTILISATEUR";
    const CHOOSE_POINTER = "DESIGNER POINTEUR";
    const  RENEW_SUBS = "RENOUVELER ABONNEMENT";
    const  UPDATE_SETTINGS = "MODIFIER PARAMETRES";
    const  UPDATE_COMPANY_INFO = "MODIFIER INFO SOCIETE";
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
