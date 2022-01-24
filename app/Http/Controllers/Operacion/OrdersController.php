<?php

namespace App\Http\Controllers\Operacion;

use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function getListarPedidos(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre        = $request->cNombre;
        $cDocumento     = $request->cDocumento;
        $cPedido        = $request->cPedido;
        $nIdEstado      = $request->nIdEstado;

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = ''): $cDocumento;
        $cPedido = ($cPedido == NULL) ? ($cPedido = 0): $cPedido;
        $nIdEstado = ($nIdEstado == NULL) ? ($nIdEstado = 0): $nIdEstado;

        $rpta = DB::select('call sp_Pedido_getListarPedidos (?, ?, ?, ?)',
                                                            [   
                                                                $cNombre,
                                                                $cDocumento,
                                                                $cPedido,
                                                                $nIdEstado
                                                            ]);
        return $rpta;
    }

    public function setRegistrarPedido(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdCliente = $request->nIdCliente;
        $cComentario = $request->cComentario;
        $nIdUserAut = Auth::id(); 

        $cComentario = ($cComentario == NULL) ? ($cComentario = ''): $cComentario;

        try {
            DB::beginTransaction();
            $rpta = DB::select('call sp_Pedidos_setRegistrarPedido (?, ?, ?)',
                                                            [
                                                                $nIdCliente,
                                                                $cComentario,
                                                                $nIdUserAut
                                                            ]);
            $nIdPedido = $rpta[0]->nIdPedido;

            $listPedido = $request->listPedido;
            $listPedidoSize = sizeof((array)$listPedido);
            
            if ($listPedidoSize>0) {
                foreach ($listPedido as $key => $value) {
                        DB::select('call sp_Pedidos_setRegistrarDetallePedido (?, ?)',
                                                            [
                                                                $nIdPedido,
                                                                $value['nIdProducto']
                                                            ]);
                }
            }
            DB::commit();
            return $nIdPedido;
        } catch (Exception $e) {
            DB::rollBack();
        }
                
    }

    public function setGenerarDocumento(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdPedido = $request->nIdPedido;

        $rpta1 = DB::select('call sp_Pedidos_getPedido (?)',
                                                            [
                                                                $nIdPedido
                                                            ]);

        $rpta2 = DB::select('call sp_Pedidos_getDetallePedido (?)',
                                                            [
                                                                $nIdPedido
                                                            ]);

        $pdf = PDF::loadView('reportes.caso.pdf.ver', [
            'rpta1' => $rpta1,
            'rpta2' => $rpta2
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function setCambiarEstadoPedido(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdPedido = $request->nIdPedido;
        $cEstado = $request->cEstado;
        $nIdUserAut = Auth::id();

        $nIdPedido = ($nIdPedido == NULL) ? ($nIdPedido = ''): $nIdPedido;    
        $cEstado = ($cEstado == NULL) ? ($cEstado = ''): $cEstado;

        DB::select('call sp_Pedido_setCambiarEstadoPedido (?, ?, ?)',
                                                            [
                                                                $nIdPedido,
                                                                $cEstado, 
                                                                $nIdUserAut
                                                            ]);
    }

}
