<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Bancos;
use App\Models\GirosAnticipos;
use App\Models\Contratos;
use App\Models\CatalogoEmpresas;
use App\Models\CuentasBancos;
use App\Models\BancosMovimiento;
use Yajra\Datatables\Datatables;

class GirosAnticiposController extends Controller
{
    /*
	|--------------------------------------------------------------------------
	| Giros
	|--------------------------------------------------------------------------
    */
    public function listado_giros(){
        $titulo = 'Listado Giros a Contratos';
		$modulo = 'Giros y Anticipos';
		$seccion = 'Giros';
        $registros = GirosAnticipos::where('tipo_operacion',1)->get();
        $session= session('role_id');
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->orderBy('nit','asc')->get();
        $facturador = CatalogoEmpresas::where('es_propietario',1)->orderBy('nit','asc')->get();
        $cuentas = CuentasBancos::orderBy('created_at','asc')->get();

        foreach($cuentas as $reg){
            $banco = Bancos::find($reg->id_banco);
            $reg->banco = $banco;
        }

        foreach($registros as $rows){
            $cuenta = CuentasBancos::find($rows->id_cuenta_banco);
            $cliente = CatalogoEmpresas::find($rows->id_catalogo);
			try{
				$banco = Bancos::find($cuenta->id_banco);
			}catch(\Exception $e){
				$banco = null;
			}
            $rows->cuenta = $cuenta;
            $rows->cliente = $cliente;
            $rows->banco = $banco;
        }


        return view('giros_anticipos.listado_giros',compact('registros','titulo','modulo','seccion','proveedores','cuentas','session','facturador'));
    }
    public function listado_giros_data(){
        $modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
       }
        if($modo==1){
        $operaciones=Datatables::of(
            GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',1)
            ->where('000_catalogo_empresas.es_proveedor','=',1)
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')     
            
        )->make();
    }else{
        $operaciones=Datatables::of(
            GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',1)
            ->where('000_catalogo_empresas.es_proveedor','=',1)
            ->where('000_catalogo_empresas.es_proveedor','=',1)
            ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')     
            
        )->make();
    }
        return $operaciones;
    }
    public function registrar_giro(Request $request){

        $registro = new GirosAnticipos;
        $registro->tipo_operacion = 1;
        $registro->valor = str_replace('.','',$request->c04);
        $registro->id_catalogo = $request->c01;
        $registro->id_cuenta_banco = $request->c03;
        $registro->fecha_giro = $request->c05;
        $registro->forma_pago = $request->c07;
        $registro->numero_cheque = $request->c06;
        $registro->id_facturador = $request->c08;
		//return floatval(str_replace('$','',$request->c04));
        $registro->save();
        $encontrado=BancosMovimiento::where('numero','GIR'.$registro->id)->select('numero')->value('numero');
        if($encontrado==null){
            $request->validate([
                'GIR'.'id'=>['unique:000_bancos_movimiento,numero,NULL,id'],//deleted_at,NULL
              ],[
                  'id.unique'=> 'Numero de giro repetido',
              ]
            );
        $registrom = new BancosMovimiento;
        $registrom->numero = 'GIR'.$registro->id;
        $registrom->tipo_operacion = 2;
        $registrom->fecha_operacion = $request->c05;
        $registrom->forma_pago = $request->c07;
        $registrom->id_cuenta_banco = $request->c03;
        $registrom->descripcion = 'REGISTRO DESDE GIRO';
        $registrom->numero_factura_remision = 'N/A';
        $registrom->valor = str_replace('.','',$request->c04);
        $registrom->modo = 2;
        $registrom->id_tercero = $request->c01;
        $registrom->save();
        }
        return redirect()->route('giros.listado')->with('result',array('message'=>'El Registro del Giro se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_giro($id){
        $registro = GirosAnticipos::find($id);
        return json_encode($registro);
    }
    public function eliminar_giro($id){

        $registro = GirosAnticipos::find($id);
        GirosAnticipos::find($id)->delete();
        //ELIMINAR REGISTRO DE MOVIMIENTO BANCARIO
        BancosMovimiento::where('numero','GIR'.$id)->delete();

        return redirect()->route('giros.listado')->with('result',array('message'=>'El Giro se elimino Exitosamente','type'=>'success'));
    }
	/*
	|--------------------------------------------------------------------------
	| Anticipos
	|--------------------------------------------------------------------------
    */
    public function listado_anticipos(){
        $titulo = 'Listado Anticipos a Contratos';
		$modulo = 'Giros y Anticipos';
		$seccion = 'Anticipos';
        $session= session('role_id');
        $registros = GirosAnticipos::where('tipo_operacion',2)->get();
        
        foreach($registros as $rows){
            $cuenta = CuentasBancos::find($rows->id_cuenta_banco);
            $cliente = CatalogoEmpresas::find($rows->id_catalogo);
            $banco = Bancos::find($cuenta->id_banco);
            $rows->cuenta = $cuenta;
            $rows->cliente = $cliente;
            $rows->banco = $banco;
        }

        $clientes = CatalogoEmpresas::where('es_cliente',1)->orderBy('nit','asc')->get();
        $cuentas = CuentasBancos::orderBy('created_at','asc')->get();
        foreach($cuentas as $reg){
            $banco = Bancos::find($reg->id_banco);
            $reg->banco = $banco;
        }

        return view('giros_anticipos.listado_anticipos',compact('registros','titulo','modulo','seccion','clientes','cuentas','session'));
    }

    public function registrar_anticipo(Request $request){
        $registro = new GirosAnticipos;
        $registro->tipo_operacion = 2;
        $registro->valor = str_replace('.','',$request->c04);
        $registro->id_catalogo = $request->c01;
        $registro->id_cuenta_banco = $request->c03;
        
        $registro->fecha_giro = $request->c05;
        $registro->forma_pago = $request->c07;
        $registro->numero_cheque = $request->c06;
        
        $registro->save();

        //REGISTRO DE MOVIMIENTO BANCARIO
        $encontrado=BancosMovimiento::where('numero','ANT'.$registro->id)->select('numero')->value('numero');
        if($encontrado==null){
            $request->validate([
                'ANT'.'id'=>['unique:000_bancos_movimiento,numero,NULL,id'],//deleted_at,NULL
              ],[
                  'id.unique'=> 'Numero de ANTICIPO repetido',
              ]
            );
            $registrom = new BancosMovimiento;
            $registrom->numero = 'ANT'.$registro->id;
            $registrom->tipo_operacion = 1;
            $registrom->fecha_operacion = $request->c05;
            $registrom->forma_pago = $request->c07;
            $registrom->id_cuenta_banco = $request->c03;
            $registrom->descripcion = 'REGISTRO DESDE ANTICIPO';
            $registrom->numero_factura_remision = 'N/A';
            $registrom->valor = str_replace('.','',$request->c04);
            $registrom->modo = 1;
            $registrom->id_tercero = $request->c01;
            $registrom->save();
        }
        return redirect()->route('anticipos.listado')->with('result',array('message'=>'El Registro del Anticipo se realizo Exitosamente','type'=>'success'));
    }

    public function obtener_anticipo($id){
        $registro = GirosAnticipos::find($id);
        return json_encode($registro);
    }

    public function eliminar_anticipo($id){

        //$registro = GirosAnticipos::find($id);
        GirosAnticipos::find($id)->delete();
        //ELIMINAR REGISTRO DE MOVIMIENTO BANCARIO
        BancosMovimiento::where('numero','ANT'.$id)->delete();
  
        return redirect()->route('anticipos.listado')->with('result',array('message'=>'El Anticipo se elimino Exitosamente','type'=>'success'));
    }

	/*
	|--------------------------------------------------------------------------
	| Reporte de Giros
	|--------------------------------------------------------------------------
    */
    public function procesar_reporte_giros(Request $request){
		if($request->c03==-1){
			return $this->reporte_giro_fecha($request->c01,$request->c02,$request->c04);
		}elseif($request->c03!=-1){
			return $this->reporte_giro_fecha_proveedor($request->c01,$request->c02,$request->c03,$request->c04);
		}
	}

    public function reporte_giro_fecha($fecha_inicial,$fecha_final,$tipo_archivo){

        $registros = CatalogoEmpresas::where('es_proveedor',1)->get();
        foreach($registros as $rows){
            $giros = GirosAnticipos::where('tipo_operacion',1)
            ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
            ->where('id_catalogo', $rows->id)
            ->get();
            $rows->giros = $giros;
        }
		
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
		if(count($registros)>0){
             
          // return View('giros_anticipos.reportes.giros.reporte_proveedor',compact('registros','fecha_inicial','fecha_final'));
            if($tipo_archivo==1){
                $pdf = \App::make('dompdf.wrapper');
                $pdf->setPaper('a4', 'landscape');
                $pdf->loadView('giros_anticipos.reportes.giros.reporte_proveedor',compact('registros','fecha_inicial','fecha_final','imagen'));
                return $pdf->stream();
            }else{
                return View('giros_anticipos.reportes.giros.reporte_proveedor_excel',compact('registros','fecha_inicial','fecha_final'));
            }
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }

    public function reporte_giro_fecha_proveedor($fecha_inicial,$fecha_final,$id_proveedor,$tipo_archivo){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));

        $registros = CatalogoEmpresas::where('id',$id_proveedor)->get();
        foreach($registros as $rows){
            $giros = GirosAnticipos::where('tipo_operacion',1)
            ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
			->where('id_catalogo', $rows->id)
            ->get();
            $rows->giros = $giros;
        }

		if(count($registros)>0){
           
            if($tipo_archivo==1){
                $pdf = \App::make('dompdf.wrapper');
                $pdf->setPaper('a4', 'landscape');
                $pdf->loadView('giros_anticipos.reportes.giros.reporte_proveedor',compact('registros','fecha_inicial','fecha_final','imagen'));
                return $pdf->stream();
            }else{
                return View('giros_anticipos.reportes.giros.reporte_proveedor_excel',compact('registros','fecha_inicial','fecha_final'));
            }

		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }

	/*
	|--------------------------------------------------------------------------
	| Reporte de Anticipos
	|--------------------------------------------------------------------------
    */
    public function procesar_reporte_anticipos(Request $request){
    
    if($request->c03==-1){
		return $this->reporte_anticipo_fecha($request->c01,$request->c02,$request->c04);
	}elseif($request->c03!=-1){
		return $this->reporte_anticipo_fecha_proveedor($request->c01,$request->c02,$request->c03,$request->c04);
	}
    }
    public function listado_anticipos_data(){

        $modo=1;
        if(isset($_GET['modo'])){
            $modo = $_GET['modo'];
            $fecha_inicial = $_GET['fecha_inicial'];
            $fecha_final = $_GET['fecha_final'];
       }
        if($modo==1){
        return Datatables::of(
            GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',2)
            ->where('000_catalogo_empresas.es_cliente','=',1)
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')  
        )->make();
        }else{
            return Datatables::of(
                GirosAnticipos::query()
                ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
                ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
                ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
                ->where('002_giros_anticipos.tipo_operacion','=',2)
                ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
                ->where('000_catalogo_empresas.es_cliente','=',1)
                ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
                '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
                '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
                '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
                '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
                '000_bancos.entidad')  
            )->make(); 
        }
    }

    public function reporte_anticipo_fecha($fecha_inicial,$fecha_final,$tipo_archivo){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $registros = CatalogoEmpresas::where('es_cliente',1)->get();
        foreach($registros as $rows){
            $giros = GirosAnticipos::where('tipo_operacion',2)
            ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
			->where('id_catalogo', $rows->id)
            ->get();
            $rows->giros = $giros;
        }

		if(count($registros)>0){
          if($tipo_archivo==1){
           return View('giros_anticipos.reportes.giros.reporte_proveedor_anticipo',compact('registros','fecha_inicial','fecha_final','imagen'));

			$pdf = \App::make('dompdf.wrapper');
			$pdf->setPaper('a4', 'landscape');
			$pdf->loadView('giros_anticipos.reportes.giros.reporte_proveedor_anticipo',compact('registros','fecha_inicial','fecha_final','imagen'));
			return $pdf->stream();
          }else{
            return View('giros_anticipos.reportes.giros.reporte_proveedor_anticipo_excel',compact('registros','fecha_inicial','fecha_final')); 
          }
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }

    public function reporte_anticipo_fecha_proveedor($fecha_inicial,$fecha_final,$id_proveedor,$tipo_archivo){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $registros = CatalogoEmpresas::where('id',$id_proveedor)->get();
        foreach($registros as $rows){
            $giros = GirosAnticipos::where('tipo_operacion',2)
            ->whereBetween('fecha_giro', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])
			->where('id_catalogo', $rows->id)
            ->get();
            $rows->giros = $giros;
        }

		if(count($registros)>0){
           if($tipo_archivo==1){
                return View('giros_anticipos.reportes.giros.reporte_proveedor_anticipo',compact('registros','fecha_inicial','fecha_final','imagen'));

			   $pdf = \App::make('dompdf.wrapper');
			    $pdf->setPaper('a4', 'landscape');
			    $pdf->loadView('giros_anticipos.reportes.giros.reporte_proveedor_anticipo',compact('registros','fecha_inicial','fecha_final','imagen'));
			    return $pdf->stream();
           }else{
            return View('giros_anticipos.reportes.giros.reporte_proveedor_anticipo_excel',compact('registros','fecha_inicial','fecha_final'));
           }
		}else{
			$datos['registros']=0;
			return view('cafe.reportes.no-reporte');
		}
    }
    
    public function reporte_giros_listado(Request $request){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
         //dump($request->c03);
        if($request->c03==-1){
        $consulta=GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',1)
            ->where('000_catalogo_empresas.es_proveedor','=',1)
            ->whereBetween('fecha_giro',[$fecha_inicial,$fecha_final])
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')
            ->get();
        }else{
            $consulta=GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',1)
            ->where('000_catalogo_empresas.es_proveedor','=',1)
            ->where('000_catalogo_empresas.id',$request->c03)
            ->whereBetween('fecha_giro',[$fecha_inicial,$fecha_final])
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')
            ->get();
        }
        //return $operaciones;

        if(count($consulta)==''){
            return view('despachos.reportes.no-reporte');
          }else{
              $excel=$request->c04;
              return view('giros_anticipos.reportes.giros.listado_principal_giro',compact('consulta','fecha_inicial','fecha_final','excel','imagen'));
           }
    }

    public function reporte_anticipos_listado(Request $request){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));

        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        if($request->c03==-1){
        $consulta=GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',2)
            ->whereBetween('fecha_giro',[$fecha_inicial,$fecha_final])->where('000_catalogo_empresas.es_cliente','=',1)
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')
            ->get();
        ;
        }else{
            $consulta=GirosAnticipos::query()
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','002_giros_anticipos.id_catalogo')
            ->join('000_cuentas_bancos','000_cuentas_bancos.id','=','002_giros_anticipos.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','=','000_cuentas_bancos.id_banco')
            ->where('002_giros_anticipos.tipo_operacion','=',2)
            ->where('000_catalogo_empresas.id',$request->c03)
            ->whereBetween('fecha_giro',[$fecha_inicial,$fecha_final])
            ->select('002_giros_anticipos.id','000_catalogo_empresas.nombre','000_catalogo_empresas.nit',
            '000_catalogo_empresas.digito_verificacion_nit','002_giros_anticipos.valor',
            '002_giros_anticipos.fecha_giro','002_giros_anticipos.forma_pago',
            '002_giros_anticipos.numero_cheque','000_cuentas_bancos.cuenta','000_cuentas_bancos.cliente',
            '002_giros_anticipos.created_at','002_giros_anticipos.updated_at','002_giros_anticipos.numero_cheque',
            '000_bancos.entidad')
            ->get();

        }
        if(count($consulta)==''){
            return view('despachos.reportes.no-reporte');
        }else{
            $excel=$request->c04;
              return view('giros_anticipos.reportes.giros.listado_principal_anticipo',compact('consulta','fecha_inicial','fecha_final','excel','imagen'));
        } 
    }
}
