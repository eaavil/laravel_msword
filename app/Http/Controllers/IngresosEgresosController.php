<?php

namespace App\Http\Controllers;
use App\Models\MovimientoEmpaques;
use App\Models\CatalogoEmpresas;
use App\Models\TiposEmpaque;
use App\Models\Bancos;
use App\Models\TiposCuentas;
use App\Models\CuentasBancos;
use App\Models\BancosMovimiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Yajra\Datatables\Datatables;
use App\Models\ParametrosModulos;

class IngresosEgresosController extends Controller
{
    //
    public function listado_ingreso_egresos(){
        $titulo = 'Ingresos y Egresos';
		$modulo = 'Financiero';
		$seccion = 'Ingresos y Egresos';
        $session= session('role_id');
        $empaques = TiposEmpaque::all();
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->get();
        $bancos = Bancos::all();
        $numeracion_ingreso = ParametrosModulos::find(17);
        $numeracion_egreso = ParametrosModulos::find(18);
        return view('ingresos_egresos.listado',compact('titulo','modulo','seccion','empaques','proveedores','clientes','bancos','session','numeracion_ingreso','numeracion_egreso'));
    }
    
    public function data_listado(Request $request){
       
        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;
        $catalogo = new CatalogoEmpresas;
        $movimientos = new BancosMovimiento;
        $valor_total=0;
        $modo = -1;
        $banco = -1;
        $cal_valor=0;
        if(isset($_GET['valor'])){
             $modo = $_GET['valor'];
             $banco = $_GET['banco'];
             $cal_valor=$_GET['modo'];
        }
       
        if($modo==-1){
            if($banco==-1){
            $operaciones = BancosMovimiento::query()
                                ->orderBy('fecha_operacion','asc')
                                ->whereBetween('tipo_operacion',[1,2])
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
            }else{
                $operaciones =BancosMovimiento::query()
                                    ->orderBy('fecha_operacion','asc')
                                    ->whereBetween('tipo_operacion',[1,2])
                                    ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                    ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                    ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                    ->where('000_bancos.id',$banco)
                                    ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                    ->get();

            }
        }else{
            if($banco==-1){
            $operaciones =BancosMovimiento::query()
                                ->orderBy('fecha_operacion','asc')
                                ->where('modo',$modo)
                                ->where('tipo_operacion',$modo)
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
           }else{
            $operaciones =BancosMovimiento::query()
                                ->orderBy('fecha_operacion','asc')
                                ->where('modo',$modo)
                                ->where('tipo_operacion',$modo)
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->where('000_bancos.id',$banco)
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();

           }
        }

        foreach($operaciones as $rows){
            $valor_total+=$rows->valor;

        }
        if($cal_valor==1){
            return $valor_total;
        }else{
            return  Datatables::of($operaciones)->make();
        }
    }

    public function listado_ingreso_egresos_fecha(Request $request){

        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;
        $catalogo = new CatalogoEmpresas;
        $movimientos = new BancosMovimiento;
        $valor_total=0;
        $modo = -1;
        $banco = -1;
        $cal_valor=0;
        if(isset($_GET['valor'])){
             $modo = $_GET['valor'];
             $banco = $_GET['banco'];
             $fecha_inicial = $_GET['fecha_inicial'];
             $fecha_final = $_GET['fecha_final'];
             $cal_valor=$_GET['modo'];
        }
       
        if($modo==-1){
            if($banco==-1){
            $operaciones = BancosMovimiento::query()
                                ->whereBetween('fecha_operacion',[$fecha_inicial,$fecha_final])
                                ->orderBy('fecha_operacion','asc')
                                ->whereBetween('tipo_operacion',[1,2])
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
            }else{
                $operaciones = BancosMovimiento::query()
                                     ->whereBetween('fecha_operacion',[$fecha_inicial,$fecha_final])
                                    ->orderBy('fecha_operacion','asc')
                                    ->whereBetween('tipo_operacion',[1,2])
                                    ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                    ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                    ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                    ->where('000_bancos.id',$banco)
                                    ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                    ->get();

            }
        }else{
            if($banco==-1){
            $operaciones =  BancosMovimiento::query()
                                ->whereBetween('fecha_operacion',[$fecha_inicial,$fecha_final])
                                ->orderBy('fecha_operacion','asc')
                                ->where('modo',$modo)
                                ->where('tipo_operacion',$modo)
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
           }else{
            $operaciones = BancosMovimiento::query()
                                ->whereBetween('fecha_operacion',[$fecha_inicial,$fecha_final])
                                ->orderBy('fecha_operacion','asc')
                                ->where('modo',$modo)
                                ->where('tipo_operacion',$modo)
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->where('000_bancos.id',$banco)
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
           

           }
        }
        
        foreach($operaciones as $rows){
            $valor_total+=$rows->valor;

        }
        if($cal_valor==1){
            return $valor_total;
        }else{
            return Datatables::of($operaciones)->make();
        }
        
    }
    public function registrar_operacion(Request $request){

        $request->validate([
            //valida que un regitro no eliminado no ingrese 
            'c01'=>['unique:000_bancos_movimiento,numero,NULL,id'],//deleted_at,NULL
            'c02'=>'required',
            'c03'=>'required',
            'c04'=>'required',
            'c05'=>'required',
            'c06'=>'required',
            'c07'=>'required',
            'c08'=>'required',
            'modo'=>'required'
        ],[
            'c01.unique'=> 'Numero de ingreso/egreso repetido',
            'c02.required'=>'Especifique la fecha de operacion',
            'c03.required'=>'Campo Requerido',
            'c04.required'=>'Campo Requerido',
            'c05.required'=>'Campo Requerido',
            'c06.required'=>'Especifique el Producto o Servicio a Cobrar',
            'c07.required'=>'Especifique el Numero de Factura / Remision',
            'c08.required'=>'Ingrese el Total a Cobrar',
            'modo.required'=>'Tipo Requerido'
        ]);
        
        $registro = new BancosMovimiento;
        $registro->numero = $request->c01;
        $registro->tipo_operacion = $request->modo;
        $registro->fecha_operacion = $request->c02;
        $registro->forma_pago = $request->c03;
        $registro->id_cuenta_banco = $request->c05;
        $registro->descripcion = $request->c06;
        $registro->numero_factura_remision = $request->c07;
        $registro->valor = str_replace('.','',$request->c08);
        $registro->modo = $request->modo;
        if($request->modo==1){
            $this->incrementar_contador_ingreso();
        }else{
            $this->incrementar_contador_egreso();
        }
        $registro->id_tercero = $request->c04;
        $registro->save();
    }

    public function eliminar_movimiento($id){
        $registro = BancosMovimiento::where('id',$id)->delete();
        return redirect()->back()->with('result',array('message'=>'El Movimiento se elimino Exitosamente','type'=>'success'));
    }

    
    public function reporte_movimientos(Request $request){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;
        $catalogo = new CatalogoEmpresas;
        $movimientos = new BancosMovimiento;
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $excel=$request->c04;
        $modo=$request->c03;
        $titulo='';
        if($modo==1){$titulo='Reporte de ingresos';}
        if($modo==2){$titulo='Reporte de ingresos';}

       
        if($modo==-1){
            $titulo='Reporte de ingresos y egresos';
            $operaciones = BancosMovimiento::query()
                                ->orderBy('fecha_operacion','asc')
                                ->whereBetween('tipo_operacion',[1,2])
                                ->whereBetween('fecha_operacion',[$request->c01,$request->c02])
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
            
        }else{
            $operaciones = BancosMovimiento::query()
                                ->orderBy('fecha_operacion','asc')
                                ->where('modo',$modo)
                                ->whereBetween('fecha_operacion',[$request->c01,$request->c02])
                                ->where('tipo_operacion',$modo)
                                ->join($cuentas->getTable(), $cuentas->getTable().'.id', '=', $movimientos->getTable().'.id_cuenta_banco')
                                ->join($bancos->getTable(), $bancos->getTable().'.id', '=', $cuentas->getTable().'.id_banco')
                                ->join($catalogo->getTable(), $catalogo->getTable().'.id', '=', $movimientos->getTable().'.id_tercero')
                                ->selectRaw($movimientos->getTable().'.id,numero,modo,fecha_operacion,nombre,nit,descripcion,forma_pago,cuenta,cliente,documento_cliente,numero_factura_remision,valor,entidad')
                                ->get();
                               
        }
         
        return view('ingresos_egresos.reportes.listado_principal',compact('operaciones','fecha_inicial','fecha_final','excel','titulo','imagen')) ;
    }
    
    
    private function incrementar_contador_ingreso(){
        $contador = ParametrosModulos::find(17);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

    private function incrementar_contador_egreso(){
        $contador = ParametrosModulos::find(18);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
	}
}
