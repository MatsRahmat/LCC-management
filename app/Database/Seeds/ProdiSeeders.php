<?php

namespace App\Database\Seeds;

use App\Models\ProgramStudyModel;
use CodeIgniter\Database\Seeder;

class ProdiSeeders extends Seeder
{
    public function run()
    {
        $model = new ProgramStudyModel();
        $data = [
            ['name' => 'Manajement Informatika', 'code' => '04411'],
            ['name' => 'Manajement Informatika', 'code' => '04421'],
            //
            ['name' => 'Administrasi Bisnis', 'code' => '04111'],
            ['name' => 'Administrasi Bisnis', 'code' => '04121'],
            // 
            ['name' => 'Administrasi Bisnis Internasional', 'code' => '04511'],
            ['name' => 'Administrasi Bisnis Internasional', 'code' => '04512'],
            ['name' => 'Administrasi Bisnis Internasional', 'code' => '04521'],
            //
            ['name' => 'Komputer Akuntansi', 'code' => '04211'],
            ['name' => 'Komputer Akuntansi', 'code' => '04221'],
        ];
        $model->insertBatch($data);
    }
}
