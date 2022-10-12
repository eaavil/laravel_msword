<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\MultiConnector;
use App\Models\CentrosOperacion;
use Yajra\Datatables\Datatables;

class CentrosOperacionController extends Controller
{
    public function listado_centros(){
        $titulo = 'Listado Total de Centros de Operacion';
		$modulo = 'Empresas';
		$seccion = 'Centros de Operacion';
        $session= session('role_id');
        $registros = CentrosOperacion::where('id_empresa',session('company'))->get();
        foreach($registros as $rows){
            $poblacion = \DB::table('000_poblaciones')
                        ->where('000_poblaciones.id','=',$rows->id_poblacion)
                        ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')
                        ->get();
            $rows->poblacion = $poblacion;
        }
        $poblaciones = \DB::table('000_poblaciones')
                            ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')
                            ->select('000_poblaciones.id as id_poblacion','000_poblaciones.nombre_ciudad','000_departamentos.departamento')
                            ->get();
        return view('empresas.000_centros_operacion.listado',compact('registros','titulo','modulo','seccion','poblaciones','session'));
    }
    public function registrar_centro(Request $request){
        $registro = new CentrosOperacion;
        $registro->id_empresa=session('company');
        $registro->codigo=$request->c02;
        $registro->descripcion=$request->c03;
        $registro->estado=1;
        $registro->direccion1=$request->c04;
        $registro->direccion2=$request->c05;
        $registro->direccion3=$request->c06;
        $registro->id_poblacion=$request->c07;
        $registro->telefono=$request->c08;
        $registro->fax=$request->c09;
        $registro->save();

        return redirect()->route('empresas.centros_operacion.listado')->with('result',array('message'=>'El Registro de la Empresa se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_centro($id){
        $registro = CentrosOperacion::find($id);
        return json_encode($registro);
    }
    public function actualizar_centro(Request $request){
        $registro = CentrosOperacion::find($request->id);
        $registro->codigo=$request->c02;
        $registro->descripcion=$request->c03;
        $registro->direccion1=$request->c04;
        $registro->direccion2=$request->c05;
        $registro->direccion3=$request->c06;
        $registro->id_poblacion=$request->c07;
        $registro->telefono=$request->c08;
        $registro->fax=$request->c09;
        $registro->save();

        return redirect()->route('empresas.centros_operacion.listado')->with('result',array('message'=>'La Actualizacion de la Empresa se realizo Exitosamente','type'=>'success'));
    }
    public function eliminar_centro($id){
        $registro = CentrosOperacion::where('id',$id)->delete();
        return redirect()->route('empresas.centros_operacion.listado')->with('result',array('message'=>'El Centro de Operacion de la Empresa se elimino Exitosamente','type'=>'success'));
    }
}
