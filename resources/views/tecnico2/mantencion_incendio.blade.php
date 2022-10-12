@extends('template.main')

@section('contenedor_principal')

<form action=" {{route ('contratos.reporte')}}" method="post" class="frmr_0001">
    {{ csrf_field() }}
    <h4 class="my-3">CORTE DE CONTRATOS:</h4>
	<div class="row">
		<div class="col-12">
		    <label>Fecha Inicial</label>
			<input type="date" name="c01" required value="<?php echo date('Y-m-d', strtotime('first day of this month', time()));?>"  class="form-control">
		</div>
		<div class="col-12">
		    <label>Fecha Final</label>
			<input type="date" name="c02" required value="<?php echo date('Y-m-d', strtotime('last day of this month', time()));?>" class="form-control">
		</div>
		<div class="col-12">
		    <button style="display:none" class="act_form"></button>
            <button type="button" class="mt-3 btn btn-block btn-primary trigger_form" target="frmr_0001">GENERAR REPORTE</button>
		</div>
    </div>
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