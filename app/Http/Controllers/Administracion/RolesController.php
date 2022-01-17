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

    public function setRegistrarRolPermisos(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cUrl = $request->cUrl;

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUrl = ($cUrl == NULL) ? ($cUrl = ''): $cUrl;
        
            
            $rpta = DB::select('call sp_Rol_setRegistrarRol (?, ?)',
                                                            [
                                                                $cNombre,
                                                                $cUrl
                                                            ]);
            $nIdRol = $rpta[0]->nIdRol;


        try {
            DB::beginTransaction();
            $listPermisos = $request->listPermisosFilter;
            $listPermisosSize = sizeof((array)$listPermisos);
            
            if ($listPermisosSize>0) {
                foreach ($listPermisos as $key => $value) {
                    if ($value['checked'] == true) {
                        DB::select('call sp_Rol_setRegistrarRolPermisos (?, ?)',
                                                            [
                                                                $nIdRol,
                                                                $value['id']
                                                            ]);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

}
