<nav class="main-header navbar navbar-expand navbar-white navbar-light " >
   
   @if(isset($movil)==false)
  <ul class="navbar-nav">
      <li class="nav-item d-md-none">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
  </ul>
 
  @endif
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      @if(isset($movil)==false)
      <li class="nav-item">
          <a class="nav-link help-main" href="#" title="Ayuda" style='font-size:220%;color:black'>
              <i class="fa fa-question"></i>
          </a>
      </li>
     
      <!-- Messages Dropdown Menu -->
      <li class="nav-item" id="logout">
          <a class="nav-link" href="{{ route('login.release') }}">
              <i class="fa fa-door-open" style='font-size:190%;color:black' title="cerrar sesion"></i>
          </a>
      </li>
      @else
      <label class="titulo texto">prueba titulo</label>
          <a class="nav-link" href="{{ route('mostrar.encuestas') }}">
              <i class="fas fa-head-side-mask" style='font-size:220%;color:black'></i>
          </a>
          
         <a class="nav-link" href="{{ route('mostrar.nominas') }}">
              <i class="fas fa-dollar-sign" style='font-size:220%;color:black'></i>
          </a>
       
         @if(session('role_id')==1)
         <a class="nav-link" href="{{ route('mostrar.firma') }}">
              <i class="fas fa-user-alt" style='font-size:220%;color:black'></i>
          </a>
        @endif
          <a class="nav-link" href="{{ route('mostrar.ordenes') }}">
              <i class="fa fa-eye" style='font-size:220%;color:black'></i>
          </a>
          <!-- @if(\Request::is('mostrar/ordenes')) @endif-->
          @if(session('role_id')==1)
          <a class="nav-link" href="#">
              <i class="fa fa-file-signature" style='font-size:220%;color:black' data-target="#modal-lgb" titulo="ver contratos" data-toggle="modal"></i>
          </a>
          @endif
           <li class="nav-item" id="logout">
          <a class="nav-link" href="{{ route('login.release') }}">
              <i class="fa fa-door-open" style='font-size:220%;color:black'></i>
          </a>
      </li>
         
      @endif
      
  </ul>
</nav>

<!-- 
    <a class="nav-link" href="{{ route('mostrar.ingreso') }}">
              <i class="fa fa-plus" style='font-size:220%;color:black'></i>
          </a>


/.navbar -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
  $(document).ready(function(){
      var combo = $('select[name="company_selector"]');
      $('.sel-emp').click(function(){
          console.log(combo)
          combo.empty();
          $.get('{{ asset("empresas/activas") }}',function(companies){
              $.each(companies.data,function(i,v){
                  combo.append(new Option(v.razon_social,v.id));
              })
          });
      })
  })
</script>