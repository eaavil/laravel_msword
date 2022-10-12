<?php

namespace App\Http\Controllers;
use App\Models\CatalogoEmpresas;
use App\Models\Poblaciones;
use App\Models\TipoRegimen;
use App\Models\Bancos;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CatalogoEmpresasController extends Controller
{
    public function listado_clientes(){
        $titulo = 'Listado Total de Clientes';
		$modulo = 'Configuracion';
        $seccion = 'Clientes';
        $tipo_etiqueta = 'Cliente';
		$tipo = 1;
        $session= session('role_id');
        $registros = CatalogoEmpresas::all();
        $regimen = TipoRegimen::all();
        $bancos = Bancos::all();
        $poblaciones = CatalogoEmpresas::select('id_poblacion');
        return view('catalogo_empresas.listado_clientes',compact('registros','titulo','modulo','seccion','poblaciones','tipo','regimen','bancos','tipo_etiqueta','session'));
    }

    public function listado_clientes_data(){
        $operaciones=Datatables::of(
            CatalogoEmpresas::query()
        )->make();

        return $operaciones;
    }
    
    public function registrar_empresa(Request $request){
        $location="";
        foreach ($_FILES as $file) {
            
       
            if($file['tmp_name']!=""){
                $extencion= pathinfo($file['name'], PATHINFO_EXTENSION);
              /*  dump($request);
                  exit();
                  return $request->id;
                  exit();*/
                  
                if($extencion=='pdf'){
                    
                    $location="hojas_de_vida/";
                    $name = $request->id.'.pdf';//$extencion;
                }else{
                  $location="firmas/";
                    $name =$request->id.'.jpg';//$extencion;
                }
               
               // $path =asset();//public_path(): este metodo me permite saber la ruta publica del servidor
             
              if(file_exists($location.$name)){
                   unlink($location.$name);
              }
              //   return $location.$name;
                move_uploaded_file($file['tmp_name'],$location.$name);
                
            }  
            
        }
        
        $registro = new CatalogoEmpresas;
        $registro->nombre=strtoupper($request->c01);
        $registro->nit=str_replace('.','',$request->c02);
        $registro->direccion=strtoupper($request->c04);
        $registro->id_poblacion=strtoupper($request->c05);
        $registro->comuna=strtoupper($request->comuna);
        $registro->giro=strtoupper($request->giro);
        $registro->numero_telefono_1=$request->c06;
        $registro->email_empresa=strtoupper($request->c07);
        $registro->id_tipo_regimen=$request->c08;
        $registro->id_banco=$request->c09;
        $registro->numero_cuenta=$request->c10;
        $registro->tipo_cuenta=$request->c11;
        $registro->persona_contacto=strtoupper($request->c17);
      
        if($request->c12){
            $registro->es_cliente=1;
        }
        if($request->c13){
            $registro->es_empleado=1;
        }
        if($request->c14){
            $registro->es_proveedor=1;
        }
        if($request->c15){
            $registro->es_tercero=1;
        }
		if($request->c16){
            $registro->es_empresa_transporte=1;
        }

        $registro->es_eps=0;
        $registro->es_arp=0;
        $registro->es_caja_compensacion=0;
        $registro->es_pension=0;
        $registro->es_cesantias=0;
        $registro->es_taller=0;
        $registro->es_medico=0;
        $registro->es_colegio=0;
        $registro->es_ess=0;
        $registro->es_arl=0;

        $registro->estado=1;
        $registro->id_empresa=1;
        $registro->save();

        return redirect()->back()->with('result',array('message'=>'El Registro del Cliente se realizo Exitosamente','type'=>'success'));
    }

    public function actualizar_empresa(Request $request){
       
        $location="";
        foreach ($_FILES as $file) {
            
       
            if($file['tmp_name']!=""){
                $extencion= pathinfo($file['name'], PATHINFO_EXTENSION);
              /*  dump($request);
                  exit();
                  return $request->id;
                  exit();*/
                  
                if($extencion=='pdf'){
                    
                    $location="hojas_de_vida/";
                    $name = $request->id.'.pdf';//$extencion;
                }else{
                    
                     $location="firmas/";
                    $name =$request->id.'.jpg';//$extencion;
                }
               
               // $path =asset();//public_path(): este metodo me permite saber la ruta publica del servidor
            
              if(file_exists($location.$name)){
                   unlink($location.$name);
                   
              }
              //   return $location.$name;
                move_uploaded_file($file['tmp_name'],$location.$name);
                
            }  
            
        }
        
        $registro = CatalogoEmpresas::find($request->id);
        $registro->nombre=strtoupper($request->c01);
        $registro->nit=$request->c02;
        $registro->direccion=strtoupper($request->c04);
        $registro->id_poblacion=strtoupper($request->c05);
        $registro->comuna=strtoupper($request->comuna);
        $registro->giro=strtoupper($request->giro);
        $registro->numero_telefono_1=$request->c06;
        $registro->email_empresa=strtoupper($request->c07);
        $registro->id_tipo_regimen=$request->c08;
        $registro->id_banco=$request->c09;
        $registro->numero_cuenta=$request->c10;
        $registro->tipo_cuenta=$request->c11;
        $registro->persona_contacto=strtoupper($request->c17);
       
       if($request->c12){
            $registro->es_cliente=1;
        }else{
            $registro->es_cliente=0;
        }
        
        if($request->c13){
            $registro->es_empleado=1;
        }else{
            $registro->es_empleado=0;
        }
        
        if($request->c14){
            $registro->es_proveedor=1;
        }else{
            $registro->es_proveedor=0;
        }
        
        if($request->c15){
            $registro->es_tercero=1;
        }else{
            $registro->es_tercero=0;
        }
        
		if($request->c16){
            $registro->es_empresa_transporte=1;
        }else{
            $registro->es_empresa_transporte=0;
        }
		
     
        $registro->estado=1;
        $registro->id_empresa=1;
        $registro->save();


        return redirect()->back()->with('result',array('message'=>'El Registro del Cliente se actualizo Exitosamente','type'=>'success'));
    }

    public function eliminar_empresa($id){
        $registro = CatalogoEmpresas::where('id',$id)->delete();
        return redirect()->back()->with('result',array('message'=>'El Registro se elimino Exitosamente','type'=>'success'));
    }

    public function obtener_empresa($id){
        $registro = CatalogoEmpresas::find($id);
        return json_encode($registro);
    }    
	
	public function validar_registro_unico($nit,$dv,$email){
        $nit = CatalogoEmpresas::where('nit',$nit)->where('digito_verificacion_nit',$dv)->count();
        $email = CatalogoEmpresas::where('email_empresa',$email)->count();
		
		$vali_nit = false;
		$vali_email = false;
		
		if($nit>0){
			
		}else{
			
		}
		
		if($nit==0){
			$vali_nit=true;
		}		
		
		if($email==0){
			$vali_email=true;
		}
		$response = ['email'=>$vali_email,'nit'=>$vali_nit];
		
        return json_encode($response);
    }

    public function obtener_catalogo_segun_tipo($tipo){
        switch ($tipo) {
            case 1:{
                $registros = CatalogoEmpresas::where('es_cliente',1)->get();
                break;
            }
            case 2:{
                $registros = CatalogoEmpresas::where('es_tercero',1)->get();
                break;
            }
            case 3:{
                $registros = CatalogoEmpresas::where('es_proveedor',1)->get();
                break;
            }
        }
        return ['registros'=>$registros];
    }

    public function reporte_listado_clientes_data(){
       
    $operaciones=CatalogoEmpresas::query()
            ->join('000_poblaciones','000_poblaciones.id','=','000_catalogo_empresas.id_poblacion')
            ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')  
            ->select('000_catalogo_empresas.*','000_catalogo_empresas.created_at','000_poblaciones.nombre_ciudad','000_departamentos.departamento')
            ->get();

        return $operaciones;
    }

    public function reporte_clientes(Request $request ){
        $fecha_inicial=$request->c01;
        $fecha_final=$request->c02;
        $imagen = base64_encode(\Storage::get('logo_actual.png'));
        $operaciones= CatalogoEmpresas::query()
            ->join('000_poblaciones','000_poblaciones.id','=','000_catalogo_empresas.id_poblacion')
            ->join('000_departamentos', '000_poblaciones.id_departamento', '=', '000_departamentos.id')  
            ->whereBetween('000_catalogo_empresas.created_at',[$request->c01.' 00:00:00',$request->c02." 23:59:00"])
            ->select('000_catalogo_empresas.*','000_catalogo_empresas.created_at','000_poblaciones.nombre_ciudad','000_departamentos.departamento') 
            ->get()
        ;
       
        $excel=$request->c04;
        return view('catalogo_empresas.reportes.listado_clientes',compact('operaciones','excel','fecha_inicial','fecha_final','excel','imagen'));
       
    }
}
