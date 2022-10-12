<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRestClients;
use App\Models\Usuarios;

class ClientsController extends Controller
{
    //
    public function add_client(Request $request){
        $registro = new ApiRestClients;
        $registro->client_name=$request->c01;
        $registro->login=$request->c02;
        $registro->email=$request->c03;
        $registro->phone=$request->c04;
        $registro->host=$request->c05;
        $registro->port=$request->c06;
        $registro->user_database=$request->c07;
        $registro->pass_database=$request->c08;
        $registro->database=$request->c09;
        $registro->password=\Hash::make(strtotime('now'));
        $registro->token_auth=md5(strtotime('now'));
        $registro->state=1;
        $registro->save();

        $registro_u = new Usuarios;
        $registro_u->nombres="Cliente";
        $registro_u->apellidos=$registro->client_name;
        $registro_u->login=$registro->login;
        $registro_u->password=\Hash::make(strtotime('now'));
        $registro_u->email=$registro->email;
        $registro_u->id_rol=2;
        $registro_u->estado=2;
        $registro_u->token_verificacion=\Hash::make(strtotime('now'));
        $registro_u->estado=1;
        $registro_u->id_client=$registro->id;
        $registro_u->save();

        return redirect()->route('dashboard-admin')->with('result',array('message'=>'El Cliente ha sido registrado Exitosamente','type'=>'success'));
    }

    public function get_client($id){
        $registro = ApiRestClients::find($id);
        return $registro;
    }

    public function delete_client($id){
        ApiRestClients::find($id)->delete();
        return redirect()->route('dashboard-admin')->with('result',array('message'=>'El Cliente ha sido eliminado Exitosamente','type'=>'success'));
    }

    public function change_state_client($id){
        $registro = ApiRestClients::find($id);
        if($registro->state==1){
            $registro->state=0;
        }else{
            $registro->state=1;
        }
        $registro->save();
        return redirect()->route('dashboard-admin')->with('result',array('message'=>'El Cliente ha cambiado de Estado Exitosamente','type'=>'success'));
    }

    public function update_client(Request $request){
        $registro = ApiRestClients::find($request->id);
        $registro->client_name=$request->c01;
        $registro->login=$request->c02;
        $registro->email=$request->c03;
        $registro->phone=$request->c04;
        $registro->host=$request->c05;
        $registro->port=$request->c06;
        $registro->database=$request->c09;
        $registro->user_database=$request->c07;
        $registro->pass_database=$request->c08;
        $registro->save();

        return redirect()->route('dashboard-admin')->with('result',array('message'=>'El Cliente ha sido actualizado Exitosamente','type'=>'success'));
    }
}
