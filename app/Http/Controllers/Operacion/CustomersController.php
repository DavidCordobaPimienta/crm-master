<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function getListarClientes(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $nIdCliente     = $request->nIdCliente;
        $cNombre        = $request->cNombre;
        $cDocumento     = $request->cDocumento;

        $nIdCliente = ($nIdCliente == NULL) ? ($nIdCliente = 0): $nIdCliente;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = ''): $cDocumento;

        $rpta = DB::select('call sp_Clientes_getListarClientes (?, ?, ?)', [
                                                                            $nIdCliente,
                                                                            $cNombre,
                                                                            $cDocumento,
                                                                        ]);
        return $rpta;

    }

    public function setRegistrarCliente(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre        = $request->cNombre;
        $cDocumento     = $request->cDocumento;
        $cApellido      = $request->cApellido;
        $cCorreo        = $request->cCorreo;
        $cTelefono      = $request->cTelefono;
        $nIdUserAut = Auth::id();

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = ''): $cDocumento;
        $cApellido = ($cApellido == NULL) ? ($cApellido = 0): $cApellido;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = 0): $cCorreo;
        $cTelefono = ($cTelefono == NULL) ? ($cTelefono = 0): $cTelefono;

        $rpta = DB::select('call sp_Clientes_setRegistrarCliente (?, ?, ?, ?, ?, ?)',
                                                            [   
                                                                $cNombre,
                                                                $cDocumento,
                                                                $cApellido,
                                                                $cCorreo,
                                                                $cTelefono,
                                                                $nIdUserAut
                                                            ]);
        return $rpta;
    }

    public function setEditarCliente(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdCliente     = $request->nIdCliente;
        $cNombre        = $request->cNombre;
        $cDocumento     = $request->cDocumento;
        $cApellido      = $request->cApellido;
        $cCorreo        = $request->cCorreo;
        $cTelefono      = $request->cTelefono;
        $nIdUserAut = Auth::id();

        $nIdCliente = ($nIdCliente == NULL) ? ($nIdCliente = 0): $nIdCliente;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = ''): $cDocumento;
        $cApellido = ($cApellido == NULL) ? ($cApellido = 0): $cApellido;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = 0): $cCorreo;
        $cTelefono = ($cTelefono == NULL) ? ($cTelefono = 0): $cTelefono;

        $rpta = DB::select('call sp_Clientes_setEditarCliente (?, ?, ?, ?, ?, ?, ?)',
                                                            [   
                                                                $nIdCliente,
                                                                $cNombre,
                                                                $cDocumento,
                                                                $cApellido,
                                                                $cCorreo,
                                                                $cTelefono,
                                                                $nIdUserAut
                                                            ]);
        return $rpta;
    }

}
