<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\RolesUsuarios;
use App\Models\Secciones;
use App\Models\ControlAcceso;
use App\Models\CatalogoEmpresas;
class AccesosController extends Controller
{
    //USUARIOS
    public function listado_usuarios(){
        $titulo = 'Usuarios Registrados';
		$modulo = 'Seguridad';
		$seccion = 'Usuarios';
        
        $roles = RolesUsuarios::where('estado',1)->get();
       $clientes=CatalogoEmpresas::get();
        return view('acceso.usuarios.listado',compact('titulo','modulo','seccion','roles',"clientes"));
    }

    public function data_usuarios(Request $request){
        $registros = Usuarios::all();
        foreach($registros as $rows){
            $rol = RolesUsuarios::find($rows->id_rol);
            $rows->rol = $rol;
        }
        return array('data'=>$registros);
    }

	public function validar_email_cliente($email){
        $verificacion = Usuarios::where('email',$email)->count();
        if($verificacion==0){
			return 0;
		}else{
			return -1;
		}
		return $verificacion;
	}

	public function validar_login_unico($login){
		$validacion = Usuarios::where('login',$login)->count();
		if($validacion==0){
			return 0;
		}else{
			return -1;
		}
		
		return $verificacion;
    }
    
    public function registrar_usuario(Request $request){
   
        $registro = new Usuarios;
        $registro->id_persona=$request->persona;
        $registro->nombres=$request->nombres;
        $registro->estado=1;
        $registro->login=$request->c03;
        $registro->password =\Hash::make('123456');
        $registro->email=$request->c04;
        $registro->id_rol=$request->c05;
        $registro->token_verificacion = md5(strtotime('now'));
      

        $registro->save();

     
        
        //<img src=\"".env('APP_URL')."/logo_largo.jpg\" style=\"display:block;\" width=\"10%\">
   
			$html = "
			Saludos cordiales, bienvenido a la plataforma <H2 style='font-family:Avenir;text-align: center'>MAK & CIA ABOGADOS</H2>, aqui podra llevar seguimiento a sus procesos.<br>
			Nombre de usuario:".$request->c03."<br>
			Contraseña:123456<br>
			 Si desea cambiar su contraseña haga click en el siguiente enlace:
			<br><br>
			<a href=\"".env('APP_URL')."/restore?email=".$request->c04."&tokken=".$registro->password."\">Comience a restaurar con el Asistente de contraseña</a>
			";
			$subject = 'Bienvenido a la plataforma Mak y Cia abogados';
			$for = $request->c04;
			\Mail::send('mailer.text', array('text'=>$html), function($msj) use ($subject , $for) {
				$msj->from("mailer@coffeegold.libellum.com.co",env('APP_NAME'));
				$msj->subject($subject);
				$msj->to($for);
			});
			
			return redirect()->back()->with('result',array('message'=>'Hemos enviado un Email a '.$request->email.', revise su buzon para verificar las intrucciones que contiene ese correo electronico.','type'=>'success'));
	
    
  
    }

    
    public function obtener_usuario($id){
        $registro = Usuarios::find($id);
        return $registro;
    }

    public function actualizar_usuario(Request $request){
        
        $registro = Usuarios::find($request->id);
        $registro->nombres=$request->nombres;
        $registro->id_persona=$request->persona_edit;
       
        $registro->apellidos=" ";
        $registro->login=$request->c03;
        $registro->email=$request->c04;
        $registro->id_rol=$request->c05;
        $registro->save();

        return redirect()->route('dashboard.users')->with('result',array('message'=>'El Usuario ha sido actualizado Exitosamente','type'=>'success'));
    }

    public function eliminar_usuario($id){
        Usuarios::where('id',$id)->delete();
        return redirect()->route('dashboard.users')->with('result',array('message'=>'El Usuario ha sido eliminado Exitosamente','type'=>'success'));
    }

    public function cambiar_estado_usuario($id){
        $registro=Usuarios::find($id);
        $estado = $registro->estado;
        if($estado==1){
            $registro->estado=0;
        }else{
            $registro->estado=1;
        }
        $registro->save();
        return redirect()->route('dashboard.users')->with('result',array('message'=>'El Usuario ha sido Actualizado Exitosamente','type'=>'success'));
    }

    //ROLES
    public function listado_roles(){
        $titulo = 'Roles Registrados';
		$modulo = 'Seguridad';
		$seccion = 'Roles';
        
        $roles = RolesUsuarios::all();
    
        return view('acceso.roles.listado',compact('titulo','modulo','seccion','roles'));
    }

    public function data_roles(Request $request){
        $registros = RolesUsuarios::all();
        return array('data'=>$registros);
    }

	public function validar_nombre_rol($login){
		$validacion = RolesUsuarios::where('nombre_rol',$login)->count();
		if($validacion==0){
			return 0;
		}else{
			return -1;
		}
		
		return $verificacion;
    }
    
    public function registrar_rol(Request $request){
        $registro = new RolesUsuarios;
        $registro->nombre_rol=$request->c01;
        $registro->descripcion=$request->c02;
        $registro->estado=0;
        $registro->save();

        return redirect()->route('dashboard.roles')->with('result',array('message'=>'El Rol ha sido registrado Exitosamente','type'=>'success'));
    }
    
    public function obtener_rol($id){
        $registro = RolesUsuarios::find($id);
        return $registro;
    }

    public function actualizar_rol(Request $request){
        $registro = RolesUsuarios::find($request->id);
        $registro->nombre_rol=$request->c01;
        $registro->descripcion=$request->c02;
        $registro->save();

        return redirect()->route('dashboard.roles')->with('result',array('message'=>'El Rol ha sido actualizado Exitosamente','type'=>'success'));
    }

    public function eliminar_rol($id){
        RolesUsuarios::where('id',$id)->delete();
        return redirect()->route('dashboard.roles')->with('result',array('message'=>'El Rol ha sido eliminado Exitosamente','type'=>'success'));
    }

    public function cambiar_estado_rol($id){
        $registro=RolesUsuarios::find($id);
        $estado = $registro->estado;
        if($estado==1){
            $registro->estado=0;
        }else{
            $registro->estado=1;
        }
        $registro->save();
        return redirect()->route('dashboard.roles')->with('result',array('message'=>'El Rol ha sido Actualizado Exitosamente','type'=>'success'));
    }

    public function listado_accesos($id){
        $registros = Secciones::where('padre',0)->get();
        
        //cargo los hijos segun su tipo
        foreach($registros as $modulo){
            $lectura = Secciones::where('id',$modulo->id)->get();
            $escritura = Secciones::where('padre',$modulo->id)->where('escritura',1)->get();
            $edicion = Secciones::where('padre',$modulo->id)->where('edicion',1)->get();
            $eliminar = Secciones::where('padre',$modulo->id)->where('eliminar',1)->get();
            
            $permiso_lectura=0;
            $permiso_escritura=0;
            $permiso_edicion=0;
            $permiso_eliminar=0;
            
            foreach($lectura as $seccion){
                try{
                    $permiso = ControlAcceso::where('id_seccion',$seccion->id)->where('id_rol',$id)->get();
                    if($permiso[0]->permiso==1){
                        $permiso_lectura++;
                    }
                }catch(\Exception $e){

                }
            }

            foreach($escritura as $seccion){
                try{
                    $permiso = ControlAcceso::where('id_seccion',$seccion->id)->where('id_rol',$id)->get();
                    if($permiso[0]->permiso==1){
                        $permiso_escritura++;
                    }
                }catch(\Exception $e){
                    
                }
            }
            
            foreach($edicion as $seccion){
                try{
                    $permiso = ControlAcceso::where('id_seccion',$seccion->id)->where('id_rol',$id)->get();
                    if($permiso[0]->permiso==1){
                        $permiso_edicion++;
                    }
                }catch(\Exception $e){
                    
                }
            }

                        
            foreach($eliminar as $seccion){
                try{
                    $permiso = ControlAcceso::where('id_seccion',$seccion->id)->where('id_rol',$id)->get();
                    if($permiso[0]->permiso==1){
                        $permiso_eliminar++;
                    }
                }catch(\Exception $e){
                    
                }
            }
            $modulo->permiso_lectura=$permiso_lectura;
            $modulo->permiso_escritura=$permiso_escritura;
            $modulo->permiso_edicion=$permiso_edicion;
            $modulo->permiso_eliminar=$permiso_eliminar;
        }
        return array('data'=>$registros);
    }

    public function actualizar_permisos_rol(Request $request){
        ControlAcceso::where('id_rol',$request->id)->delete();
        //dump($request->p_l);
        //dump($request->p_e);
        //dump($request->p_a);
        //dump($request->p_b);
        
        try{
            foreach($request->p_l as $seccion){//permiso para ver
                $rutas = Secciones::where('id',$seccion)->where('lectura',1)->get();
                foreach($rutas as $seccion){
                    if(count(ControlAcceso::where('id_rol',$request->id)->where('id_seccion',$seccion->id)->get())==0){
                        $registro = new ControlAcceso;
                        $registro->id_rol=$request->id;
                        $registro->id_seccion=$seccion->id;
                        $registro->permiso=1;
                        $registro->save();
                    }
                    
                }
               
            }
        }catch(\Exception $e){

        }
        try{
            foreach($request->p_l as $seccion){
                $rutas = Secciones::where('padre',$seccion)->where('lectura',1)->get();
                foreach($rutas as $seccion){
                if(count(ControlAcceso::where('id_rol',$request->id)->where('id_seccion',$seccion->id)->get())==0){
                    $registro = new ControlAcceso;
                    $registro->id_rol=$request->id;
                    $registro->id_seccion=$seccion->id;
                    $registro->permiso=1;
                    $registro->save();
                }
                }
               
            }
        }catch(\Exception $e){

        }
        try{
            foreach($request->p_e as $seccion){
                $rutas = Secciones::where('padre',$seccion)->where('escritura',1)->get();
                foreach($rutas as $seccion){
                    if(count(ControlAcceso::where('id_rol',$request->id)->where('id_seccion',$seccion->id)->get())==0){

                        $registro = new ControlAcceso;
                        $registro->id_rol=$request->id;
                        $registro->id_seccion=$seccion->id;
                        $registro->permiso=1;
                        //dump('Esc rol: '.$request->id.'seccion: '.$seccion->id);
                        $registro->save();
                    }
                }
            }
        }catch(\Exception $e){
        
        }

        try{
            foreach($request->p_a as $seccion){
                $rutas = Secciones::where('padre',$seccion)->where('edicion',1)->get();
                foreach($rutas as $seccion){
                    if(count(ControlAcceso::where('id_rol',$request->id)->where('id_seccion',$seccion->id)->get())==0){
                        $registro = new ControlAcceso;
                        $registro->id_rol=$request->id;
                        $registro->id_seccion=$seccion->id;
                        $registro->permiso=1;
                        //dump('Edi rol: '.$request->id.'seccion: '.$seccion->id);
                        $registro->save();
                    }
                }
            }
        }catch(\Exception $e){
        
        }
        try{
            foreach($request->p_b as $seccion){
                $rutas = Secciones::where('padre',$seccion)->where('eliminar',1)->get();
                foreach($rutas as $seccion){
                    if(count(ControlAcceso::where('id_rol',$request->id)->where('id_seccion',$seccion->id)->get())==0){

                        $registro = new ControlAcceso;
                        $registro->id_rol=$request->id;
                        $registro->id_seccion=$seccion->id;
                        $registro->permiso=1;
                        //dump('Eli rol: '.$request->id.'seccion: '.$seccion->id);
                        $registro->save();
                    }
                }
            }
        }catch(\Exception $e){
        
        }
        return redirect()->route('dashboard.roles')->with('result',array('message'=>'Los permisos para el Rol ha sido Actualizado Exitosamente','type'=>'success'));
    }
}
