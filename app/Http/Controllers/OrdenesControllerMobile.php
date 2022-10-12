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
use App\Models\InventarioDetalles;
use App\Models\ContratosDetalle;
use App\Models\Categorias;
use App\Models\listas;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;
use App\Models\OrdenesChekeos;
use App\Models\Usuarios;
use App\Models\Nominas;
class OrdenesControllerMobile extends Controller
{ 
    public function mostrar_firma(Request $request){
        $editar=0;
        $personas=CatalogoEmpresas::get();
        foreach($personas as $rows){
            $persona=CatalogoEmpresas::find($rows->id);
            $persona->nit=str_replace('.','',$rows->nit);
            $persona->save();
        }
       return view('tecnico.modals.ingresar_firma',compact('personas','editar'));
    }
    
    public function registrar_editar(Request $request){
        
    if($request->modo=="documento_para_firmar"){
         $orden=Ordenes::find($request->id);
            $ruta='firmas/'.$request->id.'.jpg';
           if(isset($_POST['imagen'])){
             
                if($request->actualizar_firma=='on' && file_exists($ruta)){
                   
                    unlink($ruta);
                    if($request->recepcion!=null){
                        $orden->fecha_firma=date( 'Y-m-d H:i:s' );
                        $orden->save(); 
                    }
                }

                if(file_exists($ruta)==false){
                    $data = base64_decode( preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagen']));
                    $im = imagecreatefromstring($data); //convertir a imagen
                    imagejpeg($im,$ruta); //guardar a disco
                    imagedestroy($im); //liberar memoria
                }
               
            }

            
            //ingresar la fecha de la primera firma nada mas
            
         $id=$request->id;
         
         $orden->save();
        
         return redirect()->route('imprimir.orden', ['id' => $id,'modo' => 1]);
    }else{
        if($request->id==0){
            $orden=new Ordenes;
            //aumentar contador
            $contador=ParametrosModulos::find(23);
            $contador->parametro = $contador->parametro+1;
            $contador->save();
            $orden->id_vendedor=Usuarios::where("id",session('id'))->select("id_persona")->value("id_persona");
            
        }else{
            $orden=Ordenes::find($request->id);
        //ajustar en bodega
        $elementos=OrdenesDetalle::where('id_orden',$request->id)->get();
     
        //devolver a bodega
      
  
        foreach($elementos as $rows){//SOLO ENTRA SI ENCUENTRA ELEMENTOS
            if($rows->id_inventario_detalle!=null){
                
                //ajustar medidas
                  //ajustar medida
				    //polarizado
				$id=Inventario::where("nombre",$rows->descripcion)->select("id")->value("id");
				$lamina=Inventario::find($id);
				$lamina->stock=$lamina->stock+$rows->alto;
				$lamina->save();
            }else{
                $articulo=Inventario::find($rows->id_elemento);
                $articulo->stock=$articulo->stock+$rows->cantidad;
                $articulo->save();
            }
        }
       
       
         //eliminar antiguos detalles
         OrdenesDetalle::where('id_orden',$request->id)->delete();
        

        OrdenesChekeos::where('id_orden',$request->id)->delete();
           
        } 
            if($request->estado=="INACTIVO"){
             
                $orden->estado=3;//presupuesto
            }else{
                $orden->estado=0;//factura creada
            }
            $orden->id_cliente=$request->cliente;
            $orden->numero=$request->correlativo;
            $orden->modelo=$request->modelo;
            $orden->patente=$request->patente;
            $orden->observacion=$request->observacion;
            $orden->tecnico=$request->tecnico;
            $orden->tecnico2=$request->tecnico2;
            $orden->tecnico3=$request->tecnico3;
            $orden->total=str_replace('.','',$request->neto);
            if($request->iva=="on"){
                $orden->es_iva=1;
            }else{
                $orden->es_iva=0;
            }
            $orden->descuento=$request->porcentaje_iva;
            $orden->total_des=str_replace('.','',$request->neto_des);
            $orden->forma_pago=$request->forma_pago;
            $orden->save();
            //registrar detalles
        //registrar nuevos detalles
        $neto=0;
        $numero="";
        if(isset($_POST['entrada'])){
            foreach($_POST['entrada'] as $index => $registro){
                $detalle = new OrdenesDetalle;
				$detalle->id_orden = $orden->id;
				$detalle->id_elemento = $_POST['entrada'][$index];
				$detalle->cantidad =str_replace('.','',$_POST['cantidad'][$index]);
				
			
				if(strpos($_POST['descripcion'][$index], 'LAMINA') !== false || strpos($_POST['descripcion'][$index], 'POLARIZADO') !== false){
				   
				    $detalle->id_inventario_detalle=$_POST['papa'][$index];
				    $detalle->descripcion=$_POST['descripcion'][$index];
				    $detalle->alto=$_POST['metros'][$index];
				    //ajustar medida
				    //polarizado
				    if($request->estado!="INACTIVO"){//SOLO AJUSTA A BODEGA SI NO ES PRESUPUESTO
				    $id=Inventario::where("nombre",$_POST['descripcion'][$index])->select("id")->value("id");
				    
				    $lamina=Inventario::find($id);
				    $lamina->stock=$lamina->stock-$_POST['metros'][$index];
				    $lamina->save();
				     }
				}else{
                    //ajustar bodega
                    if($request->estado!="INACTIVO"){//SOLO AJUSTA A BODEGA SI NO ES PRESUPUESTO
                    $articulo=Inventario::find($_POST['entrada'][$index]);
                    $articulo->stock=$articulo->stock-$_POST['cantidad'][$index];
                    $articulo->save();
                    }
            
                }
			
                $detalle->valor =str_replace('.','',$_POST['valor'][$index]);
                $detalle->comentario =strtoupper($_POST['comentario'][$index]);
                $neto+=str_replace('.','',$_POST['cantidad'][$index])*str_replace('.','',$_POST['valor'][$index]);
                $detalle->save();
        }
    }
   
        $orden->neto=$neto;
        $orden->save();
             //registrar nuevos chekeos
        
             if(isset($_POST['entrada_detalle'])){
             foreach($_POST['entrada_detalle'] as $index => $registro){
				$chekeo = new OrdenesChekeos;
				$chekeo->id_orden = $orden->id;
				$chekeo->item = $_POST['entrada_detalle'][$index];
                if($_POST['imagen_base64'][$index]!=null){//guardar imagen
                 $ruta='chekeos/'.$orden->id."-".str_replace(' ','',$_POST['entrada_detalle'][$index]).'.jpg';
                    if( file_exists($ruta)){
                        unlink($ruta);
                    }
                    $data=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagen_base64'][$index]));
                    $im=imagecreatefromstring($data); //convertir a imagen
                    imagejpeg($im,$ruta); //guardar a disco
                    imagedestroy($im); //liberar memoria
                  
                }
                $chekeo->comentario =strtoupper($_POST['comentario_detalle'][$index]);
                $chekeo->save();
            }
        }
        return redirect()->route('mostrar.ordenes')->with('result',array('message'=>'Registrado exitosamente','type'=>'success'));
    } 
    }


    public function mostrar_ingreso(Request $request){
        $editar=0;
        $dato_a = ParametrosModulos::find(22);
        $dato_b = ParametrosModulos::find(23);
        $correlativo = $dato_a->parametro.'-'.$dato_b->parametro;
        $personas=CatalogoEmpresas::get();
        foreach($personas as $rows){
            $persona=CatalogoEmpresas::find($rows->id);
            $persona->nit=str_replace('.','',$rows->nit);
            $persona->save();
        }
       return view('tecnico.modals.ingresar_editar',compact('correlativo','personas','editar'));
    }
    
 
        

        
    public function registrar_firma(Request $request){
     
        $persona= CatalogoEmpresas::where('nit',$request->documento)->get();
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
        $persona->es_empleado=1;//empleado es facturador en tecnor
        
        if($request->caracteristica=='CLIENTE'){
            $persona->es_cliente=1;
        }else{
              $persona->es_cliente=0;
        }
        if($request->caracteristica=='PROVEEDOR'){
            $persona->es_proveedor=1;
        }else{
              $persona->es_proveedor=0;
        }
        if($request->caracteristica=='EMPLEADO'){
             $persona->es_empleado=1;
        }else{
              $persona->es_empleado=0;
        }
        $persona->save();
        $id_persona=$persona->id;
        //registrar firma 
       if(isset($_POST['imagen'])){
           
        if($request->actualizar_firma=='on' && isset($_POST['imagen'])){
           unlink('firmas/'.$id_persona.'.jpg');
        }
        if(file_exists('firmas/'.$id_persona.'.jpg')==false){
            $data = base64_decode( preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagen']));
            $im = imagecreatefromstring($data);  //convertir a imagen
            imagejpeg($im,'firmas/'.$id_persona.'.jpg'); //guardar a disco
            imagedestroy($im); //liberar memoria
        }
       }
       
    return redirect()->route('mostrar.firma')->with('result',array('message'=>'Registrado exitosamente','type'=>'success'));
    }

  
    
    public function buscar_persona(Request $request){
       
        $persona=CatalogoEmpresas::where('nit',$request->$nit)->get();
        $persona[0]->firma=file_exists('firmas/'.$persona[0]->id.'.jpg');
        return $persona;
             
    }
    
    public function mostrar_ordenes(){
        $ordenes=Ordenes::orderBy('created_at','desc')->get();//join('000_catalogo_empresas','000_catalogo_empresas.id','')
      return view('tecnico.listado_ordenes',compact('ordenes'));
    }
     
    public function editar(Request $request){
        $editar=1;
        $personas=CatalogoEmpresas::get();
        $orden=Ordenes::where('ordenes.id',$request->$id)->get();
        $correlativo='OT-'.$orden[0]['id'];
       foreach($orden as $rows){
           $rows->cliente=CatalogoEmpresas::where('id',$rows->id_cliente)->select('nombre')->value('nombre');
           $rows->recibido=CatalogoEmpresas::where('id',$rows->recibido)->select('nombre')->value('nombre');
           $rows->tecnico_1=CatalogoEmpresas::where('id',$rows->tecnico_1)->select('nombre')->value('nombre');
           $rows->tecnico_2=CatalogoEmpresas::where('id',$rows->tecnico_2)->select('nombre')->value('nombre');
           $rows->tecnico_3=CatalogoEmpresas::where('id',$rows->tecnico_3)->select('nombre')->value('nombre');
           $rows->tecnico_4=CatalogoEmpresas::where('id',$rows->tecnico_4)->select('nombre')->value('nombre');
           $rows->tecnico_5=CatalogoEmpresas::where('id',$rows->tecnico_5)->select('nombre')->value('nombre');
           $rows->tecnico_6=CatalogoEmpresas::where('id',$rows->tecnico_6)->select('nombre')->value('nombre');
           $rows->tecnico_7=CatalogoEmpresas::where('id',$rows->tecnico_7)->select('nombre')->value('nombre');
           
       }
       return view('tecnico.modals.ingresar_editar',compact('editar','correlativo','personas'));
       }

       public function almacenar_detalles(Request $request){
          
        $ruta='ordenes_imagenes/'.$request->id_orden.'-'.$request->id_lista.'-'.$request->id_elemento.'.jpg';
        //si existe se elimina
        if(file_exists($ruta)){
            unlink($ruta);
        }
        //se crea la nueva imagen
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$request->imagen));
        $im = imagecreatefromstring($data); //convertir a imagen
        imagejpeg($im,$ruta); //guardar a disco
        imagedestroy($im); //liberar memoria
       return 'imagen guardada';
        }
        
        public function consultar_comentario(Request $request){
           
            //si es comentario antes
            if (strpos($request->nombre,'A') !== false) {
               $comentario=OrdenesDetalle::where('id',str_replace('A','',$request->nombre))->select('comentario_antes')->value('comentario_antes');
            }
            //si es comentario despues
            if (strpos($request->nombre,'D') !== false) {
                $comentario=OrdenesDetalle::where('id',str_replace('D','',$request->nombre))->select('comentario_despues')->value('comentario_despues');
           }
            return $comentario;
        }

       
        public function registrar_base_datos(Request $request){
           
              $tipo_campo=$request->tipo_campo;
              $orden=Ordenes::find($request->nombre);

             if($tipo_campo=="tecnico_check_orden"){
                if($orden->estado==0){
                    $orden->estado=1;
                    if($orden->tiempo_inicio==null){
                        $orden->tiempo_inicio=date("H:i");
                    }
                }else{
                    $orden->estado=0;
                    $tiempo_fin=date("H:i");
                    if($orden->tiempo_fin==null){
                        $separado_inicio=explode(":",$orden->tiempo_inicio);
                        $orden->tiempo_fin=$tiempo_fin;
                        $separado_fin=explode(":",$tiempo_fin);
                         date_default_timezone_set("America/Santiago");
                        $orden->fecha_salida=date('Y-m-d h:i:s');
                         $orden->mes_salida=date('m');
                         $orden->dia_salida=date('d');
                        $ini_tiempo=strval($separado_fin[0]-$separado_inicio[0]);
                        $fin_tiempo=strval($separado_fin[1]-$separado_inicio[1]);
                        
                        if($fin_tiempo<0){
                            $ini_tiempo=$ini_tiempo-1; 
                            $fin_tiempo=60-$fin_tiempo;
                        }
                        $orden->tiempo_total=$ini_tiempo.":".$fin_tiempo;
                        $orden->estado=2;
                    }
                }
                if($orden->tiempo_total!=null){
                    $orden->estado=0;
                }
                $orden->save();
              }
           
              if($tipo_campo=="valores"){
                
                 $detalle=OrdenesDetalle::find($request->id);
                 $detalle->valor_tecnico=$request->valor;
                $detalle->save();
              }
               if($tipo_campo=="nomina"){
                   if(Nominas::where("token",$request->token)->select("token")->value("token")==null){
                   $nomina=new Nominas;
                   $nomina->total=$request->total;
                   $nomina->empleado=$request->empleado;
                   $nomina->numero=ParametrosModulos::find(9)->parametro."-".ParametrosModulos::find(10)->parametro;
                   $nomina->sueldo_base=$request->sueldo;
                   $nomina->token=$request->token;
                   $nomina->dias=$request->dias;
                   $nomina->val_dia=$request->val_dia;
                   $nomina->inicio_orden=$request->inicio;
                   $nomina->fin_orden=$request->fin;
                   $nomina->descuentos=$request->descuentos;
                   $nomina->observaciones=$request->observaciones;
                   $nomina->save();
                   $ordenes=$request->ordenes;
                   if($ordenes!=""){
                   for($x=0;$x<count($ordenes);$x++){
                       $ordenes[$x];
                       $orden=Ordenes::find($ordenes[$x]);
                  
                       if($orden->id_nomina_1==null){
                       $orden->id_nomina_1=$nomina->id;
                       }elseif($orden->id_nomina_2==null){
                           $orden->id_nomina_2=$nomina->id;
                           }else{
                               
                            $orden->id_nomina_3=$nomina->id;   
                        }
                      $orden->save();
                   }
                   }
                   /*foreach($request->ordenes as $rows){
                       return $rows->[$rows;
                   }*/
                   $sumatoria=ParametrosModulos::find(10);
                   $sumatoria->parametro=$sumatoria->parametro+1;
                   $sumatoria->save();
                   
                    }
                
              }
              if($tipo_campo=="actualizar_nomina"){ 
                  $nomina=Nominas::find($request->id);
                  $nomina->sueldo_base=$request->sueldo;
                  $nomina->observaciones=$request->observaciones;
                  $nomina->descuentos=$request->descuentos;
                  $nomina->total=$request->total;
                  $nomina->dias=$request->dias;
                  $nomina->val_dia=$request->val_dia;
                  $nomina->save();
              }
          }  
       
        public function buscar_orden(Request $request){
            if($request->fecha_inicio!=null and $request->fecha_fin!=null){
          $mes_inicial=intval(substr($request->fecha_inicio,5, 2));
          $dia_inicial=intval(substr($request->fecha_inicio,8, 2));
          $mes_final=intval(substr($request->fecha_fin,5, 2));
          $dia_final=intval(substr($request->fecha_fin,8, 2));
        $id_empleado=CatalogoEmpresas::where("nombre",$request->empleado)->select("id")->value("id");
       //   return $request->fecha_inicio.' 00:00:00'.",".$request->fecha_fin.' 23:59:59';
         
          $base= ordenes::query();
          
         
            ;
             /* $base=ordenes::whereDate("fecha_salida",">=",$request->fecha_inicio)
              ->whereDate("fecha_salida",">=",$request->fecha_fin);*/
           
               $base= $base->whereBetween('ordenes.fecha_salida', [$request->fecha_inicio. " 00:00:00", $request->fecha_fin. " 23:59:59"]);
          
           if($request->cliente!=null){
                
                $id_cliente=CatalogoEmpresas::where('nombre',$request->cliente)->select('id')->value('id');
                $base=$base->where('id_cliente',$id_cliente);
            }

            if($request->orden!=null){
                $base=$base->where('numero',$request->orden);
            }
            
         
            if($request->estado!=null){
               
                if($request->estado=="ejecutada"){
                  
                    $base=$base->where('recibido','!=','');
                }else{
                    $base=$base->where('recibido',null);
                }
                
            }
           
           /* if($request->empleado!=null){
                $id_empleado=CatalogoEmpresas::where("nombre",$request->empleado)->select("id")->value("id");
                $base=$base->where('tecnico',$id_empleado)
                ->orWhere('tecnico2',$id_empleado)
                ->orWhere('tecnico3',$id_empleado);
               
            }*/
         
         $base=$base->get();
          
          foreach($base as $rows){
              $existe=0;
               if($rows->tecnico==$id_empleado){
                   $existe=1;
               }
                if($rows->tecnico2==$id_empleado){
                   $existe=1;
               }
               if($rows->tecnico3==$id_empleado){
                   $existe=1;
               }
               $rows->existe=$existe;
               //return OrdenesDetalle::where("id_orden",$rows->id)->get();
               $ordenes_detalles=OrdenesDetalle::where("id_orden",$rows->id)->get();
               foreach($ordenes_detalles as $rowsx){
                   $rowsx->nombre_servicio=inventario::where("id",$rowsx->id_elemento)->select("nombre")->value("nombre");
                   $rowsx->parte=$rows->nombre=InventarioDetalles::where("id",$rowsx->id_elemento)->select("descripcion")->value("descripcion");
                
               }
               $rows->ordenes_detalles=$ordenes_detalles;
               
           }
           return $base;
        }
        }

        public function mostrar_encuestas(){
            return view('tecnico.listado_encuestas',compact('correlativo','personas','editar','nombre_persona','id_orden','orden','modo','movil'));

        }

}

