<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function responseNoContent(): JsonResponse
    {
        return response()->json(status: 204);
    }
}
