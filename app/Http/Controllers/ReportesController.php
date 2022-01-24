<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReportesController extends Controller
{
    public function getListarPedidosR(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cDocumento     = $request->cDocumento;
        $cNombre        = $request->cNombre;
        $cPedido        = $request->cPedido;
        $dFechaInicio   = $request->dFechaInicio;
        $dFechaFin      = $request->dFechaFin; 
        $nIdEstado      = $request->nIdEstado;
   
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = ''): $cDocumento;
        $cPedido = ($cPedido == NULL) ? ($cPedido = 0): $cPedido;
        $nIdEstado = ($nIdEstado == NULL) ? ($nIdEstado = 0): $nIdEstado;
        $dFechaInicio = ($dFechaInicio == NULL) ? ($dFechaInicio = ''): $dFechaInicio;
        $dFechaFin = ($dFechaFin == NULL) ? ($dFechaFin = ''): $dFechaFin;

        $rpta = DB::select('call sp_Reporte_getListarPedidosR (?, ?, ?, ?, ?, ?)',
                                                            [   
                                                                $cDocumento,
                                                                $cNombre,
                                                                $cPedido,
                                                                $dFechaInicio,
                                                                $dFechaFin,
                                                                $nIdEstado
                                                            ]);
        return $rpta;
    }
}
