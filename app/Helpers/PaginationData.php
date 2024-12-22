<?php

namespace App\Helpers;

class PaginationData
{
    public static function generate($builder, $limit, $page)
    {
        $totalPage = ceil($builder->countAll() / $limit);
        $totalData = $builder->countAll();
        return [
            'curent_page'   => $page,
            'prev_page'     => $page - 1 >= 1 ? $page - 1 : null,
            'next_page'     => $page < $totalPage ? $page + 1 : null,
            'total_data'    => $totalData,
            'total_page'    => $totalPage,
        ];
    }
}
