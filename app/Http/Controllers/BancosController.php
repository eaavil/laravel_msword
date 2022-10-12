<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Bancos;
use App\Models\CuentasBancos;
use App\Models\GirosAnticipos;
use App\Models\CatalogoEmpresas;
use App\Models\TiposCuentas;
use App\Models\BancosMovimiento;
use Yajra\Datatables\Datatables;

class BancosController extends Controller
{   public $fecha_inicio_periodo='2021-01-01';

    public function listado_bancos(){
        $titulo = 'Listado Total de Bancos';
		$modulo = 'Configuracion';
		$seccion = 'Bancos';
        $registros = Bancos::all();
        $session= session('role_id');
        return view('bancos.listado',compact('registros','titulo','modulo','seccion','session'));
    }

    public function listado_bancos_data(){
        $registros=  Datatables::of(
                     Bancos::query()
                     )->make();
        return $registros;
    }

    public function listado_cuentas_data(){
       
        return Datatables::of(
        CuentasBancos::query()
        ->join('000_bancos', '000_bancos.id', '=','000_cuentas_bancos.id_banco')
        ->join('000_tipos_cuentas','000_tipos_cuentas.id','=','000_cuentas_bancos.id_tipo_cuenta')
        ->select('000_cuentas_bancos.*','000_bancos.entidad','000_tipos_cuentas.nombre')
        )->make();
       
    }

    public function registrar_banco(Request $request){
        $registro = new Bancos;
        $registro->entidad=$request->c02;
        $registro->estado=1;
        $registro->save();
        return redirect()->route('bancos.listado')->with('result',array('message'=>'El Registro del Banco se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_banco($id){
        $registro = Bancos::find($id);
        return json_encode($registro);
    }
    public function eliminar_banco($id){
        Bancos::find($id)->delete();
        return redirect()->route('bancos.listado')->with('result',array('message'=>'El Banco se elimino Exitosamente','type'=>'success'));
    }
    public function actualizar_banco(Request $request){
        $registro = Bancos::find($request->id);
        $registro->entidad=$request->c02;
        $registro->save();
        return redirect()->route('bancos.listado')->with('result',array('message'=>'La Actualizacion del banco se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_bancos_activos(){
        $registro = Empresas::all();
        return array('data'=>$registro);
    }

    public function listado_cuentas(){
        $titulo = 'Cuentas Bancarias Registradas';
		$modulo = 'Bancos';
		$seccion = 'Cuentas';
        $registros = CuentasBancos::orderBy('created_at','asc')->get();
        $bancos = Bancos::all();
        $tipo_cuentas = TiposCuentas::all();
        $session= session('role_id');
        foreach($registros as $rows){
            $banco = Bancos::find($rows->id_banco);
            $tipo_cuenta = TiposCuentas::find($rows->id_tipo_cuenta);
            $rows->banco = $banco;
            $rows->tipo_cuenta = $tipo_cuenta;
        }
        return view('bancos.listado_cuentas',compact('registros','titulo','modulo','seccion','bancos','tipo_cuentas','session'));
    }

    public function registrar_cuenta_banco(Request $request){
        $registro = new CuentasBancos;
        $registro->id_banco=$request->c04;
        $registro->id_tipo_cuenta=$request->c05;
        $registro->cuenta=$request->c01;
        $registro->cliente=$request->c02;
        $registro->documento_cliente=$request->c03;
        $registro->save();
        return redirect()->route('bancos.cuenta.listado')->with('result',array('message'=>'El Registro de la cuenta bancaria se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_cuenta_banco($id){
        $registro = CuentasBancos::find($id);
        return json_encode($registro);
    }
    public function eliminar_cuenta_banco($id){
        CuentasBancos::find($id)->delete();
        return redirect()->route('bancos.cuenta.listado')->with('result',array('message'=>'La cuenta bancaria se elimino Exitosamente','type'=>'success'));
    }
    public function actualizar_cuenta_banco(Request $request){
        $registro = CuentasBancos::find($request->id);
        $registro->id_banco=$request->c04;
        $registro->id_tipo_cuenta=$request->c05;
        $registro->cuenta=$request->c01;
        $registro->cliente=$request->c02;
        $registro->documento_cliente=$request->c03;
        $registro->save();
        return redirect()->route('bancos.cuenta.listado')->with('result',array('message'=>'La Actualizacion de la cuenta bancaria se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_cuenta_bancos_activos(){

        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;

        $registro = CuentasBancos::join($bancos->getTable(),$bancos->getTable().'.id','=',$cuentas->getTable().'.id_banco')
        ->join($tipos_cuentas->getTable(),$tipos_cuentas->getTable().'.id','=',$cuentas->getTable().'.id_tipo_cuenta')
        ->selectRaw('*,'.$cuentas->getTable().'.id as id_cuenta')
        ->get();
        return array('data'=>$registro);
    }

    public function listado_saldos(Request $request){
        $titulo = 'Saldos Cuentas Bancarias';
		$modulo = 'Bancos';
		$seccion = 'Saldos';
        $saldo_inicial = [];
        $inicio=0;
        $session=0;
        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;
        $catalogo = new CatalogoEmpresas;
        $movimientos = new BancosMovimiento;
        $Giros_anticipos= new GirosAnticipos;
        $saldo_acumulado =0;
        $registros = [];
        $session= session('role_id');
       $cuentas = CuentasBancos::join($bancos->getTable(),$bancos->getTable().'.id','=',$cuentas->getTable().'.id_banco')
                                  ->join($tipos_cuentas->getTable(),$tipos_cuentas->getTable().'.id','=',$cuentas->getTable().'.id_tipo_cuenta')
                                  ->selectRaw('*,'.$cuentas->getTable().'.id as id_cuenta')
                                  ->get();
        
        return view('bancos.listado_saldos',compact('saldo_acumulado','registros','cuentas','titulo','modulo','seccion','inicio','session'));
    }

    public function procesar_reporte(Request $request){
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $titulo = 'Saldos Cuentas Bancarias';
		$modulo = 'Bancos';
		$seccion = 'Saldos';
        $saldo_inicial = [];
        $giro=0;
        $cuentas = new CuentasBancos;
        $bancos = new Bancos;
        $tipos_cuentas = new TiposCuentas;
        $catalogo = new CatalogoEmpresas;
        $movimientos = new BancosMovimiento;
        $Giros_anticipos= new GirosAnticipos;
        $numero_cheque_giro=0;
        $inicio=1;
        $total_ingreso=0;
        $total_egreso=0;
        if(isset($_GET['modo'])){
            $fecha_a=$request->c02;
            $fecha_b=$request->c03;
        }else{
            $fechas = explode(' al ',$request->c02);
            $fecha1 = explode("/",$fechas[0]);
            krsort($fecha1);
            $fecha_a = implode("-",$fecha1); 
            $fecha2 = explode("/",$fechas[1]);
            krsort($fecha2);
            $fecha_b = implode("-",$fecha2);
        }
        $ultimo_movimento=BancosMovimiento::where('id_cuenta_banco',$request->c01)
                                      ->whereBetween($movimientos->getTable().'.fecha_operacion', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_a))])
                                      ->orderBy('fecha_operacion','desc')
                                      ->selectRaw('fecha_operacion')
                                      ->limit(1)
                                      ->value('fecha_operacion')
        ;

        $mov_div1=explode('T',$ultimo_movimento);
        $mov_div2=explode(" ",$mov_div1[0]);
        if($mov_div2[0]!=$fecha_a&&$mov_div2[0]!=""){
             $fecha_a=$mov_div2[0];
        }
      
        if($fecha_a!=$this->fecha_inicio_periodo){
         
            $ingresos_acumulados = BancosMovimiento::where('id_cuenta_banco',$request->c01)
                                                    ->where('modo',1)
                                                    ->where($movimientos->getTable().'.deleted_at',null)
                                                   ->whereBetween($movimientos->getTable().'.fecha_operacion', [$this->fecha_inicio_periodo , date('Y-m-d',strtotime($fecha_a.' -1 days'))])
                                                   // ->groupBy('fecha_operacion','id_cuenta_banco')
                                                   //->orderBy('fecha_operacion','asc')
                                                   //->selectRaw('valor')->get();
                                                    ->selectRaw('sum(valor) as saldo')
                                                    ->value('saldo');

            $egresos_acumulados = BancosMovimiento::where('id_cuenta_banco',$request->c01)
                                                    ->where('modo',2)
                                                    ->where($movimientos->getTable().'.deleted_at',null)
                                                    ->whereBetween($movimientos->getTable().'.fecha_operacion', [$this->fecha_inicio_periodo, date('Y-m-d',strtotime($fecha_a.' -1 days'))])
                                                    //->groupBy('fecha_operacion','id_cuenta_banco')
                                                    //->orderBy('fecha_operacion','asc')
                                                    //->selectRaw('valor')->get();
                                                   ->selectRaw('sum(valor) as saldo')
                                                   ->value('saldo');

        }else{
            $ingresos_acumulados = 0;
            $egresos_acumulados = 0;
            
        }
        
         $saldo_acumulado = $ingresos_acumulados-$egresos_acumulados;
        
        $registros = BancosMovimiento::where('id_cuenta_banco',$request->c01)
                                    ->where($movimientos->getTable().'.deleted_at',null)
                                    ->whereBetween($movimientos->getTable().'.fecha_operacion', [$fecha_a , $fecha_b])
                                    ->join($catalogo->getTable(),$catalogo->getTable().'.id','=',$movimientos->getTable().'.id_tercero')
                                    ->join($cuentas->getTable(),$cuentas->getTable().'.id','=',$movimientos->getTable().'.id_cuenta_banco')
                                    ->join($bancos->getTable(),$bancos->getTable().'.id','=',$cuentas->getTable().'.id_banco')
                                    ->join($tipos_cuentas->getTable(),$tipos_cuentas->getTable().'.id','=',$cuentas->getTable().'.id_tipo_cuenta')
                                    ->selectRaw('*,'.$movimientos->getTable().'.id as id_movimiento,'.$catalogo->getTable().'.nombre as nombre_tercero,'.$movimientos->getTable().'.descripcion as descripcion_movimiento')
                                    ->orderBy('fecha_operacion','asc')
                                    ->get();
        
        $cuentas = CuentasBancos::join($bancos->getTable(),$bancos->getTable().'.id','=',$cuentas->getTable().'.id_banco')
                                  ->join($tipos_cuentas->getTable(),$tipos_cuentas->getTable().'.id','=',$cuentas->getTable().'.id_tipo_cuenta')
                                  ->selectRaw('*,'.$cuentas->getTable().'.id as id_cuenta')
                                  ->get();
        
       foreach($registros as $rows){
        $id_movimiento=intval(preg_replace('/[^0-9]+/', '', $rows->numero), 10);
            $numero_cheque_giro= GirosAnticipos::where('id',$id_movimiento)->select('numero_cheque')->value('numero_cheque');
            $rows->numero_cheque_giro=$numero_cheque_giro;
            $valor=GirosAnticipos::where('id',$id_movimiento)->select('valor')->value('valor');
            $rows->facturador="";
            
            if(strpos($rows->numero,'GIR') !== false and strlen(preg_replace('/[0-9]+/', '', $rows->numero)) == 3){    
                $total_egreso+=$valor;
                $rows->facturador=GirosAnticipos::join($catalogo->getTable(),$catalogo->getTable().'.id','=',$Giros_anticipos->getTable().'.id_facturador')
                ->where($Giros_anticipos->getTable().'.id',$id_movimiento)
                ->select($catalogo->getTable().'.nombre')
                ->value($catalogo->getTable().'.nombre');
               
            }

            if(strpos($rows->numero,'E')!== false and strlen(preg_replace('/[0-9]+/', '', $rows->numero)) == 1){    
                $rows->numero_cheque_giro;
                 $total_egreso+=$rows->valor;
            }
            if(strpos($rows->numero,'ANT') !== false and strlen(preg_replace('/[0-9]+/', '', $rows->numero)) == 3){ 
                $total_ingreso+=$valor;
            } 
            if(strpos($rows->numero,'I')!== false  and strlen(preg_replace('/[0-9]+/', '', $rows->numero)) == 1){ 
                $total_ingreso+=$rows->valor;
            }
        } 
        if(isset($_GET['modo'])){//si es modo reporte
            $excel=$request->c04;
            return view('bancos.reportes.listado_saldo',compact('saldo_acumulado','registros','cuentas','titulo','modulo','seccion','total_egreso','total_ingreso','inicio','excel','fecha_a','fecha_b','imagen'));
        }else{// si es modo tabla
            return view('bancos.listado_saldos',compact('saldo_acumulado','registros','cuentas','titulo','modulo','seccion','total_egreso','total_ingreso','inicio'));
        }
 
    }

    public function eliminar_movimiento($id){
        $registro = BancosMovimiento::where('id',$id)->delete();
        return redirect()->route('bancos.cuenta.listado.saldo')->with('result',array('message'=>'El Movimiento se elimino Exitosamente','type'=>'success'));
    }
    
    public function reporte_saldos(){
        setlocale(LC_TIME, "spanish");
        $fecha_actual=  strftime("%A, %d de %B de %Y");
        $ingresos_acomulados=BancosMovimiento::join('000_cuentas_bancos','000_cuentas_bancos.id','000_bancos_movimiento.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','000_cuentas_bancos.id_banco')
            ->where('fecha_operacion','>',$this->fecha_inicio_periodo)
            ->where('modo',1)
            ->selectRaw('000_bancos.id,sum(000_bancos_movimiento.valor) as total')
            ->orderBY('000_bancos.id')
            ->groupBy('000_bancos.id')
            ->get()
        ;
        
        $egresos_acomulados=BancosMovimiento::join('000_cuentas_bancos','000_cuentas_bancos.id','000_bancos_movimiento.id_cuenta_banco')
            ->join('000_bancos','000_bancos.id','000_cuentas_bancos.id_banco')
            ->where('fecha_operacion','>',$this->fecha_inicio_periodo)
            ->where('modo',2)
            ->selectRaw('000_bancos.id,sum(000_bancos_movimiento.valor) as total')
            ->orderBY('000_bancos.id')
            ->groupBy('000_bancos.id')
            ->get()
        ;
        $saldo_total=[];
        $total=0;
        $excel=1;
        if(count($egresos_acomulados)>count($ingresos_acomulados)){
            $saldo_total=$egresos_acomulados;
            foreach($egresos_acomulados as $rows){
                $cont=0;
                $rows->entidad=Bancos::where('id',$rows->id)->select('entidad')->value('entidad');
                $rows->cuenta_No=CuentasBancos::where('id_banco',$rows->id)->selectRaw('cuenta')->value('cuenta');
                $rows->tipo_cuenta=CuentasBancos::where('id_banco',$rows->id)->join('000_tipos_cuentas','000_tipos_cuentas.id','000_cuentas_bancos.id_tipo_cuenta')
                ->selectRaw('nombre')->value('nombre');
                //comparar ingresos con egresos 
                foreach($ingresos_acomulados as $rowsx){
                    if($rows->id==$rowsx->id){
                    $saldo= $rowsx->total-$rows->total;
                $cont=1;
                }
                }
                //si lo encuentra el saldo se suma al total
                if($cont==1){
                    $rows->saldo= $saldo;
                    $total+=$saldo;
                }
                //si  no lo encuentra el saldo se resta al total
                else{
                    $rows->saldo=-$rows->total;
                    $total-=$rows->total;
                }
                
            }
        }else{
            $saldo_total=$ingresos_acomulados;
            foreach($ingresos_acomulados as $rows){
                $cont=0;
                $rows->entidad=Bancos::where('id',$rows->id)->select('entidad')->value('entidad');
                $rows->cuenta_No=CuentasBancos::where('id_banco',$rows->id)->selectRaw('cuenta')->value('cuenta');
                $rows->tipo_cuenta=CuentasBancos::where('id_banco',$rows->id)->join('000_tipos_cuentas','000_tipos_cuentas.id','000_cuentas_bancos.id_tipo_cuenta')
                ->selectRaw('nombre')->value('nombre');
                foreach($egresos_acomulados as $rowsx){
                    if($rows->id==$rowsx->id){
                     $saldo= $rows->total-$rowsx->total;
                    
                $cont=1;
                }
                }
                if($cont==1){
                    $rows->saldo= $saldo;
                     $total+=$saldo;
                }
                else{
                    $rows->saldo=$rows->total;
                    $total+=$rows->total;
                }
                
            }

        }
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        return view('bancos.reportes.saldo_bancos',compact('saldo_total','excel','total','fecha_actual','imagen')); 
    }
}
