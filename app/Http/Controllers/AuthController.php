<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\MultiConnector;
//Inclusion de Modelos Internos
use App\Models\Usuarios;
use App\Models\RolesUsuarios;
use App\Models\Secciones;
use App\Models\ControlAcceso;
use App\Models\ControlAccesoUsuarios;

class AuthController extends Controller
{	
	
	public function login(Request $request){


		$user = Usuarios::where('login',$request->input('auth_user'))->get();
		
		//verificacion de registro de usuario en bd
		if(count($user)!=1){
			return redirect()->route('login')->with('result','Usuario Invalido'); 
		//verificacion de estado activo del registro
		}elseif($user[0]->estado!=1){
			return redirect()->route('login')->with('result','Usuario Deshabilitado'); 
		//verificacion de la contrase;
		
		}elseif(!Hash::check($request->input('auth_pass'),$user[0]->password)){
			return redirect()->route('login')->with('result','Clave de Acceso Invalida'); 
		}

	$role = RolesUsuarios::find($user[0]->id_rol);
		
		if($role->estado!=1){
			return redirect()->route('login')->with('result','Perfil de Usuario Deshabilitado.'); 
		}else{
			$this->makeCredentials($user,$role,$request);
			return redirect()->route('dashboard');
		}

		
		
    }
	
	protected function makeCredentials($user,$role,$request){
		$request->session()->put('id', $user[0]->id);
		$request->session()->put('name', $user[0]->nombres);
		$request->session()->put('surname', $user[0]->apellidos);
		$request->session()->put('email', $user[0]->email);
		$request->session()->put('role', $role->nombre_rol);
		$request->session()->put('role_id', $user[0]->id_rol);
		$request->session()->put('client_id', $user[0]->id_client);
		$request->session()->put('token_auth', $user[0]->token_verificacion);
	}

    	public function forgot(Request $request){
		// pendiente
		$user = Usuarios::where('email',$request->email)->get();
		
		if(count($user)>0){
			$html = "
			<br>
			<img src=\"".env('APP_URL')."/logo_largo.jpg\" style=\"display:block;\" width=\"10%\">
			<br>
			Saludos cordiales, según sus instrucciones, se envió el siguiente correo electrónico para ayudarlo a restablecer su contraseña a Mak y Cia abogados
			haga clic en el siguiente enlace para iniciar el proceso:
			<br><br>
			<a href=\"".env('APP_URL')."/restore?email=".$request->email."&tokken=".$user[0]->password."\">Comience a restaurar con el Asistente de contraseña</a>
			";
			$subject = 'Recuperacion de Contraseña';
			$for = $request->email;
			\Mail::send('mailer.text', array('text'=>$html), function($msj) use ($subject , $for) {
				$msj->from("mailer@coffeegold.libellum.com.co",env('APP_NAME'));
				$msj->subject($subject);
				$msj->to($for);
			});
			
			return redirect()->route('login')->with('result','Hemos enviado un Email a '.$request->email.', revise su buzon para verificar las intrucciones que contiene ese correo electronico.');
		}else{
			return redirect()->route('login')->with('result','la direccion de correo electronico es invalida');
		}
	}
	
	public function restore(Request $request){
	   
		$user = Usuarios::where('email',$request->email)
					   ->where('password',$request->tokken)
					   ->get();
		if(count($user)>0){
			return View('security.restore',compact('user'));
		}else{
			return redirect()->route('login')->with('result','Este token es invalido.');
		}
	}
	
	public function restore_processor(Request $request){
		$user = Usuarios::where('id',base64_decode($request->tik))->get();
		if(count($user)>0){
			$user = Usuarios::find(base64_decode($request->tik));
			$user->password = \Hash::make($request->pass);
			$user->save();
			return redirect()->route('login')->with('result','Tu contraseña ha sido cambiada exitosamente, ya puedes ingresar con tus credenciales');
		}else{
			return redirect()->route('login')->with('result','Transaccion fallida, intenta luego');
		}
	}

	public function logout(Request $request){
		$request->session()->forget('id');
		$request->session()->forget('name');
		$request->session()->forget('surname');
		$request->session()->forget('email');
		$request->session()->forget('role');
		$request->session()->forget('role_id');
		$request->session()->forget('token_auth');
		return redirect()->route('login')->with(array('result'=>'Gracias por usar la plataforma MAC Y CIA ABOGADOS, hasta pronto!'));
	}	

		
	public static function checkAccessModule($route,$role_id){
		// pendiente
		try{
			$seccion = Secciones::where('route',$route)->get();
			$permiso_registro = ControlAcceso::where('id_rol',session('role_id'))->where('id_seccion',$seccion[0]->id)->count();
			$posee_permiso = ControlAcceso::where('id_rol',session('role_id'))->where('id_seccion',$seccion[0]->id)->get();
	
			if($permiso_registro==1){
				if($posee_permiso[0]->permiso==1){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}

		}catch(\Exception $e){
			return false;
		}
	}
}
