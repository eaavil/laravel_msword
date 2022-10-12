<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\MultiConnector;
use App\Models\CentrosCosto;
use App\Models\Empresas;
use Yajra\Datatables\Datatables;

class CentrosCostoController extends Controller
{
    public function listado_centros(){
        $titulo = 'Listado Total de Centros de Costo';
		$modulo = 'Empresas';
		$seccion = 'Centros de Costo';
        $session= session('role_id');
        $registros = CentrosCosto::all();
        foreach($registros as $rows){
            $padre = CentrosCosto::find($rows->padre);
            $rows->padre_data = $padre;
            $empresa = Empresas::find($rows->id_empresa);
            $rows->empresa_data = $empresa;
        }
        return view('empresas.000_centros_costo.listado',compact('registros','titulo','modulo','seccion','session'));
    }
    public function listado_centros_data(){
        return Datatables::of(
            CentrosCosto::query()
            ->join('000_empresas','000_empresas.id','000_centros_costos.id_empresa')
            ->join('000_poblaciones','000_poblaciones.id','000_empresas.id_poblacion')
            ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')
            ->select('000_empresas.*','000_poblaciones.nombre_ciudad','000_departamentos.departamento')
            )->make();
    }
    public function registrar_centro(Request $request){
        $registro = new CentrosCosto;
        $registro->id_empresa=1;
        $registro->codigo=$request->c01;
        $registro->tipo=$request->c02;
        $registro->descripcion=$request->c03;
        $registro->responsable=$request->c04;
        $registro->padre=$request->c05;
        $registro->nivel=$request->c06;

        $registro->save();

        return redirect()->route('empresas.centros_costo.listado')->with('result',array('message'=>'El Registro del Centro de Costo se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_centro($id){
        $registro = CentrosCosto::find($id);
        return json_encode($registro);
    }
    public function eliminar_centro($id){
        $registro = CentrosCosto::find($id)->delete();
        return redirect()->route('empresas.centros_costo.listado')->with('result',array('message'=>'El Borrado del Centro de Costo se realizo Exitosamente','type'=>'success'));
    }
    public function actualizar_centro(Request $request){
        $registro = CentrosCosto::find($request->id);
        $registro->codigo=$request->c01;
        $registro->tipo=$request->c02;
        $registro->descripcion=$request->c03;
        $registro->responsable=$request->c04;
        $registro->padre=$request->c05;
        $registro->nivel=$request->c06;
        $registro->save();

        return redirect()->route('empresas.centros_costo.listado')->with('result',array('message'=>'La Actualizacion del Centro de Costo se realizo Exitosamente','type'=>'success'));
    }
}
