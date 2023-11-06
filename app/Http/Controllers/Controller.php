<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data, $code = 200): \Illuminate\Http\JsonResponse
    {
        if ($data instanceof LengthAwarePaginator) {
            $data = [
                'data' => $data->all(),
                'meta' => [
                    'total' => $data->total(),
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                ]
            ];
        } else {
            $data = ['data' => $data];
        }

        return response()->json(['result' => $data, 'code' => $code], $code);
    }

    protected function error($message, $code, $type = 'number'): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => [$type => $message], 'code' => $code], $code);
    }

    protected function customPaginate($items, $perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
