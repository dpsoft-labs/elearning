<?php

namespace App\Http\Controllers\Web\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->roles()->exists()) {


            return view(
                'themes.default.back.index'
            );
        } else {
            return view(theme('back.index'));
        }
    }
}
