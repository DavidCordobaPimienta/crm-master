<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function getListarPermisos (Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdPermiso = $request->nIdPermiso;
        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $nIdPermiso = ($nIdPermiso == NULL) ? ($nIdPermiso = 0): $nIdPermiso;
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

    public function setRegistrarPermiso (Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUrl = ($cUrl == NULL) ? ($cUrl = ''): $cUrl;

        DB::select('call sp_Permiso_setRegistrarPermiso (?, ?)',
                                                            [
                                                                $cNombre,
                                                                $cUrl
                                                            ]);
    }

    public function setEditarPermiso(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdPermiso = $request->nIdPermiso;
        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $nIdPermiso = ($nIdPermiso == NULL) ? ($nIdPermiso = 0): $nIdPermiso;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUrl = ($cUrl == NULL) ? ($cUrl = ''): $cUrl;

        DB::select('call sp_Permiso_setEditarPermiso (?, ?, ?)',
                                                            [   
                                                                $nIdPermiso,
                                                                $cNombre,
                                                                $cUrl
                                                            ]);
    }
}
