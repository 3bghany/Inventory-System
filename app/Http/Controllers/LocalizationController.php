<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function changeLang(string $lang){
            Session::put('locale', $lang);
            return response()->json([
                'status' => 'success',
                'message' => 'Language changed successfully',
                'data'=> $lang,
            ]);

    }
}
