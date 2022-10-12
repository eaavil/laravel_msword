<?php

namespace App\Http\Controllers;
use App\Models\MovimientoEmpaques;
use App\Models\CatalogoEmpresas;
use App\Models\TiposEmpaque;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Yajra\Datatables\Datatables;
use App\Models\EntradasSalidasCafe;

class EmpaquesController extends Controller
{
    //
    public function listado_entradas_empaques(){
        $titulo = 'Movimiento empaques proveedor';
		$modulo = 'Empaques';
		$seccion = 'Entradas';
        $session= session('role_id');
        $empaques = TiposEmpaque::all();
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();

        foreach($proveedores as $rows){
             $total_sacos=EntradasSalidasCafe::where('id_catalogo_proveedor',$rows->id)
             ->selectRaw('sum(cantidad_sacos) as saldo')
			->value('saldo');

            $total_tulas=EntradasSalidasCafe::where('id_catalogo_proveedor',$rows->id)
            ->selectRaw('sum(catidad_tulas) as saldo')
           ->value('saldo');

           $movimiento=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$rows->id)->where('tipo_operacion',3)->get();
           if(count($movimiento)>0){
               $movimiento=MovimientoEmpaques::find($movimiento[0]->id);
               $movimiento->id_catalogo_empresas_proveedor=$rows->id;
               $movimiento->total_sacos=$total_sacos;
               $movimiento->total_tulas=$total_tulas;
               $movimiento->tipo_operacion=3;
               $movimiento->save();
               
           }else{
             $movimiento=new MovimientoEmpaques;
             $movimiento->id_catalogo_empresas_proveedor=$rows->id;
             $movimiento->total_sacos=$total_sacos;
             $movimiento->total_tulas=$total_tulas;
             $movimiento->tipo_operacion=3;
             $movimiento->save();
           }
        }
        $inventario=MovimientoEmpaques::find(-1)->get();
        return view('empaques.listado_entrada',compact('titulo','modulo','seccion','empaques','proveedores','session','inventario'));
    }
    public function data_listado_empaques(Request $request){
        return Datatables::of(
            MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_proveedor')->whereIn('tipo_operacion',[1,2])
            ->select('003_movimiento_empaques.*','000_catalogo_empresas.nombre')
            ->orderBy('003_movimiento_empaques.created_at','desc')
        )->make();

        
    }
    public function reporte_proveedores(Request $request){
       
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $cliente=$request->c03;
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        
        if($cliente==-1){
            $data=MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_proveedor')->whereIn('tipo_operacion',[1,2])->select('000_catalogo_empresas.id','000_catalogo_empresas.nombre')
            ->whereBetween('003_movimiento_empaques.created_at', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])->orderBy('nombre','asc')->distinct()->get();
        }else{
            $data=MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_proveedor')
            ->whereBetween('003_movimiento_empaques.created_at', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])->where('id_catalogo_empresas_proveedor',$cliente)->whereIn('tipo_operacion',[1,2])->select('000_catalogo_empresas.id','000_catalogo_empresas.nombre')->orderBy('nombre','asc')->distinct()->get();
         
        }
        
        $data_reporte=[];
        $saldo_anterior_sacos=0;
        $saldo_anterior_tulas=0;
        foreach($data as $indice => $row){
            $tamaño=0;
            $cantidad_movimiento_sacos=0;
            $cantidad_movimiento_tulas=0;
			try{
                $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$row->id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
                $movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$row->id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
                $cantidad_sacos=0;
                $cantidad_tulas=0;
                if(count($movimientos_sacos)>0){
                    $saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
                foreach($movimientos_sacos as $rows){//si son sacos
                        $rows->total_sacos=$saldo_inicial_sacos;
                        if(date("Y-m-d", strtotime($rows->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rows->created_at))<=$fecha_final){
                            $cantidad_movimiento_sacos++;
                        }
                        if($rows->tipo_operacion==2){ //si es ingreso
                            $cantidad_sacos+=$rows->cantidad;
                            $rows->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
                            $saldo_inicial_sacos+=$rows->cantidad;
                        }else{// si es salida
                            $cantidad_sacos-=$rows->cantidad;
                            $rows->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
                            $saldo_inicial_sacos-=$rows->cantidad;
                        }
                }
                $data_reporte[$row->id]['proveedor']['info'] =CatalogoEmpresas::find($row->id);
                $data_reporte[$row->id]['proveedor']['sacos'] =$movimientos_sacos;
                $data_reporte[$row->id]['proveedor']['saldo_sacos']=$saldo_inicial_sacos;
                $data_reporte[$row->id]['proveedor']['cantidad_sacos']=$cantidad_sacos;
                $tamaño+=$cantidad_movimiento_sacos+1;
                if($request->tipo_reporte==2){
                    $tamaño=1;
                }
                }
                // si son tulas
                if(count($movimientos_tulas)!=0){
                    $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
                   
                foreach($movimientos_tulas as $rowsx){
                    $rowsx->total_tulas=$saldo_inicial_tulas;
                    $prueba=$rowsx;
                    if(date("Y-m-d", strtotime($rowsx->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rowsx->created_at))<=$fecha_final){
                        $cantidad_movimiento_tulas++;
                    }
                    if($rowsx->tipo_operacion==2){ //si es ingreso
                        $cantidad_tulas+=$rowsx->cantidad;
                        $rowsx->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
                        $saldo_inicial_tulas+=$rowsx->cantidad;
                    }else{// si es salida
                        $cantidad_tulas-=$rowsx->cantidad;
                        $rowsx->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
                        $saldo_inicial_tulas-=$rowsx->cantidad;

                    }
                }

                $data_reporte[$row->id]['proveedor']['info'] = CatalogoEmpresas::find( $row->id);
                $data_reporte[$row->id]['proveedor']['tulas'] =$movimientos_tulas;
                $data_reporte[$row->id]['proveedor']['cantidad_tulas']=$cantidad_tulas;
                $data_reporte[$row->id]['proveedor']['saldo_tulas']=$saldo_inicial_tulas;
                $tamaño+=$cantidad_movimiento_tulas+1;
                if($request->tipo_reporte==2){
                    $tamaño-=$cantidad_movimiento_tulas+1;
                    $tamaño++;
                }
            } 
            $data_reporte[$row->id]['proveedor']['tamaño']=$tamaño;  	
            }catch(\Exception $e){
                return $movimientos_tulas.$row->id; 
                return $data_reporte[$rows->id]['proveedor']['info'];
                return $e->getmessage();
			return $data_reporte[$rows->id]['proveedor']['info'];
            }
        } 
       $excel=$request->c04;
        if(count($data)>0){
            if($request->tipo_reporte==1){
                return view('empaques.reportes.reporte_proveedores',compact('data_reporte','imagen','excel','fecha_inicial','fecha_final'));
            }else{
                return view('empaques.reportes.reporte_proveedores_general',compact('data_reporte','imagen','excel','fecha_inicial','fecha_final'));
            }
        }else{
            return view('cafe.reportes.no-reporte');
        }
    
    }
    public function reporte_clientes(Request $request){
        
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $cliente=$request->c03;
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        if($cliente==-1){
            $data=MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_cliente')->whereIn('tipo_operacion',[1,2])->select('000_catalogo_empresas.id','000_catalogo_empresas.nombre')
            ->whereBetween('003_movimiento_empaques.created_at', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])->orderBy('nombre','asc')->distinct()->get();
        }else{
            $data=MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_cliente')
            ->whereBetween('003_movimiento_empaques.created_at', [$fecha_inicial.' 00:00:00', $fecha_final.' 23:00:00'])->where('id_catalogo_empresas_cliente',$cliente)->whereIn('tipo_operacion',[1,2])->select('000_catalogo_empresas.id','000_catalogo_empresas.nombre')->orderBy('nombre','asc')->distinct()->get();
         
        }
        $data_reporte=[];
        $saldo_anterior_sacos=0;
        $saldo_anterior_tulas=0;
        foreach($data as $indice => $row){
            $tamaño=0;
            $cantidad_movimiento_sacos=0;
            $cantidad_movimiento_tulas=0;
			try{
               $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$row->id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
                $movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$row->id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
                $cantidad_sacos=0;
                $cantidad_tulas=0;
                
                if(count($movimientos_sacos)!=0){
                   $saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
                foreach($movimientos_sacos as $rows){//si son sacos
                     $rows->total_sacos=$saldo_inicial_sacos;
                        if(date("Y-m-d", strtotime($rows->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rows->created_at))<=$fecha_final){
                            $cantidad_movimiento_sacos++;
                        }
                        if($rows->tipo_operacion==2){ //si es ingreso
                            $cantidad_sacos-=$rows->cantidad;
                            $rows->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
                            $saldo_inicial_sacos-=$rows->cantidad;
                        }else{// si es salida
                            $cantidad_sacos+=$rows->cantidad;
                            $rows->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
                            $saldo_inicial_sacos+=$rows->cantidad;
                        }
                }
                 $data_reporte[$row->id]['proveedor']['info'] =CatalogoEmpresas::find($row->id);
                $data_reporte[$row->id]['proveedor']['sacos'] =$movimientos_sacos;
                $data_reporte[$row->id]['proveedor']['saldo_sacos']=$saldo_inicial_sacos;
                $data_reporte[$row->id]['proveedor']['cantidad_sacos']=$cantidad_sacos;
                $tamaño+=$cantidad_movimiento_sacos+1;
                if($request->tipo_reporte==2){
                    $tamaño=1;
                }
                }
                // si son tulas
                if(count($movimientos_tulas)!=0){
                    $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
                foreach($movimientos_tulas as $rowsx){
                    $rowsx->total_tulas=$saldo_inicial_tulas;
                    if(date("Y-m-d", strtotime($rowsx->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rowsx->created_at))<=$fecha_final){
                        $cantidad_movimiento_tulas++;
                    }
                    if($rowsx->tipo_operacion==2){ //si es ingreso
                        $cantidad_tulas-=$rowsx->cantidad;
                        $rowsx->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
                        $saldo_inicial_tulas-=$rowsx->cantidad;
                    }else{// si es salida
                        $cantidad_tulas+=$rowsx->cantidad;
                        $rowsx->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
                        $saldo_inicial_tulas+=$rowsx->cantidad;

                    }
                } 
                $data_reporte[$row->id]['proveedor']['info'] = CatalogoEmpresas::find( $rowsx->id_catalogo_empresas_cliente);
                $data_reporte[$row->id]['proveedor']['tulas'] =$movimientos_tulas;
                $data_reporte[$row->id]['proveedor']['cantidad_tulas']=$cantidad_tulas;
                $data_reporte[$row->id]['proveedor']['saldo_tulas']=$saldo_inicial_tulas;
                $tamaño+=$cantidad_movimiento_tulas+1;
                if($request->tipo_reporte==2){
                    $tamaño-=$cantidad_movimiento_tulas+1;
                    $tamaño++;
                }
            }
                
            $data_reporte[$row->id]['proveedor']['tamaño']=$tamaño;  	
            }catch(\Exception $e){
				dump($e->getMessage());
			return $e->getMessage();
            }
        }
       $excel=$request->c04;
        if(count($data)>0){
            if($request->tipo_reporte==1){
                return view('empaques.reportes.reporte_clientes',compact('data_reporte','imagen','excel','fecha_inicial','fecha_final'));
            }else{
                return view('empaques.reportes.reporte_clientes_general',compact('data_reporte','imagen','excel','fecha_inicial','fecha_final'));
            }
        }else{
            return view('cafe.reportes.no-reporte');
        }
    
    }
    public function registrar_entrada(Request $request){
      
        if(isset($request->c04)){//agregar al cliente
        $registro = new MovimientoEmpaques;
        $registro->cantidad=str_replace('.','',$request->c01);
        $registro->id_tipo_empaque=$request->c02;
        if($request->c02==1){
            $registro->total_sacos=str_replace('.','',$request->saldo_sacos);
            $registro->saldo_sacos=str_replace('.','',str_replace('.','',$request->saldo_sacos)-str_replace('.','',$request->c01));
        }else{
            $registro->total_tulas=str_replace('.','',$request->saldo_tulas);
            $registro->saldo_tulas= str_replace('.','',str_replace('.','',$request->saldo_tulas)-str_replace('.','',$request->c01));
        }
         
        $registro->fecha_ingreso=date(strtotime($request->c03));
        $registro->id_catalogo_empresas_proveedor=$request->c04;
        $registro->tipo_operacion=1;
        $registro->save();
        $movimiento=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$request->c04)->where('tipo_operacion',3)->get();
        $movimiento=MovimientoEmpaques::find($movimiento[0]->id);
        $inventario=MovimientoEmpaques::find(-1);
              if($request->c02==1){
                $movimiento->abono_sacos+=str_replace('.','',$request->c01);
                $inventario->total_sacos-=str_replace('.','',$request->c01);

              }else{
                $movimiento->abono_tulas+=str_replace('.','',$request->c01);
                $inventario->total_tulas-=str_replace('.','',$request->c01);
              }
        $movimiento->save();
        $inventario->save();
        }else{//actualizar total general del inventario
            $movimiento=MovimientoEmpaques::find(-1);
            if($request->tipo_empaque==1){
                $movimiento->total_sacos=str_replace('.','',$request->cantidad);
            }else{
                $movimiento->total_tulas=str_replace('.','',$request->cantidad);
            } 
        $movimiento->save(); 
        }
        return redirect()->route('empaques.entradas')->with('result',array('message'=>'El Registro del Movimiento se realizo Exitosamente','type'=>'success'));
    }
    public function obtener_empaque_entrada($id){
        $registro = MovimientoEmpaques::find($id);
        return json_encode($registro);
    }
    public function obtener_empaque_entrada_general($id){
        $cantidad_sacos=0;
        $cantidad_tulas=0;
        $saldo_inicial_sacos=0;
        $saldo_inicial_tulas=0;
        $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
        $movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();

        if(count($movimientos_sacos)>0){
            $saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
                
                foreach($movimientos_sacos as $rows){//si son sacos
                    
                    if($rows->tipo_operacion==2){ //si es ingreso
                        $cantidad_sacos+=$rows->cantidad;
                        $rows->saldo_sacos=$saldo_inicial_sacos+$rows->cantidad;
                        $saldo_inicial_sacos+=$rows->cantidad;
                    }else{// si es salida
                        $cantidad_sacos-=$rows->cantidad;
                        $rows->saldo_sacos=$saldo_inicial_sacos-$rows->cantidad;
                        $saldo_inicial_sacos-=$rows->cantidad;
                    }
            }
        } 
        if(count($movimientos_tulas)){
                $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
            
            foreach($movimientos_tulas as $rowsx){
                $rowsx->total_tulas=$saldo_inicial_tulas;
                if($rowsx->tipo_operacion==2){ //si es ingreso
                    $cantidad_tulas+=$rowsx->cantidad;
                    $rowsx->saldo_tulas=$saldo_inicial_tulas+$rowsx->cantidad;
                $saldo_inicial_tulas+=$rowsx->cantidad;
                }else{// si es salida
                    $cantidad_tulas-=$rowsx->cantidad;
                    $rowsx->saldo_tulas=$saldo_inicial_tulas-$rowsx->cantidad;
                    $saldo_inicial_tulas-=$rowsx->cantidad;

                }
            }
        }
        $movimientos_sacos['saldo_sacos']=$saldo_inicial_sacos;
        $movimientos_sacos['saldo_tulas']=$saldo_inicial_tulas;
        $movimientos_sacos['total_tulas']=$movimientos_tulas[0]->total_tulas;
        return json_encode($movimientos_sacos);
    }
    public function obtener_empaque_salida_general($id){
      
        $movimientos_sacos=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',1)->orderBy('created_at','asc')->get();
        $movimientos_tulas=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$id)->whereIn('tipo_operacion',[1,2])->where('id_tipo_empaque',2)->orderBy('created_at','asc')->get();
        $cantidad_sacos=0;
        $cantidad_tulas=0;
        $saldo_inicial_sacos=0;
        $saldo_inicial_tulas=0;
        if(count($movimientos_sacos)!=0){
            $saldo_inicial_sacos=$movimientos_sacos[0]->total_sacos;
            foreach($movimientos_sacos as $rows){//si son sacos
                 $rows->total_sacos=$saldo_inicial_sacos;
                    if($rows->tipo_operacion==2){ //si es ingreso
                        $saldo_inicial_sacos-=$rows->cantidad;
                    }else{// si es salida
                        $saldo_inicial_sacos+=$rows->cantidad;
                    }
            }
        }
        if(count($movimientos_tulas)!=0){
            $saldo_inicial_tulas=$movimientos_tulas[0]->total_tulas;
            foreach($movimientos_tulas as $rowsx){
                $rowsx->total_tulas=$saldo_inicial_tulas;
                if($rowsx->tipo_operacion==2){ //si es ingreso
                    $saldo_inicial_tulas-=$rowsx->cantidad;
                }else{// si es salida
                    $saldo_inicial_tulas+=$rowsx->cantidad;
                }
            } 
        }
        $movimientos_sacos['saldo_sacos']=$saldo_inicial_sacos;
        $movimientos_sacos['saldo_tulas']=$saldo_inicial_tulas;
        $movimientos_sacos['total_tulas']=$movimientos_tulas[0]->total_tulas;
        return json_encode($movimientos_sacos);
    }
    public function actualizar_entrada(Request $request){
        $registro = MovimientoEmpaques::find($request->id);//entrada
        $proveedor=MovimientoEmpaques::where('id_catalogo_empresa_clientes',$request->proeveedor)->where('tipo_operacion',3)->select('id')->value('id');
        $proveedor=MovimientoEmpaques::find($proveedor);//inventario proveedor
        $inventario= MovimientoEmpaques::find(-1);//inventario
        if($request->$tipo_empaque=="Sacos"){
            $registro->cantidad=$request->$request->c01;
            $proveedor->abono_sacos-=$request->sacos_anterior;
            $proveedor->abono_sacos+=$request->c01;
            $inventario->abono_sacos-=$request->sacos_anterior;
            $inventario->abono_sacos+=$request->c01;

        }else{
            $registro->cantidad=$request->$request->c01;
            $proveedor->abono_tulas-=$request->tulas_anterior;
            $proveedor->abono_tulas+=$request->c01;
            $inventario->abono_tulas-=$request->tulas_anterior;
            $inventario->abono_tulas+=$request->c01;
        }
        $registro->fecha_ingreso=date(strtotime($request->c03));
        $registro->save();
        $inventario->save();
        

        return redirect()->route('empaques.entradas')->with('result',array('message'=>'La Actualizacion del Movmimiento de Entrada se realizo Exitosamente','type'=>'success'));
    }

    public function listado_salidas_empaques(){
        $titulo = 'Movimiento empaques clientes';
		$modulo = 'Empaques';
		$seccion = 'Salidas';
        $session= session('role_id');
        $empaques = TiposEmpaque::all();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->get();

        foreach($clientes as $rows){
             $total_sacos=EntradasSalidasCafe::where('id_catalogo_cliente',$rows->id)
             ->selectRaw('sum(cantidad_sacos) as saldo')
			->value('saldo');

            $total_tulas=EntradasSalidasCafe::where('id_catalogo_cliente',$rows->id)
            ->selectRaw('sum(catidad_tulas) as saldo')
           ->value('saldo');

           $movimiento=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$rows->id)->where('tipo_operacion',4)->get();
           if(count($movimiento)>0){
               $movimiento=MovimientoEmpaques::find($movimiento[0]->id);
               $movimiento->id_catalogo_empresas_cliente=$rows->id;
               $movimiento->total_sacos=$total_sacos;
               $movimiento->total_tulas=$total_tulas;
               $movimiento->tipo_operacion=4;
               $movimiento->save();
               
           }else{
             $movimiento=new MovimientoEmpaques;
             $movimiento->id_catalogo_empresas_cliente=$rows->id;
             $movimiento->total_sacos=$total_sacos;
             $movimiento->total_tulas=$total_tulas;
             $movimiento->tipo_operacion=4;
             $movimiento->save();
           }
        }

        $inventario=MovimientoEmpaques::find(-1)->get();
        return view('empaques.listado_salida',compact('titulo','modulo','seccion','empaques','clientes','session','inventario'));
    }
    public function data_listado_empaques_salidas(Request $request){
        return Datatables::of(
            MovimientoEmpaques::join('000_catalogo_empresas','000_catalogo_empresas.id','003_movimiento_empaques.id_catalogo_empresas_cliente')->whereIn('tipo_operacion',[1,2])
            ->select('003_movimiento_empaques.*','000_catalogo_empresas.nombre')
            ->orderBy('003_movimiento_empaques.created_at','desc')
        )->make();
    }

    public function registrar_salida(Request $request){
         if(isset($request->c04)){//agregar al cliente
            $registro = new MovimientoEmpaques;
            $registro->cantidad=str_replace('.','',$request->c01);
            $registro->id_tipo_empaque=$request->c02;
         if($request->c02==1){
            $registro->total_sacos=str_replace('.','',$request->saldo_sacos);
            $registro->saldo_sacos=str_replace('.','',str_replace('.','',$request->saldo_sacos)-str_replace('.','',$request->c01));
        }else{
            $registro->total_tulas=str_replace('.','',$request->saldo_tulas);
            $registro->saldo_tulas= str_replace('.','',str_replace('.','',$request->saldo_tulas)-str_replace('.','',$request->c01));
        }
         $registro->fecha_ingreso=date(strtotime($request->c03));
         $registro->id_catalogo_empresas_cliente=$request->c04;
         $registro->tipo_operacion=2;
         $registro->save();
         $movimiento=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$request->c04)->where('tipo_operacion',4)->get();
         $movimiento=MovimientoEmpaques::find($movimiento[0]->id);
         $inventario=MovimientoEmpaques::find(-1);
               if($request->c02==1){
                 $movimiento->abono_sacos+=str_replace('.','',$request->c01);
                 $inventario->total_sacos+=str_replace('.','',$request->c01);
               }else{
                 $movimiento->abono_tulas+=str_replace('.','',$request->c01);
                 $inventario->total_tulas+=str_replace('.','',$request->c01);
               }
         $movimiento->save();
         $inventario->save();
         }else{//actualizar total general del inventario
             $movimiento=MovimientoEmpaques::find(-1);
             if($request->tipo_empaque==1){
                 $movimiento->total_sacos=str_replace('.','',$request->cantidad);
             }else{
                 $movimiento->total_tulas=str_replace('.','',$request->cantidad);
             } 
         $movimiento->save(); 
         }
         return redirect()->route('empaques.salidas')->with('result',array('message'=>'El Registro del Movimiento se realizo Exitosamente','type'=>'success'));
     }
    public function obtener_empaque_salida($id){
        $registro = MovimientoEmpaques::find($id);
        return json_encode($registro);
    }
    public function actualizar_salida(Request $request){
        $registro = MovimientoEmpaques::find($request->id);
        $registro->cantidad=$request->c01;
        $registro->id_tipo_empaque=$request->c02;
        $registro->fecha_ingreso=date(strtotime($request->c03));
        $registro->id_catalogo_empresas_cliente=$request->c04;
        $registro->id_catalogo_empresas_proveedor=$request->c05;
        $registro->save();

        return redirect()->route('empaques.salidas')->with('result',array('message'=>'La Actualizacion del Movmimiento se realizo Exitosamente','type'=>'success'));
    }

    public function eliminar_empaque($id){
        $registro = MovimientoEmpaques::where('id',$id);
        $inventario=MovimientoEmpaques::find(-1);
        $proveedor=$registro->get();
        $id_proveedor=$proveedor[0]->id_catalogo_empresas_proveedor;
        $cantidad=$proveedor[0]->cantidad;
        $tipo_empaque=$proveedor[0]->id_tipo_empaque;
        $id_movimiento=MovimientoEmpaques::where('id_catalogo_empresas_proveedor',$id_proveedor)->where('tipo_operacion',3)->select('id')->value('id');
        $proveedor=MovimientoEmpaques::find($id_movimiento);
        if($tipo_empaque==1){
            $proveedor->abono_sacos-=str_replace('.','',$cantidad);
            $inventario->total_sacos+=str_replace('.','',$cantidad);
        }else{
            $proveedor->abono_tulas-=str_replace('.','',$cantidad);
            $inventario->total_sacos+=str_replace('.','',$cantidad);
        }
        $proveedor->save();
        $inventario->save();
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

        return redirect()->back()->with('result',array('message'=>'El Movimiento se elimino Exitosamente','type'=>'success'));
    }
    public function eliminar_empaque_salida($id){
        $registro = MovimientoEmpaques::where('id',$id);
        $inventario=MovimientoEmpaques::find(-1);
        $cliente=$registro->get();
        $id_cliente=$cliente[0]->id_catalogo_empresas_cliente;
        $cantidad=$cliente[0]->cantidad;
        $tipo_empaque=$cliente[0]->id_tipo_empaque;
        $id_movimimento=MovimientoEmpaques::where('id_catalogo_empresas_cliente',$id_cliente)->where('tipo_operacion',4)->select('id')->value('id');
     
        $cliente=MovimientoEmpaques::find($id_movimimento);
        
        if($tipo_empaque==1){
            $cliente->abono_sacos-=str_replace('.','',$cantidad);
            $inventario->total_sacos-=str_replace('.','',$cantidad);
          }else{
            $cliente->abono_tulas-=str_replace('.','',$cantidad);
            $inventario->total_sacos-=str_replace('.','',$cantidad);
          }
        $cliente->save();
        $inventario->save();
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
        return redirect()->back()->with('result',array('message'=>'El Movimiento se elimino Exitosamente','type'=>'success'));
    }

}
