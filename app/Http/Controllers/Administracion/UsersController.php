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

        $cNombre = $request->cNombre;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cEstado = $request->cEstado;
        
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = ''): $cUsuario;
        $cEstado = ($cEstado == NULL) ? ($cEstado = ''): $cEstado;

        $rpta = DB::select('call sp_Usuario_getListarUsuarios (?, ?, ?)',
                                                            [
                                                                $cNombre, 
                                                                $cUsuario, 
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
        $cSegundoApellido = $request->cSegundoApellido;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cContrasena = Hash::make($request->cContrasena);

        $cPrimerNombre = ($cPrimerNombre == NULL) ? ($cPrimerNombre = ''): $cPrimerNombre;
        $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = ''): $cSegundoNombre;
        $cApellidos = ($cApellidos == NULL) ? ($cApellidos = ''): $cApellidos;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = ''): $cUsuario;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = ''): $cCorreo;
        $cContrasena = ($cContrasena == NULL) ? ($cContrasena = ''): $cContrasena;

        DB::select('call sp_Usuario_setRegistrarUsuarios (?, ?, ?, ?, ?, ?)',
                                                            [
                                                                $cPrimerNombre, 
                                                                $cSegundoNombre, 
                                                                $cApellidos, 
                                                                $cUsuario,
                                                                $cCorreo,
                                                                $cContrasena
                                                            ]);
    }

}
