<?php

namespace App\Database\Seeds;

use App\Enums\TransactionTypeEnum;
use App\Models\TransactionTypeModel;
use CodeIgniter\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    public function run()
    {
        $model = new TransactionTypeModel();

        $data = array(
            [
                'id'    => TransactionTypeEnum::INCOME,
                'name'  => 'Income'
            ],
            [
                'id'    => TransactionTypeEnum::OUTCOME,
                'name'  => 'Outcome'
            ]
        );
        $model->insertBatch($data);
    }
}
