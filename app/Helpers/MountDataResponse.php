<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class MountDataResponse
{
    public static function mountData(array $data, LengthAwarePaginator $queryResponse): array
    {
        $totalPages = ceil($queryResponse->total()/$queryResponse->perPage());
        return [
            'results' => $data,
            'totalDocs' => $queryResponse->total(),
            'page' => $queryResponse->currentPage(),
            'totalPages' => $totalPages,
            'hasNext' => $queryResponse->currentPage() < $totalPages ? true : false,
            'hasPrev' => $queryResponse->currentPage() > 1 ? true : false
        ];
    }
}
