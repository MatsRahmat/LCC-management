<?php

namespace App\Database\Seeds;

use App\Models\RoleModel;
use CodeIgniter\Database\Seeder;

class RoleSeeders extends Seeder
{
    public function run()
    {
        $model = new RoleModel();

        $data = [
            ['id' => \App\Enums\RoleEnum::SUPER_ADMIN, 'name' => 'Super Admin'],
            ['id' => \App\Enums\RoleEnum::ADMINISTRATOR, 'name' => 'Administrator'],
            ['id' => \App\Enums\RoleEnum::ACCOUNTING, 'name' => 'Accounting'],
            ['id' => \App\Enums\RoleEnum::MAHASISWA, 'name' => 'Mahasiswa'],
            ['id' => \App\Enums\RoleEnum::OUTSIDER, 'name' => 'Outsiders'],
        ];

        $model->insertBatch($data);
    }
}
