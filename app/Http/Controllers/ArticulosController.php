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
use App\Models\Productos;
use App\Models\Inventario;
use App\Models\Articulos_categorias;
use App\Models\CentrosCosto;
use App\Models\Listas;
use App\Models\InventarioModelos;
use App\Models\InventarioDetalles;
class ArticulosController extends Controller
{
   
    public function listado_categorias(){
     
        $titulo = 'Modulo categorias';
		$modulo = 'Bodega';
		$seccion = 'Servicios';
        $session= session('role_id');
        $articulos=Inventario::select('id','nombre')->get();
       

        $clientes = CatalogoEmpresas::where('es_cliente',1)->orderBy('nit','asc')->get();
       
        return view('servicios.listado_categorias',compact('articulos','clientes','titulo','modulo','seccion','session'));
    }


    public function listado_categorias_data(Request $request){
        
        if(isset($request->id)){
            return Listas::where('id_servicio',$request->id)->get();
        }else{
        $operaciones=Inventario::where('es_categoria',1)
            ->select('*')->get();
        }
        return Datatables::of($operaciones)->make();
   
    }
    
    public function listado_precios(){
       
        $titulo = 'Modulo Lista de precios';
		$modulo = 'Bodega';
		$seccion = 'Servicios';
        $session= session('role_id');
        $registros = GirosAnticipos::where('tipo_operacion',2)->get();
        $articulos=Inventario::select('id','nombre')->get();
        $bodegas=CentrosCosto::select('id','descripcion')->get();
        $categorias=Inventario::where('es_categoria',1)
        ->select('*')->get();
       

        $clientes = CatalogoEmpresas::where('es_cliente',1)->orderBy('nit','asc')->get();
        $cuentas = CuentasBancos::orderBy('created_at','asc')->get();
       
        return view('servicios.listado_servicios',compact('articulos','clientes','registros','titulo','modulo','seccion','cuentas','session','categorias','bodegas'));
    }
    
    
    public function listado_servicios_comunes(Request $request){
        $titulo = 'Modulo Lista de servicos comunes';
		$modulo = 'Bodega';
		$seccion = 'Servicios';
        $session= session('role_id');
            return view('articulos.listado_servicios_comunes',compact('titulo','modulo','seccion',"session"));
       }

    public function listado_servicios_comunes_data(Request $request){
        
        if(isset($request->id)){
            return Listas::where('id_servicio',$request->id)->get();
        }else{
        $operaciones=Inventario::where('es_servicio_comun',1)
            ->select('*')->get();

            foreach($operaciones as $rows){
                $rows->nombre_categoria=Inventario::where('id',$rows->id_categoria)->select('nombre')->value('nombre');
            }
        }
        return Datatables::of($operaciones)->make();
    }
    
    public function agregar_editar_servicios_comunes(Request $request){
       
        if($request->id==0){
            $servicio=new inventario;
        }else{
            $servicio=inventario::find($request->id);
        }
        
        $servicio->nombre=strtoupper($request->nombre_interno);
        $servicio->valor_compra=str_replace('.','',$request->valor_compra);
        $servicio->es_servicio_comun=1;
        $servicio->save();

        return redirect()->route('servicio.comun')->with('result',array('message'=>'El servicio '.$request->c01.' se registro Exitosamente','type'=>'success'));
    }
    public function listado_servicios_data(Request $request){
        
        if(isset($request->id)){
            return Listas::where('id_servicio',$request->id)->get();
        }else{
        $operaciones=Inventario::where('es_servicio',1)
            ->select('*')->get();

            foreach($operaciones as $rows){
                $rows->nombre_categoria=Inventario::where('id',$rows->id_categoria)->select('nombre')->value('nombre');
            }
        }
        return Datatables::of($operaciones)->make();
    }

    public function registrar_editar_servicio(Request $request){
  
        $registro = new Inventario;
        
        if($request->id!=''){
            $registro=Inventario::find($request->id);
            InventarioModelos::where('id_inventario',$request->id)->delete();//eliminamos modelos
            InventarioDetalles::where('id_inventario',$request->id)->delete();//eliminamos detalles
        }
        $registro->codigo = $request->c03;
        $registro->nombre = strtoupper($request->c01);
        $registro->es_servicio= 1;
        $registro->id_categoria=$request->categoria;
        $registro->save(); 
        $id=$registro->id;
        //crear caracteristica arreglo de referencia para iterar modelos
        if(isset($_POST['caracteristicas'])){
            foreach($_POST['caracteristicas'] as $index => $registro){
    			$detalle = new InventarioModelos;
                $detalle->id_inventario=$id;
    			$detalle->nombre = strtoupper($_POST['caracteristicas'][$index]);
    			$detalle->save();
                
            }
        }
        ///crear detalles, arreglo de referencia para iterar modelos itera valor y cantidad al mismo tiempo es importante que tenga algo
        
        if(isset($_POST['elementos'])){
         foreach($_POST['elementos'] as $index => $registro){
            
			$detalle =new InventarioDetalles;
			$detalle->id_inventario= $id;
            $detalle->descripcion= strtoupper($_POST['elementos'][$index]);
            $detalle->valor= str_replace('.','',$_POST['valor'][$index]);
            $detalle->alto= $_POST['alto'][$index];
            $detalle->ancho= $_POST['ancho'][$index];
			$detalle->save();
             
         }
        }
         $i=0;
        foreach ($_FILES as $file){
            if($file['tmp_name']!=""){
                $extencion= pathinfo($file['name'], PATHINFO_EXTENSION);
                $name =$id.'.png';//$extencion;
              // $path =asset();//public_path(): este metodo me permite saber la ruta publica del servidor
              $ruta='catalogo/'.$name;
             
               if(file_exists($ruta)){
                   unlink($ruta);
               }
                
                move_uploaded_file($file['tmp_name'],$ruta);
                
            }  
            $i++; 
            
        }

      return redirect()->route('servicio.listado')->with('result',array('message'=>'El servicio '.$request->c01.' se registro Exitosamente','type'=>'success'));
    }
   
    public function registrar_editar_categoria(Request $request){
      
        $registro = new Inventario;
        $id=$registro->id;
        if($request->id!=''){
            $registro=Inventario::find($request->id);
            $id=$request->id;
        }
        $registro->codigo = $request->codigo;
        $registro->nombre = strtoupper($request->nombre);
        $registro->medida = $request->medida;
        $registro->es_categoria= 1;
        $registro->save(); 
        //crear caracteristica
      
        return redirect()->route('categorias.listado')->with('result',array('message'=>'El servicio '.$request->c01.' se registro Exitosamente','type'=>'success'));
    
    }


    public function consultar_modelos(Request $request){
      
    return InventarioModelos::where('id_inventario',$request->id)->get();
    
    }
  
    public function consultar_detalles(Request $request){
      
        return InventarioDetalles::where('id_inventario',$request->id)->get();
        
    }

    public function registrar_editar_articulo(Request $request){
       
        //registrar nuevo articulo
         if($request->id==0){
            $registro = new Inventario;
        }else{
            $registro =Inventario::find($request->id);
        }
            $registro->nombre =strtoupper($request->nombre);//round(str_replace('.','',$request->c02)/$this->calcular_indicador(),2);
         $registro->nombre_interno =strtoupper($request->nombre_interno);

            $registro->valor=str_replace('.','',$request->valor_venta);
            $registro->valor_compra=str_replace('.','',$request->valor_compra);
            $registro->es_articulo=1;
            $registro->codigo=strtoupper($request->modelo); 
            $registro->id_categoria=$request->categoria;  
            $registro->save();
       
        return redirect()->route('inventario.listado')->with('result',array('message'=>'El Registro se realizo Exitosamente','type'=>'success'));
    }
    
    
    
    
    
    
    
    //******antiguo */
    
    
    
    
    public function actualizar_servicio(Request $request){
      
            $registro = Inventario::find($request->id);
            $registro->codigo = $request->c03;
            $registro->nombre = $request->c01;
            $registro->valor= str_replace('.','',$request->c02);
            $registro->categoria = $request->c04;
            $registro->es_servicio= 1;
            $registro->save();
            return redirect()->route('servicio.listado')->with('result',array('message'=>'El servicio '.$request->c01.' se actualizo Exitosamente','type'=>'success'));
    }

 

    public function registrar_categoria(Request $request){
     
        return $request;
        //registrar nuevo articulo
         if($request->c01){
            $registro = new Inventario;
            $registro->nombre =strtoupper($request->c01);//round(str_replace('.','',$request->c02)/$this->calcular_indicador(),2);
            $registro->valor=str_replace('.','',$request->c02);
            $registro->valor_compra=str_replace('.','',$request->valor_compra);
            $registro->es_articulo=1;
            $registro->codigo=strtoupper($request->codigo); 
            $registro->id_categoria=$request->categoria;  
            $registro->save();
         }
         return redirect()->route('inventario.listado')->with('result',array('message'=>'El Registro se realizo Exitosamente','type'=>'success'));
        }
    public function eliminar_categoria(Request $request){
         $id = $_GET['id'];
         $id_categoria = $_GET['id_categoria'];
         Productos::find($id)->delete();
         $operaciones=Datatables::of(
            Productos::query()
            ->where('id_categoria',$id_categoria)
            ->select('*') 
        )->make();
        return $operaciones;
    }
    public function actualizar_articulo(Request $request){
        
        $valor=0;
        $registro = Inventario::find($request->id);
        $registro->nombre=strtoupper($request->nombre); 
        if($request->valor!=""){
            $valor=round(str_replace('.','',$request->valor)/$this->calcular_indicador(1),2);
        }
        $registro->valor= $valor;
        if($request->codigo!=null){
            $codigo=strtoupper($request->codigo);
        }
        $registro->codigo = $codigo;  
        $registro->stock = str_replace('.','',$request->stock);
        $registro->stock_p = str_replace('.','',$request->stock_p);
        $registro->save();
        
        //eliminar articulos categorias
        $art_categoria=Articulos_categorias::where('id_articulo',$request->id)->get();
        foreach($art_categoria as $rows){
            Articulos_categorias::where('id_articulo',$rows->id_articulo)->delete();
        }
        //crear articulos categorias
        return $this->listado_inventario_data();

    }
    public function actualizar_categoria(Request $request){
        $id_categoria = $_GET['id_categoria'];
        if(isset($_GET['modo'])){
           
            $modo=$_GET['modo'];
            if($modo=='todos'){
                $id_categoria=0;
                $operaciones=Inventario::where('categoria',0)->get();
                    foreach($operaciones as $rows){
                        $id_categoria=Articulos_categorias::join('004_categorias','004_categorias.id','004_articulos_categorias.id_categoria')
                          ->where('id_articulo',$rows->id)->select('004_categorias.nombre')->get();
                       $rutas="";
                      foreach( $id_categoria as $rowsx){
                            $rutas.=$rowsx->nombre.',';
                      }
                        $rows->rutas=$rutas;
                        $rows->principal=1;
                     }
                return Datatables::of($operaciones)->make();
            }else{//para modo 1
                
                $operaciones=Articulos_categorias::query()
                ->join('inventario','inventario.id','=','004_articulos_categorias.id_articulo')
                ->where('id_categoria',$id_categoria)
                ->select('*')->get()
               ;
               foreach($operaciones as $rows){
                $id_categoria=Articulos_categorias::join('004_categorias','004_categorias.id','004_articulos_categorias.id_categoria')
                 ->where('id_articulo',$rows->id)->select('004_categorias.nombre','004_categorias.es_tienda')->get();
               $rutas="";
               $es_tienda=0;
              foreach( $id_categoria as $rowsx){
                    $rutas.=$rowsx->nombre.',';
                    if($rowsx->es_tienda==1){
                        $es_tienda=1; 
                    }
              }
                $rows->rutas=$rutas;
                $rows->es_tienda=$es_tienda;

                
     
             }
                return Datatables::of($operaciones)->make();
        }
        }else{
            $id = $_GET['id'];
           
            if($id!=0){
                $nombre = $_GET['nombre'];
                $registro = Productos::find($id);
                $registro->nombre=strtoupper($nombre);
                $registro->id_categoria=$id_categoria;
                $registro->save();
            }
        $operaciones=Datatables::of(
            Productos::query()
            ->where('id_categoria',$id_categoria)
            ->select('*') 
        )->make();
        return $operaciones;
    }
    }
    public function listado_inventario(){
        $titulo = 'Listado Inventario';
		$modulo = 'Inventario';
		$seccion = 'Bodega';
        $session= session('role_id');
        $dolar=$this->calcular_indicador(1);
        $articulos=Inventario::select('id','nombre')->where('es_articulo',1)->get();
        $clientes = CatalogoEmpresas::where('es_cliente',1)->orderBy('nit','asc')->get();
        $categorias=Inventario::where('es_categoria',1)->get();
        return view('articulos.listado_articulos',compact('dolar','titulo','modulo','seccion','clientes','session','articulos','categorias'));
    }
    
    public function listado_inventario_data(){
        $id_categoria=0;
        $operaciones=Inventario::where('es_articulo',1)->get();
  
    foreach($operaciones as $rows){
      $rows->categoria=Inventario::where("id",$rows->id_categoria)->select('nombre')->value("nombre");

    }
        
        return Datatables::of($operaciones)->make();
    }

       
    public function eliminar_articulo(Request $request){
       
        Inventario::find($request->id_articulo)->delete();
  
    }

    public function eliminar_servicio(Request $request){
        Inventario::find($request->id_articulo)->delete();
        $operaciones=Inventario::where('es_servicio',1)
        ->select('*')->get();
        return Datatables::of($operaciones)->make();
    }

    public function buscar_articulo(Request $request){
       
        $articulo=Inventario::where('id',$request->id)
        ->get();
      

        
    return $articulo;
   }
    
     public function buscar_servicios(Request $request){
       
    $servicios=InventarioDetalles::where('id_inventario',$request->id)
    ->get();
    return $servicios;
}

    public function buscar_servicio(Request $request){
       
    $servicios=InventarioDetalles::where('id_inventario',$request->id)->where("id",$request->servicio)
    ->get();
    return $servicios;
   }




    public function listado_giros_data(){
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
        return $operaciones;
    }
    
     public function inventario_destacar(Request $request){
       
         $registro = Inventario::find($request->id_articulo);
         $destacar=$registro->es_destacado;
         if($destacar==0){
             $destacar=1;
         }else{
             $destacar=0;
         }
         $registro->es_destacado= $destacar;
        $registro->save();  
        
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

 

  
     /*
	|--------------------------------------------------------------------------
	| Reporte de Inventario
	|--------------------------------------------------------------------------
    */
    public function inventario_reporte(Request $request){
        $imagen = base64_encode(\Storage::get('logo.png'));
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $categoria=$request->c03;
        $excel=$request->c04;
        $ruta="";
         $consulta=Inventario::where('es_servicio',0);
        //filtrar por fecha si existe
        if($fecha_inicial && $fecha_final){
           $consulta=$consulta->whereBetween('inventario.created_at',[$fecha_inicial.' 00:00',$fecha_final.' 23:59']);
        }
        //filtrar por categoria
        if($categoria!=""){

            $consulta=$consulta->join('004_articulos_categorias','004_articulos_categorias.id_articulo','inventario.id')
            ->where('004_articulos_categorias.id_categoria',$categoria)
            ->where('004_articulos_categorias.deleted_at',null);
        }
      
        $consulta=$consulta->select('inventario.id','inventario.created_at','inventario.nombre','valor','stock','codigo')->get();

        foreach($consulta as $rows){
            $id_categoria=Articulos_categorias::join('004_categorias','004_categorias.id','004_articulos_categorias.id_categoria')
           ->where('id_articulo',$rows->id)
           ->select('004_categorias.ruta','004_categorias.id')->get();
           $rutas="";
           $i=0;
           $categoria1=0;
           $categoria2=0;
           $categoria3=0;
           $categoria4=0;
       foreach( $id_categoria as $rowsx){
           $rutas.=$rowsx->ruta.'//';
           if($i==0){
               $categoria1=$rowsx->id;
           }
           if($i==1){
               $categoria2=$rowsx->id;
           }
           if($i==3){
               $categoria3=$rowsx->id;
           }
           if($i==4){
               $categoria4=$rowsx->id;
           }
           $i++;
       }    
           $rows->categoria1=$categoria1;
           $rows->categoria2=$categoria2;
           $rows->categoria3=$categoria3;
           $rows->categoria4=$categoria4;
           $rows->rutas=$rutas;    
           $rows->principal=1;
   
       }

      $consulta;
                  
        if(count($consulta)==''){
            return view('articulos.reportes.no-reporte');
        }else{
              return view('articulos.reportes.reporte_inventario',compact('consulta','fecha_inicial','fecha_final','excel','imagen'));
        } 
    }
   
}

