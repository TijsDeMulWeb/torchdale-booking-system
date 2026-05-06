<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('escaperoomAddress.create');
    }
}
