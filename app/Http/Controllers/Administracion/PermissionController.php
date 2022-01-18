<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function getListarPermisos (Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdPermiso = $request->nIdRol;
        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $nIdPermiso = ($nIdPermiso == NULL) ? ($nIdnIdPermisoRol = 0): $nIdPermiso;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUrl = ($cUrl == NULL) ? ($cUrl = ''): $cUrl;

        $rspta = DB::select('call sp_Permiso_getListarPermisos (?, ?, ?)',
                                                            [
                                                                $nIdPermiso,
                                                                $cNombre,
                                                                $cUrl
                                                            ]);
        return $rspta;   
    }
}
