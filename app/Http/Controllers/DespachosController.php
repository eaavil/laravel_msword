<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despachos;
use App\Models\DespachosDetalle;
use App\Models\EntradasSalidasCafe;
use App\Models\TiposCafe;
use App\Models\CatalogoEmpresas;
use App\Models\ParametrosModulos;
use App\Models\CentrosCosto;
use Yajra\Datatables\Datatables;
use App\Models\Liquidaciones;

class DespachosController extends Controller
{
    //
    public function listado_salidas_por_despachar(Request $request){
		$titulo = 'Salidas de Cafe para Despachar';
		$modulo = 'Despachos';
		$seccion = 'Salidas';
		$clientes = CatalogoEmpresas::where('es_cliente',1)->get();
		$consecutivo = ParametrosModulos::find(16);
		$numeracion = ParametrosModulos::find(15);

		//importante
		if($request->data_id!=null){
			$adicional= ['id'=>$request->data_id,'numero'=>$request->data_number,'peso_neto'=>$request->data_weight];
		}else{
			$adicional = [];
		}

		return view('despachos.listado_pendientes',compact('titulo','modulo','seccion','consecutivo','numeracion','clientes','adicional'));
    }

    public function listado_salidas_por_despachar_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
		    $id_prov=$_GET['id_prov'];
       }

	   if($modo==1){
		if($request->id_prov==null){
			$operaciones = 		Datatables::of(
								EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)
								->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->where('despachado',0)
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								)->make();
		}else{
			$operaciones = 		Datatables::of(
								EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)
								->where('despachado',0)
								->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->where('id_catalogo_cliente',$request->id_prov)
								->whereColumn('peso_neto','>','despachado')
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								)->make();
		}
	}else{
		if($id_prov==-1){
			$operaciones = 		Datatables::of(
								EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)
								->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
                                 ->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->where('despachado',0)
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								)->make();
		}else{
			$operaciones = 		Datatables::of(
								EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)
								->where('despachado',0)
								->whereBetween('fecha_ticket', [$fecha_inicial.' 00:00',$fecha_final.' 23:59'])
                                ->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->where('id_catalogo_cliente',$request->id_prov)
								->whereColumn('peso_neto','>','despachado')
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								)->make();
		}

	}
		return $operaciones;
    }
    public function listado_despachos(){
		$titulo = 'Despachos de Cafe';
		$modulo = 'Despachos';
		$seccion = 'Registros';
		$session= session('role_id');
		$clientes=CatalogoEmpresas::where('es_cliente',1)->select('id','nombre')->get();
		$despachos = Despachos::all();
		$salidas=EntradasSalidasCafe::where('tipo_operacion',2)->get();
		return view('despachos.listado',compact('titulo','modulo','seccion','despachos','clientes','salidas','session'));
    }

	public function listado_despachos_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
			$id_prov=$_GET['id_prov'];
       }
        if($modo==1){
			if($request->id_prov==null){
					$operaciones =Despachos::query()
					->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
					->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
					->where('pendiente','!=',2)
					->select('*','003_despachos.id as idx')
               ;
			}else{
				$operaciones =Despachos::query()
				->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
				->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
				->where('pendiente','!=',2)
				->where('000_catalogo_empresas.id',$request->id_prov)
				->select('*','003_despachos.id as idx')
               ;
		    }      
		}else{
			if($id_prov==-1){
					$operaciones =Despachos::query()
					->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
					->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
					->whereBetween('003_despachos.fecha',[$request->fecha_inicial.' 00:00',$request->fecha_final.' 23:59'])
					->where('pendiente','!=',2)
					->select('*','003_despachos.id as idx')			
				;
			} else{ 
					$operaciones =Despachos::query()
						->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
						->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
						->where('pendiente','!=',2)
						->whereBetween('003_despachos.fecha',[$request->fecha_inicial.' 00:00:00',$request->fecha_final.' 23:59:59'])
						->where('000_catalogo_empresas.id',$request->id_prov)
						->select('*','003_despachos.id as idx')
					;
			    }
		    }
			return Datatables::of($operaciones)->make();
	}

	public function detalle_despacho_data($id){
		$operaciones = DespachosDetalle::join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos_detalle.id_entrada')
		->join('000_catalogo_empresas', '000_catalogo_empresas.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
		->where('id_despacho',$id)
		->select(\DB::raw('*,003_despachos_detalle.id as idx,003_despachos_detalle.factor as factorx'))
		->get();
		return $operaciones;
	}

	public function procesar_despacho_pendiente(Request $request){
		$pendientes = 0;
		\DB::beginTransaction();
		try{

			if($request->type==0){
				$despacho = Despachos::find($request->id_despacho);
				$despacho->pendiente = 2;
				$despacho->finished_at = date('Y-m-d h:i:s');
				$despacho->save();
				\DB::commit();
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' Procesado Exitosamente','type'=>'success'));
			}



			foreach($_POST['resultado'] as $index => $registro){
				$detalle = DespachosDetalle::find($_POST['id'][$index]);
				$detalle->factor = $_POST['factor'][$index];
				$detalle->valor =$_POST['resultado'][$index];
				//return $_POST['pendiente'][$_POST['id'][$index]];
				if($_POST['pendiente'][$_POST['id'][$index]]==1){
					$detalle->definitivo=$_POST['pendiente'][$_POST['id'][$index]]; 
					$detalle->save();
					
					//	$pendientes++;
				}
				$detalle->definitivo = $_POST['pendiente'][$_POST['id'][$index]];
				$detalle->save();
			}

			$despacho = Despachos::find($request->id_despacho);
			$despacho->factor_promedio = $request->porcentaje_factor;
			$despacho->factor_promedio_referencia = $request->porcentaje_factor_referencia;
			if($pendientes>0){
				$despacho->pendiente = 1;
			}else{
			    $despacho->pendiente = 2;
			    $despacho->finished_at = date('Y-m-d h:i:s');
			}

			$despacho->save();

			\DB::commit();
			return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' Procesado Exitosamente','type'=>'success'));
		}catch(\Exception $e){
			\DB::rollback();
			if($e->getCode()==23000){
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado, Consecutivo de Despacho ya registrado','type'=>'error'));
			}else{
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado '.$e->getMessage(),'type'=>'error'));
			}
		}
	}

    public function registrar_despacho(Request $request){
		$request->validate([
			'numero'=>['unique:003_despachos,numero,NULL,id,deleted_at,NULL'],
			],[
				'numero.unique'=> 'Numero de liquidacion repetido',
			]
			);
		$pendientes = 0;
		\DB::beginTransaction();
		try{
			$despacho = new Despachos;
			$despacho->fecha = date('Y-m-d h:i:s',strtotime('now'));
			$despacho->numero = $request->numero;
			$despacho->id_salida = $request->id_salida;
			$despacho->kilogramos = $request->kilogramos;
			$despacho->factor_promedio = $request->factor_promedio;
			$despacho->factor_promedio_referencia = $request->factor_promedio_referencia;
			$despacho->valor_despacho = $request->valor_despacho;
			$despacho->save();

			$salida = EntradasSalidasCafe::find($request->id_salida);
			$salida->despachado = 1;
			$salida->save();

			foreach($_POST['entrada'] as $index => $registro){

				$detalle = new DespachosDetalle;
				$detalle->id_despacho = $despacho->id;
				$detalle->id_entrada = $_POST['entrada'][$index];
				$detalle->kilogramos = $_POST['kilos'][$index];
				$detalle->factor = $_POST['factor'][$index];
				$detalle->valor =$_POST['resultado'][$index];
				if($_POST['factor'][$index]==0){
					$detalle->definitivo = 1;
					$pendientes++;
				}else{
					$detalle->definitivo = 0;
				}
				$detalle->save();

				$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}

			if($pendientes>0){
				$despacho->pendiente = 1;
			}else{
				$despacho->pendiente = 0;
			}

			$despacho->save();

			\DB::commit();
			$this->incrementar_contador_despacho();
			return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' Registrado Exitosamente','type'=>'success'));
		}catch(\Exception $e){
			\DB::rollback();
			if($e->getCode()==23000){
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado, Consecutivo de Despacho ya registrado','type'=>'error'));
			}else{
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado '.$e->getMessage(),'type'=>'error'));
			}

		}

    }

    public function actualizar_despacho($id){

    }

    public function eliminar_despacho($id){
		//elimino el registro
		$despacho = Despachos::find($id);
		Despachos::find($id)->delete();
		//busco sus registros detalle
		$despacho_detalle = DespachosDetalle::where('id_despacho',$id)->get();

		//reverso el estado de la salida asociada
		$salida = EntradasSalidasCafe::find($despacho->id_salida);
		$salida->despachado = 0;
		$salida->save();
		//itero cada registro detalle encontrado
		foreach ($despacho_detalle as $key => $value) {
			//disminuyo lo despachado en la entrada asociada al despacho
			$entrada = EntradasSalidasCafe::find($value->id_entrada);
			$entrada->despachado = $entrada->despachado - $value->kilogramos;
			$entrada->save();
			//elimino el registro detalle del despacho
			$despacho = DespachosDetalle::find($value->id)->delete();
		}
		return redirect()->back()->with('result',array('message'=>'Despacho Eliminado Exitosamente','type'=>'success'));
    }

    public function obtener_informacion_salida($id){

    }

	public function obtener_entradas_pendientes(){

		$operaciones = EntradasSalidasCafe::query()
		->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_proveedor')
		->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
		->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
		->where('tipo_operacion',1)
		->whereColumn('peso_neto','>','despachado')
		->select('003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto','003_entradas_salidas_cafe.despachado','003_entradas_salidas_cafe.mezclado','nombre')
		->get();

		return $operaciones;
	}

    public function obtener_informacion_despacho($id){

    }

	private function incrementar_contador_despacho(){
		$contador = ParametrosModulos::find(15);
		$contador->parametro = $contador->parametro+1;
		$contador->save();
	}

	private function adicionar_cantidad_despachada_entrada($id,$cantidad){
		$contador = EntradasSalidasCafe::find($id);
		$contador->despachado = $contador->despachado+$cantidad;
		$contador->save();
	}

	public function procesar_reportes(Request $request){
		
        if($request->tipo_reporte==1){
			return $this->reporte_salidas_por_despachar_data($request);
		}
		if($request->tipo_reporte==2){
			if($request->c03==-1){
				return $this->reporte_fecha_despachos($request->c01,$request->c02,$request->c04,$request->c03);
			}elseif($request->c03!=-1){
				return $this->reporte_despacho($request->c01,$request->c02,$request->c03,$request->c04);
			}
	    }
		if($request->tipo_reporte==3){
			return $this->reporte_despachos_culminados_data($request);
		}
	}

	public function reporte_fecha_despachos($fecha_inicial,$fecha_final,$tipo_archivo,$salida){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		if($salida==-1){
			$data_reporte = Despachos::whereBetween('finished_at',[$fecha_inicial.' 00:00:00',$fecha_final." 23:59:00"])->get();
	    }else{
			$data_reporte = Despachos::where('id_salida',$salida)->whereBetween('finished_at',[$fecha_inicial.' 00:00:00',$fecha_final." 23:59:00"])->get();
	    }
		if(count($data_reporte)>0){

			foreach($data_reporte as $registros){
				$detalles = DespachosDetalle::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','003_despachos_detalle.id_entrada')
							->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
							->where('id_despacho',$registros->id)
							->select(\DB::raw('*,003_despachos_detalle.kilogramos as kilogramos_despacho,003_despachos_detalle.factor as factor_despacho,003_despachos_detalle.valor as factor_promedio_despacho'))
							->get();
				$enta = DespachosDetalle::where('id_despacho',$registros->id)->get();
				$cliente=EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
				->where('003_entradas_salidas_cafe.id',$registros->id_salida)
				->select('000_catalogo_empresas.nombre','003_entradas_salidas_cafe.numero_ticket')
				->get();
				         
				$registros->detalle = $detalles;
				$registros->cliente_despacho= $cliente;

			}
			if($tipo_archivo==1){
				return view('despachos.reportes.reporte_fechas_excel',compact('fecha_inicial','fecha_final','data_reporte'));
			}else{
				return view('despachos.reportes.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','imagen'));
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();
			}
             
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function reporte_despacho($fecha_inicial,$fecha_final,$id,$tipo_archivo){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));

			$data_reporte = Despachos::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','003_despachos.id_salida')
				->whereBetween('finished_at',[$fecha_inicial.' 00:00:00',$fecha_final." 23:59:00"])
				->where('003_entradas_salidas_cafe.id_catalogo_cliente',$id)->select('003_despachos.*')->get();
	  
       
		if(count($data_reporte)>0){

			foreach($data_reporte as $registros){
				$detalles = DespachosDetalle::join('003_entradas_salidas_cafe','003_entradas_salidas_cafe.id','003_despachos_detalle.id_entrada')
							->join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_proveedor')
							->where('id_despacho',$registros->id)
							->select(\DB::raw('*,003_despachos_detalle.kilogramos as kilogramos_despacho,003_despachos_detalle.factor as factor_despacho,003_despachos_detalle.valor as factor_promedio_despacho'))
							->get();
				$cliente=EntradasSalidasCafe::join('000_catalogo_empresas','000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
				->where('003_entradas_salidas_cafe.id',$registros->id_salida)
				->select('000_catalogo_empresas.nombre')
				->get();
				$enta = DespachosDetalle::where('id_despacho',$registros->id)->get();
				$registros->detalle = $detalles;
				$registros->cliente_despacho= $cliente;
			}
			if($tipo_archivo==1){
				return view('despachos.reportes.reporte_fechas_excel',compact('fecha_inicial','fecha_final','data_reporte'));
			}else{
				return view('despachos.reportes.reporte_fechas',compact('fecha_inicial','fecha_final','data_reporte','imagen'));
				$pdf = \App::make('dompdf.wrapper');
				$pdf->setPaper('a4', 'landscape');
				$pdf->loadView('cafe.reportes.entradas.reporte_fechas',compact('fecha_inicial','fecha_final','datos','imagen'));
				return $pdf->stream();
			}
             
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
	}

	public function listado_despachos_culminados(){
		$titulo = 'Despachos culminados';
		$modulo = 'Despachos';
		$seccion = 'Salidas';
		$session= session('role_id');
		return view('despachos.listado_culminados',compact('titulo','modulo','seccion','session'));
	}
	
	public function listado_despachos_culminados_data(Request $request){
		$modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
		    $id_prov=$_GET['id_prov'];
       }
        if($modo==1){
		
		$despachos=Despachos::query()
						->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '003_despachos.id_salida')
						->where('pendiente',2)
						->select('*','003_despachos.id as idx')
						->get();
		}else{
			$despachos=Despachos::query()
						->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '003_despachos.id_salida')
						->whereBetween('003_despachos.fecha',[$request->fecha_inicial.' 00:00',$request->fecha_final.' 23:59'])
                        ->where('pendiente',2)
						->select('*','003_despachos.id as idx')
						->get();
		}
		$definitivos=DespachosDetalle::where('definitivo',1)->select('id_despacho')->get();
		foreach($despachos as $rows){
			$definitivo=0;
			foreach($definitivos as $rowsx){
				if($rows->idx==$rowsx->id_despacho){
						$definitivo++;
				}
			}
			if($definitivo>0){
				$rows->definitivo=1;
			}else{
				$rows->definitivo=0; 
			}
		
			$rows->factor_liquidacion=Liquidaciones::where('id_salida_cafe',$rows->id)->select('factor')->value('factor');
			$rows->descuento_factor=Liquidaciones::where('id_salida_cafe',$rows->id)->select('descuento_factor')->value('descuento_factor');

		}
		
		return 	Datatables::of($despachos)->make();
    }

	public function reporte_salidas_por_despachar_data(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02; 
		if($request->c03==-1){
			$operaciones = EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)
								->whereBetween('fecha_ticket', [$request->c01.' 00:00',$request->c02.' 23:59'])
                                ->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->whereColumn('peso_neto','>','despachado')
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								->get();
		}else{
			$operaciones = EntradasSalidasCafe::query()
								->join('000_catalogo_empresas as ce', 'ce.id', '=', '003_entradas_salidas_cafe.id_catalogo_cliente')
								->join('000_centros_costos', '000_centros_costos.id', '=', '003_entradas_salidas_cafe.id_centro_costo')
								->join('000_catalogo_empresas as cex', 'cex.id', '=', '003_entradas_salidas_cafe.id_catalogo_conductor')
								->join('000_tipos_cafe', '000_tipos_cafe.id', '=', '003_entradas_salidas_cafe.id_tipo_cafe')
								->where('tipo_operacion',2)								
								->whereBetween('fecha_ticket', [$request->c01.' 00:00',$request->c02.' 23:59'])
								->where('despachado',0)
								->where([
									['tipo_cafe','!=','pasilla'],
								    ['tipo_cafe','!=','corriente']
								])
								->where('id_catalogo_cliente',$request->c03)
								->whereColumn('peso_neto','>','despachado')
								->select('ce.nombre','003_entradas_salidas_cafe.id','003_entradas_salidas_cafe.numero_ticket','003_entradas_salidas_cafe.factor','000_centros_costos.descripcion as centros','000_tipos_cafe.tipo_cafe','003_entradas_salidas_cafe.fecha_ticket','003_entradas_salidas_cafe.peso_neto')
								->get();
		}

		if(count($operaciones)>0){
			$excel=$request->c04;
	 return view('despachos.reportes.reporte_pendientes_excel',compact('operaciones','excel','fecha_inicial','fecha_final','imagen'));
	 }else{
			$datos['registros']=0;
		 return view('cafe.reportes.no-reporte');
	 }	
    }
	
	public function reporte_despachos_culminados_data(Request $request){
		$imagen = base64_encode(\Storage::get('logo_actual.png'));
		$fecha_inicial=$request->c01;
		$fecha_final=$request->c02; 
		if($request->c03==-1){
			$operaciones=Despachos::query()
			->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
			->whereBetween('finished_at', [$request->c01.' 00:00',$request->c02.' 23:59'])
			->where('pendiente',2)
			->select('*','003_despachos.id as idx','003_entradas_salidas_cafe.id as id_salida_cafe')
			->orderBy('000_catalogo_empresas.nombre')
			->get();
		}else{
			$operaciones=Despachos::query()
			->join('003_entradas_salidas_cafe', '003_entradas_salidas_cafe.id', '=', '003_despachos.id_salida')
			->join('000_catalogo_empresas', '000_catalogo_empresas.id','003_entradas_salidas_cafe.id_catalogo_cliente')
			->whereBetween('finished_at', [$request->c01.' 00:00',$request->c02.' 23:59'])
			->where('id_catalogo_cliente',$request->c03)
			->where('pendiente',2)
			->select('*','003_despachos.id as idx','003_entradas_salidas_cafe.id as id_salida_cafe')
			->get();

		}
		$tamaño=0;
		$data_reporte=[];
		foreach($operaciones as $rows){
			$rows->factor_liquidacion=Liquidaciones::where('id_salida_cafe',$rows->id_salida_cafe)->select('factor')->value('factor');
			$rows->descuento_factor=Liquidaciones::where('id_salida_cafe',$rows->id_salida_cafe)->select('descuento_factor')->value('descuento_factor');
            $data_reporte[$rows->nombre]['proveedor']['info']= $rows->nombre;
			$data_reporte[$rows->nombre]['proveedor']['data'][]=$rows;
		}
		if(count($operaciones)>0){
			   $excel=$request->c04;
		return view('despachos.reportes.reporte_culminados_excel',compact('data_reporte','excel','fecha_inicial','fecha_final','imagen'));
		}else{
			   $datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}	
    }

	
   
}
