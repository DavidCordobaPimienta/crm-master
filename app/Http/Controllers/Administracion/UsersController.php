<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    public function getListarUsuarios(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cNombre = $request->cNombre;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cEstado = $request->cEstado;
        
        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0): $nIdUsuario;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = ''): $cUsuario;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = ''): $cCorreo;
        $cEstado = ($cEstado == NULL) ? ($cEstado = ''): $cEstado;

        $rpta = DB::select('call sp_Usuario_getListarUsuarios (?, ?, ?, ?, ?)',
                                                            [   
                                                                $nIdUsuario,
                                                                $cNombre, 
                                                                $cUsuario, 
                                                                $cCorreo, 
                                                                $cEstado
                                                            ]);
        return $rpta;
    }

    public function setRegistrarUsuarios(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $cPrimerNombre = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellidos = $request->cApellidos;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cContrasena = Hash::make($request->cContrasena);

        $cPrimerNombre = ($cPrimerNombre == NULL) ? ($cPrimerNombre = ''): $cPrimerNombre;
        $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = ''): $cSegundoNombre;
        $cApellidos = ($cApellidos == NULL) ? ($cApellidos = ''): $cApellidos;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = ''): $cUsuario;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = ''): $cCorreo;
        $cContrasena = ($cContrasena == NULL) ? ($cContrasena = ''): $cContrasena;

        $rpta = DB::select('call sp_Usuario_setRegistrarUsuarios (?, ?, ?, ?, ?, ?)',
                                                            [
                                                                $cPrimerNombre, 
                                                                $cSegundoNombre, 
                                                                $cApellidos, 
                                                                $cUsuario,
                                                                $cCorreo,
                                                                $cContrasena
                                                            ]);
        return $rpta[0]->nIdUsuario;
    }

    public function setEditarUsuarios(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cPrimerNombre = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellidos = $request->cApellidos;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cContrasena = $request->cContrasena;

        if ($cContrasena != NULL) {
            $cContrasena = Hash::make($request->cContrasena);                        
        }

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = ''): $nIdUsuario;
        $cPrimerNombre = ($cPrimerNombre == NULL) ? ($cPrimerNombre = ''): $cPrimerNombre;
        $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = ''): $cSegundoNombre;
        $cApellidos = ($cApellidos == NULL) ? ($cApellidos = ''): $cApellidos;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = ''): $cUsuario;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = ''): $cCorreo;
        $cContrasena = ($cContrasena == NULL) ? ($cContrasena = ''): $cContrasena;

        DB::select('call sp_Usuario_setEditarUsuarios (?, ?, ?, ?, ?, ?, ?)',
                                                            [
                                                                $nIdUsuario,
                                                                $cPrimerNombre, 
                                                                $cSegundoNombre, 
                                                                $cApellidos, 
                                                                $cUsuario,
                                                                $cCorreo,
                                                                $cContrasena
                                                            ]);
    }

    public function setCambiarEstadoUsuario(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cEstado = $request->cEstado;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = ''): $nIdUsuario;    
        $cEstado = ($cEstado == NULL) ? ($cEstado = ''): $cEstado;

        DB::select('call sp_Usuario_setCambiarEstadoUsuario (?, ?)',
                                                            [
                                                                $nIdUsuario,
                                                                $cEstado, 
                                                            ]);
    }

    public function setEditarRolByUsuario(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $nIdRol = $request->nIdRol;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0): $nIdUsuario;
        $nIdRol = ($nIdRol == NULL) ? ($nIdRol = 0): $nIdRol;

        DB::select('call sp_Usuario_setEditarRolByUsuario (?, ?)',
                                                            [
                                                                $nIdUsuario, 
                                                                $nIdRol
                                                            ]);
    }

    public function getRolByUsuario(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0): $nIdUsuario;

        $rspta = DB::select('call sp_Usuario_getRolByUsuario (?)',
                                                            [
                                                                $nIdUsuario
                                                            ]);
        return $rspta;
    }

    public function getListarPermisosByRolAsignado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0): $nIdUsuario;

        $rspta = DB::select('call sp_Usuario_getListarPermisosByRolAsignado (?)',
                                                            [
                                                                $nIdUsuario
                                                            ]);
        return $rspta;
    }

    public function getListarRolPermisosByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   0) :   $nIdUsuario;

        $rpta   =   DB::select('call sp_Usuario_getListarRolPermisosByUsuario (?)',
                                                [
                                                    $nIdUsuario
                                                ]);

        return $rpta;
    }
}
