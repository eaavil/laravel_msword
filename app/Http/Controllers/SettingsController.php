<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParametrosModulos;
use App\Models\Poblaciones;
use App\Models\Departamentos;
use App\Models\BancosMovimiento;

class SettingsController extends Controller
{
    //
	public function view_settings(){
		$titulo = 'Parametros del Sistema';
		$modulo = 'Contratos';
		$seccion = 'Compras';
		$settings = ParametrosModulos::all();
		return view('settings.listado',compact('titulo','modulo','seccion','settings'));
	}
	
	public function get_setting($id){
		$data = ParametrosModulos::find($id);
		return $data;
	}
	
	public function update_setting(Request $request){
		$data = ParametrosModulos::find($request->id);
		$data->parametro = $request->c01;
		$data->save();
		return back()->with('result',array('message'=>'El parametro se Actualizo Exitosamente','type'=>'success'));
	}

	public function get_interval_rows($table_index){
		switch ($table_index) {
			case 1: //ingreso
				$rows = BancosMovimiento::where('modo',1)->count();
				return $rows+1;
				break;
			case 2: //egreso
				$rows = BancosMovimiento::where('modo',2)->count();
				return $rows+1;
				break;
		}
	}
	
	public function ciudades(){
		$titulo = 'Parametros del Sistema';
		$modulo = 'Ciudades';
		$seccion = 'Gestion';
		$settings = Poblaciones::all();
		$departamentos = Departamentos::all();
		foreach($settings as $rows){
			$poblacion = Departamentos::find($rows->id_departamento);
			$rows->departamentos = $poblacion;
		}
		return view('settings.listado_ciudades',compact('titulo','modulo','seccion','settings','departamentos'));
	}
	
	public function obtener_ciudad($id){
		$data = Poblaciones::find($id);
		return $data;
	}
	
	public function actualizar_ciudad(Request $request){
		$data = Poblaciones::find($request->id);
		$data->nombre_ciudad = $request->c01;
		$data->id_departamento = $request->c02;
		$data->save();
		return back()->with('result',array('message'=>'El parametro se Actualizo Exitosamente','type'=>'success'));
	}	
	
	public function eliminar_ciudad(Request $request){
		$data = Poblaciones::find($request->id)->delete();
		return back()->with('result',array('message'=>'El parametro se Elimino Exitosamente','type'=>'success'));
	}	
	
	public function registrar_ciudad(Request $request){
		$data = new Poblaciones;
		$data->nombre_ciudad = $request->c01;
		$data->id_departamento = $request->c02;
		$data->save();
		return back()->with('result',array('message'=>'El parametro se Registro Exitosamente','type'=>'success'));
	}
}
