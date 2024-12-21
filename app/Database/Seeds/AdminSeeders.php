<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AdminSeeders extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        //
        $dataAdmin = [
            'username' => getenv('admin.name') ?? "Super Admin",
            'email' => getenv('admin.email') ?? 'Admin@mail.com',
            'password' => password_hash(getenv('admin.password') ?? 'admin#2024', PASSWORD_DEFAULT),
            'role_id' => 1,
        ];
        $userModel->insert($dataAdmin);
    }
}
