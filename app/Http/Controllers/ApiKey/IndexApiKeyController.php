<?php

namespace App\Http\Controllers\ApiKey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexApiKeyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $apiKeys = auth()->user()->escaperoom->apiKeys()->get();

        return view('apiKeys.index', [
            'apiKeys' => $apiKeys,
        ]);
    }
}
