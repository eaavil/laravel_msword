<?php

namespace App\Http\Controllers\Empresas;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\MultiConnector;
use App\Models\Empresas;
use App\Models\Poblaciones;
use Yajra\Datatables\Datatables;

class EmpresasController extends Controller
{


    public function listado_empresas(){
        $titulo = 'Listado Total de Empresas';
		$modulo = 'Configuracion';
		$seccion = 'Empresas';
        $session= session('role_id');
        $registros = Empresas::all();
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
        return view('empresas.000_empresas.listado',compact('registros','titulo','modulo','seccion','poblaciones','session'));
    }

    public function listado_empresas_data(){
    return Datatables::of(
                     Empresas::query()
                     ->join('000_poblaciones','000_poblaciones.id','000_empresas.id_poblacion')
                     ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')
                     ->select('000_empresas.*','000_poblaciones.nombre_ciudad','000_departamentos.departamento')
                     )->make();
    }
    public function registrar_empresa(Request $request){
        $registro = new Empresas;
        $registro->codigo_empresa=$request->c01;
        $registro->razon_social=$request->c02;
        $registro->nit=$request->c03;
        $registro->digito_verificacion=$request->c04;
        $registro->direccion1=$request->c05;
        $registro->direccion2=$request->c06;
        $registro->direccion3=$request->c07;
        $registro->id_poblacion=$request->c08;
        $registro->telefono1=$request->c09;
        $registro->telefono2=$request->c10;
        $registro->correo_electronico=$request->c11;
        $registro->gran_contribuyente=$request->c12;
        $registro->retencion_renta_compras=$request->c13;
        $registro->retencion_renta_ventas=$request->c14;
        $registro->retencion_cree_ventas=$request->c15;
        $registro->retencion_iva_compras=$request->c16;
        $registro->retencion_iva_ventas=$request->c17;
        $registro->retencion_ica_compras=$request->c18;
        $registro->retencion_ica_ventas=$request->c19;
        $registro->tipo_modelo_ubl=1;
        $registro->save();
        return redirect()->route('empresas.listado')->with('result',array('message'=>'El Registro de la Empresa se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_empresa($id){
        $registro = Empresas::find($id);
        return json_encode($registro);
    }
    public function eliminar_empresa($id){
        Empresas::find($id)->delete();
        return redirect()->route('empresas.listado')->with('result',array('message'=>'La Empresa se elimino Exitosamente','type'=>'success'));
    }
    public function actualizar_empresa(Request $request){
        $registro = Empresas::find($request->id);
        $registro->codigo_empresa=$request->c01;
        $registro->razon_social=$request->c02;
        $registro->nit=$request->c03;
        $registro->digito_verificacion=$request->c04;
        $registro->direccion1=$request->c05;
        $registro->direccion2=$request->c06;
        $registro->direccion3=$request->c07;
        $registro->id_poblacion=$request->c08;
        $registro->telefono1=$request->c09;
        $registro->telefono2=$request->c10;
        $registro->correo_electronico=$request->c11;
        $registro->gran_contribuyente=$request->c12;
        $registro->retencion_renta_compras=$request->c13;
        $registro->retencion_renta_ventas=$request->c14;
        $registro->retencion_cree_ventas=$request->c15;
        $registro->retencion_iva_compras=$request->c16;
        $registro->retencion_iva_ventas=$request->c17;
        $registro->retencion_ica_compras=$request->c18;
        $registro->retencion_ica_ventas=$request->c19;
        $registro->tipo_modelo_ubl=1;
        $registro->save();

        return redirect()->route('empresas.listado')->with('result',array('message'=>'La Actualizacion de la Empresa se realizo Exitosamente','type'=>'success'));
    }
    public function set_default_empresa(Request $request){
        $request->session()->put('company', $request->company_selector);
        $empresa = Empresas::find($request->company_selector);
        $request->session()->put('company_name', $empresa->razon_social);
        return redirect()->back()->with('result',array('message'=>'Empresa Seleccionada con Exito','type'=>'success'));
    }
    public function obtener_empresas_activas(){
        $empresa = Empresas::all();
        return array('data'=>$empresa);
    }
  

        
}
