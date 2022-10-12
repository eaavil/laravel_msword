<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperacionesController extends Controller
{
    //
    public function listado_entradas(){
        $titulo = 'Entradas de Cafe Registradas';
		$modulo = 'Operaciones';
		$seccion = 'Entradas';
        return view('operaciones.entradas.listado',compact('titulo','modulo','seccion'));
    }
}
