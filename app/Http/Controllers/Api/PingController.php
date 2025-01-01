<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class PingController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'pong']);
    }
}
