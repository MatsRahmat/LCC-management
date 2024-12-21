<?php

namespace App\Enums;

class RoleEnum
{
    const SUPER_ADMIN = 1;
    const ADMINISTRATOR = 2;
    const ACCOUNTING = 3;
    const MAHASISWA = 4;
    const OUTSIDER = 5;


    public static function toArray()
    {
        return [
            self::SUPER_ADMIN,
            self::ADMINISTRATOR,
            self::ACCOUNTING,
            self::MAHASISWA,
            self::OUTSIDER
        ];
    }

    public static function validateRole(mixed $roleId)
    {
        return in_array($roleId, self::toArray(), true);
    }

    public static function isAdminRole(mixed $roleId)
    {
        return in_array($roleId, [self::SUPER_ADMIN, self::ADMINISTRATOR, self::ACCOUNTING], true);
    }
}
