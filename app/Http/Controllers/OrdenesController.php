<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ContratosController;
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
use App\Models\Categorias;
use App\Models\Listas;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;
class OrdenesController extends Controller
{ 

    public function listar_ordenes_vista(Request $request){
       
        $titulo = 'Ordenes de trabajo';
		$modulo = 'Ordenes';
		$seccion = 'Ordenes';
       $session= session('role_id'); 
       /*$dato_a = ParametrosModulos::find(5);
        $dato_b = ParametrosModulos::find(4);
		$factor = ParametrosModulos::find(2);
        $correlativo = $dato_a->parametro.$dato_b->parametro;
        $proveedores = CatalogoEmpresas::where('es_proveedor',1)->get();
        $clientes = CatalogoEmpresas::where('es_propietario',1)->get();
        $centros = CentrosOperacion::all();
        $articulos= Inventario::where('es_servicio',0)->get();
        $imagen = base64_encode(\Storage::get('logo.png'));
         $uf=$this->calcular_indicador(2);
        $dolar=$this->calcular_indicador(1);*/
         $ordenes= Ordenes::get();
        $clientes=CatalogoEmpresas::get();
        $dato_a = ParametrosModulos::find(22);
        $dato_b = ParametrosModulos::find(23);
         $clientes = CatalogoEmpresas::where('es_cliente',1)->orwhere("es_empleado",1)->get();
        $correlativo = $dato_a->parametro.'-'.$dato_b->parametro;
        $servicios=Inventario::whereIn('id_categoria', ['2', '3'])->get();
        $id_orden=0;
        
        return view('ordenes.listado_orden',compact('titulo','modulo','seccion','session','ordenes','clientes','correlativo','servicios','id_orden'));
    }


    public function listar_ordenes_tabla(Request $request){
       
        $editar=1;
        $ordenes=Ordenes::orderBy('id','DESC')->get();
       // $correlativo='OT-'.$orden[0]['id'];
       foreach($ordenes as $rows){
           $rows->cliente=CatalogoEmpresas::where('id',$rows->id_cliente)->select('nombre')->value('nombre');
           $rows->tecnico_1=CatalogoEmpresas::where('id',$rows->tecnico_1)->select('nombre')->value('nombre');
           $rows->tecnico_2=CatalogoEmpresas::where('id',$rows->tecnico_2)->select('nombre')->value('nombre');
           $rows->tecnico_3=CatalogoEmpresas::where('id',$rows->tecnico_3)->select('nombre')->value('nombre');
           $rows->tecnico_4=CatalogoEmpresas::where('id',$rows->tecnico_4)->select('nombre')->value('nombre');
           $rows->tecnico_5=CatalogoEmpresas::where('id',$rows->tecnico_5)->select('nombre')->value('nombre');
           $rows->tecnico_6=CatalogoEmpresas::where('id',$rows->tecnico_6)->select('nombre')->value('nombre');
           $rows->tecnico_7=CatalogoEmpresas::where('id',$rows->tecnico_7)->select('nombre')->value('nombre');
           $rows->contrato=Contratos::where('orden_trabajo',$rows->id)->select('numero')->value('numero');

           
       }
    return  Datatables::of($ordenes)->make();}
    
    public function destacar_orden(Request $request){
       
        $registro = Ordenes::find($request->id_orden);
        $destacar=$registro->pendiente;
        if($destacar==0){
            $destacar=1;
        }else{
            $destacar=0;
        }
        $registro->pendiente= $destacar;
       $registro->save();  
       
   }
   
    public function listar_elementos(Request $request){
       
        $elementos=listas::where('id_servicio',$request->id_lista)
        ->where('tipo',2)
        ->join('inventario','inventario.id','listas.id_servicio')
        ->orderBy('inventario.id','asc')
        ->select('listas.*','inventario.nombre')
        ->get();//2 para tipo elemento

        //si es edicion
        if($request->id_orden!=0){
         $elementos=Listas::where('id_servicio',$request->id_lista)
            ->where('tipo',2)
            ->join('inventario','inventario.id','listas.id_servicio')
            ->orderBy('inventario.id','asc')
            ->select('listas.*','inventario.nombre')
            ->get();//2 para tipo elemento
            
            $cantidades=0;
            foreach($elementos as $rows){
               
               $cantidad= OrdenesDetalle::where('id_orden', $request->id_orden)
                ->where('id_lista', $rows->id_servicio)
                ->select('id_elemento')
                ->groupBy('id_elemento')
                ->count();
                $rows->cantidades=$cantidad;
            }
        }

        
    return $elementos;
   }
    
    public function registrar_editar(Request $request){
        // return $_POST['cantidades'][0];
       //return $_POST['cantidades'][1];
     
         
        /*$persona= CatalogoEmpresas::where('nit',$request->documento)->get();
        if(count($persona)==0){
            $persona=new CatalogoEmpresas;
           
        }else{
            $persona=CatalogoEmpresas::find($persona[0]->id);
            
        }
        $persona->nombre=$request->nombre;
        $persona->nit=$request->documento;
        $persona->persona_contacto=$request->representante;
        $persona->direccion=$request->direccion;
        $persona->email_empresa=$request->correo;
        $persona->numero_telefono_1=$request->telefono;
        $persona->cargo=$request->cargo;
        $persona->es_cliente=1;
        $persona->save();
        $id_persona=$persona->id;*/
        if($request->id==null){
            $orden=new Ordenes;
        }else{//si es editar
            $orden=Ordenes::find($request->id);
            
        }
       $orden->id_cliente=$request->cliente;
       $orden->servicio=$request->servicio;
       $orden->numero=$request->correlativo;
       $orden->servicio=$request->servicio_2;
       $orden->requerimiento_inicial=$request->requerimiento_inicial;
       $orden->descripcion=$request->descripcion;
       $orden->save();
       //gurardar listas
      
      if($request->crear_lista=="on"){
          
       if(isset($request->es_escritorio)){
          //eliminar listas anteriores
          $detalle=OrdenesDetalle::where('id_orden',$request->id)->delete();
          //crear nuevos
       foreach($_POST['cantidades'] as $rows){
            $separados = explode(";",$rows); 
            return $elementos=listas::where("id_servicio",$separados[0])->where("tipo",1)->get();
            // almacenar desde una hasta las cantidades solicitadas
            for($i=1;$i<=$separados[2];$i++){
                //alamcenar elementos a chequear por cada articulo
                foreach($elementos as $rows){
                $detalle_orden=new OrdenesDetalle;

                $detalle_orden->id_orden=$orden->id;
                $detalle_orden->id_lista=$separados[0];
                $detalle_orden->id_elemento=$rows->id;
                $detalle_orden->numeracion=$i;
                $detalle_orden->unico=$detalle_orden->id.$orden->id.$separados[0].$separados[1];
                $detalle_orden->save();
               }
            }
       }
    }
}
       
      /* foreach( as $rows){
        $detalle = new OrdenesDetalle;
       
        /*id_elemento=109,cantidad=4
        $detalle->id_contrato = $request->id;
        $detalle->id_articulo = str_replace('.','',$_POST['entrada'][$index]);
        $detalle->disponible = -str_replace('.','',$_POST['cantidad'][$index]);
        $detalle->cantidad_total =str_replace('.','',$_POST['cantidad'][$index]);
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
       // $detalle->save();

    //	$this->adicionar_cantidad_despachada_entrada($_POST['entrada'][$index],$_POST['kilos'][$index]);
    if($request->id==null){//si es nuevo aumento el contador de la orden
        $contador=ParametrosModulos::find(23);
        $contador->parametro = $contador->parametro+1;
        $contador->save();
    }
    
      return redirect()->route('listar.ordenes.vista')->with('result',array('message'=>'Registrado exitosamente','type'=>'success'));
    }
    
    public function consultar_listas(Request $request){
        return OrdenesDetalle::where('id_orden', $request->id)
        ->join('inventario','inventario.id','ordenes_listas.id_lista')
        ->orderBy('inventario.id', 'DESC')
        ->select('id_lista','nombre')
        ->distinct('id_lista')
        ->get();
    }
    
    public function habilitar_orden(Request $request){
        //actualizar OT CON ESTADO aprobado
        //$request->id;
        $orden=Ordenes::find($request->id);
        $orden->estado=3;//estado aprobado
        $orden->save();
        //crear contrato de venta
        $orden->id_cliente;
        $dato_a = ParametrosModulos::find(6);
        $dato_b = ParametrosModulos::find(3);
        $correlativo = $dato_a->parametro.$dato_b->parametro;
        $contrato = new Contratos;
        $contrato->fecha_contrato = strval(date("Y-m-d",strtotime('now'))); 
        $contrato->validez =strval(date("Y-m-d",strtotime('now'."+ 10 days"))); 
        $contrato->numero = $correlativo;	
        $contrato->orden_trabajo = $request->id;
        $contrato->id_catalogo_empresa_cliente=$orden->id_cliente;
        $contrato->tipo_contrato= 2;
        $contrato->estado=1;
        $contrato->save();
         //incremetar correlativo de venta
      
         $clase_contrato = new ContratosController;
         $clase_contrato->incrementar_contador_contrato_venta();
        return redirect()->back()->with('result',array('message'=>'Orden de trabajo habilitada y contrato creado','type'=>'success'));
    }
    public function deshabilitar_orden(Request $request){
        //actualizar OT CON ESTADO aprobado
        //$request->id;
        $orden=Ordenes::find($request->id);
        $orden->estado=1;//estado aprobado
        $orden->save();
        //crear contrato de venta
        Contratos::where('orden_trabajo',$request->id)->delete();
        return redirect()->back()->with('result',array('message'=>'Orden de trabajo deshabilitada y contrato eliminado','type'=>'success'));
    }
    
    public function listar_elementos_detallado(Request $request){
       
        $elementos=OrdenesDetalle::where('id_orden', $request->id_orden)
        ->where('id_lista', $request->id_lista)
        ->where('numeracion',$request->id_elemento)
        ->orderBy('numeracion','asc')
        ->join('listas','listas.id','ordenes_listas.id_elemento')
        ->select('ordenes_listas.*','listas.item')
        ->get();

        
    return $elementos;
   }


  
   
}

