<?php

namespace App\Http\Controllers;
use App\Models\MovimientoEmpaques;
use App\Models\CatalogoEmpresas;
use App\Models\EntradasSalidasCafe;
use App\Models\TiposEmpaque;
use App\Models\TiposCafe;
use App\Models\CentrosOperacion;
use App\Models\CentrosCosto;
use App\Models\ParametrosModulos;
use App\Models\Contratos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use App\Models\Despachos;
use App\Models\DespachosDetalle;
use App\Models\Mezclas;
use App\Models\MezclasDetalle;
use Yajra\Datatables\Datatables;
use App\Models\Liquidaciones;
use App\Models\FactorSaldos;

class EntradasSalidasController extends Controller
{
	public $fecha_inicio_periodo='2021-01-01';

    //
    public function listado_entradas_empaques(){
        $titulo = 'Entradas de Cafe';
		$modulo = 'Cafe';
		$seccion = 'Entradas';
        $cafe = TiposCafe::all();
		$centros = CentrosCosto::all();
        $empaques = TiposEmpaque::all();
		$factor = ParametrosModulos::find(2);
        $consecutivo = ParametrosModulos::find(7);
        $numeracion = ParametrosModulos::find(8);
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $transporte = CatalogoEmpresas::where('es_empresa_transporte',1)->get();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->get();
		$session= session('role_id');
        return view('cafe.listado_entrada',compact('titulo','modulo','seccion','empaques','proveedores','clientes','cafe','centros','factor','consecutivo','numeracion','transporte','session'));
	}

	public function listado_mezclas_cafe(){
        $titulo = 'Mezclas de Cafe';
		$modulo = 'Cafe';
		$seccion = 'Mezclas';
		$proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $consecutivo = ParametrosModulos::find(19);
        $numeracion = ParametrosModulos::find(20);
		$cafe = TiposCafe::all();
		$centros = CentrosCosto::all();
        $pergamino = EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
		->where('id_tipo_cafe',1)
		->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.despachado')
		->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre')->get();
        
		
		foreach($pergamino as $rows){
			$rows->kilos_disponibles=$rows->peso_neto-$rows->despachado-$rows->mezclado;
		}
		
		$inferiores = EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
		->join('002_liquidaciones','002_liquidaciones.id_entrada_cafe','003_entradas_salidas_cafe.id')
		->whereColumn('003_entradas_salidas_cafe.peso_neto','>','003_entradas_salidas_cafe.despachado')
		->where('003_entradas_salidas_cafe.id_tipo_cafe','!=',1)
		->distinct('002_liquidaciones.id_entrada')
		->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre','003_entradas_salidas_cafe.id_tipo_cafe')->get();
		foreach($inferiores as $rows){
			$rows->kilos_disponibles=$rows->peso_neto-$rows->despachado-$rows->mezclado;
		}
		
		$session= session('role_id');
        return view('cafe.listado_mezclas',compact('centros','cafe','proveedores','titulo','modulo','seccion','inferiores','pergamino','consecutivo','numeracion','session'));
	}
	
    public function data_listado_empaques(Request $request){
        $registros = EntradasSalidasCafe::where('tipo_operacion',1)->orderBy('fecha_ticket','desc')->get();
        foreach($registros as $rows){
            $cafe = TiposCafe::find($rows->id_tipo_cafe);
            $centros = CentrosCosto::find($rows->id_centro_costo);
			$proveedores = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
            $rows->cafe = $cafe;
            $rows->centros = $centros;
            $rows->proveedores = $proveedores;
        }
        return array('data'=>$registros);
	}

	public function listado_empaques_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
       }
        if($modo==1){
			if($request->id_prov==null){
			return Datatables::of(
			   EntradasSalidasCafe::query()
			        ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
					->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
					->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
					->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					)
					->make();	
				}else{
				return Datatables::of(
				EntradasSalidasCafe::query()
					->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
					->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
					->where('003_entradas_salidas_cafe.tipo_operacion',1)
					->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->id_prov)
					->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					)
				->make();	
				}
			}else{
                 if($request->id_prov==null){
				return Datatables::of(
					EntradasSalidasCafe::query()
						 ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
						 ->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
						 ->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
						 ->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
						 ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
						 ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
						 ->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
						 )
						 ->make();
				}else{
					return Datatables::of(
						EntradasSalidasCafe::query()
							 ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
							 ->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
							 ->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
							 ->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
							 ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
							 ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
							 ->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->id_prov)
							 ->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
							 )
							 ->make();
				}	
			}

	}

	public function listado_mezclas_data(Request $request){
		$modo=1;
		
        if(isset($_GET['modo']) && isset($_GET['fecha_inicial'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];

       }
	
        if($modo==1){
			if($request->id_prov==null){
			return Datatables::of(
				Mezclas::query()->orderBy('created_at','DESC')
					)
					->make();	
				}else{Datatables::of(
				EntradasSalidasCafe::query()
					->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
					->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
					->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
					->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
					->where('003_entradas_salidas_cafe.tipo_operacion',1)
					->where('003_entradas_salidas_cafe.id_catalogo_proveedor',$request->id_prov)
					->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					)
				->make();	
				}
			}else{
                 if($request->id_prov==null){
				return Datatables::of(
					EntradasSalidasCafe::query()
						 ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
						 ->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
						 ->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
						 ->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
						 ->where('003_entradas_salidas_cafe.tipo_operacion','=',1)
						 ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
						 ->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
						 )
						 ->make();
				}else{  
						return EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
						->where('id',$request->id_prov)->get();
					
						
				}	
			}
			if(isset($_GET['id_prov'])){ 
			     $tipo_cafe=EntradasSalidasCafe::find($_GET['id_prov'])->select('id_tipo_cafe')->value('id_tipo_cafe');
				if($tipo_cafe != 1){//si es inferiores
				$consulta=EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
				->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
				->join('002_liquidaciones','002_liquidaciones.id_entrada_cafe','003_entradas_salidas_cafe.id')
				->where('003_entradas_salidas_cafe.id',$_GET['id_prov'])
				->limit(1)
				->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre','000_tipos_cafe.tipo_cafe','002_liquidaciones.valor_producido')->get();
			    

			    }else{//si es pasilla

					
					$consulta=EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
					->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
					->where('003_entradas_salidas_cafe.id',$_GET['id_prov'])
					->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre','000_tipos_cafe.tipo_cafe')->get();
					foreach($consulta as $rows){
						$rows->kilos_disponibles=$rows->peso_neto-$rows->despachado-$rows->mezclado;
					}
				}

				

				return $consulta;
			}

	}

	public function listado_empaques_salidas_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
       }
        if($modo==1){
			if($request->id_prov==null){
				return Datatables::of(
					EntradasSalidasCafe::query()
							->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
							->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_cliente')
							->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
							->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
							->where('003_entradas_salidas_cafe.tipo_operacion','=',2)
							->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','cc.nombre as conductor')
				    )->make();
			}else{
				return Datatables::of(
					EntradasSalidasCafe::query()
							->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
							->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_cliente')
							->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
							->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
							->where('003_entradas_salidas_cafe.tipo_operacion',2)
							->where('003_entradas_salidas_cafe.id_catalogo_cliente',$request->id_prov)
							->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','cc.nombre as conductor')
				    )->make();

			}
		}else{
			if($request->id_prov==null){
			return Datatables::of(
				EntradasSalidasCafe::query()
						 ->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
						 ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_cliente')
						 ->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
						 ->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
						 ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
                         ->where('003_entradas_salidas_cafe.tipo_operacion',2)
						 ->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','cc.nombre as conductor')
			)->make();
		}else{
			return Datatables::of(
				EntradasSalidasCafe::query()
						 ->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
						 ->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_cliente')
						 ->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
						 ->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
						 ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
                         ->where('003_entradas_salidas_cafe.tipo_operacion',2)
						 ->where('003_entradas_salidas_cafe.id_catalogo_cliente',$request->id_prov)
						 ->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','cc.nombre as conductor')
			)->make();

		    }
	    }  
    }
	
    public function registrar_entrada(Request $request){
		

		$request->validate([
			//valida que un regitro que no este eliminado no ingrese nuevamente
			'c02'=>['unique:003_entradas_salidas_cafe,numero_ticket,NULL,id'],//,deleted_at,NULL
		  ],[
			  'c02.unique'=> 'Numero de ticket repetido',
		  ]
		);
		$registro = new EntradasSalidasCafe;

		$registro->tipo_operacion =1;
		$registro->fecha_ticket=$request->c01;
		$registro->numero_ticket=$request->c02;
		$registro->id_catalogo_proveedor=$request->c03;
		$registro->id_centro_costo=$request->c04;
		$registro->id_tipo_cafe=$request->c06;
		$registro->factor=$request->c05;
		$registro->cantidad_sacos=$request->c07;
		$registro->catidad_tulas=$request->c08;
		$registro->id_catalogo_conductor=$request->c09;
		$registro->placa=$request->c11;
		$registro->observaciones=$request->c12;
		$registro->peso_entrada=str_replace('.','',$request->c13);
		$registro->peso_salida=str_replace('.','',$request->c14);
		$registro->peso_bruto=str_replace('.','',$request->c15);
		$registro->tara=str_replace('.','',$request->c16);
		$registro->peso_neto=str_replace('.','',$request->c17);
        $registro->liquidado=0;
        $registro->catidad_tulas=$request->c08;
		if($request->c03!='526'&&$request->c03!='381'){
			$inventario=MovimientoEmpaques::find(-1);
			$inventario->total_sacos+=str_replace('.','',$request->c07);
			$inventario->total_tulas+=str_replace('.','',$request->c08);
			$inventario->save();
	    }
		$registro->save();
		//registrar entrada sacos a movimiento empaques no contabiliza 2 cofeeworld
		if($request->c07>0&&$request->c03!='526'&&$request->c03!='381'){
			$movimiento=new MovimientoEmpaques;
			$movimiento->id_catalogo_empresas_proveedor=$request->c03;//selectRaw('sum(valor) as saldo')
			$movimiento->numero_ticket=$request->c02;
			$total=EntradasSalidasCafe::where('id_catalogo_proveedor',$request->c03)
             ->selectRaw('sum(cantidad_sacos) as saldo')
			->value('saldo');
			$abono_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$request->c03)->where('tipo_operacion',3)->select('abono_sacos')->value('abono_sacos');
			if($total==null){$total=0;}
			if($abono_sacos==null){$abono_sacos=0;}
			$movimiento->cantidad=str_replace('.','',$request->c07);
			$movimiento->total_sacos=$total-$abono_sacos-$request->c07;
			$movimiento->saldo_sacos=$total-$abono_sacos;
			$movimiento->id_tipo_empaque=1;
			$movimiento->fecha_ingreso=$request->c01;
			$movimiento->tipo_operacion=2;
			$movimiento->save();
			
	    }
		//registrar entrada tulas a movimiento empaques
		if($request->c08>00&&$request->c03!='526'&&$request->c03!='381'){
			$movimiento_2=new MovimientoEmpaques;
			$movimiento_2->id_catalogo_empresas_proveedor=$request->c03;
			$movimiento_2->cantidad=str_replace('.','',$request->c08);
			$movimiento_2->numero_ticket=$request->c02;
			$movimiento_2->fecha_ingreso=$request->c01;
			$total=EntradasSalidasCafe::where('id_catalogo_proveedor',$request->c03)
            ->selectRaw('sum(catidad_tulas) as saldo')
            ->value('saldo');
			$abono_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$request->c03)->where('tipo_operacion',3)->select('abono_tulas')->value('abono_tulas');
			if($total==null){$total=0;}
			if($abono_tulas==null){$abono_tulas=0;}
			$movimiento_2->total_tulas=$total-$abono_tulas-str_replace('.','',$request->c08);
			$movimiento_2->saldo_tulas=$total-$abono_tulas;
			$movimiento_2->tipo_operacion=2;
			$movimiento_2->id_tipo_empaque=2;
			$movimiento_2->fecha_ingreso=$request->c01;
			$movimiento_2->save();
		}
		if($request->c05>0){
			$comprobacion = DespachosDetalle::where('id_entrada',$request->id)->get();
		   
		   if(count($comprobacion)>0){
			   foreach($comprobacion as $rows){
				   //actualizo factor en el detalle del despacho
				   $registro_despacho_detalle = DespachosDetalle::find($rows->id);
				   $registro_despacho_detalle->factor=$request->c05;
				   $registro_despacho_detalle->definitivo=0;
				   $registro_despacho_detalle->save();
				   //actualizo factor aportante de la entrada
				   $valor_entradas=DespachosDetalle::where('id_despacho',$registro_despacho_detalle->id_despacho)
				   ->selectRaw('sum(kilogramos) as total')
				   ->value('total');
				   $registro_despacho_detalle->valor=round(($registro_despacho_detalle->kilogramos/$valor_entradas)*$request->c05, 2);
				   $registro_despacho_detalle->save();
				   //actualizo el factor promedio del despacho
				   $factor_promedio=DespachosDetalle::where('id_despacho',$registro_despacho_detalle->id_despacho)
				   ->selectRaw('sum(valor) as total')
				   ->value('total');
				   $despacho= Despachos::find($registro_despacho_detalle->id_despacho);
				   $despacho->factor_promedio=round($factor_promedio,2);
				   $despacho->save();;
			   }
		   }
	   }
           
        $this->incrementar_contador_entrada();
		//agregar factor al despacho y ajustar promedio en despachos con tentativa
	
		
        return redirect()->route('cafe.entradas')->with('result',array('message'=>'El Registro del Movimiento se realizo Exitosamente','type'=>'success'));
    }

	public function registrar_mezcla(Request $request){
		$request->validate([
			'numero'=>['unique:003_mezclas_cafe,numero,NULL,id,deleted_at,NULL'],
			],[
				'numero.unique'=> 'Numero de liquidacion repetido',
			]
			);
		$pendientes = 0;
		\DB::beginTransaction();
		try{ 
			$mezcla = new mezclas;
			$mezcla->numero = $request->numero;
			$mezcla->factor = $request->factor_promedio;
			$mezcla->peso_neto = $request->kilogramos;
			$mezcla->cantidad_sacos = $request->total_tulas;
			$mezcla->cantidad_tulas = $request->total_sacos;
			$mezcla->cantidad_tulas = $request->total_sacos;
			$mezcla->save();

			foreach($_POST['entrada'] as $index => $registro){
                  
				$detalle = new MezclasDetalle;
				$detalle->id_mezcla = $mezcla->id;
				$detalle->id_entrada = $_POST['entrada'][$index];
				$detalle->peso_neto = $_POST['kilos'][$index];
				if($_POST['tipo_cafe'][$index]!=1){
				$detalle->aprovechable = $_POST['aprovechable'][$index];
			    }
				$detalle->save();
				$this->adicionar_cantidad_mezclada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}
			

			\DB::commit();
			$this->incrementar_contador_mezcla();;
			return redirect()->back()->with('result',array('message'=>'Mezcla'.$request->numero.' Registrado Exitosamente','type'=>'success'));
		}catch(\Exception $e){
			\DB::rollback();
			if($e->getCode()==23000){
				return redirect()->back()->with('result',array('message'=>'Mezcla '.$request->numero.' no pudo ser Registrado, Consecutivo de Mezcla ya registrado','type'=>'error'));
			}else{
				return redirect()->back()->with('result',array('message'=>'Mezcla '.$request->numero.' no pudo ser Registrado '.$e->getMessage(),'type'=>'error'));
			}

		}

    }

	private function restar_cantidad_mezclada_entrada($id, $cantidad){
		$contador = EntradasSalidasCafe::find($id);
		$contador->mezclado =$contador->mezclado-$cantidad;
		$contador->save();
	}

	private function adicionar_cantidad_mezclada_entrada($id, $cantidad){
		$contador = EntradasSalidasCafe::find($id);
		$contador->mezclado =$contador->mezclado+$cantidad;
		$contador->save();
	}

    public function obtener_empaque_entrada($id){
        $registro = EntradasSalidasCafe::find($id);
        return json_encode($registro);
    }

    public function actualizar_entrada(Request $request){
		$registro = EntradasSalidasCafe::find($request->id);
        $registro->factor=$request->c05;
		if($request->usuario==1){//si es superusuario puede editar todo
			$fecha_anterior=$registro->fecha_ticket;
			$proveedor_anterior=$registro->id_catalogo_proveedor;
			$registro->fecha_ticket=$request->c01;
			$registro->numero_ticket=$request->c02;
			$registro->id_catalogo_proveedor=$request->c03;
			$registro->id_centro_costo=$request->c04;
			$registro->id_tipo_cafe=$request->c06;
			$registro->cantidad_sacos=$request->c07;
			$registro->catidad_tulas=$request->c08;
			//actualizar bodega empaques
			if($request->c07!=$request->sacos_anterior||$request->c08!=$request->tulas_anterior){
				$inventario = MovimientoEmpaques::find(-1);	
				$inventario->total_sacos-=$request->sacos_anterior;
				$inventario->total_sacos+=$request->c07;
				$inventario->total_tulas-=$request->tulas_anterior;
				$inventario->total_tulas+=$request->c08;
				$inventario->save();
			}
			//actualizar movimiento de sacos
                $id_movimiento = MovimientoEmpaques::where('numero_ticket',$request->c02)->where('id_tipo_empaque',1)->select('id')->value('id');
				if($id_movimiento!=null){
					$movimiento = MovimientoEmpaques::find($id_movimiento);
					$movimiento->id_catalogo_empresas_proveedor=$request->c03;
					$movimiento->cantidad=$request->c07;
					$movimiento->fecha_ingreso=$request->c01;
					$movimiento->saldo_sacos=$movimiento->total_sacos+$request->c07;
					$movimiento->save();
			    }
				//recalcular saldos en movimientos sacos
				 $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$request->c03)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
				 
				 if(count($movimientos_sacos)){
					$saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
                foreach($movimientos_sacos as $rows){//si son sacos
					 $saco=MovimientoEmpaques::find($rows->id);
					 $saco->total_sacos=$saldo_inicial_sacos;
					if($rows->tipo_operacion==1){ //si es ingreso
						$saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
						$saldo_inicial_sacos-=$rows->cantidad;
					}else{//si es salida
						$saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
							$saldo_inicial_sacos+=$rows->cantidad;
					}
					$saco->save();
				   
                }
			    }
			//actualizar movimiento de tulas
				$id_movimiento = MovimientoEmpaques::where('numero_ticket',$request->c02)->where('id_tipo_empaque',2)->select('id')->value('id');
				if($id_movimiento!=null){	
				    $movimiento = MovimientoEmpaques::find($id_movimiento);	
					$movimiento->id_catalogo_empresas_proveedor=$request->c03;
					$movimiento->cantidad=$request->c08;
					$movimiento->fecha_ingreso=$request->c01;
					$movimiento->saldo_tulas=$movimiento->total_tulas+$request->c08;
					$movimiento->save();
				}
				//recalcular saldos movimientos tulas
				 $movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$request->c03)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
                if(count($movimientos_tulas)){
					 $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
					foreach($movimientos_tulas as $rowsx){
						$tulas=MovimientoEmpaques::find($rowsx->id);
						$tulas->total_tulas=$saldo_inicial_tulas;
						if($rowsx->tipo_operacion==1){ //si es ingreso
							$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
							$saldo_inicial_tulas-=$rowsx->cantidad;
						}else{// si es salida
							$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
							$saldo_inicial_tulas+=$rowsx->cantidad;
	
						}
						$tulas->save();
					}
				}
			//actualizar fechas
			if($fecha_anterior!=$request->c01){
				$movimientos=MovimientoEmpaques::where('numero_ticket',$request->c02)->get();
				foreach($movimientos as $rows){
                    $movimiento=MovimientoEmpaques::find($rows->id);
					$movimiento->created_at=$request->c01;	
					$movimiento->save();
				}
			}
			//actualizar saldo del proveedor antenrior en caso de cambio de proveedor en entrada
			if($proveedor_anterior!=$request->c03){
                //recalcular movimientos sacos
				 $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$proveedor_anterior)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
				 $saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
				 if(count($movimientos_sacos)){
					foreach($movimientos_sacos as $rows){//si son sacos
						$saco=MovimientoEmpaques::find($rows->id);
						$saco->total_sacos=$saldo_inicial_sacos;
						if($rows->tipo_operacion==1){ //si es ingreso
							$saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
							$saldo_inicial_sacos-=$rows->cantidad;
						}else{//si es salida
							$saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
								$saldo_inicial_sacos+=$rows->cantidad;
						}
						$saco->save();
					
					}
				}
				//recalcular movimientos tulas
				$movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$proveedor_anterior)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
                if(count($movimientos_tulas)){
					 $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
					foreach($movimientos_tulas as $rowsx){
						$tulas=MovimientoEmpaques::find($rowsx->id);
						$tulas->total_tulas=$saldo_inicial_tulas;
						if($rowsx->tipo_operacion==1){ //si es ingreso
							$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
							$saldo_inicial_tulas-=$rowsx->cantidad;
						}else{// si es salida
							$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
							$saldo_inicial_tulas+=$rowsx->cantidad;
	
						}
						$tulas->save();
					}
				}
			}
			$registro->id_catalogo_conductor=$request->c09;
			$registro->placa=$request->c11;
			$registro->observaciones=$request->c12;
			$registro->peso_entrada=str_replace('.','',$request->c13);
			$registro->peso_salida=str_replace('.','',$request->c14);
			$registro->peso_bruto=str_replace('.','',$request->c15);
			$registro->tara=str_replace('.','',$request->c16);
			$registro->peso_neto=str_replace('.','',$request->c17);
		}
	
		
		if($request->c05>0){
			 $comprobacion = DespachosDetalle::where('id_entrada',$request->id)->get();
			
			if(count($comprobacion)>0){
				foreach($comprobacion as $rows){
					//actualizo factor en el detalle del despacho
					$registro_despacho_detalle = DespachosDetalle::find($rows->id);
					$registro_despacho_detalle->factor=$request->c05;
					$registro_despacho_detalle->definitivo=0;
					$registro_despacho_detalle->save();
					//actualizo factor aportante de la entrada
					$valor_entradas=DespachosDetalle::where('id_despacho',$registro_despacho_detalle->id_despacho)
					->selectRaw('sum(kilogramos) as total')
					->value('total');
					$registro_despacho_detalle->valor=round(($registro_despacho_detalle->kilogramos/$valor_entradas)*$request->c05, 2);
					$registro_despacho_detalle->save();
					//actualizo el factor promedio del despacho
					$factor_promedio=DespachosDetalle::where('id_despacho',$registro_despacho_detalle->id_despacho)
					->selectRaw('sum(valor) as total')
					->value('total');
					$despacho= Despachos::find($registro_despacho_detalle->id_despacho);
					$despacho->factor_promedio=round($factor_promedio,2);
					$despacho->save();;
				}
		    }
	    }
		$registro->save();
		return redirect()->route('cafe.entradas')->with('result',array('message'=>'La Actualizacion del Movmimiento de Entrada se realizo Exitosamente','type'=>'success'));
    }

	public function actualizar_mezcla(Request $request){
		\DB::beginTransaction();
		try{
			$mezcla =mezclas::find($request->id);
			$mezcla->factor = $request->factor_promedio;
			$mezcla->peso_neto = $request->kilogramos;
			$mezcla->cantidad_sacos = $request->total_tulas;
			$mezcla->cantidad_tulas = $request->total_sacos;
			$mezcla->save();
            //eliminar detalles de la mexcla
			$detalles =MezclasDetalle::where('id_mezcla',$request->id)->get();
			foreach($detalles as $rows){
				MezclasDetalle::find($rows->id)->delete();
				$this->restar_cantidad_mezclada_entrada($rows->id_entrada,$rows->peso_neto);	
			}
			//return $request;
            //agregar nuevos detalles
			foreach($_POST['entrada'] as $index => $registro){
                $detalle = new MezclasDetalle;
				$detalle->id_mezcla=$request->id;
				$detalle->id_entrada = $_POST['entrada'][$index];
				$detalle->peso_neto = $_POST['kilos'][$index];
				if($_POST['tipo_cafe'][$index]!=1){
					$detalle->aprovechable = $_POST['aprovechable'][$index];
				}
				$detalle->save();
				$this->adicionar_cantidad_mezclada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}
			

			\DB::commit();
			$this->incrementar_contador_mezcla();;
			return redirect()->back()->with('result',array('message'=>'Mezcla'.$request->numero.' Actualizado Exitosamente','type'=>'success'));
		}catch(\Exception $e){
			\DB::rollback();
			if($e->getCode()==23000){
				return redirect()->back()->with('result',array('message'=>'Mezcla '.$request->numero.' no pudo ser Actualizado, Consecutivo de Mezcla ya Actualizado','type'=>'error'));
			}else{
				return redirect()->back()->with('result',array('message'=>'Mezcla '.$request->numero.' no pudo ser Actualizado '.$e->getMessage(),'type'=>'error'));
			}

		}

    }

	public function detalle_mezcla(Request $request){
		
     $mezcla=MezclasDetalle::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','003_mezclas_detalle.id_entrada')
	 ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
	 ->join('000_tipos_cafe','000_tipos_cafe.id','003_entradas_salidas_cafe.id_tipo_cafe')
	 ->where('id_mezcla',$request->id)
	 ->select('003_entradas_salidas_cafe.*','003_entradas_salidas_cafe.peso_neto as peso_neto_entrada',
	 '003_mezclas_detalle.*','003_mezclas_detalle.peso_neto as peso_neto_detalle','000_tipos_cafe.tipo_cafe','000_catalogo_empresas.nombre')->get();
      
	 foreach($mezcla as $rows){
		$rows->kilos_disponibles=$rows->peso_neto_entrada-$rows->despachado-$rows->mezclado;
	}

	return $mezcla;}

    public function eliminar_entrada($id){
		
        $registro = EntradasSalidasCafe::find($id);
		//recalcular inventario
		$inventario=MovimientoEmpaques::find(-1);
		$inventario->total_sacos-=$registro->cantidad_sacos;
		$inventario->total_tulas-=$registro->catidad_tulas;
		$inventario->save();
       //eliminar movimiento
	    $movimimento=MovimientoEmpaques::where('numero_ticket',$registro->numero_ticket)->get();
		if(count($movimimento)>0){
			foreach($movimimento as $rows){
				$movimiento=MovimientoEmpaques::find($rows->id);
				$id_proveedor=$movimiento->id_catalogo_empresas_proveedor;
				$movimiento->delete();    
			}
		}
		//eliminar entrada
        $registro->delete();
		//recalcular movimientos sacos
		$movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$id_proveedor)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
		$saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
		if(count($movimientos_sacos)){
		foreach($movimientos_sacos as $rows){//si son sacos
			$saco=MovimientoEmpaques::find($rows->id);
			$saco->total_sacos=$saldo_inicial_sacos;
			if($rows->tipo_operacion==1){ //si es ingreso
				$saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
				$saldo_inicial_sacos-=$rows->cantidad;
			}else{//si es salida
				$saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
					$saldo_inicial_sacos+=$rows->cantidad;
			}
			$saco->save();
		}
		}
        //recalcular movimientos tulas
		$movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$id_proveedor)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
		if(count($movimientos_tulas)){
			$saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
			foreach($movimientos_tulas as $rowsx){
				$tulas=MovimientoEmpaques::find($rowsx->id);
				$tulas->total_tulas=$saldo_inicial_tulas;
				if($rowsx->tipo_operacion==1){ //si es ingreso
					$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
					$saldo_inicial_tulas-=$rowsx->cantidad;
				}else{// si es salida
					$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
					$saldo_inicial_tulas+=$rowsx->cantidad;

				}
				$tulas->save();
			}
		}
        return redirect()->route('cafe.entradas')->with('result',array('message'=>'La Entrada se elimino Exitosamente','type'=>'success'));
    }

	public function eliminar_mezcla($id){
        //eiliminar mezcla
		Mezclas::find($id)->delete();
	    //eliminar detalles de la mezcla
		$detalles =MezclasDetalle::where('id_mezcla',$id)->get();
		foreach($detalles as $rows){
			MezclasDetalle::find($rows->id)->delete();
			$this->restar_cantidad_mezclada_entrada($rows->id_entrada,$rows->peso_neto);	
		}
	return redirect()->route('cafe.mezclas')->with('result',array('message'=>'La mezcla se elimino Exitosamente','type'=>'success'));}
	
	public function procesar_reporte_entrada(Request $request){
		
		if($request->c03==-1 and $request->c04==-1 and $request->c07==-1){
			return $this->reporte_fecha_entradas($request->c01,$request->c02,$request->c05,$request->c06);
		}elseif($request->c03!=-1 and $request->c04!=-1 and $request->c07==-1){
			return $this->reporte_fecha_entradas_producto_proveedor($request->c01,$request->c02,$request->c03,$request->c04,$request->c05,$request->c06);
		}elseif($request->c03!=-1 and $request->c07==-1){
			return $this->reporte_fecha_entradas_proveedor($request->c01,$request->c02,$request->c03,$request->c05,$request->c06);
		}elseif($request->c04!=-1 and $request->c07==-1){
			return $this->reporte_fecha_entradas_producto($request->c01,$request->c02,$request->c04,$request->c05,$request->c06);
		}
		if($request->c07==1){
			return $this->reporte_fecha_detallado($request->c01,$request->c02,$request->c05);
		}
		if($request->c07==2){
			return $this->reporte_fecha_resumido($request->c02,$request->c05);
		}
	}

	public function reporte_fecha_entradas_proveedor($fecha_inicial,$fecha_final,$proveedor,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')->get();
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_catalogo_proveedor',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();
		}
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;
           
			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}
            
			$datos['total_peso_entrada']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');
             
            if($tipo_archivo==2){
			$pdf = \App::make('dompdf.wrapper');
			$pdf->setPaper('a4', 'landscape');
			$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
			return $pdf->stream();}
			else{

             return view('cafe.reportes.entradas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
			}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_entradas_producto($fecha_inicial,$fecha_final,$producto,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_tipo_cafe',$producto)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->get();
	    }else{
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_tipo_cafe',$producto)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();
		}
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_entrada']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');

           
			if($tipo_archivo==2){
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.entradas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_entradas_producto_proveedor($fecha_inicial,$fecha_final,$proveedor,$producto,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_tipo_cafe',$producto)->where('id_catalogo_proveedor',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->get();
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->where('id_tipo_cafe',$producto)->where('id_catalogo_proveedor',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();	
		}

		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_entrada']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');


			if($tipo_archivo==2){
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.entradas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_entradas($fecha_inicial,$fecha_final,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->get();
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',1)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();
		}
		
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_entrada']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');


			if($tipo_archivo==2){
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.entradas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}


	}

	public function reporte_fecha_detallado($fecha_inicial,$fecha_final,$excel){
		 $entrada = EntradasSalidasCafe::where('tipo_operacion',1)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
		->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
		->where('id_tipo_cafe','1')
		->get();

		$salida = EntradasSalidasCafe::where('tipo_operacion',2)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
		->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
		->where('id_tipo_cafe','1')
		->get();
		 
		$inferiores_entrada=EntradasSalidasCafe::where('tipo_operacion',1)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
		->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
		->whereNotin('id_tipo_cafe',[1])
		->get();

		$inferiores_salida=EntradasSalidasCafe::where('tipo_operacion',2)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
		->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
		->whereNotIn('id_tipo_cafe',[1])
		->get();
        
		$cont=0;
		$entradas['registros']=0;
		$salidas['registros']=0;
		$inferiores_entradas['registros']=0;
		$inferiores_salidas['registros']=0;

		
		if(count($entrada)>0){
			$entra=1;
			$cont++;
			$entradas['registros']=count($entrada);
			$entradas['rows']=$entrada;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;
            
			foreach($entrada as $rows){
				
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$entradas['total_peso_entrada']=number_format($tot1,0,',','.');
			$entradas['total_peso_salida']=number_format($tot2,0,',','.');
			$entradas['total_peso_bruto']=number_format($tot3,0,',','.');
			$entradas['total_peso_neto']=number_format($tot4,0,',','.');
             
		}
		
		if(count($salida)>0){
			$cont++;
			$salidas['registros']=count($salida);
			$salidas['rows']=$salida;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($salida as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$salidas['total_peso_entrada']=number_format($tot1,0,',','.');
			$salidas['total_peso_salida']=number_format($tot2,0,',','.');
			$salidas['total_peso_bruto']=number_format($tot3,0,',','.');
			$salidas['total_peso_neto']=number_format($tot4,0,',','.');
		}
        if(count($inferiores_entrada)>0){
			$infer_entradas=1;
			$cont++;
			$inferiores_entradas['registros']=count($inferiores_entrada);
			$inferiores_entradas['rows']=$inferiores_entrada;
			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($inferiores_entrada as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$inferiores_entradas['total_peso_entrada']=number_format($tot1,0,',','.');
			$inferiores_entradas['total_peso_salida']=number_format($tot2,0,',','.');
			$inferiores_entradas['total_peso_bruto']=number_format($tot3,0,',','.');
			$inferiores_entradas['total_peso_neto']=number_format($tot4,0,',','.');
		}
		if(count($inferiores_salida)>0){
			$cont++;
			$infer_entradas=1;
			$inferiores_salidas['registros']=count($inferiores_salida);
			$inferiores_salidas['rows']=$inferiores_salida;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($inferiores_salida as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_entrada;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$inferiores_salidas['total_peso_entrada']=number_format($tot1,0,',','.');
			$inferiores_salidas['total_peso_salida']=number_format($tot2,0,',','.');
			$inferiores_salidas['total_peso_bruto']=number_format($tot3,0,',','.');
			$inferiores_salidas['total_peso_neto']=number_format($tot4,0,',','.');

		}
        if($cont>0){
			$imagen = base64_encode(\Storage::get('logo_actual.png'));
			return view('cafe.reportes.entradas.reporte_detallado',compact('fecha_inicial','fecha_final','entradas','salidas','inferiores_entradas','inferiores_salidas','excel','imagen'));
			
        }else{
			return view('cafe.reportes.no-reporte');
		}
	}
	
	public function reporte_fecha_resumido($fecha_final,$excel){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		 $entradas = EntradasSalidasCafe::where('tipo_operacion',1)
		 ->whereBetween('fecha_ticket', [$this->fecha_inicio_periodo, $fecha_final])
		 ->where('id_tipo_cafe','1')
		->selectRaw('sum(peso_neto) as peso_entradas')
		->value('peso_entradas')
		;
  
		$salidas = EntradasSalidasCafe::where('tipo_operacion',2)->whereBetween('fecha_ticket', [$this->fecha_inicio_periodo, $fecha_final])
			->where('id_tipo_cafe','1')
			->selectRaw('sum(peso_neto) as peso_salidas')
			->value('peso_salidas')
	    ;
		
		$inferiores_entradas=EntradasSalidasCafe::where('tipo_operacion',1)->whereBetween('fecha_ticket', [$this->fecha_inicio_periodo, $fecha_final])
			->whereNotIn('id_tipo_cafe',[1])
			->selectRaw('sum(peso_neto) as peso_inferiores_entradas')
			->value('peso_inferiores_entradas')
	   ;

	   $inferiores_salidas=EntradasSalidasCafe::where('tipo_operacion',2)->whereBetween('fecha_ticket', [$this->fecha_inicio_periodo, $fecha_final])
		->whereNotIn('id_tipo_cafe',[1])
		->selectRaw('sum(peso_neto) as peso_inferiores_salidas')
		->value('peso_inferiores_salidas')
	   ;
	   
	   if($entradas+$salidas+$inferiores_entradas+$inferiores_salidas>0){
		   $fecha_inicial=$this->fecha_inicio_periodo;
		   return view('cafe.reportes.entradas.reporte_resumen',compact('fecha_inicial','fecha_final','entradas','salidas','inferiores_entradas','inferiores_salidas','excel','imagen'));
		 
		}else{
		   return view('cafe.reportes.no-reporte');
	   }
   }
	public function procesar_reporte_salida(Request $request){

		if($request->c03==-1 and $request->c04==-1 and $request->c07==-1){
			return $this->reporte_fecha_salidas($request->c01,$request->c02,$request->c05,$request->c06);
		}elseif($request->c03!=-1 and $request->c04!=-1 and $request->c07==-1){
			return $this->reporte_fecha_salidas_producto_proveedor($request->c01,$request->c02,$request->c04,$request->c03,$request->c05,$request->c06);
		}elseif($request->c03!=-1 and $request->c07==-1){
			return $this->reporte_fecha_salidas_proveedor($request->c01,$request->c02,$request->c03,$request->c05,$request->c06);
		}elseif($request->c04!=-1 and $request->c07==-1){
			return $this->reporte_fecha_salidas_producto($request->c01,$request->c02,$request->c04,$request->c05,$request->c06);
		}
		if($request->c07==1){
			return $this->reporte_fecha_detallado($request->c01,$request->c02,$request->c05);
		}
		if($request->c07==2){
			return $this->reporte_fecha_resumido($request->c02,$request->c05);
		}
		
	}

	public function reporte_fecha_salidas_proveedor($fecha_inicial,$fecha_final,$proveedor,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_catalogo_cliente',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')->get();
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_catalogo_cliente',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();
		}
		
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_salida;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_salida']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');

          
			if($tipo_archivo==2){
				
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();
			}else{
				return view('cafe.reportes.salidas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
			}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_salidas_producto($fecha_inicial,$fecha_final,$producto,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_tipo_cafe',$producto)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')->get();
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_tipo_cafe',$producto)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
			->where('id_centro_costo',$bodega)
			->get();
		}
		
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);$tot1 += $rows->peso_salida;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_salida']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');
             
		

			if($tipo_archivo==2){
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.salidas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_salidas_producto_proveedor($fecha_inicial,$fecha_final,$producto,$proveedor,$tipo_archivo,$bodega){
		
		if($bodega==-1){
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_tipo_cafe',$producto)->where('id_catalogo_cliente',$proveedor)->whereBetween('fecha_ticket',[$fecha_inicial, $fecha_final])
			->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')->get();
			
		}else{
			$data = EntradasSalidasCafe::where('tipo_operacion',2)->where('id_tipo_cafe',$producto)->where('id_catalogo_cliente',$proveedor)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')
		    ->where('id_centro_costo',$bodega)
			->get();
		}
		
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
                $tot1 += $rows->peso_salida;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_salida']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');
			

			if($tipo_archivo==2){
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.salidas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_fecha_salidas($fecha_inicial,$fecha_final,$tipo_archivo,$bodega){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$data = EntradasSalidasCafe::where('tipo_operacion',2)->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
		->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_conductor')->select('003_entradas_salidas_cafe.*','000_catalogo_empresas.nombre as nombre_conductor')->get();
		if(count($data)>0){
			$datos['registros']=count($data);
			$datos['rows']=$data;

			$tot1 = 0;
			$tot2 = 0;
			$tot3 = 0;
			$tot4 = 0;

			foreach($data as $rows){
				$rows->proveedor = CatalogoEmpresas::find($rows->id_catalogo_cliente);
				$rows->centro = CentrosCosto::find($rows->id_centro_costo);
				$rows->producto = TiposCafe::find($rows->id_tipo_cafe);
				$tot1 += $rows->peso_salida;
				$tot2 += $rows->peso_salida;
				$tot3 += $rows->peso_bruto;
				$tot4 += $rows->peso_neto;
			}

			$datos['total_peso_salida']=number_format($tot1,0,',','.');
			$datos['total_peso_salida']=number_format($tot2,0,',','.');
			$datos['total_peso_bruto']=number_format($tot3,0,',','.');
			$datos['total_peso_neto']=number_format($tot4,0,',','.');

			//return $data;
			if($tipo_archivo==2){
			
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.salidas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();}
				else{
	
				 return view('cafe.reportes.salidas.reporte_fechas_excel',compact('fecha_inicial','fecha_final','datos'));
				}

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}


    }
	public function generar_comprobante_entrada($id){
        $registro = EntradasSalidasCafe::where('id',$id)->get();
        foreach($registro as $rows){
            $cafe = TiposCafe::find($rows->id_tipo_cafe);
            $conductor = CatalogoEmpresas::find($rows->id_catalogo_conductor);
            $cliente = CatalogoEmpresas::find($rows->id_catalogo_proveedor);
            $rows->cafe = $cafe;
            $rows->conductor = $conductor;
            $rows->cliente = $cliente;
        }
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        return view('cafe.reportes.entradas.comprobante_entrada',compact('registro','imagen'));
    }

    public function generar_comprobante_salida($id){
        $registro = EntradasSalidasCafe::where('id',$id)->get();
        foreach($registro as $rows){
            $cafe = TiposCafe::find($rows->id_tipo_cafe);
            $conductor = CatalogoEmpresas::find($rows->id_catalogo_conductor);
            $cliente = CatalogoEmpresas::find($rows->id_catalogo_cliente);
            $rows->cafe = $cafe;
            $rows->conductor = $conductor;
            $rows->cliente = $cliente;
        }
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        return view('cafe.reportes.salidas.comprobante_salida',compact('registro','imagen'));
    }


    public function listado_salidas_empaques(){
        $titulo = 'Salidas de Cafe Registradas';
		$modulo = 'Cafe';
		$seccion = 'Salidas';
        $cafe = TiposCafe::all();
		$centros = CentrosCosto::all();
        $empaques = TiposEmpaque::all();
		$factor = ParametrosModulos::find(2);
        $consecutivo = ParametrosModulos::find(9);
        $numeracion = ParametrosModulos::find(10);
        $transporte = CatalogoEmpresas::where('es_empresa_transporte',1)->get();
        $session= session('role_id');
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->get();
        return view('cafe.listado_salida',compact('titulo','modulo','seccion','empaques','proveedores','clientes','cafe','centros','factor','consecutivo','numeracion','transporte','session'));
    }
    public function data_listado_empaques_salidas(Request $request){
        $registros = EntradasSalidasCafe::where('tipo_operacion',2)->get();
        foreach($registros as $rows){
            $cafe = TiposCafe::find($rows->id_tipo_cafe);
            $centros = CentrosCosto::find($rows->id_centro_costo);
            $rows->cafe = $cafe;
            $rows->centros = $centros;
        }
        return array('data'=>$registros);
    }
    public function registrar_salida(Request $request){
		
		$request->validate([
			//valida que un regitro que no sea eliminado no ingrese nuevamente
			'c02'=>['unique:003_entradas_salidas_cafe,numero_ticket,NULL,id'],//,deleted_at,NULL
		  ],[
			  'c02.unique'=> 'Numero de ticket repetido',
		  ]
		);

		$registro = new EntradasSalidasCafe;
		$registro->tipo_operacion =2;
		$registro->fecha_ticket=$request->c01;
        $registro->numero_ticket=$request->c02;
        $registro->id_catalogo_proveedor=$request->c03;
		$registro->id_centro_costo=$request->c04;
		$registro->id_tipo_cafe=$request->c06;
		$registro->factor=$request->c05;
		$registro->cantidad_sacos=$request->c07;
		$registro->catidad_tulas=$request->c08;
		$registro->id_catalogo_conductor=$request->c09;
		$registro->telefono_conductor=$request->c18;
		$registro->placa=$request->c11;
		$registro->observaciones=$request->c12;
		$registro->peso_entrada=str_replace('.','',$request->c13);
		$registro->peso_salida=str_replace('.','',$request->c14);
		$registro->peso_bruto=str_replace('.','',$request->c15);
		$registro->tara=str_replace('.','',$request->c16);
		$registro->peso_neto=str_replace('.','',$request->c17);
		$registro->id_catalogo_cliente=$request->c19;
		$registro->empresa_transportadora=$request->c20;
		$registro->direccion_destino=$request->c22;
		$registro->lugar_destino=$request->c21;
        $registro->kilometros=$request->c23;
        $registro->liquidado=0;
		//no contabiliza 2 cofeeworld 
		if($request->c03!='526'&&$request->c03!='381'){
			$inventario=MovimientoEmpaques::find(-1);
			$inventario->total_sacos-=str_replace('.','',$request->c07);
			$inventario->total_tulas-=str_replace('.','',$request->c08);
			$inventario->save();
		}
		$registro->save();
      //registrar entrada sacos a movimiento empaques no contabiliza 2 cofeeworld 
	  if($request->c07>0 && $request->c03!='526' && $request->c03!='381'){
		$request->validate([//,deleted_at,NULL
			'c02'=>['unique:003_movimiento_empaques,numero_ticket,NULL,id,id_tipo_empaque,1'],//deleted_at,NULL
			],[
				'c02.unique'=> 'empaque repetido',
			]
			);
			$movimiento=new MovimientoEmpaques;
			$movimiento->id_catalogo_empresas_cliente=$request->c19;
			$total=EntradasSalidasCafe::where('id_catalogo_cliente',$request->c19)
             ->selectRaw('sum(cantidad_sacos) as saldo')
			->value('saldo');
			$abono_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$request->c19)->where('tipo_operacion',4)->select('abono_sacos')->value('abono_sacos');
			if($total==null){$total=0;}
			if($abono_sacos==null){$abono_sacos=0;}
			$movimiento->cantidad=str_replace('.','',$request->c07);
		    $movimiento->total_sacos=$total-$abono_sacos-str_replace('.','',$request->c07);
			$movimiento->saldo_sacos=$total-$abono_sacos;
			$movimiento->numero_ticket=$request->c02;
			$movimiento->id_tipo_empaque=1;
			$movimiento->tipo_operacion=1;
			$movimiento->fecha_ingreso=$request->c01;
			$movimiento->save();
	    }
		//registrar entrada tulas a movimiento empaques
		if($request->c08>0&&$request->c03!='526'&&$request->c03!='381'){
			$request->validate([//,deleted_at,NULL
				'c02'=>['unique:003_movimiento_empaques,numero_ticket,NULL,id,id_tipo_empaque,2'],//deleted_at,NULL
				],[
					'c02.unique'=> 'empaque repetido',
				]
				);
			$movimiento_2=new MovimientoEmpaques;

			$movimiento_2->id_catalogo_empresas_cliente=$request->c19;
			$movimiento_2->cantidad=str_replace('.','',$request->c08);
			$total=EntradasSalidasCafe::where('id_catalogo_cliente',$request->c19)
            ->selectRaw('sum(catidad_tulas) as saldo')
            ->value('saldo');
			$abono_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$request->c19)->where('tipo_operacion',4)->select('abono_tulas')->value('abono_tulas');
			if($total==null){$total=0;}
			if($abono_tulas==null){$abono_tulas=0;}
			$movimiento_2->total_tulas=$total-$abono_tulas-str_replace('.','',$request->c08);
			$movimiento_2->saldo_tulas=$total-$abono_tulas;
			$movimiento_2->id_tipo_empaque=2;
			$movimiento_2->tipo_operacion=1;
			$movimiento_2->numero_ticket=$request->c02;
			$movimiento_2->fecha_ingreso=$request->c01;
			$movimiento_2->save();
		}

        $this->incrementar_contador_salida();

        return redirect()->route('despachos.pendientes',['data_id'=>$registro->id,'data_number'=>$registro->numero_ticket,'data_weight'=>$registro->peso_neto]);
    }
    public function obtener_empaque_salida($id){
        $registro = EntradasSalidasCafe::find($id);
        return json_encode($registro);
    }

    public function eliminar_salida($id){
        $registro = EntradasSalidasCafe::find($id);
		$inventario=MovimientoEmpaques::find(-1);
		$inventario->total_sacos+=$registro->cantidad_sacos;
		$inventario->total_tulas+=$registro->catidad_tulas;
		$inventario->save();
		 //eliminar movimiento
		 $movimimento=MovimientoEmpaques::where('numero_ticket',$registro->numero_ticket)->get();
		 if(count($movimimento)>0){
			 foreach($movimimento as $rows){
				 $movimiento=MovimientoEmpaques::find($rows->id);
				 $id_cliente=$movimiento->id_catalogo_empresas_cliente;
				 $movimiento->delete();    
			 }
		 }
		 //eliminar salida
        $registro->delete();
		//recacular movimientos sacos
		$movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$id_cliente)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
		$saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
		if(count($movimientos_sacos)){
	   foreach($movimientos_sacos as $rows){//si son sacos
			$saco=MovimientoEmpaques::find($rows->id);
			$saco->total_sacos=$saldo_inicial_sacos;
		   if($rows->tipo_operacion==1){ //si es ingreso
			   $saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
			   $saldo_inicial_sacos+=$rows->cantidad;
		   }else{//si es salida
			   $saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
				   $saldo_inicial_sacos-=$rows->cantidad;
		   }
		   $saco->save();
		}
	}
	//recalcular movimientos tulas
	$movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$id_cliente)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
	if(count($movimientos_tulas)){
		$saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
		foreach($movimientos_tulas as $rowsx){
			$tulas=MovimientoEmpaques::find($rowsx->id);
			$tulas->total_tulas=$saldo_inicial_tulas;
			if($rowsx->tipo_operacion==1){ //si es ingreso
				$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
				$saldo_inicial_tulas+=$rowsx->cantidad;
			}else{// si es salida
				$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
				$saldo_inicial_tulas-=$rowsx->cantidad;

			}
			$tulas->save();
		}
	}
        return redirect()->route('cafe.salidas')->with('result',array('message'=>'La Salida se elimino Exitosamente','type'=>'success'));
    }

    public function actualizar_salida(Request $request){
        $registro = EntradasSalidasCafe::find($request->id);
		$fecha_anterior=$registro->fecha_ticket;
		
		$registro->fecha_ticket=$request->c01;
		$registro->numero_ticket=$request->c02;
		$registro->id_catalogo_proveedor=$request->c03;
		$registro->id_centro_costo=$request->c04;
		$registro->id_tipo_cafe=$request->c06;
		$registro->factor=$request->c05;
		$registro->cantidad_sacos=$request->c07;
		$registro->catidad_tulas=$request->c08;
		if($request->c07!=$request->sacos_anterior||$request->c08!=$request->tulas_anterior){
			$inventario = MovimientoEmpaques::find(-1);	
			$inventario->total_sacos+=$request->sacos_anterior;
			$inventario->total_sacos-=$request->c07;
			$inventario->total_tulas+=$request->tulas_anterior;
			$inventario->total_tulas-=$request->c08;
			$inventario->save();
		}
		$registro->id_catalogo_conductor=$request->c09;
		$registro->telefono_conductor=$request->c18;
		$registro->placa=$request->c11;
		$registro->observaciones=$request->c12;
		$registro->peso_entrada=str_replace('.','',$request->c13);
		$registro->peso_salida=str_replace('.','',$request->c14);
		$registro->peso_bruto=str_replace('.','',$request->c15);
		$registro->tara=str_replace('.','',$request->c16);
		$registro->peso_neto=str_replace('.','',$request->c17);
		$cliente_anterior=$registro->id_catalogo_cliente;
		$registro->id_catalogo_cliente=$request->c19;
		$registro->empresa_transportadora=$request->c20;
		$registro->direccion_destino=$request->c22;
		$registro->lugar_destino=$request->c21;
		$registro->kilometros=$request->c23;
        $registro->save();
			//actualizar movimiento sacos
                $id_movimiento = MovimientoEmpaques::where('numero_ticket',$request->c02)->where('id_tipo_empaque',1)->select('id')->value('id');
				if($id_movimiento!=null){
					$movimiento = MovimientoEmpaques::find($id_movimiento);	
					$movimiento->cantidad-=$request->sacos_anterior;
					$movimiento->cantidad+=$request->c07;
					$movimiento->id_catalogo_empresas_cliente=$request->c19;
					$movimiento->fecha_ingreso=$request->c01;
					$movimiento->saldo_sacos=$movimiento->total_sacos+$request->c07;
					$movimiento->save();
			    }
				//recalcular movimientos sacos
				$movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$request->c19)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
				
				if(count($movimientos_sacos)){
					$saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
			   foreach($movimientos_sacos as $rows){//si son sacos
					$saco=MovimientoEmpaques::find($rows->id);
					$saco->total_sacos=$saldo_inicial_sacos;
				   if($rows->tipo_operacion==1){ //si es ingreso
					   $saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
					   $saldo_inicial_sacos+=$rows->cantidad;
				   }else{//si es salida
					   $saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
						   $saldo_inicial_sacos-=$rows->cantidad;
				   }
				   $saco->save();
				}
			}
			//actualizar movimiento de tulas 
				$id_movimiento = MovimientoEmpaques::where('numero_ticket',$request->c02)->where('id_tipo_empaque',2)->select('id')->value('id');
				if($id_movimiento!=null){	
				    $movimiento = MovimientoEmpaques::find($id_movimiento);	
					$movimiento->id_catalogo_empresas_cliente=$request->c19;
					$movimiento->cantidad-=$request->tulas_anterior;
					$movimiento->cantidad+=$request->c08;
					$movimiento->fecha_ingreso=$request->c01;
					$movimiento->saldo_tulas=$movimiento->total_tulas+$request->c08;
					$movimiento->save();
					}
					//recalcular movimientos tulas
					$movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$request->c19)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
					if(count($movimientos_tulas)){
						$saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
						foreach($movimientos_tulas as $rowsx){
							$tulas=MovimientoEmpaques::find($rowsx->id);
							$tulas->total_tulas=$saldo_inicial_tulas;
							if($rowsx->tipo_operacion==1){ //si es ingreso
								$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
								$saldo_inicial_tulas+=$rowsx->cantidad;
							}else{// si es salida
								$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
								$saldo_inicial_tulas-=$rowsx->cantidad;
		
							}
							$tulas->save();
						}
					}
          	//actualizar fechas
			if($fecha_anterior!=$request->c01){
				$movimientos=MovimientoEmpaques::where('numero_ticket',$request->c02)->get();
				foreach($movimientos as $rows){
                    $movimiento=MovimientoEmpaques::find($rows->id);
					$movimiento->created_at=$request->c01;	
					$movimiento->save();
				}
			}
			//recalcular saldos cliente anterior en caso de cambiar de cliente en la salida
			if($cliente_anterior!=$request->c19){
               //recalcular movimientos sacos
				$movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$cliente_anterior)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
				$saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
				if(count($movimientos_sacos)){
					foreach($movimientos_sacos as $rows){//si son sacos
							$saco=MovimientoEmpaques::find($rows->id);
							$saco->total_sacos=$saldo_inicial_sacos;
						if($rows->tipo_operacion==1){ //si es ingreso
							$saco->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
							$saldo_inicial_sacos+=$rows->cantidad;
						}else{//si es salida
							$saco->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
								$saldo_inicial_sacos-=$rows->cantidad;
						}
						$saco->save();
					}
			    }
				//recalcular movimientos tulas
				$movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$cliente_anterior)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
				if(count($movimientos_tulas)){
					$saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
					foreach($movimientos_tulas as $rowsx){
						$tulas=MovimientoEmpaques::find($rowsx->id);
						$tulas->total_tulas=$saldo_inicial_tulas;
						if($rowsx->tipo_operacion==1){ //si es ingreso
							$tulas->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
							$saldo_inicial_tulas+=$rowsx->cantidad;
						}else{// si es salida
							$tulas->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
							$saldo_inicial_tulas-=$rowsx->cantidad;
	
						}
						$tulas->save();
					}
				}
			}
        return redirect()->route('cafe.salidas')->with('result',array('message'=>'La Actualizacion del Movmimiento se realizo Exitosamente','type'=>'success'));
    }

    private function incrementar_contador_entrada(){
        $contador = ParametrosModulos::find(8);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

	private function incrementar_contador_mezcla(){
        $contador = ParametrosModulos::find(20);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

    private function incrementar_contador_salida(){
        $contador = ParametrosModulos::find(10);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

	public function terminar_entrada_salida($id){
		$registro = EntradasSalidasCafe::find($id);
		$registro->terminada=1;
        $registro->save();
		return redirect()->back()->with('result',array('message'=>'La Actualizacion del Registro se realizo Exitosamente','type'=>'success'));
	}

	public function habilitar_entrada_salida($id){
		$registro = EntradasSalidasCafe::find($id);
		$registro->terminada=0;
        $registro->save();
		return redirect()->back()->with('result',array('message'=>'La Actualizacion del Registro se realizo Exitosamente','type'=>'success'));
	}
	
	public function procesar_reporte_entradas_liquidadas(Request $request){
        $titulo_reporte="";
		$catalogo_empresas=new CatalogoEmpresas;
		$entradas_salidas_cafe=new EntradasSalidasCafe;
		$liquidaciones=new Liquidaciones;
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$excel=$request->c05;
		if($request->c04==2){//si es entrada de cafe sin liquidadar
			 $titulo_reporte="Reporte de entradas sin liquidar";
			if($request->c03!=-1){//consulta con proveedor
			 $data = EntradasSalidasCafe::join($catalogo_empresas->getTable(),$catalogo_empresas->getTable().'.id','=',$entradas_salidas_cafe->getTable().'.id_catalogo_proveedor')
			    ->whereColumn('peso_neto','>','liquidado')
			    ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->where('tipo_operacion',1)
				->where('terminada',0)
				->where('id_catalogo_proveedor',$request->c03)
				->orderBy($catalogo_empresas->getTable().'.nombre','asc')
				->select($entradas_salidas_cafe->getTable().'.*','fecha_ticket as fecha')
				->get()
		    ;
		   }else{
			 $data = EntradasSalidasCafe::join($catalogo_empresas->getTable(),$catalogo_empresas->getTable().'.id','=',$entradas_salidas_cafe->getTable().'.id_catalogo_proveedor')
			->whereColumn('peso_neto','>','liquidado')
				->where('tipo_operacion',1)
				->where('terminada',0)
			    ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->orderBy($catalogo_empresas->getTable().'.nombre','asc')
				->select($entradas_salidas_cafe->getTable().'.*','fecha_ticket as fecha')
				->get()
		    ;
		   }
		}else{//si es entrada de cafe liquidada
			$titulo_reporte="Reporte de entradas liquidadas";
			if($request->c03!=-1){//consulta con proveedor
				$data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
		        ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
		        ->orderBy('000_catalogo_empresas.nombre','asc')
				->where('id_catalogo_proveedor',$request->c03)
		        ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->select(\DB::raw("002_liquidaciones.*,003_entradas_salidas_cafe.id as id_entrada,003_entradas_salidas_cafe.fecha_ticket as fecha"))->get()
	        ;
		    }else{//consulta con todos
				 $data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_entrada_cafe')
		        ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
		        ->orderBy('000_catalogo_empresas.nombre','asc')
				->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->select(\DB::raw("002_liquidaciones.*,003_entradas_salidas_cafe.id as id_entrada,003_entradas_salidas_cafe.fecha_ticket as fecha"))->get()					

		    ;
		    }
		
		}
		foreach($data as $indice => $rows){
			try{
				if($request->c04==1){//si es entrada de cafe liquidada
					//Restauramos entrada liquidada si se elimino
					$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_entrada)->first();
					$entrada_eliminada->restore();
					$entrada = EntradasSalidasCafe::where('id',intval($rows->id_entrada))->get();
					//restaurar contrato si se elimino
			        $contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
				    $contrato_eliminado->restore();
				    $contrato = Contratos::find($rows->id_contrato);
				    $rows->contrato = $contrato;
				}else{
					$entrada = EntradasSalidasCafe::where('id',intval($rows->id))->get();
				}
				$indice=intval($entrada[0]->id_catalogo_proveedor);
				$rows->entrada = $entrada;
				$cafe = TiposCafe::find($entrada[0]->id_tipo_cafe);
				$rows->cafe = $cafe;
				$data_reporte[$indice]['proveedor']['info'] = CatalogoEmpresas::find($indice);
				$data_reporte[$indice]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				dump ($rows);
			}
		}
		foreach($data_reporte as $indice => $datal){
			usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
				return $a['fecha'] <=> $b['fecha'];
			});
		}
	    try{
			if(count($data_reporte)>0){
				if($request->c04==1){
					return view('cafe.reportes.entradas.reporte_liquidadas',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','titulo_reporte'));
				}else{
					return view('cafe.reportes.entradas.reporte_sin_liquidar',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','titulo_reporte'));
				}
		    }else{
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
		}catch(\Exception $e){
			return ($e);
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
	}

	public function procesar_reporte_salidas_liquidadas(Request $request){
        $titulo_reporte="";
		$catalogo_empresas=new CatalogoEmpresas;
		$entradas_salidas_cafe=new EntradasSalidasCafe;
		$liquidaciones=new Liquidaciones;
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02;
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$excel=$request->c05;
		if($request->c04==2){//si es salida de cafe sin liquidadar
			$titulo_reporte="Reporte de salidas sin liquidar";
			if($request->c03!=-1){//consulta con proveedor
			$data = EntradasSalidasCafe::join($catalogo_empresas->getTable(),$catalogo_empresas->getTable().'.id','=',$entradas_salidas_cafe->getTable().'.id_catalogo_cliente')
			    ->whereColumn('peso_neto','>','liquidado')
			    ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->where('tipo_operacion',2)
				->where('terminada',0)
				->where('id_catalogo_cliente',$request->c03)
				->orderBy($catalogo_empresas->getTable().'.nombre','asc')
				->select($entradas_salidas_cafe->getTable().'.*','fecha_ticket as fecha')
				->get()
		    ;
		   }else{
			$data = EntradasSalidasCafe::join($catalogo_empresas->getTable(),$catalogo_empresas->getTable().'.id','=',$entradas_salidas_cafe->getTable().'.id_catalogo_cliente')
			    ->whereColumn('peso_neto','>','liquidado')
				->where('tipo_operacion',2)
				->where('terminada',0)
			    ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->orderBy($catalogo_empresas->getTable().'.nombre','asc')
				->select($entradas_salidas_cafe->getTable().'.*','fecha_ticket as fecha')
				->get()
		    ;
		   }
		}else{//si es salida de cafe liquidada
			$titulo_reporte="Reporte de salidas liquidadas";
			if($request->c03!=-1){//consulta con cliente
				 $data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
		        ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
		        ->orderBy('000_catalogo_empresas.nombre','asc')
				->where('id_catalogo_cliente',$request->c03)
		        ->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->select(\DB::raw("002_liquidaciones.*,003_entradas_salidas_cafe.id as id_entrada,003_entradas_salidas_cafe.fecha_ticket as fecha"))->get()
	        ;
		    }else{//consulta con todos
				$data = Liquidaciones::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','002_liquidaciones.id_salida_cafe')
		        ->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
		        ->orderBy('000_catalogo_empresas.nombre','asc')
				->whereBetween('fecha_ticket', [$fecha_inicial, $fecha_final])
				->select(\DB::raw("002_liquidaciones.*,003_entradas_salidas_cafe.id as id_entrada,003_entradas_salidas_cafe.fecha_ticket as fecha"))->get()					

		    ;
		    }
		
		}
		
		foreach($data as $indice => $rows){
			try{
				if($request->c04==1){//si es entrada de cafe liquidada
					//Restauramos entrada liquidada si se elimino
					$entrada_eliminada = EntradasSalidasCafe::withTrashed()->where('id', $rows->id_entrada)->first();
					$entrada_eliminada->restore();
					$entrada = EntradasSalidasCafe::where('id',intval($rows->id_entrada))->get();
					//restaurar contrato si se elimino
				    $contrato_eliminado=Contratos::withTrashed()->where('id', $rows->id_contrato)->first();
				    $contrato_eliminado->restore();
				    $contrato = Contratos::find($rows->id_contrato);
				    $rows->contrato = $contrato;
				}else{
					$entrada = EntradasSalidasCafe::where('id',intval($rows->id))->get();
				}
				$indice=intval($entrada[0]->id_catalogo_cliente);
				$rows->entrada = $entrada;
				$cafe = TiposCafe::find($entrada[0]->id_tipo_cafe);
				$rows->cafe = $cafe;
				$data_reporte[$indice]['proveedor']['info'] = CatalogoEmpresas::find($indice);
				$data_reporte[$indice]['proveedor']['data'][strtotime($rows->created_at)]=$rows;
			}catch(\Exception $e){
				dump ($rows);
			}
		}
		foreach($data_reporte as $indice => $datal){
			usort($data_reporte[$indice]['proveedor']['data'], function($a, $b) {
				return $a['fecha'] <=> $b['fecha'];
			});
		}
	    try{
			if(count($data_reporte)>0){
				if($request->c04==1){
					return view('cafe.reportes.entradas.reporte_liquidadas',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','titulo_reporte'));
				}else{
					return view('cafe.reportes.entradas.reporte_sin_liquidar',compact('fecha_inicial','fecha_final','data_reporte','excel','imagen','titulo_reporte'));
				}
		    }else{
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
		}catch(\Exception $e){
			return ($e);
				$datos['registros']=0;
				return view('cafe.reportes.no-reporte');
			}
	}
	
	public function reporte_corte_mensual(Request $request){
		
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $excel=$request->c03;
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_saldo=date('Y-m-d',strtotime($fecha_inicial.' -1 days'));
		$tipo_reporte=$request->c04;
	    
		$base_entrada=EntradasSalidasCafe::query()
		->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
		->join('000_catalogo_empresas as cc','cc.id','003_entradas_salidas_cafe.id_catalogo_conductor')
		->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
		->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
		->whereBetween('fecha_ticket',[$fecha_inicial, $fecha_final])
		->where('003_entradas_salidas_cafe.tipo_operacion','=',1);

		$base_salida=EntradasSalidasCafe::query()
		->join('000_tipos_cafe','000_tipos_cafe.id','=','003_entradas_salidas_cafe.id_tipo_cafe')
		->join('000_catalogo_empresas as cp','cp.id','003_entradas_salidas_cafe.id_catalogo_cliente')
		->join('000_centros_costos','000_centros_costos.id','=','003_entradas_salidas_cafe.id_centro_costo')
		->whereBetween('fecha_ticket',[$fecha_inicial, $fecha_final])
		->where('003_entradas_salidas_cafe.tipo_operacion','=',2);

		$entradas_cafe=$base_entrada->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
					->get();
					
        $salidas_cafe=$base_salida->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','003_entradas_salidas_cafe.created_at as fecha_ticket_salida')
					 ->get();
		//si reporte no incluye coffeworld
	    if($tipo_reporte==2){
			$entradas_cafe=$base_entrada->whereNotIn('cp.nit', [901383798])->select('000_tipos_cafe.*','003_entradas_salidas_cafe.*','cp.nombre','cc.nombre as conductor','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id')
			->get();
			
             $salidas_cafe=$base_salida->whereNotIn('cp.nit', [901383798])->select('*','003_entradas_salidas_cafe.id as entradas_salidas_cafe_id','cp.nombre','003_entradas_salidas_cafe.created_at as fecha_ticket_salida')
			 ->get();
		}
		$factor_aportante=0;
		$factor_aportante_salida=0;
		$factor_liquidacion=0;
		$total_kilos_netos=0;
		$total_kilos_netos_salidas=0;
		$total_factor_aportante=0;
		$total_factor_aportante_salida=0;
		//consultar sin hay saldo anterior
		$saldo=FactorSaldos::where('fecha_saldo',$fecha_saldo)->get();
		$base_total_kilos_netos=EntradasSalidasCafe::where('tipo_operacion','=',1)
		->where('factor','!=',0)
		->whereBetween('fecha_ticket',[$fecha_inicial, $fecha_final]);
   
		$total_kilos_netos=$base_total_kilos_netos->selectRaw('sum(peso_neto) as total')->value('total');
		$id_cofeeworld=CatalogoEmpresas::whereIn('nit',[901383798])->select('id')->get();
		if($tipo_reporte==2){
			$total_kilos_netos=$base_total_kilos_netos->whereNotIn('id_catalogo_proveedor',$id_cofeeworld)->selectRaw('sum(peso_neto) as total')->value('total');
			$saldo=FactorSaldos::where('fecha_saldo',$fecha_saldo)->where('tipo_saldo',1)->get();

		}
		 $saldo_ant=0;
		 $factor_saldo=0;
		 $factor_aportante_saldo=0;
		 $total_factor_aportante=0;
		 $total_factor_aportante_saldo=0;
		 //si hay saldo
		 if(count($saldo)>0){
		   $total_kilos_netos+=$saldo[0]->kilos;
		   $saldo_ant=$saldo[0]->kilos;
		   $factor_saldo=$saldo[0]->factor;
		   $total_factor_aportante=round($saldo[0]->kilos/$total_kilos_netos*$saldo[0]->factor,2);
		   $total_factor_aportante_saldo=round($saldo[0]->kilos/$total_kilos_netos*$saldo[0]->factor,2);
		  // $total_factor_aportante+=$factor_aportante_saldo;
		 }
		/********corte */
		$salidas_liquidadas=Liquidaciones::where('id_salida_cafe','!=',null)->select('id_salida_cafe')->get();
		
		$base_total_kilos_netos_salidas=EntradasSalidasCafe::whereIn('id',$salidas_liquidadas)
		->whereBetween('fecha_ticket',[$fecha_inicial, $fecha_final]);
		
		$total_kilos_netos_salidas=$base_total_kilos_netos_salidas->selectRaw('sum(peso_neto) as total')->value('total');

		if($tipo_reporte==2){
			$total_kilos_netos_salidas=$base_total_kilos_netos_salidas->whereNotIn('id_catalogo_cliente', $id_cofeeworld)->selectRaw('sum(peso_neto) as total')->value('total');
		}

		try {
            foreach($entradas_cafe as $rows){
				$factor_aportante=round($rows->peso_neto/$total_kilos_netos*$rows->factor,2);
				$rows->factor_aportante=$factor_aportante;
				$total_factor_aportante+=$factor_aportante;
				
            }
        } catch (\Throwable $th) {
            return $rows;
        }
		
	
		try {
            foreach($salidas_cafe as $rows){
				$factor_liquidacion=Liquidaciones::where('id_salida_cafe',$rows->entradas_salidas_cafe_id)->value('factor_descuento');
                
				if($factor_liquidacion!=null){
					$rows->factor_liquidacion=$factor_liquidacion;
					$factor_aportante_salida=round($rows->peso_neto/$total_kilos_netos_salidas*$factor_liquidacion, 2);
				    $rows->factor_aportante=$factor_aportante_salida;
				    $total_factor_aportante_salida+=$factor_aportante_salida;
				}else{
					$rows->factor_liquidacion=0;
					$rows->factor_aportante=0;
				}
			}
        } catch (\Throwable $th) {
           // return $rows;
        }  
		$total_saldo=$total_kilos_netos-$total_kilos_netos_salidas;
		if($total_saldo<0){
			$total_saldo=0;
		}
	   
		$saldo=FactorSaldos::where('fecha_saldo',$fecha_final)->select('id')->value('id');

		if($saldo>0){
				$saldo=FactorSaldos::find($saldo);
				$saldo->fecha_saldo=$fecha_final;
				$saldo->kilos=$total_saldo;
				$saldo->factor=$total_factor_aportante;
				if($tipo_reporte==2){
					$saldo->tipo_saldo=1;
				}
				$saldo->save();
			//si no esta se crea
		}else{
			$saldo=new FactorSaldos;
			$saldo->fecha_saldo=$fecha_final;
			$saldo->kilos=$total_saldo;
			$saldo->factor=$total_factor_aportante;
			if($tipo_reporte==2){
				$saldo->tipo_saldo=1;
			}
			$saldo->save();
		} 
		return view('cafe.reportes.corte_mensual',compact('salidas_cafe','entradas_cafe','fecha_inicial','fecha_final',
		'excel','factor_aportante','factor_aportante_salida','total_kilos_netos','total_kilos_netos_salidas',
		'total_factor_aportante','total_factor_aportante_salida','saldo_ant','factor_saldo','factor_aportante_saldo','imagen','total_factor_aportante_saldo'));
		
		}

    }
