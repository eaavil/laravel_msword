<?php
use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Bancos;
use App\Models\GirosAnticipos;
use App\Models\Contratos;
use App\Models\CatalogoEmpresas;
use App\Models\CuentasBancos;
use App\Models\BancosMovimiento;
use App\Models\Categorias;
use App\Models\Inventario;
use App\Models\InventarioDetalles;
use App\Models\Carro;
use App\Models\CarroDetalle;
use App\Models\Articulos_categorias;
use App\Models\CentrosCosto;
use App\Http\Controllers\Controller;
use App\Models\ParametrosModulos;
use App\Models\Ordenes;
use App\Models\Listas;
use App\Models\Ordenesdetalle;


$dolar=new Controller;

Route::group(['middleware' => array('ClearCache')],function(){
    
  //ver categorias
  Route::get('/compania',function(){ 
   
 return view('tienda.compania');
 });

 Route::get('/lineas-de-negocio',function(){ 
   
 return view('/tienda.lineas_negocio');
 });

 Route::get('/servicios',function(){ 
  
 return view('/tienda.servicios');
 });
 Route::get('/servicios/instalacion-de-polarizado',function(){ 
 
  return view('/tienda.instalacion-de-polarizado');
  });

  Route::get('/servicios/instalacion-de-laminas-de-seguridad',function(){ 
  
  return view('/tienda.instalacion_laminas_seguridad');
  });

  Route::get('/servicios/lavado-de-vehiculos',function(){ 
  
    return view('/tienda.lavado_vehiculos');
    });

    Route::get('/servicios/sanitizado-y-desinfeccion-ambiental',function(){ 
  
        return view('/tienda.sanitizado');
    });

   Route::get('/productos/{pagina}',function($pagina){ 
    $inventario=Inventario::whereIn('id_categoria', array(148,149,150,151,152,153,154,218))
    ->where("inventario.deleted_at",null)
    ->orderBy("inventario.nombre","asc")->distinct("inventario.id");
    
     $total= $inventario->count();
    if($pagina==1){
        $inicio=0;
    }else{
         $inicio=1+9*($pagina-1);
    }
   
    $final=9+9*($pagina-1);
    
    if($total<=9){
    $paginas=1;
    }else{
        $paginas=round($total/9+0.4, 0, PHP_ROUND_HALF_UP);
    }
    $inventario=$inventario->select('inventario.*')->get()->slice($inicio, 9);
     $tomados=count($inventario);
     
    if($total<=9){
        $paginas=1;
    }else{
            $paginas=round($total/9+0.4, 0, PHP_ROUND_HALF_UP);
    }
    
   return view('/tienda.productos',compact('inventario','pagina',"paginas"));
  });


  
  Route::get('/productos/{categoria}/{pagina}',function($categoria,$pagina){ 

   
  
     $id_categoria=Inventario::where("nombre",str_replace('-',' ',strtoupper($categoria)))->select("id")->value("id");
    
       $inventario=Inventario::where("id_categoria",$id_categoria)
    ->where("inventario.deleted_at",null)
    ->orderBy("inventario.nombre","asc")->distinct("inventario.id");
    

     $total= $inventario->count();
    if($pagina==1){
        $inicio=0;
    }else{
         $inicio=1+9*($pagina-1);
    }
   
    $final=9+9*($pagina-1);
    
    if($total<=9){
    $paginas=1;
    }else{
        $paginas=round($total/9+0.4, 0, PHP_ROUND_HALF_UP);
    }
    $inventario=$inventario->select('inventario.*')->get()->slice($inicio, 9);
     $tomados=count($inventario);
     
    if($total<=9){
        $paginas=1;
    }else{
            $paginas=round($total/9+0.4, 0, PHP_ROUND_HALF_UP);
    }
    
    return view('/tienda.categorias.'.$categoria,compact('inventario',"categoria",'pagina',"paginas"));
    });

    Route::get('/product/{articulo}',function($articulo){ 
        
       $articulo=Inventario::where("inventario.id",$articulo)->get();
      $descripcion="sin descripcion";
      foreach($articulo as $rows){
        $consulta=InventarioDetalles::where("id_inventario",$rows->id)->select("descripcion")->value("descripcion");
          if($consulta!=null){
            $descripcion=$consulta;
          }
          $rows->descripcion=$descripcion;
      }
       $ruta=asset("/tienda/".$articulo[0]["id"].".jpg?".rand(5, 15));
        return view('/tienda.producto_info',compact('articulo',"ruta"));
   });

  Route::get('/contacto',function(){ 

  return view('/tienda.contacto');
  });


    Route::get('/', function(){ return view('security.login'); })->name('login');
    Route::get('/403', function () { return view('security.403'); })->name('403');
    Route::get('/logout', array('uses'=>'AuthController@logout'))->name('login.release');
   // Route::post('/login/auth', array('uses'=>'AuthController@login'))->name('login.auth');
    Route::post('forgot', array('uses'=>'AuthController@forgot'))->name('forgot');
    Route::get('restore', array('uses'=>'AuthController@restore'))->name('restore');
    Route::post('processor_restore/', array('uses'=>'AuthController@restore_processor'))->name('restore.processor');
    //inicio

    /*
	|--------------------------------------------------------------------------
	| tienda virtual (OT)
	|--------------------------------------------------------------------------
    */
    //ver categorias
    Route::get('/categoria/{id}/{pagina}',function($id,$pagina){ 
       $consulta=InventarioDetalle::get();
        foreach($consulta as $rows){
            $registro= InventarioDetalle::find($rows->id);
            if($registro->ruta==null){
             $registro->ruta="sin ruta";
            }
            $registro->save();
        }
        
        $dolar=new Controller;
        $dolar=$dolar->calcular_indicador(1);
      
        $dolar=3000;
        $categorias=Categorias::where('es_tienda',1)->get();
        $modo=2;
       
       $inventario=Inventario::join('004_articulos_categorias','004_articulos_categorias.id_articulo','inventario.id')
        ->where("004_articulos_categorias.deleted_at",null)
        ->where('004_articulos_categorias.id_categoria',$id)->orderBy("inventario.nombre","asc")->distinct("inventario.id");
        
   
        $total= $inventario->count();
        if($pagina==1){
            $inicio=0;
        }else{
             $inicio=1+9*($pagina-1);
        }
       
        $final=9+9*($pagina-1);
        
        if($total<=9){
        $paginas=1;
        }else{
            $paginas=round($total/9+0.4, 0, PHP_ROUND_HALF_UP);
        }
        $inventario=$inventario->select('inventario.*')->get()->slice($inicio, 9);
        $tomados=count($inventario);
      
        foreach($inventario as $rows){
            $rows->rutas=InventarioDetalle::where('id_articulo',$rows->id)->where('ruta','!=',null)->get();
            $rows->total_imagenes=count($rows->rutas);
        }
    return view('tienda.main',compact('inventario','modo','categorias','dolar','total','tomados','paginas','pagina','id'));
    });

    //registrar al carro
    Route::get('/agregar_carro/{ip}/{id}/{valor}',function($ip,$id,$valor){
      
        //crear o actualuzar carro
        //verificar existencia
        $art_1=Inventario::where('id',$id)->select('stock')->value('stock');
        $art_2= Inventario::where('id',$id)->select('stock_p')->value('stock_p');
         $existencia=$art_1 + $art_2;
           if($existencia!=0){
            
           $carro=Carro::where('usuario',$ip)->select('id')->value('id');
            if($carro==null){
            $carro=new Carro;
            }else{
                $carro=Carro::find($carro);
            }
            $carro->usuario=$ip;
            $carro->save();
            $carro->id_usuario=$carro->id.$ip;
            $carro->save();
            
            //actualizar o crear detalles del carro
            $carro_detalle=CarroDetalle::where('id_carro',$carro->id)->where('id_articulo',$id)->select('id')->value('id');
            if($carro_detalle==null){
                $carro_detalle=new CarroDetalle;
                $carro_detalle->id_articulo=$id;
                $carro_detalle->id_carro=$carro->id;
            }else{
                $carro_detalle=CarroDetalle::find($carro_detalle);
            }
            $carro_detalle->cantidad=$carro_detalle->cantidad+1;
            $carro_detalle->valor=str_replace('.','',$valor);
            $carro_detalle->save();

        }
        return $existencia;
    });
    
     //registrar al carro con cantidad
    Route::get('/agregar_carro_cantidad/{ip}/{id}/{valor}/{cantidad}',function($ip,$id,$valor,$cantidad){
      
        //crear o actualuzar carro
        //verificar existencia
        $art_1=Inventario::where('id',$id)->select('stock')->value('stock');
        $art_2= Inventario::where('id',$id)->select('stock_p')->value('stock_p');
         $existencia=$art_1 + $art_2;
           if($existencia!=0){
            
           $carro=Carro::where('usuario',$ip)->select('id')->value('id');
            if($carro==null){
            $carro=new Carro;
            }else{
                $carro=Carro::find($carro);
            }
            $carro->usuario=$ip;
            $carro->save();
            $carro->id_usuario=$carro->id.$ip;
            $carro->save();
            
            //actualizar o crear detalles del carro
            $carro_detalle=CarroDetalle::where('id_carro',$carro->id)->where('id_articulo',$id)->select('id')->value('id');
            if($carro_detalle==null){
                $carro_detalle=new CarroDetalle;
                $carro_detalle->id_articulo=$id;
                $carro_detalle->id_carro=$carro->id;
            }else{
                $carro_detalle=CarroDetalle::find($carro_detalle);
            }
            $carro_detalle->cantidad=$carro_detalle->cantidad+$cantidad;
            $carro_detalle->valor=str_replace('.','',$valor);
            $carro_detalle->save();

        }
        return $existencia;
    });

    //ver detallado
    Route::get('/detallado/{id}',function ($id){ 
        
        $dolar=new Controller;
        $dolar=$dolar->calcular_indicador(1);
        $modo=3;
        $categorias=Categorias::where('es_tienda',1)->get();
       $categoria_articulo=Articulos_categorias::where('id_articulo',$id)
        ->join('004_categorias','004_categorias.id','004_articulos_categorias.id_categoria')
        ->select('nombre')->get();
        
       
        $descripcion=InventarioDetalle::where('id_articulo',$id)->where('tipo',4)->get();
         $elementos=InventarioDetalle::where('id_articulo',$id)->where('tipo',1)->get();
        $video=InventarioDetalle::where('id_articulo',$id)->where('tipo',3)->get();
        $art_1=Inventario::where('id',$id)->select('stock')->value('stock');
         $art_2= Inventario::where('id',$id)->select('stock_p')->value('stock_p');
        $existencia=$art_1 + $art_2;

       $articulo=Inventario::find($id);
        return view('tienda.main',compact('modo','categorias','dolar','articulo','descripcion','categoria_articulo','existencia','elementos','video'));
    });
    //ver carro
    Route::get('/mostrar_carro/{id}',function($id){
       /* $dolar=new Controller;
        $dolar=$dolar->calcular_indicador(1);*/
        $dolar=3000;
        $modo=4;
        $categorias=Categorias::where('es_tienda',1)->get();
        
     $carro_detalle=Carro::where('usuario',$id)->join('004_carro_detalle','004_carro_detalle.id_carro','004_carro.id')
     ->join('inventario','inventario.id','004_carro_detalle.id_articulo')
    ->where('004_carro_detalle.deleted_at',null)
    ->select('004_carro_detalle.*','inventario.nombre')->get();
    return view('tienda.main',compact('modo','carro_detalle','dolar','categorias'));
    });

    //terminar carro 
    Route::get('/pagar/{ip}/{neto}/{iva}/{total}',function($ip,$neto,$iva,$total){
        /*$dolar=new Controller;
        $dolar=$dolar->calcular_indicador(1);*/
        $id=Carro::where("usuario",$ip)->select("id")->value("id");
        $neto=str_replace('$','',str_replace('.','',$neto));
        $iva=str_replace('$','',str_replace('.','',$iva));
        $total=str_replace('$','',str_replace('.','',$total));
        $carro=Carro::find($id);
        $carro->neto=$neto;
        $carro->iva=$iva;
        $carro->total=$total;
        $carro->save();
         $dolar=3000;
        $categorias=Categorias::where('es_tienda',1)->get();
        $carro_detalle=Carro::where('usuario',$ip)->join('004_carro_detalle','004_carro_detalle.id_carro','004_carro.id')
        ->join('inventario','inventario.id','004_carro_detalle.id_articulo')
        ->where("004_carro_detalle.deleted_at",null)
        ->select('004_carro_detalle.*','inventario.nombre')->get();
    
    return view('tienda.content.realizar_pago',compact('carro_detalle','dolar','categorias',"id","neto","iva","total")); 
    });
 
    //almacenar detalles del prodcuto
    Route::post('/tienda/registrar', function (Request $request){
        
        $i=1;
        
        if($request->imagen_1!=null){
           $ruta='tienda/'.$request->id.'.jpg';
          
           /*if(file_exists($ruta)){
                unlink($ruta);
            }*/
            
            $data=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->imagen_1));
            $im=imagecreatefromstring($data); //convertir a imagen
            imagejpeg($im,$ruta); //guardar a disco
            imagedestroy($im); //liberar memoria
        }
  
        if($request->imagen_2!=null){
            $ruta='tienda/'.$request->id.'.jpg';
            if( file_exists($ruta)){
                 unlink($ruta);
             }
             $data=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->imagen_2));
             $im=imagecreatefromstring($data); //convertir a imagen
             imagejpeg($im,$ruta); //guardar a disco
             imagedestroy($im); //liberar memoria
        }
        if($request->imagen_3!=null){
            $ruta='tienda/'.$request->id.'.jpg';
            if( file_exists($ruta)){
                 unlink($ruta);
             }
             $data=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->imagen_3));
             $im=imagecreatefromstring($data); //convertir a imagen
             imagejpeg($im,$ruta); //guardar a disco
             imagedestroy($im); //liberar memoria
        }
        if($request->imagen_4!=null){
            $ruta='tienda/'.$request->id.'.jpg';
            /*if( file_exists($ruta)){
                 unlink($ruta);
             }*/
             $data=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->imagen_4));
             $im=imagecreatefromstring($data); //convertir a imagen
             imagejpeg($im,$ruta); //guardar a disco
             imagedestroy($im); //liberar memoria
        }
        
        //eliminar anterior
        $registro=InventarioDetalles::where('id_inventario',$request->id)->delete();
        /*if(count($registro)!=0){
            foreach($registro as $rows){
                $rows=InventarioDetalle::where('id_articulo',$rows->id)->delete();
                
            }
        }*/
        //crear nuevo
        if(isset($_POST['caracteristica'])){
            foreach($_POST['caracteristica'] as $rows){
                $detalle = new InventarioDetalles;
                    if(is_numeric($rows)){
                        $detalle->relacionado = $rows;
                        $detalle->tipo=2;//es_relacionado
                    }else{
                        $detalle->item = $rows;
                        $detalle->tipo=1;//es_caracteristica
                    }
                    
                    $detalle->id_articulo = $request->id;
                    $detalle->save();
            }
        }
        if($request->video!=null){
            $detalle = new InventarioDetalles;
            $detalle->video=$request->video;
            $detalle->id_inventario= $request->id;
            $detalle->tipo=3;//es_video
            $detalle->save();
        }

        if($request->descripcion!=null){
            $detalle = new InventarioDetalles;
            $detalle->descripcion=$request->descripcion;
            $detalle->id_inventario = $request->id;
            $detalle->tipo=4;//es_descripcion
            $detalle->save();
        }
        
        

    return redirect()->back()->with('result',array('message'=>'El Registro se realizo Exitosamente','type'=>'success')); })->name('tienda.registrar');
  
    Route::post('/realizar/pago',function(Request $request){
        //almacenar recibo
        
        $id=CatalogoEmpresas::where("nit",$request->documento)->select("id")->value("id");
        if($id==null){
          $cliente= new CatalogoEmpresas;  
        }else{
            $cliente=CatalogoEmpresas::find($id);
        }
        $cliente->nombre=$request->nombre;
        $cliente->nit=$request->nit;
        $cliente->persona_contacto=$request->nombre;
        $cliente->email_empresa=$request->correo;
        $cliente->numero_telefono_1=$request->telefono;
        $cliente->save();
        $carro=carro::find($request->id);
        $carro->id_cliente=$cliente->id;
        $carro->estado=1;
        $carro->direccion=$request->direccion;
        $carro->forma_pago=$request->forma_pago;
        $carro->recibir_pedido=$request->recibir_pedido;
        $carro->save();
        
        foreach ($_FILES as $file) {
            if($file['tmp_name']!=""){
                //$extencion= pathinfo($file['name'], PATHINFO_EXTENSION);
                $name =$request->id.'.jpg';//.$extencion;
                $path = public_path() .'\recibos/';
                move_uploaded_file($file['tmp_name'], $path.$name);
            }  
          
        }
        $dolar=3000;
          $carro_detalle=Carro::where('004_carro.id',$request->id)->join('004_carro_detalle','004_carro_detalle.id_carro','004_carro.id',"cliente")
        ->join('inventario','inventario.id','004_carro_detalle.id_articulo')
        ->where("004_carro_detalle.deleted_at",null)
        ->select('004_carro_detalle.*','inventario.nombre')->get();
    $categorias=Categorias::where('es_tienda',1)->get();
    $finalizado="1";
    $neto=$carro->neto;
    $iva=$carro->iva;
    $total=$carro->total;
    $id=$request->id;
    return view('tienda.content.realizar_pago',compact('carro_detalle','dolar','categorias',"finalizado","id","neto","iva","total")); 
    })->name('realizar.pago');
    
     //ver cantidad carro
     Route::get('/cantidad_carro/{ip}',function($ip){
         
        
       $carro_detalle=Carro::where('usuario',$ip)->join('004_carro_detalle','004_carro_detalle.id_carro','004_carro.id')
        ->where('004_carro_detalle.deleted_at',null)
        ->selectRaw('sum(cantidad) as total')
        ->value('total');
        
       if($carro_detalle==null){
           $carro_detalle=0;
       }
    return   $carro_detalle; 
    });
     //cargar_detalle_tabla 
     Route::get('/cargar_detalle/{modo}/{id}',function($modo,$id){
        $consulta=InventarioDetalles::where('id_inventario',$id)->get();

        foreach($consulta as $rows){
            if($rows->tipo==2){
                $rows->nombre=Inventario::where('id',$rows->id_inventario)->select('nombre')->value('nombre');
            }
        }
       

        return $consulta;});
     //aumentar
    Route::get('/aumentar/{id_detalle}/{id_articulo}',function($id_detalle,$id_articulo){
        
        $art_1=Inventario::where('id',$id_articulo)->select('stock')->value('stock');
        $art_2= Inventario::where('id',$id_articulo)->select('stock_p')->value('stock_p');
        $existencia=$art_1 + $art_2;
           if($existencia!=0){

                $carro_detalle=CarroDetalle::find($id_detalle);
                $carro_detalle->cantidad= $carro_detalle->cantidad+1;
                $carro_detalle->save();
           }
        return $existencia;
    });
     //reducir cantidad
     Route::get('/reducir/{id_detalle}/{id_articulo}',function($id_detalle){
         $carro_detalle=CarroDetalle::find($id_detalle);
         $carro_detalle->cantidad= $carro_detalle->cantidad-1;
         $carro_detalle->save();
      
    });
     //elimnar articulo
     Route::get('/eliminar/{id}/{ip}',function($id,$ip){
      
        $carro_detalle=CarroDetalle::find($id)->delete();
        $dolar=new Controller;
        $dolar=$dolar->calcular_indicador(1);
        $modo=4;
        $categorias=Categorias::where('es_tienda',1)->get();
        $carro_detalle=Carro::where('usuario',$ip)->join('004_carro_detalle','004_carro_detalle.id_carro','004_carro.id')
            ->join('inventario','inventario.id','004_carro_detalle.id_articulo')
            ->where('004_carro_detalle.deleted_at',null)
            ->select('004_carro_detalle.*','inventario.nombre')->get();
        return view('tienda.main',compact('modo','carro_detalle','dolar','categorias'));
        
    });

  //consultar cantidad carro
  Route::get('/article/nosotros',function(){
      $modo=6;
      $categorias=Categorias::where('es_tienda',1)->get();
    
return view('tienda.main',compact('modo','categorias')); 
});

Route::get('/login',function(){ 
$modo=1;
$categorias=Categorias::where('es_tienda',1)->get();
return view('tienda.content.login'); });

 
    

   
});

       Route::get('/texto',function(){
      
 return view('demandas.word');

        
    });
  