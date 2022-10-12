
@extends('template.main')

@section('contenedor_principal')

         <form action=" {{route ('saldo.reporte')}}"  method="post" class="frmr_0001">
		 <?php csrf_field() ?> <br>
         <h4>
         SALDOS DE BANCOS: </h4> <br>
<div class="row">
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Inicial Inicial</label>
					  <input type="date" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control">
				   </div>
				</div>
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Final</label>
					  <input type="date" name="c02" required autocomplete="c01"  min="1" max="50000" class="form-control">
				   </div>
               
				</div>
			<button style="display:none" class="act_form"></button>
              <br>
            <button type="button" class="btn btn-block btn-primary trigger_form" target="frmr_0001">GENERAR REPORTE</button>
         </form>
<style>
 
 .boton{
    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0;
  }
</style>
<script>
  $(function(){
$('#logout').css("display", "none");
$('#volver').css("display", "block");
});

$(document).on('click','.volver',function(){ 
   location.href ="{{ route('dashboard') }}";
});
</script>
@stop