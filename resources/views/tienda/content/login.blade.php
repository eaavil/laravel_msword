
@include('tienda.head')
<!------------>

<div class="navbar bs-nav-center">
   <div class="container">
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation" enctype="multipart/form-data">
      <i class="fas fa-bars"></i>
      </button>
      <a class="navbar-brand py-0 mr-auto ml-3 ml-sm-n0" href="/">
      <img data-bs="header.logo"
         class="img-fluid d-print-block" src="https://dojiw2m9tvv09.cloudfront.net/59969/1/S_logoimpresionesyweb6990.jpg?90" 
         title="TKS Tecnologia y Seguridad Spa" alt="TKS Tecnologia y Seguridad Spa">
      </a>
   </div>
</div>
<div class=" container-fluid ">
<div class="row justify-content-center ">
<div class=" col-xl-10">
   <div class="card shadow-lg ">
      <div class="row justify-content-around">
         <div class="col-md-5 ">
            <form action="{{ route('realizar.pago') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="card border-0">
                  <div class="card-body pt-0">
                     <div class="card-header card-2">
                        <p class="card-text text-muted "> INICIAR SESION </p>
                     </div>
                     <br>
                        <div class="form-group">
                           <label class="form-label">Correo Electrónico</label>
                           <input type="text" name="username" class="form-control correo" placeholder="usuario@correo.com" autocomplete="nope"/>
                           <span class="login_error vista-error" style="display:none" ></span>
                        </div>
                        <div class="form-group"> 
                           <label class="form-label">Contraseña</label>
                           <input type="password" name="password" class="form-control" placeholder="Contraseña" autocomplete="nope"/>
                        </div>
                           <div class="form-group login-btn_login text-center">
                              <a class="recuperar" href="#" style="color:red;">Olvidé mi contraseña</a>
                              <input  id="btn-login" type="submit" name="login" value="Iniciar Sesión" class="btn btn-primary form-control">
                           </div>
                    
            </form>
            </div>
            </div>
         </div>
         <div class="col-md-5 ">
            <div class="card border-0 ">
               <div class="card border-0">
                  <div class="card-body pt-0">
                     <div class="card-header card-2">
                        <p class="card-text text-muted "> ¿Eres Nuevo? Crea una cuenta </p>
                     </div>
                     <br>
                     <div class="form-group">
                        <label for="" class="form-label">Correo Electrónico</label>
                        <input type="text" class="form-control" name="email" placeholder="usuario@correo.com" autocomplete="off">
                        <span class="login-error collapse"></span>
                     </div>
                     <div class="form-group">
                        <label for="" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="off">
                        <span class="login-error collapse"></span>
                     </div>
                     <div class="form-group">
                        <label for="" class="form-label">Repetir Contraseña</label>
                        <input type="password" class="form-control" name="repass" placeholder="Contraseña">
                        <span class="login-error collapse"></span>
                     </div>
                     <div class="form-group">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="firstName" placeholder="Nombre">
                        <span class="login-error collapse"></span>
                     </div>
                     <div class="form-group">
                        <label for="" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="lastName" placeholder="Apellidos">
                        <span class="login-error collapse"></span>
                     </div>
                     <div class="form-group login-btn_login text-center">
                        <input type="submit" name="create" value="Crear Cuenta" class="btn btn-primary form-control" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   .custom-file-label::after { content: ""}
   .vista-error {
   width: 100%;
   display: block;
   border-bottom-right-radius: 5px;
   border-bottom-left-radius: 5px;
   color: #ffffff;
   background-color: #ff4444;
   height: 25px;
   margin-top: -5px;
   padding: 5px 5px 0;
   position: relative;
   z-index: 1;
   font-size: 12px;
   }
   .forgot_password {
   display: block;
   margin: 0 auto;
   }
   .login-reset_password {
   padding-top: 20px;
   }
</style>
<script>
   $('.trigger_form').click(function(){
             let id = $(this).attr('target');
             $('.'+id+' > .act_form').trigger('click')
   })
   
   $(document).on('click','.recuperar',function(){
       let correo=$('.correo').val();
      if(correo==""){
        $( ".login_error" ).css('display','block');
         $( ".login_error" ).addClass(".login_error");
         $( ".login_error" ).text("Completa éste dato y presiona Olvidé mi contraseña");
         
      }else{
        $( ".login_error" ).css('display','none');
         alert('Revisa las intrucciones para recuperar contraseña enviadas a '+correo)
      }
    
    
   });
   
   $(document).on('change','.forma_pago',function(){
      if($('option:selected',this).val()==2){
         $('.consignacion_cuenta').show();
         
      }else{
         $('.consignacion_cuenta').hide();
      }
    
    
   });
   
   $(document).on('change','.recibir_pedido',function(){
     //retiro en tienda
      if($('option:selected',this).val()==1){
         $('.retiro_tienda').show();
         $('.domicilio').hide();
         $('.domicilio').attr("required", "false");
      }
      //envio a domicilio
      if($('option:selected',this).val()==2){
         $('.domicilio').show();
         $('.retiro_tienda').hide();
         $('.domicilio').attr("required", "true");
      }
      if($('option:selected',this).val()==""){
         $('.domicilio').hide();
         $('.retiro_tienda').hide();
         $('.domicilio').attr("required", "false");
      }
    
   });
</script>