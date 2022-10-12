<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Liquidaciones;
use App\Models\EntradasSalidasCafe;
use App\Models\CatalogoEmpresas;
use App\Models\Contratos;
use App\Models\GirosAnticipos;
use App\Models\TiposCafe;
use App\Models\ParametrosModulos;
use App\Models\CentrosCosto;
use App\Models\CentrosOperacion;
use Yajra\Datatables\Datatables;

class LiquidacionesController extends Controller
{
    public $fecha_inicio_periodo='2021-01-01';
    public function listar_entradas(Request $request){
        $titulo = 'Entradas de Cafe para Liquidar';
		$modulo = 'Liquidaciones';
		$seccion = 'Entradas';
		$session= session('role_id');
	    $cafe = TiposCafe::all();
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $consecutivo = ParametrosModulos::find(11);
        $numeracion = ParametrosModulos::find(12);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',1)->get();
        $id=0;
		return view('liquidaciones.listado',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','id','session','cafe'));
    }

	public function data_listar_entradas(Request $request){

		if($request->id_prov==null){
			 $operaciones = \DB::select( \DB::raw("SELECT * FROM 003_entradas_salidas_cafe WHERE tipo_operacion=1 AND peso_neto>liquidado and terminada=0 AND deleted_at IS NULL"));
		}else{
			$operaciones = \DB::select( \DB::raw("SELECT * FROM 003_entradas_salidas_cafe WHERE tipo_operacion=1 AND id_catalogo_proveedor=:proveedor and terminada=0 AND peso_neto>liquidado AND deleted_at IS NULL"), array(
			   'proveedor' => $request->id_prov,
			 ));
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}


        foreach($operaciones as $regis){
            $liquidaciones = Liquidaciones::where('id_entrada_cafe',$regis->id)->get();
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_proveedor);
            $conductor = CatalogoEmpresas::find($regis->id_catalogo_conductor);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
            $pendientes = $regis->peso_neto;

            $regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
			$regis->conductor = $conductor;
			$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}

	public function listar_entradas_data(Request $request){
        $modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
		if($request->id_prov==null){
			 $operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			 ->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
			 ->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
			 ->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
			 ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
			 ->where('003_entradas_salidas_cafe.terminada','=',0)
			 ->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
			 '000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
			 'cp.id as proveedor_id','cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
			 ->get();
		}else{
			$operaciones = EntradasSalidasCafe::query()
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
			->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
			->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
			->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
			->where('003_entradas_salidas_cafe.terminada','=',0)
			->where('003_entradas_salidas_cafe.id_catalogo_proveedor','=',$request->id_prov)
			->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
			 'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
			 'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
			 ->get();	
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}
		}else{
			
			if($id_prov==-1){
				$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.id as proveedor_id','cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
		   }else{
			   $operaciones = EntradasSalidasCafe::query()
			   ->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			   ->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
			   ->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
			   ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
			   ->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
               ->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
			   ->where('003_entradas_salidas_cafe.terminada','=',0)
			   ->where('003_entradas_salidas_cafe.id_catalogo_proveedor','=',$request->id_prov)
			   ->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();	
			   //$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}
		
		}
		foreach($operaciones as $regis){
			$liquidaciones = Liquidaciones::where('id_entrada_cafe',$regis->id)->get();
			$liquidados = 0;
			$pendientes = 0;
			foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
			$pendientes = $regis->peso_neto;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
			
		}
        return array('data'=>$operaciones);
	}

	public function listar_contratos_compra_sin_liquidacion(Request $request){
        $titulo = 'Contratos de Compra sin Liquidar';
		$modulo = 'Liquidaciones';
		$seccion = 'Entradas';
		$proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        return view('liquidaciones.listado_contratos_pendientes',compact('proveedores','titulo','modulo','seccion'));
	}
	
	public function data_listar_contratos_compra_sin_liquidacion(Request $request){

		if($request->id_prov==null){
			 $operaciones = \DB::select( \DB::raw("SELECT * FROM 003_contratos WHERE tipo_contrato=1 AND kilos_compromiso>kilos_entregados AND id NOT IN (select id FROM 002_liquidaciones WHERE tipo_contrato=1 AND id_contrato IS NOT NULL AND deleted_at IS NULL) AND estado=1 AND deleted_at IS NULL"));
		}else{
			$operaciones = \DB::select( \DB::raw("SELECT * FROM 003_contratos WHERE tipo_contrato=1 AND id_catalogo_empresa_proveedor=:proveedor AND kilos_compromiso>kilos_entregados AND id NOT IN (select id FROM 002_liquidaciones WHERE tipo_contrato=1 AND id_contrato IS NOT NULL AND deleted_at IS NULL) AND estado=1 AND deleted_at IS NULL"), array(
			   'proveedor' => $request->id_prov,
			 ));
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}


        foreach($operaciones as $regis){
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_empresa_proveedor);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $regis->proveedor = $proveedor;
			$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}
	
	public function listar_contratos_compra_sin_liquidacion_data(Request $request){

		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){		    
		if($request->id_prov==null){
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at');
		}else{
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('003_contratos.id_catalogo_empresa_proveedor','=',$request->id_prov)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at');
			}
		}else{
			if($id_prov==-1){
				$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',1)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->select('*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at');
			}else{
				$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',1)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->where('003_contratos.id_catalogo_empresa_proveedor','=',$request->id_prov)
					->select('*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at');
				}
		
		}
        return array('data'=>$operaciones);	
    }

	public function obtener_contratos_proveedor($id){
		$contratos = Contratos::where('id_catalogo_empresa_proveedor',$id)->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('estado',1)->get();
     return ['data'=>$contratos];
	}

    public function listar_entradas_liquidadas(Request $request){
        $titulo = 'Entradas de Cafe Liquidadas';
		$modulo = 'Liquidaciones';
		$seccion = 'Entradas';
		$session= session('role_id');
		$cafe = TiposCafe::all();
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $consecutivo = ParametrosModulos::find(11);
        $numeracion = ParametrosModulos::find(12);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',1)->get();

        return view('liquidaciones.listado_liquidadas',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','session','cafe'));
    }

	public function data_listar_entradas_liquidadas(Request $request){

		if($request->id_prov==null){
			 $operaciones = \DB::select( \DB::raw("SELECT *,li.id_contrato as id_contrato_liquidacion,li.factor as factor_liquidacion,li.id as id_liquidacion FROM 002_liquidaciones li INNER JOIN 003_entradas_salidas_cafe es ON li.id_entrada_cafe=es.id WHERE tipo_operacion=1 AND li.deleted_at IS NULL"));
		}else{
			$operaciones = \DB::select( \DB::raw("SELECT *,li.id_contrato as id_contrato_liquidacion,li.factor as factor_liquidacion,li.id as id_liquidacion FROM 002_liquidaciones li INNER JOIN 003_entradas_salidas_cafe es ON li.id_entrada_cafe=es.id  WHERE tipo_operacion=1 AND id_catalogo_proveedor=:proveedor AND li.deleted_at IS NULL"), array(
			   'proveedor' => $request->id_prov,
			 ));
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}


        foreach($operaciones as $regis){
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_proveedor);
            $conductor = CatalogoEmpresas::find($regis->id_catalogo_conductor);
            $contrato = Contratos::find($regis->id_contrato_liquidacion);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            $regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
			$regis->conductor = $conductor;
			$regis->contrato = $contrato;
			$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}
	
	public function listar_entradas_liquidadas_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
			if($request->id_prov==null){
				$operaciones = Liquidaciones::query()
					->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_entrada_cafe')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
					//->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->orderBy('002_liquidaciones.created_at','desc')
					->select('*','002_liquidaciones.id_contrato as id_contrato_liquidacion',
					'002_liquidaciones.factor as factor_liquidacion',
					'002_liquidaciones.id as id_liquidacion',
					'002_liquidaciones.numero as numero_liquidacion',
					//'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
					->get();
			}
			else{ 
				$operaciones =Liquidaciones::query()
					->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_entrada_cafe')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
					//->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->where('003_entradas_salidas_cafe.id_catalogo_proveedor','=',$request->id_prov)
					->orderBy('002_liquidaciones.created_at','desc')
					->select('*','002_liquidaciones.id_contrato as 
					id_contrato_liquidacion',
					'002_liquidaciones.factor as factor_liquidacion',
					'002_liquidaciones.numero as numero_liquidacion',
					'002_liquidaciones.id as id_liquidacion',
					//'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')->get();	 
			}
	    }else{
            if($id_prov==-1){
				$operaciones = Liquidaciones::query()
					->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_entrada_cafe')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
					//->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->orderBy('002_liquidaciones.created_at','desc')
					->select('*','002_liquidaciones.id_contrato as id_contrato_liquidacion',
					'002_liquidaciones.factor as factor_liquidacion',
					'002_liquidaciones.id as id_liquidacion',
					'002_liquidaciones.numero as numero_liquidacion',
					//'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
					->get();
			}
			else{
				$operaciones =Liquidaciones::query()
					->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_entrada_cafe')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
					//->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->where('003_entradas_salidas_cafe.id_catalogo_proveedor','=',$request->id_prov)
					->orderBy('002_liquidaciones.created_at','desc')
					->select('*','002_liquidaciones.id_contrato as 
					id_contrato_liquidacion',
					'002_liquidaciones.factor as factor_liquidacion',
					'002_liquidaciones.numero as numero_liquidacion',
					'002_liquidaciones.id as id_liquidacion',
					//'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')->get();	 
			}
		}
		 foreach($operaciones as $regis){
           // $proveedor = CatalogoEmpresas::find($regis->id_catalogo_proveedor);
           // $conductor = CatalogoEmpresas::find($regis->id_catalogo_conductor);
           // $contrato = Contratos::find($regis->id_contrato_liquidacion);
			//$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            //$regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
			//$regis->conductor = $conductor;
			//$regis->contrato = $contrato;
			//$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}

    public function eliminar_liquidacion_entrada($id){
        $registro = Liquidaciones::find($id);
        $registro->delete();

        $registro_entrada = EntradasSalidasCafe::find($registro->id_entrada_cafe);
        $registro_entrada->liquidado = $registro_entrada->liquidado-$registro->kilogramos;
        $registro_entrada->save();

		$registro_contrato = Contratos::find($registro->id_contrato);
        $registro_contrato->kilos_entregados = $registro_contrato->kilos_entregados-$registro->kilogramos;
        $registro_contrato->save();

        return redirect()->back()->with('result',array('message'=>'Liquidacion '.$registro->numero.' Eliminada Exitosamente','type'=>'success'));
    }


	public function listar_entradas_detalle_data($id_entrada){

		$operaciones = Liquidaciones::where('id_entrada_cafe',$id_entrada)->get();

        return array('data'=>$operaciones);
    }

    public function registrar_liquidacion_entrada(Request $request){
		$request->validate([//,deleted_at,NULL
		'numero'=>['unique:002_liquidaciones,numero,NULL,id'],//deleted_at,NULL
		],[
			'numero.unique'=> 'Numero de liquidacion repetido',
		]
	    );
		
	    if($request->id_entrada!=null){
			$contrato= $request->contrato;
			if($contrato==null){
				$contrato=-1;
			};
			$registro = new Liquidaciones;
			$registro->id_entrada_cafe=$request->id_entrada;
			$registro->id_contrato=$contrato;
			$registro->numero=$request->numero;
			$registro->kilogramos=str_replace('.','',$request->c01);
			$registro->factor=$request->c02;
			$registro->descuento_factor=$request->c03;
			$registro->factor_descuento=$request->c04;
			$registro->valor_arroba=str_replace('.','',$request->c05);
			$registro->valor_bruta=str_replace('.','',$request->c06);
			$registro->valor_descuento=str_replace('.','',$request->c07);
			$registro->porcentaje_retencion=$request->c08;
			$registro->valor_retencion_fuente=str_replace('.','',$request->c09);
			$registro->porcentaje_retencion_4_mil=$request->c10;
			$registro->valor_retencion_4_mil=str_replace('.','',$request->c11);
			$registro->porcentaje_retencion_cooperativa=$request->c12;
			$registro->valor_retencion_cooperativa=str_replace('.','',$request->c13);
			$registro->porcentaje_retencion_tercero=$request->c14;
			$registro->valor_retencion_tercero=str_replace('.','',$request->c15);
			$registro->total=str_replace('.','',$request->c16);
			$registro->id_usuario=session('id');
			$registro->fecha_liquidacion=date('Y-m-d h:i:s',strtotime($request->c17));
			$registro->valor_punto=str_replace('.','',$request->v01);
			$registro->valor_producido=$request->v02;
			$registro->save();

			$entrada = EntradasSalidasCafe::find($request->id_entrada);
			$entrada->liquidado=$entrada->liquidado+str_replace('.','',$request->c01);
			$entrada->save();
			
		if($contrato!=-1){
			$entrada = Contratos::find($request->contrato);
			$entrada->kilos_entregados=$entrada->kilos_entregados+str_replace('.','',$request->c01);
			$entrada->save();
		}

			$this->incrementar_contador_entrada();
	    }
        $id=CatalogoEmpresas::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id_catalogo_proveedor','000_catalogo_empresas.id')
		 ->where('003_entradas_salidas_cafe.id',$request->id_entrada)->select('000_catalogo_empresas.id')->value('000_catalogo_empresas.id');         
		
        
		$titulo = 'Entradas de Cafe para Liquidar';
		$modulo = 'Liquidaciones';
		$seccion = 'Entradas';
		$cafe = TiposCafe::all();
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $consecutivo = ParametrosModulos::find(11);
        $numeracion = ParametrosModulos::find(12);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',1)->get();
     
		
		return view('liquidaciones.listado',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','id','cafe'))->with('result',array('message'=>'Liquidacion Anexada Exitosamente','type'=>'success'));
	
    }

    public function obtener_liquidacion_entrada($id){
        $operacion = EntradasSalidasCafe::where('id',$id)->get();
        $liquidaciones = Liquidaciones::where('id_entrada_cafe',$id)->get();
        $liquidados = 0;
        $pendientes = 0;
        foreach($liquidaciones as $regis){
            $liquidados += $regis->kilogramos;
        }
        $pendientes = $operacion[0]->peso_neto;
        foreach($operacion as $regis){
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_proveedor);
            $regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
        }
        return $operacion;
	}
	
	public function procesar_reporte_entradas(Request $request){
	
        if($request->tipo_reporte==2){
			if($request->c03==-1){
				return $this->reporte_fecha_entradas($request->c01,$request->c02,$request->c04,$request->c06);
			}elseif($request->c03!=-1){
				return $this->reporte_fecha_entradas_proveedor($request->c01,$request->c02,$request->c03,$request->c04,$request->c06);
			}
		}

		if($request->tipo_reporte==1){
			
			//return $this->reporte_entradas_pendientes($request);
			return $this->reporte_entradas_pendientes_ordenado($request);
		}
		
		if($request->tipo_reporte==3){
			return $this->reporte_contratos_compra_sin_liquidacion_data_ordenado($request->c01,$request->c02,$request->c04,$request->c06,$request->c03);
			//return $this->reporte_contratos_compra_sin_liquidacion_data($request);		
		}
	}
	public function reporte_contratos_compra_sin_liquidacion_data_ordenado($fecha_inicial,$fecha_final,$tipo_archivo,$tipo_cafe,$proveedor){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
        $operaciones=null;
		
		if($proveedor==-1){//si son todos los clientes
			$operaciones=Contratos::join('000_catalogo_empresas','000_catalogo_empresas.id','003_contratos.id_catalogo_empresa_proveedor')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
			->where('003_contratos.tipo_contrato',1)
			->where('003_contratos.estado',1)
			->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
			->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))
			->get()
		  ;
			if($tipo_cafe!=-1){//si es algun tipo de cafe
				$operaciones=Contratos::join('000_catalogo_empresas','000_catalogo_empresas.id','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato',1)
				->where('id_tipo_cafe',$tipo_cafe)
				->where('003_contratos.estado',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->orderBy('000_catalogo_empresas.nombre','asc')
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))

				->get()
			;
			}	
		}else{//si es un cliente en particular
			$operaciones=Contratos::join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
			    ->where('003_contratos.tipo_contrato',1)
				->where('003_contratos.estado',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_proveedor','=',$proveedor)
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))
                ->get()
			;
			if($tipo_cafe!=-1){//si es un tipo de cafe en particular
				$operaciones=Contratos::join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('id_tipo_cafe',$tipo_cafe)
				->where('003_contratos.estado',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_proveedor','=',$proveedor)
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))

				->get()
			;
			}
			
			
		}
		$data_reporte = [];
		foreach($operaciones as $indice => $rows){
			try{
				
				$data_reporte[$rows->id_catalogo_empresa_proveedor]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo_empresa_proveedor);
				$data_reporte[$rows->id_catalogo_empresa_proveedor]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				//dump($e->getMessage());
				//dump($rows->id);

			}
        }
		if(count($data_reporte)>0){

            
			foreach($data_reporte as $indice => $datal){
				usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
			}
            // return $data_reporte;
			$excel=$tipo_archivo;

				return view('liquidaciones.reportes.salidas.listado_contratos_pendientes_ordenado',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen'));
			}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }

	public function reporte_fecha_entradas_proveedor($fecha_inicial,$fecha_final,$proveedor,$tipo_archivo,$tipo_cafe){
	    $imagen = base64_encode(\Storage::get('logo_actual.png'));
		
		if($tipo_cafe!=-1){
			$data = Liquidaciones::whereIn('id_entrada_cafe', function($query) use ($proveedor,$tipo_cafe){
				$query->select('id')
				->from(with(new EntradasSalidasCafe)->getTable())
				->where('id_catalogo_proveedor', $proveedor)
				->where('id_tipo_cafe',$tipo_cafe);
			})->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])
			->orderBy('fecha_liquidacion','asc')->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get();
		}else{
			$data = Liquidaciones::whereIn('id_entrada_cafe', function($query) use ($proveedor){
				$query->select('id')
				->from(with(new EntradasSalidasCafe)->getTable())
				->where('id_catalogo_proveedor', $proveedor);
			})->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])
			->orderBy('fecha_liquidacion','asc')->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get();
	     } 
		$valor_giro= GirosAnticipos::where('id_catalogo',$proveedor)
			->whereBetween('fecha_giro', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
			->where('tipo_operacion',1)
		    //->selectRaw('*')->get();
			->selectRaw('sum(valor) as saldo')
			->value('saldo')
        ;
   
        $valor_liquidacion= Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
			->where('id_catalogo_proveedor',$proveedor)
			//->where('tipo_contrato',1)
			->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
			//->selectRaw('total,fecha_liquidacion')->get();
			->selectRaw('sum(total) as saldo')
			->value('saldo')
        ;
        $saldo_acomulado=$valor_giro-$valor_liquidacion;
		$esproveedor=1;
		$indice=0;
		//si no tiene liquidaciones obtenemos solo los giros
		if(count($data)==0){
			 $giros = GirosAnticipos::where('id_catalogo',$proveedor)->whereBetween(\DB::raw('DATE(fecha_giro)'),  [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->where('tipo_operacion',1)->select(\DB::raw("*,fecha_giro as fecha"))->get();
			
			foreach($giros as $rows){
                $rows->saldo_acomulado=$saldo_acomulado;
				$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($proveedor);
				$data_reporte[0]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}
			ksort($data_reporte[0]['proveedor']['data']);
		}else{
		    foreach($data as $indice => $rows){
			try{
				//Restauramos entrada liquidada si se elimino
				$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_entrada_cafe)->first();
				$entrada_eliminada->restore();
				$entrada = EntradasSalidasCafe::where('id',intval($rows->id_entrada_cafe))->get();
				//restaurar contrato si se elimino
			    $contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
				$contrato_eliminado->restore();
				$contrato = Contratos::find($rows->id_contrato);
				$giros = GirosAnticipos::where('id_catalogo',$entrada[0]->id_catalogo_proveedor)->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial, $fecha_final])->where('tipo_operacion',1)->select(\DB::raw("*,fecha_giro as fecha"))->get();
                $centros = CentrosOperacion::find($contrato->id_centro_operacion);
				$rows->centros = $centros;
				$rows->contrato = $contrato;
				$rows->entrada = $entrada;
				$rows->saldo_acomulado=$saldo_acomulado;
                if($rows->id_contrato==-1){
					$indice=intval($entrada[0]->id_catalogo_proveedor);
					$cafe  = TiposCafe::find($entrada[0]->id_tipo_cafe);
					$rows->cafe = $cafe;
					$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($indice);
                   
				}else{
				$cafe = TiposCafe::find($contrato->id_tipo_cafe);
				$rows->cafe = $cafe;
				$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($rows->contrato->id_catalogo_empresa_proveedor);
                }
				$data_reporte[0]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
				foreach($giros as $rowsx){
					$data_reporte[0]['proveedor']['data'][strtotime($rowsx->created_at)]=$rowsx;
				}
				ksort($data_reporte[0]['proveedor']['data']);

				
			}catch(\Exception $e){
			    
			    dump ($rows);
			}
        }
	   }
	   
		//contratos sin liquidacion completa
		$operaciones=null;
		if($proveedor!=-1){
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('003_contratos.id_catalogo_empresa_proveedor',$proveedor)
				->where('003_contratos.estado',1)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')
				->get();
		}
     try{
			if(count($data_reporte[0]['proveedor']['data'])>0){
				//organizar por fecha
				usort($data_reporte[0]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
				
				$excel=$tipo_archivo;
			
				if($excel==2){
					return view('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
				}
				return view('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('legal', 'landscape');
				$pdf->loadView('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','operaciones'));
				return $pdf->stream();

			}else{
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
		}catch(\Exception $e){
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_entradas($fecha_inicial,$fecha_final,$tipo_archivo,$tipo_cafe){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $data_reporte = [];
		$operaciones=null;
		if($tipo_cafe!=-1){
			$data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->where('003_entradas_salidas_cafe.id_tipo_cafe',$tipo_cafe)
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get()
		;
		}else{
		$data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get()
		;
	    }
		$fin = [];
		$saldo_acomulado=-1;
		$esproveedor=0;
		$indice=0;
		foreach($data as $indice => $rows){
			try{
				//Restaurar entrada liquidada si se elimino
				$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_entrada_cafe)->first();
				$entrada_eliminada->restore();
				$entrada = EntradasSalidasCafe::where('id',$rows->id_entrada_cafe)->get();
				//restaurar contrato si se elimino
				$contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
			
				$contrato_eliminado->restore();$contrato = Contratos::find($rows->id_contrato);
				$giros = GirosAnticipos::where('id_catalogo',$entrada[0]->id_catalogo_proveedor)->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial, $fecha_final])->where('tipo_operacion',1)->select(\DB::raw("*,fecha_giro as fecha"))->get();
				$valor_giro= GirosAnticipos::where('id_catalogo',$entrada[0]->id_catalogo_proveedor)
					->whereBetween('fecha_giro', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_inicial.' -1 days'))])
					->where('tipo_operacion',1)
					//->selectRaw('*')->get();
					->selectRaw('sum(valor) as saldo')
					->value('saldo')
			    ;
	            
				$valor_liquidacion= Liquidaciones::query()
					->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
					->where('id_catalogo_proveedor',$entrada[0]->id_catalogo_proveedor)
					//->where('tipo_contrato',1)
					->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
					//->selectRaw('total,fecha_liquidacion')->get();
					->selectRaw('sum(total) as saldo')
					->value('saldo')
				;
				$saldo_acomulado=$valor_giro-$valor_liquidacion;
				$cafe = TiposCafe::find($contrato->id_tipo_cafe);
				$centros = CentrosOperacion::find($contrato->id_centro_operacion);
				//return $rows->id_contrato;
               
				$rows->cafe = $cafe;
				$rows->centros = $centros;
				$rows->contrato = $contrato;
				$rows->entrada = $entrada;
                $rows->saldo_acomulado=$saldo_acomulado;
				if($rows->id_contrato==-1){
					$cafe  = TiposCafe::find($entrada[0]->id_tipo_cafe);
					$rows->cafe = $cafe;
					$indice=$entrada[0]->id_catalogo_proveedor;

                    
				}else{
					$indice=$rows->contrato->id_catalogo_empresa_proveedor;
					
				}
				$data_reporte[$indice]['proveedor']['info'] = CatalogoEmpresas::find($indice);
				$data_reporte[$indice]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
				$data_reporte[$indice]['proveedor']['saldo_acomulado'] =$saldo_acomulado;

				foreach($giros as $rowsx){
					$data_reporte[$indice]['proveedor']['data'][strtotime($rowsx->created_at)]=$rowsx;
				}

			}catch(\Exception $e){
				dump($e->getMessage());
			return $rows;

			}
        }
		// agregar a $data reportes aquellas gios que no tienen liquidacion
        $clientes_liquidados=Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->select(\DB::raw("000_catalogo_empresas.id"))
	    ;
		$giros_sin_liquidar=GirosAnticipos::whereNotIn('id_catalogo',$clientes_liquidados)
			->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])
			->where('tipo_operacion',1)
			->select(\DB::raw("*,fecha_giro as fecha"))->get()
		;
		foreach($giros_sin_liquidar as $rows){
			$valor_giro= GirosAnticipos::where('id_catalogo',$rows->id_catalogo)
					->whereBetween('fecha_giro', [$this->fecha_inicio_periodo." 00:00:00" , date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
					->where('tipo_operacion',1)
					->selectRaw('sum(valor) as saldo')
					->value('saldo')
			;
			$valor_liquidacion= Liquidaciones::query()
				->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
				->where('id_catalogo_proveedor',$rows->id_catalogo)
				->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
				//->selectRaw('total,fecha_liquidacion')->get();
				->selectRaw('sum(total) as saldo')
				->value('saldo')
			;
			$saldo_acomulado=$valor_giro-$valor_liquidacion;
			$data_reporte[$rows->id_catalogo]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo);
			$data_reporte[$rows->id_catalogo]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
		    $data_reporte[$rows->id_catalogo]['proveedor']['saldo_acomulado'] =$saldo_acomulado;
		};
		try{
			if(count($data_reporte)>0){
				//organizar reporte por fecha
				foreach($data_reporte as $indice => $datal){
					usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
						return $a['fecha'] <=> $b['fecha'];
					});
				}
				//return $data_reporte;
				$excel=$tipo_archivo;
				if($excel==2){
					return view('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','operaciones'));
				}
				return view('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('legal', 'landscape');
				$pdf->loadView('liquidaciones.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
				return $pdf->stream();

			}else{
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
		}catch(\Exception $e){
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }
    
	public function reporte_resumen_saldo_entradas(Request $request){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        if($request->c01==-1){
			$data= CatalogoEmpresas::where('es_proveedor',1)
			->orderBy('nombre','asc')->select('id','nombre')->get();
	    }else{
            $data= CatalogoEmpresas::where('id',$request->c01)->where('es_proveedor',1)
			->orderBy('nombre','asc')->select('id','nombre')->get();
		}

		foreach($data as $indice => $rows){
			try{
				$giros=GirosAnticipos::where('id_catalogo', $rows->id)->where('tipo_operacion',1)
				->orderBy('fecha_giro','desc')
				->select('valor','id','fecha_giro')
				->get();

				$total_liquidaciones= liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_entrada_cafe')
				->where('id_catalogo_proveedor',$rows->id)
				->selectRaw('sum(total) as total')
				->value('total');

				$total_giros=GirosAnticipos::where('id_catalogo', $rows->id)->where('tipo_operacion',1)
				->selectRaw('sum(valor) as valor')
				->value('valor');
				
				$saldo2=$total_giros-$total_liquidaciones;
				$saldo=$total_giros-$total_liquidaciones;
				$cont=0;
				$data_reporte[$rows->id]['proveedor']['info']=$rows;
				$data_reporte[$rows->id]['proveedor']['saldo']=$saldo;
				$tot_j=0;
               if(count($giros)>0 && $saldo!=0){
				   
					foreach($giros as $rowsx){
							$tot_j+=$rowsx->valor;
							$saldo-=$rowsx->valor;
						if($saldo>=0){
							$rowsx->saldo=$rowsx->valor;
						}else{
							$rowsx->saldo=$saldo2-($tot_j-$rowsx->valor);
						}
						if($cont==0){
							$data_reporte[$rows->id]['proveedor']['giro'][]=$rowsx;
					    }
						if($saldo<=0){
							$cont++;
						}
					}
					$data_reporte[$rows->id]['proveedor']['giros']=array_reverse($data_reporte[$rows->id]['proveedor']['giro']);//ordenar giro
				}
				
			}catch(\Exception $e){
				dump($e->getMessage());
			return $rows;
			} 

		}
		$excel=$request->c02;
        if(count($data)>0){
            return view('liquidaciones.reportes.entradas.resumen_saldo',compact('data_reporte','imagen','excel'));
        }else{
            return view('cafe.reportes.no-reporte');
        }
	}
    
	public function reporte_resumen_saldo_salidas(Request $request){
		
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
        if($request->c01==-1){
			$data= CatalogoEmpresas::where('es_cliente',1)
			->orderBy('nombre','asc')->select('id','nombre')->get();
	    }else{
            $data= CatalogoEmpresas::where('id',$request->c01)->where('es_cliente',1)
			->orderBy('nombre','asc')->select('id','nombre')->get();
		}

		foreach($data as $indice => $rows){
			try{
				$giros=GirosAnticipos::where('id_catalogo', $rows->id)->where('tipo_operacion',2)
				->orderBy('fecha_giro','desc')
				->select('valor','id','fecha_giro')
				->get();

				$total_liquidaciones= liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_salida_cafe')
				->where('id_catalogo_cliente',$rows->id)
				->selectRaw('sum(total) as total')
				->value('total');

				$total_giros=GirosAnticipos::where('id_catalogo', $rows->id)->where('tipo_operacion',2)
				->selectRaw('sum(valor) as valor')
				->value('valor');
				
				$saldo2=$total_giros-$total_liquidaciones;
				$saldo=$total_giros-$total_liquidaciones;
				$cont=0;
				$data_reporte[$rows->id]['proveedor']['info']=$rows;
				$data_reporte[$rows->id]['proveedor']['saldo']=$saldo;
				$tot_j=0;
               if(count($giros)>0 && $saldo!=0){
					foreach($giros as $rowsx){
							$tot_j+=$rowsx->valor;
							$saldo-=$rowsx->valor;
						if($saldo>=0){
							$rowsx->saldo=$rowsx->valor;
						}else{
							$rowsx->saldo=$saldo2-($tot_j-$rowsx->valor);
						}
						if($cont==0){
							$data_reporte[$rows->id]['proveedor']['giro'][]=$rowsx;
					    }
						if($saldo<=0){
							$cont++;
						}
					}
					$data_reporte[$rows->id]['proveedor']['giros']=array_reverse($data_reporte[$rows->id]['proveedor']['giro']);//ordenar giro
				}
			}catch(\Exception $e){
				dump($e->getMessage());
			return $rows;
			} 

		}
		$excel=$request->c02;
        if(count($data)>0){
            return view('liquidaciones.reportes.salidas.resumen_saldo',compact('data_reporte','imagen','excel'));
        }else{
            return view('cafe.reportes.no-reporte');
        }
	}

	public function reporte_resumen_salidas(){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $data = \DB::select(\DB::raw('
				SELECT nombre,id,
				## KILOS POR LIQUIDAR (CONTRATOS SIN LIQUIDACION)
				(
				SELECT COALESCE(SUM(kilos_compromiso),0) FROM 003_contratos co
				WHERE id NOT IN (SELECT id_contrato FROM 002_liquidaciones) AND co.id_catalogo_empresa_cliente=ce.id AND estado=1 AND deleted_at IS NULL
				) as kilos_pendientes_scontrato,
				## KILOS POR LIQUIDAR (CONTRATOS CON LIQUIDACION)
				(
				SELECT COALESCE(SUM(kilos_compromiso-kilos_entregados),0) FROM 003_contratos co
				WHERE id IN (SELECT id_contrato FROM 002_liquidaciones) AND co.id_catalogo_empresa_cliente=ce.id AND co.kilos_compromiso>co.kilos_entregados AND estado=1 AND deleted_at IS NULL
				) as kilos_pendientes_ccontrato,
	            ## KILOS POR LIQUIDAR
	            (
	           SELECT COALESCE(SUM(peso_neto-liquidado),0) FROM 003_entradas_salidas_cafe es
	            WHERE es.id_catalogo_cliente=ce.id AND es.peso_neto>es.liquidado AND deleted_at IS NULL AND terminada=0
	            ) as kilos_pendientes,
	            ## KILOS LIQUIDADOS
	            (
	            SELECT COALESCE(SUM(kilogramos),0) FROM 002_liquidaciones l
	            INNER JOIN 003_entradas_salidas_cafe es ON l.id_salida_cafe=es.id
	            WHERE es.id_catalogo_cliente=ce.id AND l.deleted_at IS NULL
	            ) as kilos_liquidados,
	            ## TOTAL GIROS
	            (
	            SELECT COALESCE(SUM(valor),0) FROM 002_giros_anticipos g WHERE id_catalogo=ce.id AND tipo_operacion=2 AND deleted_at IS NULL
	            ) as total_giros,
	            ## TOTAL LIQUIDACIONES
	            (
	            SELECT COALESCE(SUM(total),0) FROM 002_liquidaciones l
	            INNER JOIN 003_entradas_salidas_cafe es ON l.id_salida_cafe=es.id
	            WHERE es.id_catalogo_cliente=ce.id AND l.deleted_at IS NULL
	            ) as total_valor_liquidaciones,
	            (
	                (
	                    (
	                    SELECT COALESCE(SUM(peso_neto-liquidado),0) FROM 003_entradas_salidas_cafe es
	                    WHERE es.id_catalogo_cliente=ce.id AND deleted_at IS NULL and es.terminada=0
	                    )/12.5
	                )
	                *
					(
					SELECT COALESCE(ROUND(AVG(precio_arroba)),0) FROM  003_contratos co 
					WHERE co.id_catalogo_empresa_cliente=ce.id and co.deleted_at IS NULL and co.estado=1 and co.kilos_compromiso > co.kilos_entregados
					)
	            ) as valor_en_kilos
	            FROM 000_catalogo_empresas ce WHERE es_cliente = 1 AND deleted_at IS NULL ORDER BY nombre ASC
        '));

        if(count($data)>0){
            return view('liquidaciones.reportes.salidas.resumen',compact('data','imagen'));
        }else{
            return view('cafe.reportes.no-reporte');
        }
	}

	public function reporte_resumen_entradas(){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $data = \DB::select(\DB::raw('
            SELECT nombre,id,
			## KILOS POR LIQUIDAR (CONTRATOS SIN LIQUIDACION)
			(
			SELECT COALESCE(SUM(kilos_compromiso),0) FROM 003_contratos co
			WHERE id NOT IN (SELECT id_contrato FROM 002_liquidaciones) AND co.id_catalogo_empresa_proveedor=ce.id AND estado=1 AND deleted_at IS NULL
			) as kilos_pendientes_scontrato,
			## KILOS POR LIQUIDAR (CONTRATOS CON LIQUIDACION)
			(
			SELECT COALESCE(SUM(kilos_compromiso-kilos_entregados),0) FROM 003_contratos co
			WHERE id IN (SELECT id_contrato FROM 002_liquidaciones) AND co.id_catalogo_empresa_proveedor=ce.id AND co.kilos_compromiso>co.kilos_entregados AND estado=1 AND deleted_at IS NULL
			) as kilos_pendientes_ccontrato,
            ## KILOS POR LIQUIDAR
            (
            SELECT COALESCE(SUM(peso_neto-liquidado),0) FROM 003_entradas_salidas_cafe es
            WHERE es.id_catalogo_proveedor=ce.id AND deleted_at IS NULL AND terminada=0
            ) as kilos_pendientes,
            ## KILOS LIQUIDADOS
            (
            SELECT COALESCE(SUM(kilogramos),0) FROM 002_liquidaciones l
            INNER JOIN 003_entradas_salidas_cafe es ON l.id_entrada_cafe=es.id
            WHERE es.id_catalogo_proveedor=ce.id AND l.deleted_at IS NULL
            ) as kilos_liquidados,
            ## TOTAL GIROS
            (
            SELECT COALESCE(SUM(valor),0) FROM 002_giros_anticipos g WHERE id_catalogo=ce.id AND tipo_operacion=1 AND deleted_at IS NULL
            ) as total_giros,
            ## TOTAL LIQUIDACIONES
            (
            SELECT COALESCE(SUM(total),0) FROM 002_liquidaciones l
            INNER JOIN 003_entradas_salidas_cafe es ON l.id_entrada_cafe=es.id
            WHERE es.id_catalogo_proveedor=ce.id AND l.deleted_at IS NULL
            ) as total_valor_liquidaciones,
            (
                (
                    (
                    SELECT COALESCE(SUM(peso_neto-liquidado),0) FROM 003_entradas_salidas_cafe es
                    WHERE es.id_catalogo_proveedor=ce.id AND deleted_at IS NULL and es.terminada=0
                    )/12.5
                )
                *
				(
				SELECT COALESCE(ROUND(AVG(precio_arroba)),0) FROM  003_contratos co 
				WHERE co.id_catalogo_empresa_proveedor=ce.id and co.deleted_at IS NULL and co.estado=1 and co.kilos_compromiso > co.kilos_entregados
				)
            ) as valor_en_kilos
            FROM 000_catalogo_empresas ce WHERE es_proveedor = 1 AND deleted_at IS NULL ORDER BY nombre ASC
        '));
       
        if(count($data)>0){
			//return $data;
            return view('liquidaciones.reportes.entradas.resumen',compact('data','imagen'));
        }else{
            return view('cafe.reportes.no-reporte');
        }
	}

	public function listar_salidas(Request $request){
        $titulo = 'Salidas de Cafe para Liquidar';
		$modulo = 'Liquidaciones';
		$seccion = 'Entradas';
		$cafe = TiposCafe::all();
        $proveedores = CatalogoEmpresas::where('es_cliente',1)->get();
        $consecutivo = ParametrosModulos::find(14);
        $numeracion = ParametrosModulos::find(13);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',2)->get();
		$id=0;
		if($request->id!=0){
            return $request->id;
		}
        return view('liquidaciones.listado_salida',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','id','cafe'));
    }

	public function data_listar_salida(Request $request){

		if($request->id_prov==null){
			 $operaciones = \DB::select( \DB::raw("SELECT * FROM 003_entradas_salidas_cafe WHERE tipo_operacion=2 AND peso_neto>liquidado AND terminada=0 AND deleted_at IS NULL"));
		}else{
			$operaciones = \DB::select( \DB::raw("SELECT * FROM 003_entradas_salidas_cafe WHERE tipo_operacion=2 AND id_catalogo_cliente=:proveedor AND peso_neto>liquidado AND terminada=0 AND deleted_at IS NULL"), array(
			   'proveedor' => $request->id_prov,
			 ));
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}


        foreach($operaciones as $regis){
            $liquidaciones = Liquidaciones::where('id_entrada_cafe',$regis->id)->get();
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_cliente);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
            $pendientes = $regis->peso_bruto-$regis->tara;

            $regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
			$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}
	
	public function listar_salida_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
			if($request->id_prov==null){
				$operaciones=EntradasSalidasCafe::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_entradas_salidas_cafe.id_catalogo_cliente')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->where('003_entradas_salidas_cafe.tipo_operacion',2)
					->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
					->where('003_entradas_salidas_cafe.terminada',0)
					->select('*','003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					->get();
			}else{
				$operaciones=EntradasSalidasCafe::query()
				->join('000_catalogo_empresas','003_entradas_salidas_cafe.id_catalogo_cliente','=','000_catalogo_empresas.id')
				->join('000_tipos_cafe','003_entradas_salidas_cafe.id_tipo_cafe','=','000_tipos_cafe.id')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_cliente','=',$request->id_prov)
				->select('*','003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
				'003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
				->get();
				
			}
	    }else{
			if($id_prov==-1){
				$operaciones=EntradasSalidasCafe::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_entradas_salidas_cafe.id_catalogo_cliente')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                     ->where('003_entradas_salidas_cafe.tipo_operacion',2)
					->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
					->where('003_entradas_salidas_cafe.terminada',0)
					->select('*','003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					->get();
			}else{
				$operaciones=EntradasSalidasCafe::query()
				->join('000_catalogo_empresas','003_entradas_salidas_cafe.id_catalogo_cliente','=','000_catalogo_empresas.id')
				->join('000_tipos_cafe','003_entradas_salidas_cafe.id_tipo_cafe','=','000_tipos_cafe.id')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                ->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_cliente','=',$request->id_prov)
				->select('*','003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
				'003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
				->get();
				
			}
		}
		foreach($operaciones as $regis){
            $liquidaciones = Liquidaciones::where('id_salida_cafe',$regis->id)->get();
            //$proveedor = CatalogoEmpresas::find($regis->id_catalogo_cliente);
			//$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
			$pendientes = $regis->peso_bruto-$regis->tara;
			//$regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
			//$regis->cafe = $cafe;
		}

        return array('data'=>$operaciones);

	}

    public function listar_contratos_venta_sin_liquidacion(Request $request){
          $titulo = 'Contratos de Venta sin Liquidar';
          $modulo = 'Liquidaciones';
          $seccion = 'Salidas';
          $proveedores = CatalogoEmpresas::where('es_cliente',1)->get();
          return view('liquidaciones.listado_contratos_pendientes_salidas',compact('proveedores','titulo','modulo','seccion'));
	}
	
	public function data_listar_contratos_venta_sin_liquidacion(Request $request){
        if($request->id_prov==null){
        	 $operaciones = \DB::select( \DB::raw("SELECT * FROM 003_contratos WHERE tipo_contrato=2 AND kilos_compromiso<kilos_entregados AND id NOT IN (select id FROM 002_liquidaciones WHERE tipo_contrato=2 AND id_contrato IS NOT NULL AND deleted_at IS NULL) AND deleted_at IS NULL"));
        }else{
        	$operaciones = \DB::select( \DB::raw("SELECT * FROM 003_contratos WHERE tipo_contrato=2 AND id_catalogo_empresa_cliente=:proveedor AND kilos_compromiso<kilos_entregados AND id NOT IN (select id FROM 002_liquidaciones WHERE tipo_contrato=2 AND id_contrato IS NOT NULL AND deleted_at IS NULL"), array(
        	   'proveedor' => $request->id_prov,
        	 ));
        }

        foreach($operaciones as $regis){
          $proveedor = CatalogoEmpresas::find($regis->id_catalogo_empresa_cliente);
          $cafe = TiposCafe::find($regis->id_tipo_cafe);
          $regis->proveedor = $proveedor;
          $regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}
	
	public function listar_contratos_venta_sin_liquidacion_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
		if($request->id_prov==null){
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->select('000_catalogo_empresas.*','000_tipos_cafe.*','003_contratos.*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at');
			}else{
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
			    ->where('003_contratos.id_catalogo_empresa_cliente','=',$request->id_prov)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at');
			}
		}else{
			if($id_prov==-1){
				$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',2)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->select('000_catalogo_empresas.*','000_tipos_cafe.*','003_contratos.*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at');
				}else{
				$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',2)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                    ->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->where('003_contratos.id_catalogo_empresa_cliente','=',$request->id_prov)
					->select('*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at');
				}
		}
        return array('data'=>$operaciones);		
    }

    public function registrar_liquidacion_salida(Request $request){
		$request->validate([
			'numero'=>['unique:002_liquidaciones,numero,NULL,id'],//deleted_at,NULL
		  ],[
			  'numero.unique'=> 'Numero de liquidacion repetido',
		  ]
		);
		$contrato= $request->contrato;
		if($contrato==null){$contrato=-2;};
        $registro = new Liquidaciones;
        $registro->id_salida_cafe=$request->id_entrada;
        $registro->kilogramos=str_replace('.','',$request->c01);
        $registro->factor=$request->c02;
        $registro->id_contrato=$contrato;
        $registro->numero=$request->numero;
        $registro->descuento_factor=$request->c03;
        $registro->factor_descuento=$request->c04;
        $registro->valor_arroba=str_replace('.','',$request->c05);
        $registro->valor_bruta=str_replace('.','',$request->c06);
        $registro->valor_descuento=str_replace('.','',$request->c07);
        $registro->porcentaje_retencion=$request->c08;
        $registro->valor_retencion_fuente=str_replace('.','',$request->c09);
        $registro->porcentaje_retencion_4_mil=$request->c10;
        $registro->valor_retencion_4_mil=str_replace('.','',$request->c11);
        $registro->porcentaje_retencion_cooperativa=$request->c12;
        $registro->valor_retencion_cooperativa=str_replace('.','',$request->c13);
        $registro->porcentaje_retencion_tercero=$request->c14;
        $registro->valor_retencion_tercero=str_replace('.','',$request->c15);
        $registro->total=str_replace('.','',$request->c16);
        $registro->fecha_liquidacion=date('Y-m-d h:i:s',strtotime($request->c17));
        $registro->id_usuario=session('id');
        $registro->save();

		$entrada = EntradasSalidasCafe::find($request->id_entrada);
		$entrada->liquidado=$entrada->liquidado+str_replace('.','',$request->c01);
        $entrada->save();
        
		if($contrato!=-2){
			$entrada = Contratos::find($request->contrato);
			$entrada->kilos_entregados=$entrada->kilos_entregados+str_replace('.','',$request->c01);
			$entrada->save();
	    }  
        $this->incrementar_contador_salida();
		$id=CatalogoEmpresas::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id_catalogo_cliente','000_catalogo_empresas.id')
		->where('003_entradas_salidas_cafe.id',$request->id_entrada)->select('000_catalogo_empresas.id')->value('000_catalogo_empresas.id');         
		$titulo = 'Salidas de Cafe para Liquidar';
		$modulo = 'Liquidaciones';
		$cafe = TiposCafe::all();
		$seccion = 'Entradas';
        $proveedores = CatalogoEmpresas::where('es_cliente',1)->get();
        $consecutivo = ParametrosModulos::find(14);
        $numeracion = ParametrosModulos::find(13);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',2)->get();
	
        
		return view('liquidaciones.listado_salida',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','id','cafe'))->with('result',array('message'=>'Liquidacion Anexada Exitosamente','type'=>'success'));
    }

	public function obtener_contratos_cliente($id){
        $contratos = Contratos::where('id_catalogo_empresa_cliente',$id)->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('estado',1)->get();
		return ['data'=>$contratos];
	}

    public function obtener_liquidacion_salida($id){
        $operacion = EntradasSalidasCafe::where('id',$id)->get();
        $liquidaciones = Liquidaciones::where('id_salida_cafe',$id)->get();
        $liquidados = 0;
        $pendientes = 0;
        foreach($liquidaciones as $regis){
            $liquidados += $regis->kilogramos;
        }
        $pendientes = $operacion[0]->peso_neto;
        foreach($operacion as $regis){
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_cliente);
            $regis->cliente = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
        }
        return $operacion;
    }

    public function procesar_reporte_salidas(Request $request){
			
			if($request->tipo_reporte==2){
				if($request->c03==-1){
					return $this->reporte_fecha_salidas($request->c01,$request->c02,$request->c04,$request->c06);
				}elseif($request->c03!=-1){
					return $this->reporte_fecha_salidas_proveedor($request->c01,$request->c02,$request->c03,$request->c04,$request->c06);
				}
			}
			
			if($request->tipo_reporte==1){
				return $this->reporte_salidas_pendientes($request);
			}
	
			if($request->tipo_reporte==3){
				
				return $this-> reporte_contratos_venta_sin_liquidacion_data_ordenado($request->c01,$request->c02,$request->c04,$request->c06,$request->c03);
				//return $this->reporte_contratos_venta_sin_liquidacion_data($request);
			}
	}

	public function reporte_fecha_salidas_proveedor($fecha_inicial,$fecha_final,$proveedor,$tipo_archivo,$tipo_cafe){
	$imagen = base64_encode(\Storage::get('logo_actual.png'));
	
	if($tipo_cafe==-1){//si es tipo cafe todos
		$data = Liquidaciones::whereIn('id_salida_cafe', function($query) use ($proveedor){
            $query->select('id')
            ->from(with(new EntradasSalidasCafe)->getTable())
            ->where('id_catalogo_cliente', $proveedor);
		})->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:59:59'])
		->orderBy('fecha_liquidacion','asc')->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))
		->get();
	}else{
		$data = Liquidaciones::whereIn('id_salida_cafe', function($query) use ($proveedor,$tipo_cafe){
            $query->select('id')
            ->from(with(new EntradasSalidasCafe)->getTable())
            ->where('id_catalogo_cliente', $proveedor)
			->where('id_tipo_cafe',$tipo_cafe);
        })->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])
		->orderBy('fecha_liquidacion','asc')->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get();
	}
		
		
		$valor_giro= GirosAnticipos::where('id_catalogo',$proveedor)
		     ->whereBetween('fecha_giro', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_inicial.' -1 days'))])
			 ->where('tipo_operacion',2)
			// ->selectRaw('*')->get();
			 ->selectRaw('sum(valor) as saldo')
			 ->value('saldo')
		;
		$valor_liquidacion= Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
			->where('id_catalogo_cliente',$proveedor)
			//->where('tipo_contrato',1)
			->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
			//->selectRaw('total,fecha_liquidacion')->get();
			->selectRaw('sum(total) as saldo')
			->value('saldo')
		;
		$saldo_acomulado=$valor_giro-$valor_liquidacion;
		$esproveedor=1;
		$indice=0;
		//si no tiene liquidaciones obtenemos solo los giros
		if(count($data)==0){
			$giros = GirosAnticipos::where('id_catalogo',$proveedor)->whereBetween(\DB::raw('DATE(fecha_giro)'),  [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->where('tipo_operacion',2)->select(\DB::raw("*,fecha_giro as fecha"))->get();
			
			foreach($giros as $rows){
                $rows->saldo_acomulado=$saldo_acomulado;
				$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($proveedor);
				$data_reporte[0]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}
			ksort($data_reporte[0]['proveedor']['data']);
		}else{
        foreach($data as $indice => $rows){
			try{
				//Restauramos salida liquidada si se elimino
				$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_salida_cafe)->first();
				$entrada_eliminada->restore();
				//restaurar contrato si se elimino
				$contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
				$contrato_eliminado->restore();
				$entrada = EntradasSalidasCafe::where('id',$rows->id_salida_cafe)->get();
				$contrato = Contratos::find($rows->id_contrato);
				$giros = GirosAnticipos::where('id_catalogo',$entrada[0]->id_catalogo_cliente)->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial, $fecha_final])->where('tipo_operacion',2)->select(\DB::raw("*,fecha_giro as fecha"))->get();

				$cafe = TiposCafe::find($contrato->id_tipo_cafe);
				$centros = CentrosOperacion::find($contrato->id_centro_operacion);

				$rows->cafe = $cafe;
				$rows->centros = $centros;
				$rows->contrato = $contrato;
				$rows->entrada = $entrada;
				$rows->saldo_acomulado=$saldo_acomulado;
                if($rows->id_contrato==-2){
					$cafe  = TiposCafe::find($entrada[0]->id_tipo_cafe);
					$rows->cafe = $cafe;
					$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($entrada[0]->id_catalogo_cliente);
                    
				}else{
					$data_reporte[0]['proveedor']['info'] = CatalogoEmpresas::find($rows->contrato->id_catalogo_empresa_cliente);
                }
				$data_reporte[0]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
				
				foreach($giros as $rowsx){
					$data_reporte[0]['proveedor']['data'][strtotime($rowsx->created_at)]=$rowsx;
				}
				ksort($data_reporte[0]['proveedor']['data']);
			}catch(\Exception $e){}
        }
	    }


		try{
			$registros = count($data_reporte[0]['proveedor']['data']);
		}catch(\Exception $e){
			$registros = 0;
		}

		if($registros>0){

			usort($data_reporte[0]['proveedor']['data'], function($a, $b) {
				return $a['fecha'] <=> $b['fecha'];
			});
           
		$excel=$tipo_archivo;
		//contratos sin liquidacion completa consulta por proveedor
		$operaciones=null;
		if($proveedor!=-1){
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('003_contratos.id_catalogo_empresa_cliente',$proveedor)
				->where('003_contratos.estado',1)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')
				->get();
		}
        if($excel==1){
				return view('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('legal', 'landscape');
				$pdf->loadView('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','imagen','operaciones'));
				return $pdf->stream();
		}else{
			return view('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
        }
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_salidas($fecha_inicial,$fecha_final,$tipo_archivo,$tipo_cafe){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
        $operaciones=null;
		
		if($tipo_cafe==-1){//si tipo de cafe es todas las categorias
			$data = Liquidaciones::where('id_salida_cafe','!=',null)
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:59:00'])->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get();
	    }else{// si es una en particular
			$data = Liquidaciones::where('id_salida_cafe','!=',null)
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
			->where('id_tipo_cafe',$tipo_cafe)
			->orderBy('000_catalogo_empresas.nombre','asc')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:59:00'])->select(\DB::raw("002_liquidaciones.*,fecha_liquidacion as fecha"))->get();
		}
		$data_reporte = [];
		$saldo_acomulado=-1;
		$esproveedor=0;
		$indice=0;
		foreach($data as $indice => $rows){
			try{
				//Restauramos salida liquidada si se elimino
				$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_salida_cafe)->first();
				$entrada_eliminada->restore();
				$entrada = EntradasSalidasCafe::where('id',$rows->id_salida_cafe)->get();
				//restaurar contrato si se elimino
				$contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
				$contrato_eliminado->restore();
				$contrato = Contratos::find($rows->id_contrato);
				$giros = GirosAnticipos::where('id_catalogo',$entrada[0]->id_catalogo_cliente)->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial, $fecha_final])->where('tipo_operacion',2)->select(\DB::raw("*,fecha_giro as fecha"))->get();
                $valor_giro= GirosAnticipos::query()
				  ->where('id_catalogo',$entrada[0]->id_catalogo_cliente)
		          ->whereBetween('fecha_giro', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_inicial.' -1 days'))])
			      ->where('tipo_operacion',2)
			      ->selectRaw('sum(valor) as saldo')
			       ->value('saldo')
		        ;
		        
		        $valor_liquidacion= Liquidaciones::query()
				->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
				->where('id_catalogo_cliente',$entrada[0]->id_catalogo_cliente)
				//->where('tipo_contrato',1)
				->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
				//->selectRaw('total,fecha_liquidacion')->get();
				->selectRaw('sum(total) as saldo')
				->value('saldo')
		        ;
		        
                $saldo_acomulado=$valor_giro-$valor_liquidacion;
				
				$cafe = TiposCafe::find($contrato->id_tipo_cafe);
				$centros = CentrosOperacion::find($contrato->id_centro_operacion);
				
				$rows->cafe = $cafe;
				$rows->centros = $centros;
				$rows->contrato = $contrato;
				$rows->entrada = $entrada;
                if($rows->id_contrato==-2){
					$cafe  = TiposCafe::find($entrada[0]->id_tipo_cafe);
					$rows->cafe = $cafe;
					$indice=$entrada[0]->id_catalogo_cliente;
				}else{
				   $indice=$rows->contrato->id_catalogo_empresa_cliente;
				
			    }
				$data_reporte[$indice]['proveedor']['info'] = CatalogoEmpresas::find($indice);
				$data_reporte[$indice]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
				$data_reporte[$indice]['proveedor']['saldo_acomulado'] =$saldo_acomulado;
				foreach($giros as $rowsx){
					$data_reporte[$entrada[0]->id_catalogo_cliente]['proveedor']['data'][strtotime($rowsx->created_at)]=$rowsx;
				}
             
			}catch(\Exception $e){
				//dump($e->getMessage());
				//dump($rows->id);

			}
        }
        // agregar a $data reportes aquellas gios que no tienen liquidacion
        $clientes_liquidados=Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])->select(\DB::raw("000_catalogo_empresas.id"))
	    ;
		$giros_sin_liquidar=GirosAnticipos::whereNotIn('id_catalogo',$clientes_liquidados)
			->whereBetween(\DB::raw('DATE(fecha_giro)'), [$fecha_inicial.' 00:00', $fecha_final.' 23:59'])
			->where('tipo_operacion',2)
			->select(\DB::raw("*,fecha_giro as fecha"))->get()
		;
		foreach($giros_sin_liquidar as $rows){
			$valor_giro= GirosAnticipos::where('id_catalogo',$rows->id_catalogo)
					->whereBetween('fecha_giro', [$this->fecha_inicio_periodo." 00:00:00" , date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
					->where('tipo_operacion',2)
					->selectRaw('sum(valor) as saldo')
					->value('saldo')
			;
			$valor_liquidacion= Liquidaciones::query()
				->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
				->where('id_catalogo_proveedor',$rows->id_catalogo)
				->whereBetween('fecha_liquidacion', [$this->fecha_inicio_periodo." 00:00:00", date('Y-m-d',strtotime($fecha_inicial.' -1 days')).' 23:59:59'])
				//->selectRaw('total,fecha_liquidacion')->get();
				->selectRaw('sum(total) as saldo')
				->value('saldo')
			;
			$saldo_acomulado=$valor_giro-$valor_liquidacion;
			$data_reporte[$rows->id_catalogo]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo);
			$data_reporte[$rows->id_catalogo]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
		    $data_reporte[$rows->id_catalogo]['proveedor']['saldo_acomulado'] =$saldo_acomulado;
		};
       

		if(count($data_reporte)>0){


			foreach($data_reporte as $indice => $datal){
				usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
			}

			$excel=$tipo_archivo;
			
			if($excel==1){
					return view('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
					$pdf = \App::make('dompdf.wrapper');
					$pdf->setPaper('legal', 'landscape');
					$pdf->loadView('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','imagen','operaciones'));
					return $pdf->stream();
			}else{
				return view('liquidaciones.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','saldo_acomulado','esproveedor','excel','imagen','operaciones'));
			}
			

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }
    
	public function reporte_contratos_venta_sin_liquidacion_data_ordenado($fecha_inicial,$fecha_final,$tipo_archivo,$tipo_cafe,$proveedor){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
        $operaciones=null;
		
		if($proveedor==-1){//si son todos los clientes
			$operaciones=Contratos::join('000_catalogo_empresas','000_catalogo_empresas.id','003_contratos.id_catalogo_empresa_cliente')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
			->where('003_contratos.tipo_contrato',2)
			->where('003_contratos.estado',1)
			->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
			->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
			->orderBy('000_catalogo_empresas.nombre','asc')
			->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))
			->get()
		  ;
			if($tipo_cafe!=-1){//si es algun tipo de cafe
				$operaciones=Contratos::join('000_catalogo_empresas','000_catalogo_empresas.id','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato',2)
				->where('id_tipo_cafe',$tipo_cafe)
				->where('003_contratos.estado',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->orderBy('000_catalogo_empresas.nombre','asc')
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))

				->get()
			;
			}	
		}else{//si es un cliente en particular
			$operaciones=Contratos::join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
			    ->where('003_contratos.tipo_contrato',2)
				->where('003_contratos.estado',1)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_cliente','=',$proveedor)
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))
                ->get()
			;
			if($tipo_cafe!=-1){//si es un tipo de cafe en particular
				$operaciones=Contratos::join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('id_tipo_cafe',$tipo_cafe)
				->where('003_contratos.estado',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_cliente','=',$proveedor)
				->select(\DB::raw("003_contratos.*,000_tipos_cafe.tipo_cafe,fecha_contrato as fecha"))

				->get()
			;
			}
			
			
		}
		$data_reporte = [];
	
		$esproveedor=0;
		$indice=0;
		foreach($operaciones as $indice => $rows){
			try{
				
				$data_reporte[$rows->id_catalogo_empresa_cliente]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo_empresa_cliente);
				$data_reporte[$rows->id_catalogo_empresa_cliente]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				//dump($e->getMessage());
				//dump($rows->id);

			}
        }
		if(count($data_reporte)>0){

            
			foreach($data_reporte as $indice => $datal){
				usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
			}
            // return $data_reporte;
			$excel=$tipo_archivo;

				return view('liquidaciones.reportes.salidas.listado_contratos_pendientes_ordenado',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen'));
			}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }
    public function listar_salidas_liquidadas(Request $request){
        $titulo = 'Salidas de Cafe Liquidadas';
		$modulo = 'Liquidaciones';
		$seccion = 'Salidas';
		$session= session('role_id');
		$cafe = TiposCafe::all();
        $proveedores = CatalogoEmpresas::where('es_cliente',1)->get();
        $consecutivo = ParametrosModulos::find(11);
        $numeracion = ParametrosModulos::find(12);
        $contratos_listado = Contratos::whereColumn('valor_contrato','!=','valor_pagado')->whereColumn('kilos_compromiso','!=','kilos_entregados')->where('tipo_contrato',1)->get();

        return view('liquidaciones.listado_liquidadas_salidas',compact('proveedores','titulo','modulo','seccion','consecutivo','numeracion','contratos_listado','session','cafe'));
    }

	public function data_listar_salidas_liquidadas(Request $request){

		if($request->id_prov==null){
			 $operaciones = \DB::select( \DB::raw("SELECT *,li.id_contrato as id_contrato_liquidacion,li.factor as factor_liquidacion,li.id as id_liquidacion FROM 002_liquidaciones li INNER JOIN 003_entradas_salidas_cafe es ON li.id_salida_cafe=es.id WHERE tipo_operacion=2 AND li.deleted_at IS NULL"));
		}else{
			$operaciones = \DB::select( \DB::raw("SELECT *,li.id_contrato as id_contrato_liquidacion,li.factor as factor_liquidacion,li.id as id_liquidacion FROM 002_liquidaciones li INNER JOIN 003_entradas_salidas_cafe es ON li.id_salida_cafe=es.id  WHERE tipo_operacion=2 AND id_catalogo_proveedor=:proveedor AND li.deleted_at IS NULL"), array(
			   'proveedor' => $request->id_prov,
			 ));
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}


        foreach($operaciones as $regis){
            $proveedor = CatalogoEmpresas::find($regis->id_catalogo_cliente);
            $conductor = CatalogoEmpresas::find($regis->id_catalogo_conductor);
            $contrato = Contratos::find($regis->id_contrato_liquidacion);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);
            $liquidados = 0;
            $pendientes = 0;
            $regis->proveedor = $proveedor;
            $regis->pendientes = $pendientes-$liquidados;
			$regis->conductor = $conductor;
			$regis->contrato = $contrato;
			$regis->cafe = $cafe;
        }
        return array('data'=>$operaciones);
	}
	
	public function listar_salidas_liquidadas_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
			if($request->id_prov==null){
			$operaciones=Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
			->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
			->orderBy('002_liquidaciones.created_at','desc')
			->select('*','002_liquidaciones.id_contrato as id_contrato_liquidacion',
			'002_liquidaciones.numero as numero_liquidacion',
			'002_liquidaciones.factor as factor_liquidacion',
			'000_catalogo_empresas.nombre as cliente','000_catalogo_empresas.nit as cliente_nit','000_catalogo_empresas.digito_verificacion_nit as cliente_digito_verificacion_nit',
			'002_liquidaciones.id as id_liquidacion')->get();
			
			
		}else{
			$operaciones=Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
			->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
			->where('003_entradas_salidas_cafe.id_catalogo_cliente','=',$request->id_prov)
			->orderBy('002_liquidaciones.created_at','desc')
			->select('*','002_liquidaciones.id_contrato as 
			id_contrato_liquidacion','002_liquidaciones.factor as factor_liquidacion',
			'002_liquidaciones.numero as numero_liquidacion',
			'000_catalogo_empresas.nombre as cliente','000_catalogo_empresas.nit as cliente_nit','000_catalogo_empresas.digito_verificacion_nit as cliente_digito_verificacion_nit',
			'002_liquidaciones.id as id_liquidacion')->get();
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}
	}else{

		if($id_prov==-1){
			$operaciones=Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
            ->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
			->orderBy('002_liquidaciones.created_at','desc')
			->select('*','002_liquidaciones.id_contrato as id_contrato_liquidacion',
			'002_liquidaciones.numero as numero_liquidacion',
			'002_liquidaciones.factor as factor_liquidacion',
			'000_catalogo_empresas.nombre as cliente','000_catalogo_empresas.nit as cliente_nit','000_catalogo_empresas.digito_verificacion_nit as cliente_digito_verificacion_nit',
			'002_liquidaciones.id as id_liquidacion')->get();
			
			
		}else{
			$operaciones=Liquidaciones::query()
			->join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','=','002_liquidaciones.id_salida_cafe')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
			->join('003_contratos','003_contratos.id','=','002_liquidaciones.id_contrato')
			->whereBetween('fecha_liquidacion', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
            ->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
			->where('003_entradas_salidas_cafe.id_catalogo_cliente','=',$request->id_prov)
			->orderBy('002_liquidaciones.created_at','desc')
			->select('*','002_liquidaciones.id_contrato as 
			id_contrato_liquidacion','002_liquidaciones.factor as factor_liquidacion',
			'002_liquidaciones.numero as numero_liquidacion',
			'000_catalogo_empresas.nombre as cliente','000_catalogo_empresas.nit as cliente_nit','000_catalogo_empresas.digito_verificacion_nit as cliente_digito_verificacion_nit',
			'002_liquidaciones.id as id_liquidacion')->get();
			//$operaciones = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$request->id_prov)->whereColumn('peso_neto','!=','liquidado')->get();
		}

	}
		foreach($operaciones as $regis){
            //$proveedor = CatalogoEmpresas::find($regis->id_catalogo_cliente);
           /* $conductor = CatalogoEmpresas::find($regis->id_catalogo_conductor);
            $contrato = Contratos::find($regis->id_contrato_liquidacion);
			$cafe = TiposCafe::find($regis->id_tipo_cafe);*/
            $liquidados = 0;
			$pendientes = 0;
			$regis->pendientes = $pendientes-$liquidados;
			//$regis->proveedor = $proveedor;
			/*$regis->conductor = $conductor;
			$regis->contrato = $contrato;
			$regis->cafe = $cafe;*/
        }
        return Datatables::of($operaciones)->make();
    }

    public function eliminar_liquidacion_salida($id){
        $registro = Liquidaciones::find($id);
        $registro->delete();

        $registro_entrada = EntradasSalidasCafe::find($registro->id_salida_cafe);
        $registro_entrada->liquidado = $registro_entrada->liquidado-$registro->kilogramos;
        $registro_entrada->save();

		$registro_contrato = Contratos::find($registro->id_contrato);
        $registro_contrato->kilos_entregados = $registro_contrato->kilos_entregados-$registro->kilogramos;
        $registro_contrato->save();

        return redirect()->back()->with('result',array('message'=>'Liquidacion '.$registro->numero.' Eliminada Exitosamente','type'=>'success'));
    }


    private function incrementar_contador_entrada(){
        $contador = ParametrosModulos::find(12);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

    private function incrementar_contador_salida(){
        $contador = ParametrosModulos::find(13);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
	}
	
	public function listar_liquidacion_detalle_reporte_salida(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$liquidaciones=EntradasSalidasCafe::query()
				//->join('002_liquidaciones','002_liquidaciones.id_salida_cafe','=','003_entradas_salidas_cafe.id') 
			    ->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->where('003_entradas_salidas_cafe.id_catalogo_cliente',$request->id)
				->where('003_entradas_salidas_cafe.terminada',0)
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as conductor','000_tipos_cafe.tipo_cafe')->get();
		$anticipos=GirosAnticipos::query()
		        ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
				->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
				->where('id_catalogo',$request->id)
				->where('tipo_operacion',2)
				->select('002_giros_anticipos.*','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente','000_bancos.entidad')
				->get()
		;
		$Kilos_bodega=0;
		$Kilos_netos=0;
		foreach($liquidaciones as $rows){
			$Kilos_bodega += $rows->peso_neto - $rows->liquidado;
			$Kilos_netos += $rows->peso_neto;
		}
		if(count($liquidaciones)==0){
			return view('cafe.reportes.no-reporte');
		}else{
			$cliente=$request->cliente;
			return view('liquidaciones.reportes.salidas.detalle_cliente',compact('liquidaciones','cliente','Kilos_bodega','Kilos_netos','imagen'));
		}
	}

	public function listar_liquidacion_detalle_reporte_entrada(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$liquidaciones=EntradasSalidasCafe::query()
				//->join('002_liquidaciones','002_liquidaciones.id_entrada_cafe','=','003_entradas_salidas_cafe.id') 
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->id)
				
				->where('003_entradas_salidas_cafe.terminada',0)
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as conductor','000_tipos_cafe.tipo_cafe')->get();

		$giros=GirosAnticipos::query()
		        ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
		        ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
		        ->where('id_catalogo',$request->id)
		        ->where('tipo_operacion',1)
		        ->select('002_giros_anticipos.*','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente','000_bancos.entidad')
				 ->get()
		;
		$Kilos_bodega=0;
		$Kilos_netos=0;
		foreach($liquidaciones as $rows){
			$Kilos_bodega += $rows->peso_neto - $rows->liquidado;
			$Kilos_netos += $rows->peso_neto;
		}
		
		if(count($liquidaciones)==0){
			return view('cafe.reportes.no-reporte');
		}else{
			$proveedor=$request->proveedor;
			return view('liquidaciones.reportes.entradas.detalle_proveedor',compact('liquidaciones','proveedor','Kilos_bodega','Kilos_netos','imagen'));
		}
	 }

	 public function reporte_entradas_pendientes(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$escliente=0;
		$titulo='Reporte entradas pendientes por liquidar';
		if($request->c03==-1){
			$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				if($request->c06!=-1){
					$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
					->where('003_entradas_salidas_cafe.terminada','=',0)
					->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
					->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
					'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
					'003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
					'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
					->get();
				}
		}
		else{ 
			$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->c03)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				
				if($request->c06!=-1){
				$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->c03)
				->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				}
		}
		foreach($operaciones as $regis){
			$regis->pendientes = $regis->peso_neto-$regis->liquidados;
            $regis->liquidados = $regis->liquidados;
		}
       
		if(count($operaciones)>0){
			$excel=$request->c04;
			return view('liquidaciones.reportes.salidas.listado_entradas_pendientes',compact('operaciones','excel','fecha_inicial','fecha_final','titulo','imagen'));
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
        
	}
     
	public function reporte_entradas_pendientes_ordenado(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$titulo='Reporte entradas pendientes por liquidar';
		if($request->c03==-1){
			$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->orderBy('cp.nombre','asc')
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				if($request->c06!=-1){
					$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
					->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
					->where('003_entradas_salidas_cafe.terminada','=',0)
					->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
					->orderBy('cp.nombre','asc')
					->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
					'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
					'003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
					'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
					->get();
				}
		}
		else{ 
			$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->c03)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				
				if($request->c06!=-1){
				$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->c03)
				->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				}
		}
		foreach($operaciones as $regis){
			$liquidaciones = Liquidaciones::where('id_entrada_cafe',$regis->id)->get();
            $liquidados = 0;
            $pendientes = 0;
            foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
			$pendientes = $regis->peso_bruto-$regis->tara;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
		}
      
		$data_reporte = [];
		foreach($operaciones as $indice => $rows){
			try{
				$data_reporte[$rows->id_catalogo_proveedor]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$data_reporte[$rows->id_catalogo_proveedor]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				//dump($e->getMessage());
				//dump($rows->id);

			}
        }
		if(count($data_reporte)>0){

            
			foreach($data_reporte as $indice => $datal){
				usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
			}   $excel=$request->c04;
			    return view('liquidaciones.reportes.salidas.listado_entradas_pendientes',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','operaciones','titulo'));
			}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
        
	}

	public function reporte_salidas_pendientes(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$titulo='Reporte  salidas pendientes por liquidar';
		if($request->c03==-1){
			$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				if($request->c06!=-1){
					$operaciones = EntradasSalidasCafe::query()->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
					->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
					->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
					->where('003_entradas_salidas_cafe.terminada','=',0)
					->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
					->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
					'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
					'003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
					'000_catalogo_empresas.nombre as conductor','000_catalogo_empresas.nit as conductor_nit','000_catalogo_empresas.digito_verificacion_nit as conductor_digito_verificacion_nit',
					'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
					->get();
				}
		}
		else{ 
			$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_cliente',$request->c03)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				
				if($request->c06!=-1){
				$operaciones = EntradasSalidasCafe::query()
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('000_catalogo_empresas as cc', 'cc.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
				->join('000_catalogo_empresas as cp', 'cp.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
				->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
				->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.liquidado')
				->where('003_entradas_salidas_cafe.terminada','=',0)
				->where('003_entradas_salidas_cafe.id_catalogo_cliente',$request->c03)
				->where('003_entradas_salidas_cafe.id_tipo_cafe',$request->c06)
				->select('003_entradas_salidas_cafe.*', '000_tipos_cafe.tipo_cafe',
				'003_entradas_salidas_cafe.updated_at as entradas_salidas_cafe_updated_at',
			    '003_entradas_salidas_cafe.created_at as entradas_salidas_cafe_created_at',
				'cc.nombre as conductor','cc.nit as conductor_nit','cc.digito_verificacion_nit as conductor_digito_verificacion_nit',
				'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit')
				->get();
				}
		}
		foreach($operaciones as $regis){
			$liquidaciones = Liquidaciones::where('id_salida_cafe',$regis->id)->get();
            $liquidados = 0;
            $pendientes = 0;
            foreach($liquidaciones as $regisx){
                $liquidados += $regisx->kilogramos;
            }
			$pendientes = $regis->peso_bruto-$regis->tara;
            $regis->pendientes = $pendientes-$liquidados;
            $regis->liquidados = $liquidados;
		}
      
		$data_reporte = [];
		foreach($operaciones as $indice => $rows){
			try{
				$data_reporte[$rows->id_catalogo_cliente]['proveedor']['info'] = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$data_reporte[$rows->id_catalogo_cliente]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				//dump($e->getMessage());
				//dump($rows->id);

			}
        }
		if(count($data_reporte)>0){

            
			foreach($data_reporte as $indice => $datal){
				usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
					return $a['fecha'] <=> $b['fecha'];
				});
			}   $excel=$request->c04;
			    return view('liquidaciones.reportes.salidas.listado_entradas_pendientes',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','operaciones','titulo'));
			}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }

	public function reporte_contratos_venta_sin_liquidacion_data(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		if($request->c03==-1){//si son todos los clientes
			$operaciones=Contratos::query()
			->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
			->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
			->where('003_contratos.tipo_contrato','=',2)
			->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
			->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
			->select('000_catalogo_empresas.*','000_tipos_cafe.*','003_contratos.*','003_contratos.id as contrato_id',
			'003_contratos.updated_at as contrato_updated_at',
			'003_contratos.created_at as contrato_created_at')
			->get()
		  ;
			if($request->c06!=-1){//si es algun tipo de cafe
				$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->where('id_tipo_cafe',$request->c06)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->select('000_catalogo_empresas.*','000_tipos_cafe.*','003_contratos.*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')
				->get()
			;
			}	
		}else{//si es un cliente en particular
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				//->whereNotIn('003_contratos.id',$subconsulta)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_cliente','=',$request->c03)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')
				->get()
			;
			if($request->c06!=-1){//si es un tipo de cafe en particular
				$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',2)
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				//->whereNotIn('003_contratos.id',$subconsulta)
				->where('id_tipo_cafe',$request->c06)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->where('003_contratos.id_catalogo_empresa_cliente','=',$request->c03)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')
				->get()
			;
			}
			
			
		}


		if(count($operaciones)>0){
			$excel=$request->c04;
			return view('liquidaciones.reportes.salidas.listado_contratos_pendientes_excel',compact('operaciones','excel','fecha_inicial','fecha_final','imagen'));
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}	
    }

	public function reporte_contratos_compra_sin_liquidacion_data(Request $request){
    	$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$subconsulta=Liquidaciones::query()
		            ->select('id')
				    ->whereNotNull('id_contrato');
				    
		if($request->c03==-1){
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',1)
				//->where('003_contratos.estado','=',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				//->whereNotIn('003_contratos.id',$subconsulta)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')->get();
				if($request->c06!=-1){
					$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',1)
					//->where('003_contratos.estado','=',1)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
					->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->where('id_tipo_cafe','=',$request->c06)
					->select('*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at')->get();

				}
		}
		else{
			$operaciones=Contratos::query()
				->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
				->where('003_contratos.tipo_contrato','=',1)
				->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
				->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
				->where('003_contratos.id_catalogo_empresa_proveedor',$request->c03)
				->select('*','003_contratos.id as contrato_id',
				'003_contratos.updated_at as contrato_updated_at',
				'003_contratos.created_at as contrato_created_at')->get();
				if($request->c06!=-1){
					$operaciones=Contratos::query()
					->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
					->join('000_tipos_cafe','000_tipos_cafe.id','=','003_contratos.id_tipo_cafe')
					->where('003_contratos.tipo_contrato','=',1)
					->whereBetween('fecha_contrato', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
					->whereColumn('003_contratos.kilos_compromiso','>','003_contratos.kilos_entregados')
					->where('003_contratos.id_catalogo_empresa_proveedor',$request->c03)
					->where('id_tipo_cafe',$request->c06)
					->select('*','003_contratos.id as contrato_id',
					'003_contratos.updated_at as contrato_updated_at',
					'003_contratos.created_at as contrato_created_at')->get();
  
				}
			}
			if(count($operaciones)>0){
				$excel=$request->c04;
				return view('liquidaciones.reportes.salidas.listado_contratos_pendientes_excel',compact('operaciones','excel','fecha_inicial','fecha_final','imagen'));
			}else{
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}	
    }
}
