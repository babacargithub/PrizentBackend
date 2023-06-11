<?php

namespace App\Policies;

class RoleNames
{
    const ROLE_PRIZENT_EMPLOYEE = "prizent_employee";
    const ROLE_PRIZENT_CEO = "prizent_ceo";
    const  ROLE_PRIZENT_SUPER_ADMIN = "prizent_super_admin";
    const  ROLE_PRIZENT_ADMIN = "prizent_admin";
    const ROLE_COMPANY_CEO = "company_ceo";
    const ROLE_COMPANY_EMPLOYEE = "company_employee";

    const ROLES = [self::ROLE_PRIZENT_EMPLOYEE,
        self::ROLE_PRIZENT_CEO,
        self::ROLE_PRIZENT_SUPER_ADMIN,
        self::ROLE_PRIZENT_ADMIN,
        self::ROLE_COMPANY_CEO,
        self::ROLE_COMPANY_EMPLOYEE,
    ];

}
