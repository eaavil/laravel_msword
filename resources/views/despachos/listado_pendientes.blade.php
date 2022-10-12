@extends('template.main')

@section('contenedor_principal')

@include('despachos.modals.registro')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

			<div class="row">
			<div class="form-group col-2">
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
             </div>
            <div class="form-group col-2">
                <label>Fecha Final</label>
                <input type="date"  class="ff form-control">
            </div>
            <div class=" pt-2 ">
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
			<div class=" pt-2 mx-5 "><br></div>
            <div class=" pt-2 mx-5 "><br></div>
			<div class=" pt-2 mx-3 "><br></div>
			<div class="form-group col-5 pt-2">
				<span style="float:right">Filtrar por Cliente:<br>
				<select class="form-control combo prov">
					<option value="-1">Todos</option>
					@foreach($clientes as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
			</div>
		    
            </div>
			  <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
				  <th >Ticket</th>
				  <th >Fecha</th>
                  <th >Producto</th>
				  <th >Cliente</th>
                  <th >Factor</th>
                  <th >Acciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
		  <button type="button" class="despacho despacho-trigger" style="display:none" data-title="" data-weight="" ="" data-toggle="modal" data-target="#modal-lg"></button>
    </div>
@stop

@section('scripts-bottom')
    <script>

		$(document).ready(function(){
			@if(count($adicional)>0)
				$('.despacho-trigger').attr('data-id','{{ $adicional["id"] }}');
				$('.despacho-trigger').attr('data-title','{{ $adicional["numero"] }}');
				$('.despacho-trigger').attr('data-weight','{{ $adicional["peso_neto"] }}');
				$('.despacho-trigger').trigger('click');
			@endif
		})

		$('.prov').change(function(){
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			let id = $('option:selected',this).val();
			if(id!=-1){
				tabla.ajax.url('{{ asset("despachos/pendientes/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("despachos/pendientes/data") }}').load();
			}
            if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("despachos.pendientes.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
            tabla.draw();
		});

		/***********************/
		/*   MODAL REGISTRO    */
		/***********************/
        $('.trigger_form_esp_entrada').click(function(){
            let id = $(this).attr('target');
			let t1 = $('.frmc_0001 .t1').val();
			let t3 = $('.frmc_0001 .t3x').val();

			if(parseInt(t1)>parseInt(t3)){
				alert('la Cantidad de Kilogramos es mayor al Peso neto de la Salida a Despachar');
			}else if(parseInt(t1)==0){
				alert('Debe Especificar la cantidad de Kilogramos a Despachar');
			}else{
				$('.'+id+' > .act_form').trigger('click')
			}

        })

		$(document).on('click','.despacho',function(){
			let id = $(this).attr('data-id');
			let title = $(this).attr('data-title');
			let peso_neto = $(this).attr('data-weight');
			$('.titulo_salida').text(title);
			$('.weight').val(peso_neto);
			$('.salida').val(id);
			$.get('{{ asset("despachos/entradas/pendientes") }}',function(dx){
				$.each(dx,function(i,v){
					$('.origen tbody').append(`
						<tr class="oc`+v.id+`">
							<td>`+v.numero_ticket+`</td>
							<td>`+v.factor+`</td>
							<td>`+v.centros+`</td>
							<td>`+v.nombre+`</td>
							<td>
								<button type="button" class="btn btn-primary add-despacho"
								data-id="`+v.id+`"
								data-c1="`+v.numero_ticket+`"
								data-c2="`+v.factor+`"
								data-c3="`+v.centros+`"
								data-c4="`+v.nombre+`"
								data-c5="`+(v.peso_neto-v.despachado-v.mezclado)+`"
								>
									<i class="fa fa-arrow-down" aria-hidden="true"></i> Adicionar
								</button>
							</td>
						</tr>
					`);
				})
			},'json');

			$(document).on('click','.remove-despacho',function(){
				let id = $(this).attr('data-id');
				$('.dc'+id).remove();
				$('.oc'+id).show();
				totalizar_despacho();
			});

			$(document).on('click','.add-despacho',function(){
				let id = $(this).attr('data-id');
				let c1 = $(this).attr('data-c1');
				let c2 = $(this).attr('data-c2');

				let lect = '';

				if(c2===0){
					lect = 'readonly';
				}

				let c3 = $(this).attr('data-c3');
				let c4 = $(this).attr('data-c4');
				let c5 = $(this).attr('data-c5');
				$('.oc'+id).hide();
				if($('.dc'+id).length==0){
					$('.destino tbody').append(`
						<tr class="dc`+id+`">
							<td>`+c1+`<input type="hidden" name="entrada[]" value="`+id+`" /></td>
							<td><input type="number" `+lect+` name="factor[]" step="0.01" style="width:50%" value="`+c2+`" /></td>
							<td><input type="number" readonly name="resultado[]" style="border:none; width:50%" value="`+c2+`" /></td>
							<td>`+c3+`</td>
							<td>`+c4+`</td>
							<td>`+c5+`</td>
							<td>
								<input type="number" min="1"  name="kilos[]" value="1" max="`+c5+`" />
							</td>
							<td>
								<button type="button" class="btn btn-danger remove-despacho" title="Remover" data-id="`+id+`">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</button>
							</td>
						</tr>
					`);
					totalizar_despacho();
					
				}
			})
		})

		

		$(document).on('change',"[type='number']",function (evt) {

			var max = parseInt($(this).attr('max'));
			var min = parseInt($(this).attr('min'));
			if ($(this).val() > max)
			{
				$(this).val(max);
			}
			else if ($(this).val() < min)
			{
				$(this).val(min);
			}
			totalizar_despacho()
		});

		function totalizar_despacho(){
			let t1 = $('.frmc_0001 .t1');
			let t2 = $('.frmc_0001 .t2');
			let t4 = $('.frmc_0001 .t3');
			let origen = $('.frmc_0001 .t3x');
			let total1 = 0;
			let total2 = 0;
			let total3 = 0;
			$.each($('.destino tbody tr'),function(i,v){
				console.log($(this).find('input[name="kilos[]"]').val());
				total1+= parseInt($(this).find('input[name="kilos[]"]').val());
			})
			$.each($('.destino tbody tr'),function(i,v){
				var temp = (parseInt($(this).find('input[name="kilos[]"]').val())/total1)*parseFloat($(this).find('input[name="factor[]"]').val()).toFixed(2);
				$(this).find('input[name="resultado[]"]').val(((temp * 100) / 100).toFixed(2))
				total2+= temp;
			})

			t1.val(total1);
			t4.val(origen.val()-total1);

			t2.val(((total2 * 100) / 100).toFixed(2));
		}

		/******************/
		/*   DATATABLE    */
		/******************/
		$(document).ready(function(){
		var tabla = $('#main').DataTable({
			serverSide:true,
            paging: true,
			pageLength: 20,
            ajax: {
                url: '{{ asset("despachos/pendientes/data") }}',
                dataSrc: 'data',
				type:'post',
            },
            columns: [
				{
					"data":'numero_ticket',
					name:'numero_ticket',
					"render": function (data) {
						return '<h6>'+data+'</h6>';
					}
				},
				{
					"data": null,
					name:'fecha_ticket',
					"render": function (data) {
						return data.fecha_ticket.substring(8,10)+'/'+data.fecha_ticket.substring(5,7)+'/'+data.fecha_ticket.substring(0,4);
					}
				},
				{
					"data": null,
					name:'000_tipos_cafe.tipo_cafe',
					"render": function (data) {
						return data.tipo_cafe;
					}
				},
				{
					"data": null,
					name:'ce.nombre',
					"render": function (data) {
						return data.nombre;
					}
				},
				{
					"data": null,
					name:'factor',
					"render": function (data) {
						return data.factor;
					}
				},
                {
                    data: null,
					name:'id',
                    render: function (data){
                        return `
							<button type="button" class="btn btn-primary despacho" data-id="`+data.id+`" data-title="`+data.numero_ticket+`" data-weight="`+data.peso_neto+`" data-id="`+data.id+`" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-truck" aria-hidden="true"></i> Despachar</button>
						`;
                    }
                }
            ],
            language: langDataTable,
        });
		$(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
            let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("despachos.pendientes.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
	});
    </script>
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

@stop
