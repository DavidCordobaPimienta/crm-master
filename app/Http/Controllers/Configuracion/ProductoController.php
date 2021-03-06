<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{    
    public function getListarProductos(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdProducto   = $request->nIdProducto;
        $cNombre        = $request->cNombre;
        $cDescripcion   = $request->cDescripcion;
        $nIdCategoria   = $request->nIdCategoria;

        $nIdProducto = ($nIdProducto == NULL) ? ($nIdProducto = 0): $nIdProducto;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0): $nIdCategoria;


        $rpta = DB::select('call sp_Producto_getListarProductos (?, ?, ?,?)',
                                                            [   
                                                                $nIdProducto,
                                                                $cNombre,
                                                                $cDescripcion,
                                                                $nIdCategoria
                                                            ]);
        return $rpta;
    }

    public function setRegistrarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre        = $request->cNombre;
        $cDescripcion   = $request->cDescripcion;
        $nIdCategoria   = $request->nIdCategoria;
        $nIdUserAut = Auth::id();

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0): $nIdCategoria;


        DB::select('call sp_Producto_setRegistrarProducto (?, ?, ?, ?)',
                                                            [   
                                                                $cNombre,
                                                                $cDescripcion,
                                                                $nIdCategoria,
                                                                $nIdUserAut
                                                            ]);
    }

    public function setEditarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdProducto    = $request->nIdProducto;
        $cNombre        = $request->cNombre;
        $cDescripcion   = $request->cDescripcion;
        $nIdCategoria   = $request->nIdCategoria;
        $nIdUserAut = Auth::id();

        $nIdProducto = ($nIdProducto == NULL) ? ($nIdProducto = 0): $nIdProducto;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0): $nIdCategoria;


        DB::select('call sp_Producto_setEditarProducto (?, ?, ?, ?, ?)',
                                                            [   
                                                                $nIdProducto,
                                                                $cNombre,
                                                                $cDescripcion,
                                                                $nIdCategoria,
                                                                $nIdUserAut
                                                            ]);
    }
}
