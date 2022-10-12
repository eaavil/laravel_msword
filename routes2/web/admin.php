<?php



Route::group(['middleware' => array('Autenticated','AdminAccess','ClearCache')], function () {
	/*
	|--------------------------------------------------------------------------
	| Dashboard - Centro de Integracion
	|--------------------------------------------------------------------------
    */
    Route::get('/admin/dashboard', function (){
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
    Route::get('/admin/users', array('uses'=>'AccesosController@listado_usuarios'))->name('dashboard.users');
    Route::get('/admin/users/data', array('uses'=>'AccesosController@data_usuarios'))->name('dashboard.users.data');
    Route::post('/admin/users/check/email/{email}', array('uses'=>'AccesosController@validar_email_cliente'))->name('dashboard.users.check.email');
    Route::post('/admin/users/check/login/{login}', array('uses'=>'AccesosController@validar_login_unico'))->name('dashboard.users.check.login');
    Route::post('/admin/users/add', array('uses'=>'AccesosController@registrar_usuario'))->name('dashboard.users.add');
    Route::get('/admin/users/get/{id}', array('uses'=>'AccesosController@obtener_usuario'))->name('dashboard.users.get');
    Route::get('/admin/users/delete/{id}', array('uses'=>'AccesosController@eliminar_usuario'))->name('dashboard.users.delete');
    Route::get('/admin/users/change/{id}', array('uses'=>'AccesosController@cambiar_estado_usuario'))->name('dashboard.users.state.change');
    Route::post('/admin/users/update', array('uses'=>'AccesosController@actualizar_usuario'))->name('dashboard.users.update');
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
});
