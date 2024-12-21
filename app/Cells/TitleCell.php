<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class TitleCell extends Cell
{
    public function show(string $param)
    {
        $data = [
            'title' => "LCC Activity Platform"
        ];
        return $this->view('title', $data);
    }
}
