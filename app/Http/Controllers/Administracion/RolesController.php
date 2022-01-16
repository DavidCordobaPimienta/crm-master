<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function getListarRoles(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUrl = ($cUrl == NULL) ? ($cUrl = ''): $cUrl;

        $rspta = DB::select('call sp_Rol_getListarRoles (?, ?)',
                                                            [
                                                                $cNombre,
                                                                $cUrl
                                                            ]);
        return $rspta;
    }

    public function getListarPermisosByRol(Request $request){
        if(!$request->ajax()) return redirect('/');

        $respta = DB::select('call sp_Rol_getListarPermisosByRol');
        return $respta;
    }

}
