<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getCasosMasUsados(Request $request){
        if(!$request->ajax()) return redirect('/');

        $rpta = DB::select('call sp_Dashboard_getCasosMasUsados');
        return $rpta;
    }

    public function getCasosPorDia(Request $request){
        if(!$request->ajax()) return redirect('/');

        $rpta = DB::select('call sp_Dashboard_getCasosPorDia');
        return $rpta;
    }
}
