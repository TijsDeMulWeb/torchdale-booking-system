<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEscaperoomAddressRequest;

class UpdateEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEscaperoomAddressRequest $request, $id = null)
    {
        dd($request->validated(), $id);
    }
}
