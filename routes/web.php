<?php
use App\Models\ParametrosModulos;
use App\Models\Ordenes;
use App\Models\OrdenesChekeos;
use App\Models\OrdenesDetalle;
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
use App\Models\InventarioDetalle;
use App\Models\Carro;
use App\Models\CarroDetalle;
use App\Models\Articulos_categorias;
use App\Models\CentrosCosto;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccesosController;
use App\Http\Controllers\CatalogoEmpresasController;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\DemandasController;
use App\Models\InventarioDetalles;
use App\Models\Usuarios;
use App\Models\Nominas;
use Illuminate\Support\Facades\Route;
use App\User;
use PhpOffice\PhpWord\TemplateProcessor;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
  //ver categorias
if(2==2){
  Route::get('/dashboard', function(){
    $titulo = '';
    $modulo = '';
    $seccion = '';
    $movil=0;
    $tablet_browser = 0;
    $mobile_browser = 0;
    $body_class = 'desktop';

    $clase_controlador = new Controller;
if($clase_controlador->consultar_mobile()){
    return redirect()->route('mostrar.ordenes');

  
}else{
    return view('dashboard.index',compact('titulo','modulo','seccion'));
}
})->name('dashboard');


  Route::get('mostrar/ingreso', function(){
    $editar=0;
    $dato_a = ParametrosModulos::find(22);
    $dato_b = ParametrosModulos::find(23);
    $correlativo = $dato_a->parametro.'-'.$dato_b->parametro;
    $personas=CatalogoEmpresas::where("es_cliente",1)->get();
    foreach($personas as $rows){
        $persona=CatalogoEmpresas::find($rows->id);
        $persona->nit=str_replace('.','',$rows->nit);
        $persona->save();
    }
    $nombre_persona="";
    $id_orden=0;
    $orden=[];
    $modo="registrar";
   $movil=1;
   return view('tecnico.modals.ingresar_editar',compact('correlativo','personas','editar','nombre_persona','id_orden','orden','modo','movil'));
})->name('mostrar.ingreso');

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
       Route::post("/login/auth", [AuthController::class, "login"])->name('login.auth');
       Route::get('/logout', [AuthController::class, "logout"])->name('login.release');
       //Route::post('/login/auth', array('uses'=>'AuthController@login'))->name('login.auth');
       Route::post('forgot',[AuthController::class, "forgot"])->name('forgot');
       Route::get('restore',[AuthController::class, "restore"])->name('restore');
       Route::post('processor_restore/',[AuthController::class, "restore_processor"])->name('restore.processor');
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
Route::get('/texto2', function () {
    $templateProcessor = new TemplateProcessor('word-template/user.docx');
    $templateProcessor->setValue('id', "3");
    $templateProcessor->setValue('name', "edward");
    $templateProcessor->setValue('email', "erer");
    $templateProcessor->setValue('address', "edward");
    $fileName = "edward";
    $templateProcessor->saveAs($fileName . '.docx');
    return response()->download($fileName . '.docx')->deleteFileAfterSend(true);

    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    $titulo = 'Centro de Control de Integracion';
    $modulo = 'Dashboard';
    $seccion = 'Incio';
    $clientes = ApiRestClients::all();
    return view('dashboard.index-admin',compact('titulo','modulo','seccion','clientes'));
})->name('dashboard-admin');
/*
|--------------------------------------------------------------------------
| Clientes
|--------------------------------------------------------------------------
*/
Route::post('/admin/dashboard/clients/add', array('uses'=>'ClientsController@add_client'))->name('dashboard.clients.add');
Route::get('/admin/dashboard/clients/get/{id}', array('uses'=>'ClientsController@get_client'))->name('dashboard.clients.get');
Route::get('/admin/dashboard/clients/delete/{id}', array('uses'=>'ClientsController@delete_client'))->name('dashboard.clients.delete');
Route::get('/admin/dashboard/clients/state/change/{id}', array('uses'=>'ClientsController@change_state_client'))->name('dashboard.clients.state.change');
Route::post('/admin/dashboard/clients/update', array('uses'=>'ClientsController@update_client'))->name('dashboard.clients.update');

/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
Route::get('/admin/users', [AccesosController::class, "listado_usuarios"])->name('dashboard.users');
Route::get('/admin/users/data', [AccesosController::class, "data_usuarios"])->name('dashboard.users.data');
Route::post('/admin/users/check/email/{email}', [AccesosController::class, "validar_email_cliente"])->name('dashboard.users.check.email');
Route::post('/admin/users/check/login/{login}', [AccesosController::class, "validar_login_unico"])->name('dashboard.users.check.login');
Route::post('/admin/users/add', [AccesosController::class, "registrar_usuario"])->name('dashboard.users.add');
Route::get('/admin/users/get/{id}', [AccesosController::class, "obtener_usuario"])->name('dashboard.users.get');
Route::get('/admin/users/delete/{id}', [AccesosController::class, "eliminar_usuario"])->name('dashboard.users.delete');
Route::get('/admin/users/change/{id}',[AccesosController::class, "cambiar_estado_usuario"])->name('dashboard.users.state.change');
Route::post('/admin/users/update', [AccesosController::class, "actualizar_usuario"])->name('dashboard.users.update');
   /*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
Route::get('/admin/roles', array('uses'=>'AccesosController@listado_roles'))->name('dashboard.roles');
Route::get('/admin/roles/data', array('uses'=>'AccesosController@data_roles'))->name('dashboard.roles.data');
Route::post('/admin/roles/check/name/{login}', array('uses'=>'AccesosController@validar_nombre_rol'))->name('dashboard.roles.check.login');
Route::post('/admin/roles/add', array('uses'=>'AccesosController@registrar_rol'))->name('dashboard.roles.add');
Route::get('/admin/roles/get/{id}', array('uses'=>'AccesosController@obtener_rol'))->name('dashboard.roles.get');
Route::get('/admin/roles/delete/{id}', array('uses'=>'AccesosController@eliminar_rol'))->name('dashboard.roles.delete');
Route::get('/admin/roles/change/{id}', array('uses'=>'AccesosController@cambiar_estado_rol'))->name('dashboard.roles.state.change');
Route::post('/admin/roles/update', array('uses'=>'AccesosController@actualizar_rol'))->name('dashboard.roles.update');
   /*
|--------------------------------------------------------------------------
| Permisos
|--------------------------------------------------------------------------
*/
Route::get('/admin/permissions/{id}', array('uses'=>'AccesosController@listado_accesos'))->name('dashboard.permissions');
Route::post('/admin/permissions', array('uses'=>'AccesosController@actualizar_permisos_rol'))->name('dashboard.permissions.update');

Route::get('/dashboard', function(){
 $titulo = '';
 $modulo = '';
 $seccion = '';
 $movil=0;
 $tablet_browser = 0;
 $mobile_browser = 0;
 $body_class = 'desktop';

 $clase_controlador = new Controller;
if($clase_controlador->consultar_mobile()){
 return redirect()->route('mostrar.ordenes');


}else{
 return view('dashboard.index',compact('titulo','modulo','seccion'));
}
 
 
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Utilidades
|--------------------------------------------------------------------------
*/
Route::get('/indicators/economic/globals', array('uses'=>'Utilidades\IndicadoresController@comprobar_valores_economicos'))->name('utilidades.indicadores.tasas');

/*
|--------------------------------------------------------------------------
| Empresas
|--------------------------------------------------------------------------
*/ 
Route::get('/empresas/listado', [EmpresasController::class, "listado_empresas"])->name('empresas.listado');
Route::post('/empresas/listado/data', array('uses'=>'Empresas\EmpresasController@listado_empresas_data'))->name('empresas.listado.data');
Route::post('/empresas/registrar', array('uses'=>'Empresas\EmpresasController@registrar_empresa'))->name('empresas.registrar');
Route::get('/empresas/detalle/{id}', array('uses'=>'Empresas\EmpresasController@obtener_empresa'))->name('empresas.detalle');
Route::get('/empresas/eliminar/{id}', array('uses'=>'Empresas\EmpresasController@eliminar_empresa'))->name('empresas.eliminar');
Route::get('/empresas/activas', array('uses'=>'Empresas\EmpresasController@obtener_empresas_activas'))->name('empresas.detalle');
Route::post('/empresas/actualizar', array('uses'=>'Empresas\EmpresasController@actualizar_empresa'))->name('empresas.actualizar');
/*
|--------------------------------------------------------------------------
| Configuraciones
|--------------------------------------------------------------------------
*/
Route::get('/settings', array('uses'=>'SettingsController@view_settings'))->name('settings.listado');
Route::get('/settings/details/{id}', array('uses'=>'SettingsController@get_setting'))->name('settings.details');
Route::post('/settings/update', array('uses'=>'SettingsController@update_setting'))->name('settings.update');
Route::post('/settings/cities/add', array('uses'=>'SettingsController@registrar_ciudad'))->name('settings.ciudad.registro');
Route::post('/settings/cities/update', array('uses'=>'SettingsController@actualizar_ciudad'))->name('settings.ciudad.actualizar');
Route::get('/settings/cities/get/{id}', array('uses'=>'SettingsController@obtener_ciudad'))->name('settings.ciudad.obtener_ciudad');
Route::get('/settings/cities/delete/{id}', array('uses'=>'SettingsController@eliminar_ciudad'))->name('settings.ciudad.eliminar_ciudad');
Route::get('/settings/cities', array('uses'=>'SettingsController@ciudades'))->name('settings.ciudad.listado');
Route::get('/settings/details/table/{table_index}', array('uses'=>'SettingsController@get_interval_rows'))->name('settings.details.table');


/*
|--------------------------------------------------------------------------
| Empaques
|--------------------------------------------------------------------------
*/
Route::get('/empaques/listado/entradas', array('uses'=>'EmpaquesController@listado_entradas_empaques'))->name('empaques.entradas');
Route::get('/empaques/listado/entradas/data', array('uses'=>'EmpaquesController@data_listado_empaques'))->name('empaques.entradas.data');
Route::post('/empaques/registrar/entrada', array('uses'=>'EmpaquesController@registrar_entrada'))->name('empaques.entrada.registrar');
Route::get('/empaques/entrada/detalle/{id}', array('uses'=>'EmpaquesController@obtener_empaque_entrada'))->name('empaques.entrada.detalle');
Route::get('/empaques/activas', array('uses'=>'EmpaquesController@obtener_empresas_activas'))->name('empresas.detalle');
Route::post('/empaques/entradas/actualizar', array('uses'=>'EmpaquesController@actualizar_entrada'))->name('empaques.entradas.actualizar');

Route::get('/empaques/listado/salidas', array('uses'=>'EmpaquesController@listado_salidas_empaques'))->name('empaques.salidas');
Route::get('/empaques/listado/salidas/data', array('uses'=>'EmpaquesController@data_listado_empaques_salidas'))->name('empaques.salidas.data');
Route::post('/empaques/registrar/salida', array('uses'=>'EmpaquesController@registrar_salida'))->name('empaques.salida.registrar');
Route::get('/empaques/salida/detalle/{id}', array('uses'=>'EmpaquesController@obtener_empaque_salida'))->name('empaques.salidas.detalle');
Route::post('/empaques/salida/actualizar', array('uses'=>'EmpaquesController@actualizar_salida'))->name('empaques.salidas.actualizar');
Route::get('/empaques/eliminar/{id}', array('uses'=>'EmpaquesController@eliminar_empaque'))->name('empaques.eliminar');



/*
|--------------------------------------------------------------------------
| Entradas Cafe
|--------------------------------------------------------------------------
*/


Route::get('/cafe/listado/entradas', array('uses'=>'EntradasSalidasController@listado_entradas_empaques'))->name('cafe.entradas');
//Route::get('/cafe/listado/entradas', array('uses'=>'EntradasSalidasController@data_listado_empaques'));
Route::post('/cafe/listado/entradas/data', array('uses'=>'EntradasSalidasController@listado_empaques_data'))->name('cafe.entradas.data');
Route::post('/cafe/registrar/entrada', array('uses'=>'EntradasSalidasController@registrar_entrada'))->name('cafe.entrada.registrar');
Route::get('/cafe/entrada/detalle/{id}', array('uses'=>'EntradasSalidasController@obtener_empaque_entrada'))->name('cafe.entrada.detalle');
Route::get('/cafe/entrada/eliminar/{id}', array('uses'=>'EntradasSalidasController@eliminar_entrada'))->name('cafe.entrada.eliminar');
Route::get('/cafe/activas', array('uses'=>'EntradasSalidasController@obtener_empresas_activas'))->name('cafe.detalle');
Route::post('/cafe/entradas/actualizar', array('uses'=>'EntradasSalidasController@actualizar_entrada'))->name('cafe.entradas.actualizar');
Route::post('/cafe/entradas/reporte', array('uses'=>'EntradasSalidasController@procesar_reporte_entrada'))->name('cafe.entradas.reporte');
Route::post('/cafe/entradas/reporte/liquidas', array('uses'=>'EntradasSalidasController@procesar_reporte_entradas_liquidadas'))->name('cafe.entradas.reporte_liquidadas');
Route::post('/cafe/salidas/reporte/liquidas', array('uses'=>'EntradasSalidasController@procesar_reporte_salidas_liquidadas'))->name('cafe.salidas.reporte_liquidadas');
Route::get('/cafe/registro/terminar/{id}', array('uses'=>'EntradasSalidasController@terminar_entrada_salida'))->name('cafe.terminar');
Route::get('/cafe/registro/habilitar/{id}', array('uses'=>'EntradasSalidasController@habilitar_entrada_salida'))->name('cafe.habilitar');

Route::get('/cafe/listado/salidas', array('uses'=>'EntradasSalidasController@listado_salidas_empaques'))->name('cafe.salidas');
Route::get('/cafe/listado/salidas/data', array('uses'=>'EntradasSalidasController@data_listado_empaques_salidas'));
Route::post('/cafe/listado/salidas/data', array('uses'=>'EntradasSalidasController@listado_empaques_salidas_data'))->name('cafe.salidas.data');
Route::post('/cafe/registrar/salida', array('uses'=>'EntradasSalidasController@registrar_salida'))->name('cafe.salida.registrar');
Route::get('/cafe/salida/detalle/{id}', array('uses'=>'EntradasSalidasController@obtener_empaque_salida'))->name('cafe.salidas.detalle');
Route::get('/cafe/salida/eliminar/{id}', array('uses'=>'EntradasSalidasController@eliminar_salida'))->name('cafe.salidas.eliminar');
Route::post('/cafe/salida/actualizar', array('uses'=>'EntradasSalidasController@actualizar_salida'))->name('cafe.salidas.actualizar');
Route::post('/cafe/salidas/reporte', array('uses'=>'EntradasSalidasController@procesar_reporte_salida'))->name('cafe.salidas.reporte');
Route::get('/cafe/salidas/comprobante/{id}', array('uses'=>'EntradasSalidasController@generar_comprobante_salida'))->name('cafe.salidas.comprobante');
Route::post('/entradas/salidas/corte', array('uses'=>'EntradasSalidasController@reporte_corte_mensual'))->name('entradas_salidas.corte'); 

/*
|--------------------------------------------------------------------------
| Operaciones
|--------------------------------------------------------------------------
*/
Route::get('/operaciones/listado/entradas', array('uses'=>'OperacionesController@listado_entradas'))->name('operaciones.entradas');
Route::get('/operaciones/listado/entradas/data', array('uses'=>'OperacionesController@data_listado'));
Route::post('/operaciones/registrar/entrada', array('uses'=>'OperacionesController@registrar'))->name('operaciones.entrada.registrar');
Route::get('/operaciones/entrada/detalle/{id}', array('uses'=>'OperacionesController@obtener_entrada'))->name('operaciones.entrada.detalle');
Route::post('/operaciones/entradas/actualizar', array('uses'=>'OperacionesController@actualizar_entrada'))->name('operaciones.entradas.actualizar');

Route::get('/operaciones/listado/salidas', array('uses'=>'OperacionesController@listado_salidas'))->name('operaciones.salidas');
Route::get('/operaciones/listado/salidas/data', array('uses'=>'OperacionesController@data_listad_salidas'))->name('operaciones.salidas.data');
Route::post('/operaciones/registrar/salida', array('uses'=>'OperacionesController@registrar_salida'))->name('operaciones.salida.registrar');
Route::get('/operaciones/salida/detalle/{id}', array('uses'=>'OperacionesController@obtener_salida'))->name('operaciones.salidas.detalle');
Route::post('/operaciones/salida/actualizar', array('uses'=>'OperacionesController@actualizar_salida'))->name('operaciones.salidas.actualizar');

/*
|--------------------------------------------------------------------------
| Centros de Operacion
|--------------------------------------------------------------------------
*/
Route::get('/empresas/centros_operacion/listado', array('uses'=>'Empresas\CentrosOperacionController@listado_centros'))->name('empresas.centros_operacion.listado');
Route::post('/empresas/centros_operacion/registrar', array('uses'=>'Empresas\CentrosOperacionController@registrar_centro'))->name('empresas.centros_operacion.registrar');
Route::get('/empresas/centros_operacion/detalle/{id}', array('uses'=>'Empresas\CentrosOperacionController@obtener_centro'))->name('empresas.centros_operacion.detalle');
Route::post('/empresas/centros_operacion/actualizar', array('uses'=>'Empresas\CentrosOperacionController@actualizar_centro'))->name('empresas.centros_operacion.actualizar');
Route::get('/empresas/centros_operacion/eliminar/{id}', array('uses'=>'Empresas\CentrosOperacionController@eliminar_centro'))->name('empresas.centros_operacion.eliminar');
/*
|--------------------------------------------------------------------------
| Centros de Costo
|--------------------------------------------------------------------------
*/
Route::get('/empresas/centros_costo/listado', array('uses'=>'Empresas\CentrosCostoController@listado_centros'))->name('empresas.centros_costo.listado');
Route::post('empresas/centros_operacion/listado/data', array('uses'=>'Empresas\CentrosCostoController@listado_centros_data'))->name('empresas.centros_costo.listado');
Route::post('/empresas/centros_costo/registrar', array('uses'=>'Empresas\CentrosCostoController@registrar_centro'))->name('empresas.centros_costo.registrar');
Route::get('/empresas/centros_costo/detalle/{id}', array('uses'=>'Empresas\CentrosCostoController@obtener_centro'))->name('empresas.centros_costo.detalle');
Route::get('/empresas/centros_costo/eliminar/{id}', array('uses'=>'Empresas\CentrosCostoController@eliminar_centro'))->name('empresas.centros_costo.eliminar');
Route::post('/empresas/centros_costo/actualizar', array('uses'=>'Empresas\CentrosCostoController@actualizar_centro'))->name('empresas.centros_costo.actualizar');
/*
|--------------------------------------------------------------------------
| Bancos
|--------------------------------------------------------------------------
*/
Route::get('/bancos/listado', array('uses'=>'BancosController@listado_bancos'))->middleware('ControlAcceso')->name('bancos.listado');
Route::post('/bancos/listado/data', array('uses'=>'BancosController@listado_bancos_data'))->name('bancos.listado.data');
Route::post('/bancos/cuentas/listado/data', array('uses'=>'BancosController@listado_cuentas_data'))->name('bancos.cuenta.listado.data');
Route::post('/bancos/registrar', array('uses'=>'BancosController@registrar_banco'))->middleware('ControlAcceso')->name('bancos.registrar');
Route::get('/bancos/detalle/{id}', array('uses'=>'BancosController@obtener_banco'))->name('bancos.detalle');
Route::get('/bancos/eliminar/{id}', array('uses'=>'BancosController@eliminar_banco'))->middleware('ControlAcceso')->name('bancos.eliminar');
Route::get('/bancos/activas', array('uses'=>'BancosController@obtener_bancos_activas'))->name('bancos.activos');
Route::post('/bancos/actualizar', array('uses'=>'BancosController@actualizar_banco'))->middleware('ControlAcceso')->name('bancos.actualizar');
/*
|--------------------------------------------------------------------------
| articulos y categorias
|--------------------------------------------------------------------------
*/

Route::get('/inventario/modelos/{id}', array('uses'=>'ArticulosController@consultar_modelos'))->name('inventario.modelos');
Route::get('/inventario/detalles/{id}', array('uses'=>'ArticulosController@consultar_detalles'))->name('inventario.detalles');
Route::get('/inventario/destacar', array('uses'=>'ArticulosController@inventario_destacar'))->name('articulo.destacar');
Route::post('/inventario/reporte', array('uses'=>'ArticulosController@inventario_reporte'))->name('inventario.reporte');
Route::any('/inventario/listado', array('uses'=>'ArticulosController@listado_inventario'))->name('inventario.listado');
Route::any('/inventario/listado/data', array('uses'=>'ArticulosController@listado_inventario_data'))->name('inventario.listado.data');
Route::any('/eliminar/articulo', array('uses'=>'ArticulosController@eliminar_articulo'))->name('articulo.eliminar');
Route::any('/articulo/categoria', array('uses'=>'ArticulosController@listado_articulo_categoria'))->name('articulo.categoria');
Route::get('/categorias/listado', array('uses'=>'ArticulosController@listado_categorias'))->name('categorias.listado');
Route::any('/registrar_editar/categoria', array('uses'=>'ArticulosController@registrar_editar_categoria'))->name('categoria.registrar_editar');
Route::any('/categorias/listado/data', array('uses'=>'ArticulosController@listado_categorias_data'))->name('categorias.listado.data');
Route::any('/articulos/listado/data', array('uses'=>'ArticulosController@listado_categorias_data'))->name('articulos.listado.data');
Route::any('/categoria/registrar', array('uses'=>'ArticulosController@registrar_categoria'))->name('categoria.registrar');
Route::any('/categoria/eliminar', array('uses'=>'ArticulosController@eliminar_categoria'))->name('categoria.eliminar');
Route::any('/categoria/editar', array('uses'=>'ArticulosController@actualizar_categoria'))->name('categoria.editar');
Route::any('/articulo/actualizar', array('uses'=>'ArticulosController@actualizar_articulo'))->name('articulo.actualizar');
Route::any('/inventario/registrar', array('uses'=>'ArticulosController@listado_inventario'))->name('inventario.registrar');

/*
|--------------------------------------------------------------------------
| Servicios
|--------------------------------------------------------------------------
*/

Route::get('/servicios/listado', array('uses'=>'ArticulosController@listado_precios'))->name('servicio.listado');
Route::any('/servicios/listado/data', array('uses'=>'ArticulosController@listado_servicios_data'))->name('servicio.listado.data');
Route::get('/servicios/listado/data/{id}', array('uses'=>'ArticulosController@listado_servicios_data'))->name('servicio.listado.data.unico');
Route::any('/servicio/registrar/editar', array('uses'=>'ArticulosController@registrar_editar_servicio'))->name('servicio.registrar_editar');
Route::any('/servicio/actualizar', array('uses'=>'ArticulosController@actualizar_servicio'))->name('servicio.actualizar');
Route::any('/eliminar/servicio', array('uses'=>'ArticulosController@eliminar_servicio'))->name('servicio.eliminar');


/*
|--------------------------------------------------------------------------
| Giros y Anticipos
|--------------------------------------------------------------------------
*/


Route::get('/giros/listado', array('uses'=>'GirosAnticiposController@listado_giros'))->name('giros.listado');
Route::post('/giros/listado/data', array('uses'=>'GirosAnticiposController@listado_giros_data'))->name('giros.listado_data');
Route::post('/giros/registrar', array('uses'=>'GirosAnticiposController@registrar_giro'))->name('giros.registrar');
Route::get('/giros/eliminar/{id}', array('uses'=>'GirosAnticiposController@eliminar_giro'))->name('giros.eliminar');
Route::post('/giros/reporte', array('uses'=>'GirosAnticiposController@procesar_reporte_giros'))->name('giros.reporte');
Route::get('/anticipos/listado', array('uses'=>'GirosAnticiposController@listado_anticipos'))->name('anticipos.listado');
Route::post('/anticipos/listado/data', array('uses'=>'GirosAnticiposController@listado_anticipos_data'))->name('anticipos.listado_data');
Route::post('/anticipos/registrar', array('uses'=>'GirosAnticiposController@registrar_anticipo'))->name('anticipos.registrar');
Route::get('/anticipos/eliminar/{id}', array('uses'=>'GirosAnticiposController@eliminar_anticipo'))->name('anticipos.eliminar');
Route::post('/anticipos/reporte', array('uses'=>'GirosAnticiposController@procesar_reporte_anticipos'))->name('anticipos.reporte');
Route::get('/anticipos/transporte/listado', array('uses'=>'GirosAnticiposController@listado_anticipos_transporte'))->name('anticipos.transporte.listado');
Route::post('/anticipos/transporte/registrar', array('uses'=>'GirosAnticiposController@registrar_anticipo_transporte'))->name('anticipos.transporte.registrar');
Route::get('/anticipos/transporte/eliminar/{id}', array('uses'=>'GirosAnticiposController@eliminar_anticipo_transporte'))->name('anticipos.transporte.eliminar');
Route::post('/anticipos/transporte/reporte', array('uses'=>'GirosAnticiposController@procesar_reporte_anticipos_transporte'))->name('anticipos.transporte.reporte');
Route::post('/anticipos/listado/reporte', array('uses'=>'GirosAnticiposController@reporte_anticipos_listado'))->name('contratos.reporte.anticipo');
Route::post('/giros/listado/reporte', array('uses'=>'GirosAnticiposController@reporte_giros_listado'))->name('contratos.reporte.giro');

/*
|--------------------------------------------------------------------------
| Bancos - Cuentas Bancarias
|--------------------------------------------------------------------------
*/
Route::get('/bancos/cuentas/listado', array('uses'=>'BancosController@listado_cuentas'))->name('bancos.cuenta.listado');
Route::post('/bancos/cuentas/registrar', array('uses'=>'BancosController@registrar_cuenta_banco'))->name('bancos.cuenta.registrar');
Route::get('/bancos/cuentas/detalle/{id}', array('uses'=>'BancosController@obtener_cuenta_banco'))->name('bancos.cuenta.detalle');
Route::get('/bancos/cuentas/eliminar/{id}', array('uses'=>'BancosController@eliminar_cuenta_banco'))->name('bancos.cuenta.eliminar');
Route::get('/bancos/cuentas/activas', array('uses'=>'BancosController@obtener_bancos_cuenta_activas'))->name('bancos.cuenta.activos');
Route::post('/bancos/cuentas/actualizar', array('uses'=>'BancosController@actualizar_cuenta_banco'))->name('bancos.cuenta.actualizar');
/*
|--------------------------------------------------------------------------
| Bancos - Saldos
|--------------------------------------------------------------------------
*/
Route::get('/bancos/cuentas/saldo', array('uses'=>'BancosController@listado_saldos'))->name('bancos.cuenta.listado.saldo');
Route::get('/bancos/cuentas/activas', array('uses'=>'BancosController@obtener_cuenta_bancos_activos'))->name('bancos.cuentas.activas');
Route::any('/bancos/cuentas/saldo/reporte', array('uses'=>'BancosController@procesar_reporte'))->name('bancos.saldo.procesar.reporte');
Route::get('/bancos/cuentas/saldo/eliminar/{id}', array('uses'=>'BancosController@eliminar_movimiento'))->name('bancos.saldo.eliminar');
Route::get('/bancos/cuentas/saldo/resumen', array('uses'=>'BancosController@reporte_saldos'))->name('saldo.reporte');
/*
|--------------------------------------------------------------------------
| Ingresos Egresos
|--------------------------------------------------------------------------
*/
Route::get('/ingreso-egreso', array('uses'=>'IngresosEgresosController@listado_ingreso_egresos'))->name('ingreso_egreso.listado');
Route::any('/ingreso-egreso/fecha', array('uses'=>'IngresosEgresosController@listado_ingreso_egresos_fecha'))->name('ingreso_egreso.listado.fecha');
Route::any('/ingreso-egreso/data', array('uses'=>'IngresosEgresosController@data_listado'))->name('ingreso_egreso.listado.data');
Route::get('/ingreso-egreso/eliminar/{id}', array('uses'=>'IngresosEgresosController@eliminar_movimiento'))->name('ingreso_egreso.eliminar');
Route::post('/ingreso-egreso/registrar', array('uses'=>'IngresosEgresosController@registrar_operacion'))->name('ingreso_egreso.registro');
Route::post('/ingreso-egreso/reporte', array('uses'=>'IngresosEgresosController@reporte_movimientos'))->name('ingresos/egresos.reporte');

/*
|--------------------------------------------------------------------------
| Liquidaciones - Entradas
|--------------------------------------------------------------------------
*/
Route::get('/eliminar_nota_credito', array('uses'=>'LiquidacionesController@eliminar_nota_credito'))->name('eliminar.nota_credito');
Route::get('/liquidaciones/recepcion', array('uses'=>'LiquidacionesController@listar_recepcion'))->name('liquidaciones.recepcion');
Route::post('/listado/recepcion/data', array('uses'=>'LiquidacionesController@listar_recepcion_data'))->name('liquidaciones.recepcion.data');
Route::get('/liquidaciones/entrada/liquidada', array('uses'=>'LiquidacionesController@listar_entradas_liquidadas'))->name('liquidaciones.entradas.liquidadas');
Route::post('/liquidaciones/entrada/liquidada/data', array('uses'=>'LiquidacionesController@listar_entradas_liquidadas_data'))->name('liquidaciones.entradas.liquidadas.data');
Route::get('/liquidaciones/entrada/contratos', array('uses'=>'LiquidacionesController@listar_contratos_compra_sin_liquidacion'))->name('liquidaciones.contratos.pendientes');
Route::get('/liquidaciones/entrada/listado', array('uses'=>'LiquidacionesController@listar_entradas'))->name('liquidaciones.entradas.listado');
Route::post('/liquidaciones/entrada/contratos/data', array('uses'=>'LiquidacionesController@listar_contratos_compra_sin_liquidacion_data'))->name('liquidaciones.contratos.pendientes.data');
Route::post('/liquidaciones/entrada/listado/data', array('uses'=>'LiquidacionesController@listar_entradas_data'))->name('liquidaciones.entradas.listado.data');
Route::get('/liquidaciones/entrada/listado/detalle/data/{id_entrada}', array('uses'=>'LiquidacionesController@listar_entradas_detalle_data'))->name('liquidaciones.entradas.listado.detalle.data');
Route::get('/liquidaciones/entrada/detalle/{id}', array('uses'=>'LiquidacionesController@obtener_liquidacion_entrada'))->name('liquidaciones.entradas.obtener');
Route::get('/liquidaciones/entrada/eliminar/{id}', array('uses'=>'LiquidacionesController@eliminar_liquidacion_entrada'))->name('liquidaciones.entradas.eliminar');
Route::post('/liquidaciones/entrada/registrar', array('uses'=>'LiquidacionesController@registrar_liquidacion_entrada'))->name('liquidaciones.entradas.registrar');
Route::get('/liquidaciones/entrada/actualizar', array('uses'=>'LiquidacionesController@actualizar_liquidacion_entrada'))->name('liquidaciones.entradas.actualizar');
Route::post('/liquidaciones/entrada/reporte', array('uses'=>'LiquidacionesController@procesar_reporte_entradas'))->name('liquidaciones.entradas.reporte');
Route::get('/liquidaciones/entrada/reporte/detalle', array('uses'=>'LiquidacionesController@listar_liquidacion_detalle_reporte_entrada'))->name('liquidaciones.entradas.reporte.detalle');
Route::get('/liquidaciones/entrada/resumen', array('uses'=>'LiquidacionesController@reporte_resumen_entradas'))->name('liquidaciones.entradas.reporte.resumen');
Route::get('/liquidaciones/entrada/contratos/proveedor/{id}', array('uses'=>'LiquidacionesController@obtener_contratos_proveedor'))->name('liquidaciones.entradas.repo_prov');
/*
|--------------------------------------------------------------------------
| Liquidaciones - Salidas
|--------------------------------------------------------------------------
*/
Route::post('/factura/reporte', array('uses'=>'LiquidacionesController@reporte_factura'))->name('factura.reporte');
Route::post('/liquidaciones/salida/registrar', array('uses'=>'LiquidacionesController@registrar_liquidacion_salida'))->name('liquidaciones.salidas.registrar');
Route::get('/liquidaciones/salida/imprimir/{id}', array('uses'=>'LiquidacionesController@imprimir_liquidacion_salida'))->name('liquidaciones.salida.imprimir');
Route::post('/liquidaciones/folios/cargar', array('uses'=>'controller@cargar_folios'))->name('folios.cargar');
Route::get('/liquidaciones/salida/liquidada', array('uses'=>'LiquidacionesController@listar_salidas_liquidadas'))->name('liquidaciones.salidas.liquidadas');
Route::post('/liquidaciones/salida/liquidada/data', array('uses'=>'LiquidacionesController@listar_salidas_liquidadas_data'))->name('liquidaciones.salidas.liquidadas.data');
Route::get('/liquidaciones/salida/contratos', array('uses'=>'LiquidacionesController@listar_contratos_venta_sin_liquidacion'))->name('liquidaciones.contratos.pendientes.salidas');
Route::post('/liquidaciones/salida/contratos/data', array('uses'=>'LiquidacionesController@listar_contratos_venta_sin_liquidacion_data'))->name('liquidaciones.contratos.pendientes.salidas.data');
Route::get('/liquidaciones/salida/listado', array('uses'=>'LiquidacionesController@listar_salidas'))->name('liquidaciones.salidas.listado');
Route::post('/liquidaciones/salida/listado/data', array('uses'=>'LiquidacionesController@listar_salida_data'))->name('liquidaciones.salidas.listadox');
Route::get('/liquidaciones/salida/detalle/{id}', array('uses'=>'LiquidacionesController@obtener_liquidacion_salida'))->name('liquidaciones.salidas.obtener');
Route::get('/liquidaciones/salida/eliminar/{id}', array('uses'=>'LiquidacionesController@eliminar_liquidacion_salida'))->name('liquidaciones.salidas.eliminar');
Route::get('/liquidaciones/salida/actualizar', array('uses'=>'LiquidacionesController@actualizar_liquidacion_salida'))->name('liquidaciones.salidas.actualizar');
Route::post('/liquidaciones/salida/reporte', array('uses'=>'LiquidacionesController@procesar_reporte_salidas'))->name('liquidaciones.salidas.reporte');
Route::get('/liquidaciones/salida/reporte/detalle', array('uses'=>'LiquidacionesController@listar_liquidacion_detalle_reporte_salida'))->name('liquidaciones.salidas.reporte.detalle');
Route::get('/liquidaciones/salida/resumen', array('uses'=>'LiquidacionesController@reporte_resumen_salidas'))->name('liquidaciones.salidas.reporte.resumen');
Route::get('/liquidaciones/salida/contratos/cliente/{id}', array('uses'=>'LiquidacionesController@obtener_contratos_cliente'))->name('liquidaciones.salidas.repo_cli');
/*
|--------------------------------------------------------------------------
| Despachos
|--------------------------------------------------------------------------
*/
Route::post('/despachos/actualizar', array('uses'=>'DespachosController@actualizar_despacho'))->name('despachos.actualizar');

Route::get('/despachos/culminados', array('uses'=>'DespachosController@listado_despachos_culminados'))->name('despachos.culminados');
Route::any('/despachos/culminados/data', array('uses'=>'DespachosController@listado_despachos_culminados_data'))->name('despachos.culminados.data');
Route::get('/despachos/pendientes', array('uses'=>'DespachosController@listado_salidas_por_despachar'))->name('despachos.pendientes');
Route::post('/despachos/pendientes/data', array('uses'=>'DespachosController@listado_salidas_por_despachar_data'))->name('despachos.pendientes.data');
Route::get('/despachos/pendientes/data', array('uses'=>'DespachosController@listado_salidas_por_despachar_data'))->name('despachos.pendientes.data');

Route::post('/despachos/add', array('uses'=>'DespachosController@registrar_despacho'))->name('despachos.registrar');
Route::get('/despachos/listado', array('uses'=>'DespachosController@listado_despachos'))->name('despachos');
Route::post('/despachos/listado/data', array('uses'=>'DespachosController@listado_despachos_data'))->name('despachos.data');
Route::get('/despachos/detalle/{id}', array('uses'=>'DespachosController@detalle_despacho_data'))->name('despachos.data');
Route::get('/despachos/eliminar/{id}', array('uses'=>'DespachosController@eliminar_despacho'))->name('despachos.eliminar');
Route::post('/despachos/procesar/pendiente', array('uses'=>'DespachosController@procesar_despacho_pendiente'))->name('despachos.datax');
Route::get('/despachos/entradas/pendientes', array('uses'=>'DespachosController@obtener_entradas_pendientes'))->name('despachos.entras.pendientes');
Route::post('/despachos/reporte', array('uses'=>'DespachosController@procesar_reportes'))->name('despachos.reporte');
Route::get('/despachos/salida/imprimir/{id}', array('uses'=>'DespachosController@imprimir_despacho_salida'))->name('despachos.salida.imprimir');
/*
|--------------------------------------------------------------------------
| Catalogo Empresas
|--------------------------------------------------------------------------
*/
Route::get('listar_empresas/vista', [CatalogoEmpresasController::class, "listar_empresas_vista"])->name('empresas.vista');
Route::any('registrar_editar/empresa',[CatalogoEmpresasController::class, "registrar_editar"])->name('registrar_editar.empresa');

Route::get('/catalogo/listado/clientes',[CatalogoEmpresasController::class, "listado_clientes"] )->name('catalogo.listado.clientes');
Route::any('/catalogo/registrar/cliente',[CatalogoEmpresasController::class, "registrar_empresa"] )->name('catalogo.registrar.clientes');
Route::post('/catalogo/listado/clientes/data',[CatalogoEmpresasController::class, "listado_clientes_data"] )->name('catalogo.listado.clientes_data');
Route::get('/catalogo/detalle/{id}',[CatalogoEmpresasController::class, "obtener_empresa"] )->name('catalogo.detalle.cliente');
Route::post('/catalogo/actualizar/cliente',[CatalogoEmpresasController::class, "actualizar_empresa"] )->name('catalogo.actualizar.cliente');
Route::get('/catalogo/eliminar/{id}',[CatalogoEmpresasController::class, "eliminar_empresa"] )->name('catalogo.eliminar');
Route::get('/catalogo/validar/{nit}/{dv}/{email}',[CatalogoEmpresasController::class, "validar_registro_unico"] )->name('catalogo.validar');
Route::get('/catalogo/obtener/tipo/{tipo}',[CatalogoEmpresasController::class, "obtener_catalogo_segun_tipo"] )->name('catalogo.ajax');
Route::post('/catalogo/reporte/cliente',[CatalogoEmpresasController::class, "reporte_clientes"] )->name('reporte.cliente');

/*
|--------------------------------------------------------------------------
| Contratos
|--------------------------------------------------------------------------
*/

Route::post('registrar_editar/plantilla',[ContratosController::class, "registrar_editar_plantilla"])->name('registrar_editar.plantilla');

Route::any('/contrato/listado/articulos',[ContratosController::class, "agregar_articulos"])->name('contrato.articulos');

Route::any('/contrato/listado/articulos',[ContratosController::class, "agregar_articulos"])->name('contrato.articulos');
Route::post('/contrato/registrar', array('uses'=>'ContratosController@registrar_contrato_venta'))->name('contrato.registrar');
Route::post('/contrato/actualizar', array('uses'=>'ContratosController@actualizar_contrato_venta'))->name('contrato.actualizar');
Route::any('presupuesto/venta/comprobante/{id}', array('uses'=>'ContratosController@generar_presupuesto_venta'))->name('presupuesto.venta.comprobante');
Route::post('/contrato/compra/actualizar', array('uses'=>'ContratosController@actualizar_contrato_compra'))->name('contrato.compra.actualizar');


Route::get('/contratos/plantillas', [ContratosController::class, "listar_plantillas"])->name('contratos.plantillas');
Route::get('/contratos/listado/compras', [DemandasController::class, "listado_demandas"])->name('contratos.compras');
Route::any('/contratos/listado/compra/data', [DemandasController::class, "listado_demandas_data"])->name('contratos.compras.data');
Route::post('/contratos/registrar/compra', [DemandasController::class, "registrar_editar"])->name('contratos.compra.registrar');
Route::get('/contratos/compra/detalle/{id}', [ContratosController::class, "obtener_contrato_compra"])->name('contratos.compra.detalle');
Route::get('/contratos/eliminar/{id}', array('uses'=>'ContratosController@eliminar_contrato'))->name('contratos.eliminar');
Route::post('/contratos/compra/actualizar', array('uses'=>'ContratosController@actualizar_contrato_compra'))->name('contratos.compras.actualizar');

Route::get('/contratos/terminar/{id}', array('uses'=>'ContratosController@terminar_contrato'))->name('contratos.terminar');
Route::get('/contratos/habilitar/{id}', array('uses'=>'ContratosController@habilitar_contrato'))->name('contratos.habilitar');
Route::get('/contratos/compra/habilitar/{id}', array('uses'=>'ContratosController@habilitar_contrato_compra'))->name('contratos.compra.habilitar');
Route::get('/contratos/compra/imprimir/{id}', array('uses'=>'ContratosController@imprimir_contrato_compra'))->name('contratos.compras.imprimir');

Route::any('/contratos/listado/ventas', array('uses'=>'ContratosController@listado_contrato_ventas'))->name('contratos.ventas');
Route::any('/contratos/listado/venta/data', array('uses'=>'ContratosController@listado_contratos_venta_data'))->name('contratos.ventas.data');
Route::post('/contratos/registrar/venta', array('uses'=>'ContratosController@registrar_contrato_venta'))->name('contratos.venta.registrar');
Route::get('/contratos/venta/detalle/{id}', array('uses'=>'ContratosController@obtener_contrato_venta'))->name('contratos.venta.detalle');
Route::any('/contratos/venta/actualizar', array('uses'=>'ContratosController@actualizar_contrato_venta'))->name('contratos.ventas.actualizar');

Route::post('/contratos/listado/reporte/compra', array('uses'=>'ContratosController@reporte_contratos_compra_data'))->name('contratos.reporte.compra'); 
Route::post('/contratos/listado/reporte/venta', array('uses'=>'ContratosController@reporte_contratos_venta_data'))->name('contratos.reporte.venta'); 
Route::post('/contratos/listado/reporte', array('uses'=>'ContratosController@reporte_corte_mensual'))->name('contratos.reporte'); 





//articulos
Route::get('/buscar/servicios/{id}', array('uses'=>'ArticulosController@buscar_servicios'))->name('buscar.servicios');
Route::get('/buscar/servicio/{id}/{servicio}', array('uses'=>'ArticulosController@buscar_servicio'))->name('buscar.servicio');
Route::post('/servicios/comunes/data', array('uses'=>'ArticulosController@listado_servicios_comunes_data'))->name('servicio.comunes.data');
Route::get('/servicios/comunes', array('uses'=>'ArticulosController@listado_servicios_comunes'))->name('servicio.comun');
Route::post('/servicios/comunes/agregar_editar', array('uses'=>'ArticulosController@agregar_editar_servicios_comunes'))->name('agregar_editar.servicios.comunes');
Route::get('/buscar/articulo/{id}', array('uses'=>'ArticulosController@buscar_articulo'))->name('buscar.articulo');
Route::post('registrar_editar/articulo', array('uses'=>'ArticulosController@registrar_editar_articulo'))->name('registrar_editar.articulo');

/*

|--------------------------------------------------------------------------
| ordenes de trabajo (OT)
|--------------------------------------------------------------------------
*/
Route::get('/listar/ordenes/vista_escritorio', array('uses'=>'OrdenesController@listar_ordenes_vista'))->name('listar.ordenes.vista');
Route::get('/listar/ordenes/vista_mobile', array('uses'=>'OrdenesControllerMovil@listar_ordenes_vista_mobile'))->name('listar.ordenes.vista_mobile');
Route::post('/listar/ordenes/tabla', array('uses'=>'OrdenesController@listar_ordenes_tabla'))->name('listar.ordenes.tabla');
Route::get('/habilitar_orden/{id}', array('uses'=>'OrdenesController@habilitar_orden'))->name('habilitar.orden');
Route::get('/deshabilitar_orden/{id}', array('uses'=>'OrdenesController@deshabilitar_orden'))->name('deshabilitar.orden');
Route::get('/destacar/orden', array('uses'=>'OrdenesController@destacar_orden'))->name('destacar.orden');

/*
|--------------------------------------------------------------------------
| Contratos de venta(CV)
|--------------------------------------------------------------------------
*/
Route::get('/destacar/cotizacion', array('uses'=>'ContratosController@destacar_cotizacion'))->name('destacar.cotizacion');
Route::get('/destacar/factura', array('uses'=>'ContratosController@destacar_factura'))->name('destacar.factura');


Route::get('/listar/elementos/{id_orden}/{id_lista}', array('uses'=>'OrdenesController@listar_elementos'))->name('listar.elementos');
Route::get('/listar/elementos/detallado/{id_orden}/{id_lista}/{id_elemento}', array('uses'=>'OrdenesController@listar_elementos_detallado'))->name('listar.elementos.detallado');
Route::post('/registrar_editar/orden', array('uses'=>'OrdenesController@registrar_editar'))->name('registrar_editar.orden');
Route::post('/registrar_editar/orden/mobile', array('uses'=>'OrdenesControllerMobile@registrar_editar'))->name('registrar_editar.orden.mobile');
Route::get('/consultar/listas/{id}', array('uses'=>'OrdenesController@consultar_listas'))->name('consultar.listas');
Route::post('/almacenar/detalles', array('uses'=>'OrdenesControllerMobile@almacenar_detalles'))->name('almacenar.detalles');
Route::get('/consultar/comentario/{nombre}', array('uses'=>'OrdenesControllerMobile@consultar_comentario'))->name('consultar.comentario');
Route::get('/registrar/base_datos/{nombre}/{texto}/{tipo_campo}', array('uses'=>'OrdenesControllerMobile@registrar_base_datos'))->name('registrar.base_datos');
Route::post('/registrar/base_datos/', array('uses'=>'OrdenesControllerMobile@registrar_base_datos'))->name('registrar.base_datos.post');
Route::post('/buscar/orden', array('uses'=>'OrdenesControllerMobile@buscar_orden'))->name('buscar.orden');
Route::get('/mostrar/encuestas', array('uses'=>'OrdenesControllerMobile@mostrar_encuestas'))->name('mostrar.encuestas');

}