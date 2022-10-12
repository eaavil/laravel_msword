<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MovimientoEmpaques;
use App\Models\Contratos;
use App\Models\CatalogoEmpresas;
use App\Models\CentrosOperacion;
use App\Models\Poblaciones;
use App\Models\ParametrosModulos;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Articulos_categorias;
use App\Models\Productos;
use App\Models\Inventario;
use App\Models\ContratosDetalle;
use App\Models\Plantillas;
use App\Models\Demandas;
use App\Models\Categorias;
use App\Models\listas;
use App\Models\Despachos;
use App\Models\DespachosDetalle;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Storage;
class DemandasController extends Controller
{ 
   
    public function listado_demandas(){
        $titulo = 'Contratos de Compras Registradas';
		$modulo = 'Contratos';
		$seccion = 'Compras';
        $session= session('role_id'); 
        $dato_a = ParametrosModulos::find(5);
        $dato_b = ParametrosModulos::find(4);
		$factor = ParametrosModulos::find(2);
        $correlativo = $dato_a->parametro.$dato_b->parametro;
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->orwhere("es_tecnico",1)->get();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->get();
        $centros = CentrosOperacion::all();
      $articulos= Inventario::where('es_categoria',null)->get();
        //$imagen = base64_encode(\Storage::get('logo.png'));
         $uf=$this->calcular_indicador(2);
        $dolar=$this->calcular_indicador(1);
        $vendedoras=CatalogoEmpresas::where("es_empleado",1)->get();
        return view('contratos.003_contratos.listado_compra',compact('titulo',"vendedoras",'modulo','seccion','centros','dolar','uf','proveedores','clientes','correlativo','factor','session','articulos'));
    }

   public function registrar_editar_demanda(Request $request){

  
    if($request->id==""){
        $plantilla=new Plantillas;
    }else{
        $plantilla=Plantillas::find($request->id);
    }


    $plantilla->nombre=$request->nombre;
    $plantilla->plantilla=$ruta;
    $plantilla->save();
    $templateProcessor = new TemplateProcessor('word-template/user.docx');
    $templateProcessor->setValue('id', "3");
    $templateProcessor->setValue('name', "edward");
    $templateProcessor->setValue('email', "erer");
    $templateProcessor->setValue('address', "edward");
    $fileName = "edward2";
    $templateProcessor->saveAs($fileName . '.docx');

    //->deleteFileAfterSend(true)
    return response()->download($fileName . '.docx');
    return redirect()->back()->with('result',array('message'=>'Contrato creado Exitosamente','type'=>'success'));
 // Storage::delete('dQp3QQBzy4DgZjAyd9ylXj4puGe57wbL3EQ00SJC.docx');
    //Storage::delete('dQp3QQBzy4DgZjAyd9ylXj4puGe57wbL3EQ00SJC.docx');
  }



    public function listado_demandas_data(Request $request){
        $registros = Contratos::where('tipo_contrato',1)->get();
        foreach($registros as $rows){
            $proveedor = CatalogoEmpresas::find($rows->id_catalogo_empresa_proveedor);
            $facturador = CatalogoEmpresas::find($rows->id_catalogo_empresa_facturador);
            $centros = CentrosOperacion::find($rows->id_centro_operacion);
            $rows->proveedor = $proveedor;
            $rows->facturador = $facturador;
        }
        return array('data'=>$registros);
    }
  public function listado_contratos_compra_data(Request $request){
        $plantillas=Plantillas::get();
      
        return Datatables::of($plantillas)->make();
    }


    public function registrar_contrato_compra(Request $request){
        //una ves se habilita se realiza la compr
      
            $contrato_compra=new contratos;
            $contrato_compra->numero=$request->cor;
            $contrato_compra->fecha_contrato=strval(date("Y-m-d",strtotime('now')));
            if($request->p==null){
                $contrato_compra->id_catalogo_empresa_proveedor=18;
            }else{
                $contrato_compra->id_catalogo_empresa_proveedor=$request->p;
            }
            
            $contrato_compra->tipo_contrato=1;
            $contrato_compra->id_vendedor=Usuarios::where("id",session('id'))->select("id_persona")->value("id_persona");
            $contrato_compra->cotizacion=$request->cc;
            $contrato_compra->valor_neto=str_replace('.','',$request->neto);
            if($request->cc=="apertura de inventario"){
              $contrato_compra->valor_iva="";
              $contrato_compra->valor_total=str_replace('.','',$request->neto); 
            }else{
              $contrato_compra->valor_iva=str_replace('.','',$request->iva);
              $contrato_compra->valor_total=str_replace('.','',$request->total); 
            }
           
            
            //$contrato_compra->id_anexo=Contratos::where('id',$id)->select('id_anexo')->value('id_anexo');
            $contrato_compra->save();
            //registrar detalles
            
            foreach($_POST['entrada'] as $index => $registro){
				$detalle = new ContratosDetalle;
				$detalle->id_contrato = $contrato_compra->id;
				$detalle->id_articulo = str_replace('.','',$_POST['entrada'][$index]);
				$detalle->disponible = -str_replace('.','',$_POST['cantidad'][$index]);
                $detalle->cantidad_total =str_replace('.','',$_POST['cantidad'][$index]);
                 //ajustar bodega
                $articulo=Inventario::find($_POST['entrada'][$index]);
                $articulo->stock=$articulo->stock+$_POST['cantidad'][$index];
                $articulo->save();
                //$detalle->valor =str_replace('.','',$_POST['valor'][$index]);
                $detalle->valor_compra =str_replace('.','',$_POST['valor'][$index]);
                $detalle->total_compra =str_replace('.','',$_POST['articulo_total'][$index]);

                /*verificar si es anexo
				if($_POST['factor'][$index]==0){
					$detalle->definitivo = 1;
					$pendientes++;
				}else{
					$detalle->definitivo = 0;
				}*/
				$detalle->save();

			//	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}

        $this->incrementar_contador_contrato_compra();
		//$registro->estado=3;
    
		
        return redirect()->back()->with('result',array('message'=>'Contrato creado Exitosamente','type'=>'success'));
    }
    
    public function generar_presupuesto_venta($id){
       
         $contrato = Contratos::where('003_contratos.id',$id)->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
        ->select('*')
        ->get();
       
        $articulos=ContratosDetalle::join('inventario','inventario.id','=','003_contratos_detalle.id_articulo')
        ->join('003_contratos','003_contratos.id','=','003_contratos_detalle.id_contrato')
        ->where('003_contratos_detalle.id_contrato',$id)
        ->select('003_contratos_detalle.*','inventario.nombre') 
        ->get();

        $imagen = base64_encode(\Storage::get('logo.png'));
      
        return view('contratos.003_contratos.reportes.comprobante_salida',compact('contrato','articulos','imagen'));
    }
    public function obtener_contrato_compra($id){
        $registro = Contratos::find($id);
        return json_encode($registro);
    }

    public function actualizar_contrato_compra(Request $request){
        //return $request;
        $contrato = Contratos::find($request->id);
        $contrato->numero = $request->c01;
        $contrato->id_catalogo_empresa_proveedor=$request->c12;
        $contrato->cotizacion=$request->c02;
        $contrato->Valor_neto = str_replace('.','',$request->neto);
        $contrato->Valor_iva= str_replace('.','',$request->iva);
        $contrato->Valor_total = str_replace('.','',$request->total);
        $contrato->save();
      
         //ajustar en bodega
        $elementos=ContratosDetalle::where('id_contrato',$request->id)->get();
        foreach($elementos as $rows){
            $articulo=Inventario::find($rows->id_articulo);
            $articulo->stock=$articulo->stock-$rows->cantidad_total;
            $articulo->save();
        }
        //eliminar antiguos detalles
        $detalle=ContratosDetalle::where('id_contrato',$request->id)->delete();
        //registrar nuevos detalles
            foreach($_POST['entrada'] as $index => $registro){
				$detalle = new ContratosDetalle;
				$detalle->id_contrato = $request->id;
				$detalle->id_articulo = str_replace('.','',$_POST['entrada'][$index]);
				$detalle->disponible = -str_replace('.','',$_POST['cantidad'][$index]);
                $detalle->cantidad_total =str_replace('.','',$_POST['cantidad'][$index]);
                 //ajustar bodega
                 $articulo=Inventario::find($_POST['entrada'][$index]);
                $articulo->stock=$articulo->stock+$_POST['cantidad'][$index];
                $articulo->save();
               // $detalle->valor =str_replace('.','',$_POST['valor'][$index]);
                $detalle->valor_compra =str_replace('.','',$_POST['valor'][$index]);
                $detalle->total_compra =str_replace('.','',$_POST['articulo_total'][$index]);

                /*verificar si es anexo
				if($_POST['factor'][$index]==0){
					$detalle->definitivo = 1;
					$pendientes++;
				}else{
					$detalle->definitivo = 0;
				}*/
				$detalle->save();

			//	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}
        
            //	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
            
            /*verificar si es anexo
            if($_POST['factor'][$index]==0){
                $detalle->definitivo = 1;
                $pendientes++;
            }else{
                $detalle->definitivo = 0;
            }*/
           
            
            /*verificar si es anexo
            if($_POST['factor'][$index]==0){
                $detalle->definitivo = 1;
                $pendientes++;
            }else{
                $detalle->definitivo = 0;
            }
          

        //	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
        }
        

        }*/
          
           
        return redirect()->route('contratos.compras')->with('result',array('message'=>'La Actualizacion del Contrato se realizo Exitosamente','type'=>'success'));
    }

    
    public function imprimir_contrato_compra($id){
 
       $contrato = Contratos::where('003_contratos.id',$id)
        ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
        ->join('000_catalogo_empresas as cc','cc.id','=','003_contratos.id_catalogo_empresa_cliente')
        ->select('003_contratos.*','000_catalogo_empresas.*','cc.nombre as proyecto','cc.direccion as direccion_proyecto')
        ->get();
       if(count($contrato)>0){
           $articulos=ContratosDetalle::join('inventario','inventario.id','003_contratos_detalle.id_articulo')
            ->where('003_contratos_detalle.id_contrato',$id)
            ->select('003_contratos_detalle.*','inventario.nombre') 
            ->get();
       }

       if(count($contrato)==0){//para stock bodega
        
          $contrato = Contratos::where('003_contratos.id',$id)->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_proveedor')
            ->select('003_contratos.*','000_catalogo_empresas.*')
            ->get();
           $articulos=ContratosDetalle::join('inventario','inventario.id','=','003_contratos_detalle.id_articulo')//hacer union con el contrato de compra
            ->where('003_contratos_detalle.id_contrato',$id)
            ->select('003_contratos_detalle.*','inventario.nombre') 
            ->get();
       } 

        $imagen = base64_encode(\Storage::get('logo.png'));
        //return $registro;
        //return $imagen;

        return view('contratos.003_contratos.reportes.comprobante_entrada',compact('contrato','articulos','imagen'));
       
    }

    //ventas

    public function listado_contrato_ventas(){
        $titulo = 'Contratos de Ventas Registradas';
		$modulo = 'Contratos';
		$seccion = 'Ventas';
        $session= session('role_id');
		$factor = ParametrosModulos::find(2);
        $dato_a = ParametrosModulos::find(6);
        $dato_b = ParametrosModulos::find(3);
        $correlativo = $dato_a->parametro.$dato_b->parametro;
        $clientes = CatalogoEmpresas::where('es_cliente',1)->where('id_empresa',1)->get();
        $centros = CentrosOperacion::all();
        $categorias=Productos::where('id_categoria',0)->where('es_tienda',0)->orderBy('nombre','asc')->select('id','ruta')->get();//Productos=categorias
        //$articulo_categorias= Articulos_categorias::select('id_categoria')->get();
        $todos=Inventario::select('*')->get();
        $reparacion= Inventario::where('categoria','!=',2)->get();
        $mantencion= Inventario::where('categoria',2)->get();
       // $categorias=Productos::whereIn('id',$articulo_categorias)->select('id','ruta')->get();
        $imagen = base64_encode(\Storage::get('logo.png'));
        $uf=$this->calcular_indicador(2);
        $dolar=$this->calcular_indicador(1);
        $ordenes=Ordenes::get();
        return view('contratos.003_contratos.listado_venta',compact('dolar','titulo','modulo','seccion','centros','clientes','correlativo','factor','session','imagen','categorias','reparacion','mantencion','uf','todos','ordenes'));
    }

    public function agregar_articulos(Request $request){
        //listar articulos indiiduales
       
        if(isset($_GET['modo'])){
           
            if($_GET['modo']==0){//obtener por tipo de servicio 
               $articulos=Inventario::where('codigo','MO')->get();
            }
            //agregar individual
            if($_GET['modo']==1){
               $articulos=Inventario::where('id',$request->id_categoria)->select('inventario.*',"inventario.id as id_articulo")->get();
            }

        }else{
            $articulos=Articulos_categorias::join('inventario','inventario.id','=','articulos_categorias.id_articulo')
            ->where('id_categoria',$request->id_categoria)
            ->select('inventario.*',"inventario.id as id_articulo")->get();
        }
         
        return $articulos;
    }
    
    public function data_listado_contratos_venta(Request $request){
        $registros = Contratos::where('tipo_contrato',2)->get();
        foreach($registros as $rows){
            $clientes = CatalogoEmpresas::find($rows->id_catalogo_empresa_cliente);
            $centros = CentrosOperacion::find($rows->id_centro_operacion);
            $rows->clientes = $clientes;
        }
        return array('data'=>$registros);
    }

    public function listado_contratos_venta_data(Request $request){
         
        if(isset($_GET['id'])){
            $contrato= Contratos::join('003_contratos_detalle','003_contratos_detalle.id_contrato','=','003_contratos.id')
            ->join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
            ->join('inventario','inventario.id','=','003_contratos_detalle.id_articulo')
            ->where('003_contratos.tipo_contrato',2)
            ->where('003_contratos_detalle.id_contrato',$_GET['id'])
            ->where('003_contratos_detalle.deleted_at',null)
            ->select('*','003_contratos.id as contrato_id','inventario.nombre as nombre_articulo','003_contratos_detalle.valor as valor_detalle','003_contratos.cotizacion as cotizacion_contrato') 
            ->get();

            if(count($contrato)==0){
                
                $contrato= Contratos::join('003_contratos_detalle','003_contratos_detalle.id_contrato','=','003_contratos.id')
                ->join('inventario','inventario.id','=','003_contratos_detalle.id_articulo')
                ->where('003_contratos_detalle.id_contrato',$_GET['id'])
                ->where('003_contratos_detalle.deleted_at',null)
                ->select('*','003_contratos.id as contrato_id','inventario.nombre as nombre_articulo','003_contratos_detalle.valor as valor_detalle') 
                ->get();
            }
            $anexo=Contratos::where('numero',$contrato[0]->numero)->select('id_anexo')->value('id_anexo')+1;
            $contrato[0]->anexo=$anexo;
          $contrato[0]->cor_anexo=$contrato[0]->numero."-".$anexo;
            return $contrato;
            
        }else{
              $contratos=Contratos::join('000_catalogo_empresas','000_catalogo_empresas.id','=','003_contratos.id_catalogo_empresa_cliente')
            ->where('id_empresa',1)
            ->where('003_contratos.tipo_contrato',2)
            ->select('000_catalogo_empresas.nombre','003_contratos.id as contrato_id','003_contratos.estado as contrato_estado',
            '003_contratos.pendiente_cotizacion','003_contratos.pendiente_factura',
            '003_contratos.numero','003_contratos.id_categoria','003_contratos.fecha_contrato','003_contratos.orden_trabajo as id_orden_trabajo','003_contratos.id_catalogo_empresa_cliente')->get();
             foreach($contratos as $rows){
       
                $rows->orden_trabajo= Ordenes::where('id',$rows->id_orden_trabajo)->select('numero')->value('numero');
           
             }
            
            return Datatables::of($contratos)->make();
        }
        
    }

    public function registrar_contrato_venta(Request $request){
       
        \DB::beginTransaction();
       $request->validate([
            'numero'=>['unique:003_contratos,numero,NULL,id,deleted_at,NULL'],
          ],[
              'numero.unique'=> 'Numero de contrato repetido',
          ]
          );
		try{
            /*$numero=$request->c01;
            $id_anexo= Contratos::where('numero',$numero)->select('id_anexo')->value('id_anexo');
            if($id_anexo>=0&&$id_anexo!=null){
                $id_anexo=$id_anexo+1;
                $numero=$request->c01."-".$id_anexo;
            }else{
                $id_anexo=0;
            }*/
            //return $request;
            //si es anexo
            $enviar_compra=0;
            $contrato_compra=0;
            if(isset($request->anexo)){
                 $id_anexo=$request->anexo;
                 $origen=Contratos::find($request->id);
                 $origen->id_anexo=$origen->id_anexo+1;
                 $origen->valor_saldo=$origen->valor_saldo+str_replace('.','', $request->total_contrato);
                 $origen->save();
            }else{
                $id_anexo=0;
                $this->incrementar_contador_contrato_venta();
            }
            $contrato = new Contratos;
			$contrato->fecha_contrato = strval(date("Y-m-d",strtotime('now'))); 
            $contrato->validez =strval(date("Y-m-d",strtotime('now'."+ 10 days"))); 
			$contrato->numero = $request->c01;	
            $contrato->orden_trabajo = $request->c02;
            $contrato->id_categoria= $request->c03;	
            $contrato->id_catalogo_empresa_cliente=$request->representante;
            
            if($request->tipo_servicio==2){//almacena con punto es flotante
                $contrato->valor_neto = round($request->neto,1);
                $contrato->valor_iva = $request->iva;
                $contrato->valor_total = $request->total_contrato;
                $contrato->valor_saldo = $request->total_contrato;
            }else{
                $contrato->valor_neto = str_replace('.','', $request->neto);
                $contrato->valor_iva = str_replace('.','', $request->iva);
                $contrato->valor_total = str_replace('.','', $request->total_contrato);
                $contrato->valor_saldo =str_replace('.','', $request->total_contrato);
            }
            $contrato->tipo_servicio=$request->tipo_servicio;
            $contrato->tipo_contrato= 2;
            $contrato->estado=1;
            $contrato->id_anexo=$id_anexo;
            $contrato->save();
            if(isset($request->anexo)){
                $contrato->id_contrato=$request->id;
            }
           foreach($_POST['entrada'] as $index => $registro){
				$detalle = new ContratosDetalle;
				$detalle->id_contrato = $contrato->id;
				$detalle->id_articulo = $_POST['entrada'][$index];
				$detalle->cantidad = str_replace('.','',$_POST['cantidad'][$index]);
                $valor=$_POST['valor'][$index];
                $total=$_POST['total'][$index];
                $comentario=$_POST['comentario'][$index];
                $detalle->comentario =strtoupper($comentario) ;
            //si es mantencion
            $categoria=Inventario::where('id',$_POST['entrada'][$index])->select('categoria')->value('categoria');
               if($categoria==2){
                    
                    $detalle->total_uf =$valor;
                    $detalle->valor =$valor;
                    $detalle->total =$total;
                    if($comentario==""){
                        $detalle->comentario ="VALOR MANTENCION ". $total. " UF";
                    }
                    
                    
                }else{
                  
                    $detalle->cantidad_total = $detalle->cantidad_total + str_replace('.','',$_POST['cantidad'][$index]);
                    $detalle->valor =str_replace('.','',$valor);
                    $detalle->aumento =str_replace('.','',$_POST['aumento'][$index]);
                    $detalle->total =str_replace('.','',$total);
                    $enviar_compra=str_replace('.','', $_POST['disponible'][$index])-str_replace('.','',$_POST['cantidad'][$index]);
                    if($enviar_compra<0 && $categoria==1){
                        $contrato_compra++;
                    }
                    $detalle->disponible=$enviar_compra;
                    $detalle->valor_compra =str_replace('.','',$_POST['valor_compra'][$index]);
                }
                $contrato->articulos=$contrato_compra;
                $detalle->id_anexo=$id_anexo;
                /*verificar si es anexo
				if($_POST['factor'][$index]==0){
					$detalle->definitivo = 1;
					$pendientes++;
				}else{
					$detalle->definitivo = 0;
				}*/
				$detalle->save();//grabar articulos
                $contrato->save();
			//	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}
            \DB::commit();
		}catch(\Exception $e){
			\DB::rollback();
			if($e->getCode()==23000){
                return $e->getCode();
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado, Consecutivo de Despacho ya registrado','type'=>'error'));
			}else{
                return $e->getMessage();
				return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado '.$e->getMessage(),'type'=>'error'));
			}

		}
       
        return redirect()->route('contratos.ventas')->with('result',array('message'=>'El Contrato '.$request->c01.' se realizo Exitosamente','type'=>'success'));
    }

    public function obtener_contrato_venta($id){
        $registro = Contratos::find($id);
        return json_encode($registro);
    }
	
    public function eliminar_contrato($id){
      
         $anexo=Contratos::where('id',$id)->select('id_anexo')->value('id_anexo');
        Contratos::where('id',$id)->delete();

        //eliminar articulos
        ContratosDetalle::where('id_contrato',$id)->where('id_anexo',$anexo)->delete();
        return redirect()->back()->with('result',array('message'=>'El Contrato se elimino Exitosamente','type'=>'success'));
    }
    public function actualizar_contrato_venta(Request $request){
      
        \DB::beginTransaction();
		try{
        $contrato_compra=0;
        $contrato = Contratos::find($request->id);
        $contrato->numero = $request->c01;
        $contrato->orden_trabajo = $request->c02;
        $contrato->id_categoria= $request->c03;	
        $contrato->id_catalogo_empresa_cliente=$request->representante;
        $contrato->valor_neto= str_replace('.','',$request->neto);
        $contrato->valor_iva = str_replace('.','',$request->iva);
        $contrato->valor_total= str_replace('.','',$request->total_contrato);
        $contrato->valor_saldo= str_replace('.','',$request->total_contrato);
        if($request->tipo_servicio==2){//almacena con punto es flotante
            $contrato->valor_neto = round($request->neto,1);
            $contrato->valor_iva = $request->iva;
            $contrato->valor_total = $request->total_contrato;
            $contrato->valor_saldo = $request->total_contrato;
            $contrato->tipo_servicio=$request->tipo_servicio;
        }else{
            $contrato->valor_neto = str_replace('.','', $request->neto);
            $contrato->valor_iva = str_replace('.','', $request->iva);
            $contrato->valor_total = str_replace('.','', $request->total_contrato);
            $contrato->valor_saldo =str_replace('.','', $request->total_contrato);
            
        }
        if($request->tipo_servicio!=""){
            $contrato->tipo_servicio=$request->tipo_servicio;
        }
        $contrato->save();

       
        if(count(explode("-", $request->c01))==3){//es anexo
           $id=Contratos::where('id',$request->id)->select('id_contrato')->value('id_contrato');
        }else{
            $id=$request->id;
        }
        $saldo=0;
        $saldo=Contratos::where('id',$id)->where('estado','>',1)->select('valor_total')->value('valor_total');//contrato base
        $saldo+=Contratos::where('id_contrato',$id)->where('estado','>',1)->selectRaw('sum(valor_total) as saldo')//anexos
        ->value('saldo');
        $contrato = Contratos::find($id);
        $contrato->valor_saldo=$saldo;
        $contrato->save();
      
        //eliminamos los detalles del contrato
        $detalle=ContratosDetalle::where('id_contrato',$contrato->id)->delete();
        //se crea los nuevos detalles
        foreach($_POST['entrada'] as $index => $registro){
				$detalle = new ContratosDetalle;
				$detalle->id_contrato = $contrato->id;
				$detalle->id_articulo = $_POST['entrada'][$index];
				$detalle->cantidad = str_replace('.','',$_POST['cantidad'][$index]);
                $valor=$_POST['valor'][$index];
                $total=$_POST['total'][$index];
                $comentario=$_POST['comentario'][$index];
                $detalle->comentario =strtoupper($comentario);
            //si es mantencion
            $categoria=Inventario::where('id',$_POST['entrada'][$index])->select('categoria')->value('categoria');
               if($categoria==2){
                    
                    $detalle->total_uf =$valor;
                    $detalle->valor =$valor;
                    $detalle->total =$total;
                    if($comentario==""){
                        $detalle->comentario ="VALOR MANTENCION ". $total. " UF";
                    }
                    
                    
                }else{
                  
                    $detalle->cantidad_total = $detalle->cantidad_total + str_replace('.','',$_POST['cantidad'][$index]);
                    $detalle->valor =str_replace('.','',$valor);
                    $detalle->aumento =str_replace('.','',$_POST['aumento'][$index]);
                    $detalle->total =str_replace('.','',$total);
                    $enviar_compra=str_replace('.','', $_POST['disponible'][$index])-str_replace('.','',$_POST['cantidad'][$index]);
                    if($enviar_compra<0 && $categoria==1){
                        $contrato_compra++;
                    }
                    $detalle->disponible=$enviar_compra;
                    $detalle->valor_compra =str_replace('.','',$_POST['valor_compra'][$index]);
                }
                $contrato->articulos=$contrato_compra;
                /*verificar si es anexo
				if($_POST['factor'][$index]==0){
					$detalle->definitivo = 1;
					$pendientes++;
				}else{
					$detalle->definitivo = 0;
				}*/
				$detalle->save();//grabar articulos
                $contrato->save();
			//	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
			}
        //	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
        
        \DB::commit();
        }catch(\Exception $e){
            \DB::rollback();
            if($e->getCode()==23000){
                return $e->getCode();
                return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado, Consecutivo de Despacho ya registrado','type'=>'error'));
            }else{
                return $e->getMessage();
                return redirect()->back()->with('result',array('message'=>'Despacho '.$despacho->numero.' no pudo ser Registrado '.$e->getMessage(),'type'=>'error'));
            }

        }
        return redirect()->route('contratos.ventas')->with('result',array('message'=>'La Actualizacion del Movmimiento de Entrada se realizo Exitosamente','type'=>'success'));
    }

    public function destacar_cotizacion(Request $request){
       
        $registro = Contratos::find($request->id_cotizacion);
        $destacar=$registro->pendiente_cotizacion;
        if($destacar==0){
            $destacar=1;
        }else{
            $destacar=0;
        }
        $registro->pendiente_cotizacion= $destacar;
       $registro->save();  
       
   }

   public function destacar_factura(Request $request){
       
        $registro = Contratos::find($request->id_cotizacion);
        $destacar=$registro->pendiente_factura;
        if($destacar==0){
            $destacar=1;
        }else{
            $destacar=0;
        }
        $registro->pendiente_factura= $destacar;
    $registro->save();  
   
   }
    public function incrementar_contador_contrato_compra(){
        $contador = ParametrosModulos::find(4);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }

    public function incrementar_contador_contrato_venta(){
        $contador = ParametrosModulos::find(3);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }
	
	public function terminar_contrato($id){
		$registro = Contratos::find($id);
		$registro->estado=1;
        $registro->save();
        	//rebajar articulos del stock
       
         $detalle=ContratosDetalle::where('id_contrato',$id)->get();
      
        foreach($detalle as $rows){
         $articulo=Inventario::find($rows->id_articulo);
         $articulo->stock+$rows->disponible*-1;
             $articulo->stock=$articulo->stock-$rows->disponible*-1;
             $articulo->nombre;
            $articulo->save();
        ;
        }
       
       $registro->save();
		return redirect()->back()->with('result',array('message'=>'La Actualizacion del Contrato se realizo Exitosamente','type'=>'success'));
	}
	
	public function habilitar_contrato($id){
		$registro = Contratos::find($id);
        //una ves se habilita se realiza la compra|
        if(Contratos::where('id',$id)->select('articulos')->value('articulos')>0){
            $registro->estado=2;
            $registro->save();
            $contrato_compra=new contratos;
            $dato_a = ParametrosModulos::find(5);
            $dato_b = ParametrosModulos::find(4);
            $factor = ParametrosModulos::find(2);
            $correlativo_contrato = $dato_a->parametro.$dato_b->parametro;
            $contrato_compra->numero=$correlativo_contrato;
            $contrato_compra->fecha_contrato=strval(date("Y-m-d",strtotime('now')));
            $contrato_compra->id_catalogo_empresa_cliente=Contratos::where('id',$id)->select('id_catalogo_empresa_cliente')->value('id_catalogo_empresa_cliente');
            $contrato_compra->tipo_contrato=1;
            $contrato_compra->id_contrato=$id;
            $contrato_compra->id_anexo=Contratos::where('id',$id)->select('id_anexo')->value('id_anexo');
            $contrato_compra->save();
            //calcular saldo
            if(count(explode("-",$registro->numero))==3){//es anexo
                $id=Contratos::where('id',$registro->id)->select('id_contrato')->value('id_contrato');
             }else{
                 $id=$registro->id;
             }
             $saldo=0;
             $saldo=Contratos::where('id',$id)->where('estado','>',1)->select('valor_total')->value('valor_total');//contrato base
             $saldo+=Contratos::where('id_contrato',$id)->where('estado','>',1)->selectRaw('sum(valor_total) as saldo')//anexos
             ->value('saldo');
             $contrato = Contratos::find($id);
             $contrato->valor_saldo=$saldo;
             $contrato->save();
        $this->incrementar_contador_contrato_compra();
    }else{
       	$registro->estado=3;
       	$registro->save();
    }
		//rebajar articulos del stock
        $detalle=ContratosDetalle::where('id_contrato',$id)->get();
        foreach($detalle as $rows){
            $articulo=Inventario::find($rows->id_articulo);
            if($articulo->categoria==0){
            $articulo->stock=intval($articulo->stock)-intval($rows->cantidad);;
            }
            $articulo->save();
        }
        //buscar guia
         
        //crear guia de despacho
         $contrato=Contratos::where('id',$id)->get();
         $id_despacho=Despachos::where('id_contrato',$id)->select('id')->value('id'); 
       
         if($id_despacho!=null){
          
            
            $despachos=Despachos::find($id_despacho);
            //eliminamos los detalle anteriores
            DespachosDetalle::where('id_despacho',$id_despacho)->delete();
            
         }else{
          
            $despachos =new Despachos;
         }
      
        $dato_a = ParametrosModulos::find(16);
        $dato_b = ParametrosModulos::find(15);
        $correlativo = $dato_a->parametro.'-'.$dato_b->parametro;
        $despachos->numero=$correlativo;
        $despachos->id_cliente=$contrato[0]->id_catalogo_empresa_cliente;
        $despachos->id_contrato=$contrato[0]->id;
        $despachos->neto=$contrato[0]->valor_neto;
        $despachos->iva=$contrato[0]->valor_iva;
        $despachos->total=$contrato[0]->valor_total;
        $despachos->id_contrato=$id;
        $despachos->save();
        //almacenar detalles del contrato en despachos
        foreach($detalle as $rows){
            $DetalleDespachos=new DespachosDetalle;
            $DetalleDespachos->id_articulo=$rows->id_articulo;
            $DetalleDespachos->id_despacho=$despachos->id;
            $DetalleDespachos->cantidad=$rows->cantidad;
            $DetalleDespachos->comentario=$rows->comentario;
            $DetalleDespachos->valor=$rows->total/$rows->cantidad;
            $DetalleDespachos->save();
        }
        //incrementar contador despacho
        $contador = ParametrosModulos::find(15);
		$contador->parametro = $contador->parametro+1;
		$contador->save();
       

        return redirect()->back()->with('result',array('message'=>'La Actualizacion del Contrato se realizo Exitosamente','type'=>'success'));
	}
    public function habilitar_contrato_compra($id){
		
        $registro = Contratos::find($id);
		$registro->estado=2;
        
        $contrato_venta=$registro->id_contrato;
        //cambiar_venta estado contrato venta 3:con_venta articulos
        if($contrato_venta!=0){//si esta asociado aun contrato de venta
        
        $registro_venta = Contratos::find($contrato_venta);
		$registro_venta->estado=3;
		$registro_venta->save();
            
        }
       //aumentar stock
         $detalle=ContratosDetalle::where('id_contrato',$id)->get();
      /* $detalle=ContratosDetalle::join('inventario','inventario.id','003_contratos_detalle.id_articulo')
        ->where('id_contrato',$registro->id_contrato)
        ->where('categoria',0)->select('id_articulo','disponible')->get();*/
        foreach($detalle as $rows){
         $articulo=Inventario::find($rows->id_articulo);
         $articulo->stock+$rows->cantidad;
             $articulo->stock=$articulo->stock+$rows->cantidad_total;
             $articulo->nombre;
            $articulo->save();
        ;
        }
       
       $registro->save();
        


    return redirect()->back()->with('result',array('message'=>'La Actualizacion del Contrato se realizo Exitosamente','type'=>'success'));
	}

    public function reporte_corte_mensual(Request $request){
        $fecha_inicial=$request->fecha_inicial;
        $fecha_final=$request->fecha_final;
        $tipo_archivo=$request->c03;
        $imagen = base64_encode(\Storage::get('logo.png'));
         $id_vendedora=$request->id_vendedora;
   
    $egresos=Contratos::where("id_vendedor",$id_vendedora)
    ->whereBetween('fecha_contrato',[$fecha_inicial,$fecha_final])
    ->join("000_catalogo_empresas","000_catalogo_empresas.id","003_contratos.id_catalogo_empresa_proveedor")
    ->get();
    $imagen = base64_encode(asset('dist/img/logo.png'));
     $ingresos=Ordenes::where("id_vendedor",$id_vendedora)
    ->whereBetween('ordenes.created_at',[$fecha_inicial. " 00:00:00",$fecha_final." 11:59:59"])
    ->join("000_catalogo_empresas","000_catalogo_empresas.id","ordenes.id_cliente")
    ->get();
    return view('contratos.003_contratos.reportes.corte_mensual',compact("egresos","ingresos","fecha_inicial","fecha_final","imagen","tipo_archivo"));
   }
   
    public function reporte_contratos_compra_data(Request $request){
        
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
         //dump($request->c03);
         $imagen = base64_encode(asset('dist/img/logo.png'));
        if($request->c03==-1){
        $consulta=Contratos::query()
            ->join('000_catalogo_empresas as cp','cp.id','003_contratos.id_catalogo_empresa_proveedor')
            ->join('000_catalogo_empresas as cf','cf.id','=','003_contratos.id_catalogo_empresa_facturador')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
            ->where('003_contratos.tipo_contrato',1)
            ->whereBetween('fecha_contrato',[$fecha_inicial,$fecha_final])
            ->select('003_contratos.*','003_contratos.id as contrato_id',
            'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit',
            'cf.nombre as facturador','cf.nit as facturador_nit','cf.digito_verificacion_nit as facturador_digito_verificacion_nit',
            '000_tipos_cafe.tipo_cafe')
            ->get();
        }else{
            $consulta=Contratos::query()
            ->join('000_catalogo_empresas as cp','cp.id','003_contratos.id_catalogo_empresa_proveedor')
            ->join('000_catalogo_empresas as cf','cf.id','=','003_contratos.id_catalogo_empresa_facturador')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
            ->where('003_contratos.tipo_contrato',1)
            ->where('cp.id',$request->c03)
            ->whereBetween('fecha_contrato',[$fecha_inicial,$fecha_final])
            ->select('003_contratos.*','003_contratos.id as contrato_id',
            'cp.nombre as proveedor','cp.nit as proveedor_nit','cp.digito_verificacion_nit as proveedor_digito_verificacion_nit',
            'cf.nombre as facturador','cf.nit as facturador_nit','cf.digito_verificacion_nit as facturador_digito_verificacion_nit',
            '000_tipos_cafe.tipo_cafe')
            ->get();   
        }
         
        if(count($consulta)==''){
            return view('despachos.reportes.no-reporte');
        }else{
            $excel=$request->c04;
            return view('contratos.003_contratos.reportes.listado_principal_compra',compact('consulta','fecha_inicial','fecha_final','excel','imagen'));
        }
    }

    public function reporte_contratos_venta_data(Request $request){
        
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $imagen = base64_encode(\Storage::get('logo.png'));
         //dump($request->c03);
        if($request->c03==-1){
        $consulta=Contratos::query()
            ->join('000_catalogo_empresas as cc','cc.id','003_contratos.id_catalogo_empresa_cliente')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
            ->where('003_contratos.tipo_contrato',2)
            ->whereBetween('fecha_contrato',[$fecha_inicial,$fecha_final])
            ->select('003_contratos.*','003_contratos.id as contrato_id',
            'cc.nombre as cliente','cc.nit as cliente_nit','cc.digito_verificacion_nit as cliente_digito_verificacion_nit',
            '000_tipos_cafe.tipo_cafe')
            ->get();
        }else{
            $consulta=Contratos::query()
            ->join('000_catalogo_empresas as cc','cc.id','003_contratos.id_catalogo_empresa_cliente')
            ->join('000_tipos_cafe','000_tipos_cafe.id','003_contratos.id_tipo_cafe')
            ->where('003_contratos.tipo_contrato',2)
            ->where('cc.id',$request->c03)
            ->whereBetween('fecha_contrato',[$fecha_inicial,$fecha_final])
            ->select('003_contratos.*','003_contratos.id as contrato_id',
            'cc.nombre as cliente','cc.nit as cliente_nit','cc.digito_verificacion_nit as cliente_digito_verificacion_nit',
            '000_tipos_cafe.tipo_cafe')
            ->get();   
        }

      //return $consulta;
      if(count($consulta)==''){
        return view('despachos.reportes.no-reporte');
      }else{
          $excel=$request->c04;
          return view('contratos.003_contratos.reportes.listado_principal_venta',compact('consulta','fecha_inicial','fecha_final','excel','imagen'));
       }
}
 
public function obtener_elementos(Request $request){

    return listas::where('id_servicio',$request)->get();
}

}
