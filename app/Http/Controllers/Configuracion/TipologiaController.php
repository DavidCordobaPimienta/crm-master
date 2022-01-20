<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipologiaController extends Controller
{
    public function getListarCategorias(Request $request){
        if(!$request->ajax()) return redirect('/');

        $nIdCategoria   = $request->nIdCategoria;
        $cNombre        = $request->cNombre;
        $cDescripcion   = $request->cDescripcion;

        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0): $nIdCategoria;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;

        $rpta = DB::select('call sp_Categoria_getListarCategorias (?, ?, ?)',
                                                            [   
                                                                $nIdCategoria,
                                                                $cNombre,
                                                                $cDescripcion
                                                            ]);
        return $rpta;
    }

    public function setRegistrarCategoria(Request $request){
        if(!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cDescripcion = $request->cDescripcion;
        $nIdUserAut = Auth::id();

        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;

        DB::select('call sp_Categoria_setRegistrarCategoria (?, ?, ?)',
                                                            [   
                                                                $cNombre,
                                                                $cDescripcion,
                                                                $nIdUserAut,
                                                            ]);
    }

    public function setEditarCategoria(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $nIdCategoria = $request->nIdCategoria;
        $cNombre = $request->cNombre;
        $cDescripcion = $request->cDescripcion;
        $nIdUserAut = Auth::id();

        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0): $nIdCategoria;
        $cNombre = ($cNombre == NULL) ? ($cNombre = ''): $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = ''): $cDescripcion;

        DB::select('call sp_Categoria_setEditarCategoria (?, ?, ?, ?)',
                                                            [   
                                                                $nIdCategoria,
                                                                $cNombre,
                                                                $cDescripcion,
                                                                $nIdUserAut,
                                                            ]);

    }

}
