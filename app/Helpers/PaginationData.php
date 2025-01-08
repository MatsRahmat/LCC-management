<?php

namespace App\Helpers;

use CodeIgniter\Database\MySQLi\Builder;

class PaginationData
{
    public static function generate(Builder $builder, $limit, $page)
    {
        $totalData = $builder->countAllResults();
        $totalPage = ceil($totalData / $limit);
        return [
            'curent_page'   => $page,
            'prev_page'     => $page - 1 >= 1 ? $page - 1 : null,
            'next_page'     => $page < $totalPage ? $page + 1 : null,
            'total_data'    => $totalData,
            'total_page'    => $totalPage,
        ];
    }
}

// 
