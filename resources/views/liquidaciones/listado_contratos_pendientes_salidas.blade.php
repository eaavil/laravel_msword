@extends('template.main')

@section('contenedor_principal')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
            <div class=" col-2 ">
                <span>Fecha Inicial</span>
                <input type="date"   class="fi form-control">
             </div>
            <div class="col-2">
                <span>Fecha Final</span>
                <input type="date"  class="ff form-control">
            </div>
            <div lass=" col-2">
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
            <div class=" col-2 mx-3">
            </div>
            <div class="form-group col-4 mx-5">  
            <span style="float:right">Filtrar por Cliente:<br>
				<select class="form-control combo prov">
					<option value="-1">Todos</option>
					@foreach($proveedores as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
                </div>
            </div> 
              <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th width="11%">Numero</th>
                  <th class="d">Fecha Operacion</th>
                  <th>Kilos Compromiso</th>
                  <th>Kilos Liquidados</th>
                  <th>Tipo Producto</th>
                  <th>Valor Arroba</th>
                  <th class="d">Cliente</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr style="display:none">
                        <td>
                            <b>Total Kilogramos:</b> <span class="dx1"></span><br>
                            <b>Total Valor Contrato:</b> <span class="dx2"></span>
                        </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </tfoot>
              </table>
                <div class="row">
                    <div class="col-4">
                        Resumen<br>
                        <b>Total Kilogramos:</b> <span class="dx1"></span><br>
                        <b>Total Valor Contrato:</b> <span class="dx2"></span>
                    </div>
                    <div class="col-4">
                        Filtrar por Fechas
                        <input type="text" class="form-control float-right" id="customDateFilter">
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>

@stop

@section('scripts-bottom')
<style>
@media(max-width:670px){
    .d{display:none}
}

</style>
<script>

    $(document).ready(function(){

        $('title').html('{{ $titulo }}');

        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("contratos/compra/detalle") }}/'+id,function(d){

                let fecha_entrega = d.fecha_entrega.substring(5,2)+'/'+d.fecha_entrega.substring(0,4);

                $(".frme_0001 input[name='c01']").val(d.numero);
                $(".frme_0001 select[name='c02']").val(d.id_tipo_cafe).trigger('change');
                $(".frme_0001 input[name='c03']").val(d.fecha_contrato.substring(0,10));
                $(".frme_0001 input[name='c04']").val(fecha_entrega);
                $(".frme_0001 input[name='c05']").val(d.kilos_compromiso);
                $(".frme_0001 input[name='c06']").val(d.precio_arroba*100);
                $(".frme_0001 input[name='c07']").val(d.precio_kilogramo*100);
                $(".frme_0001 input[name='c08']").val(d.factor_base);
                $(".frme_0001 input[name='c09']").val(d.valor_contrato*100);
                $(".frme_0001 select[name='c10']").val(d.id_centro_operacion).trigger('change');
                $(".frme_0001 select[name='c11']").val(d.id_catalogo_empresa_facturador).trigger('change');
                $(".frme_0001 select[name='c11']").val(d.id_catalogo_empresa_proveedor).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);

            },'json');
        });

        $(document).on('click','.print',function(){
            var id= $(this).attr('data-id');

            window.open("{{ asset('contratos/compra/imprimir') }}/"+id);
        });


        $('.calculator').keyup(function(){
            let pa = Math.round($('.pa').val().substring(1).replace('.',''));
            let ck = $('.ck').val().replace('.','')
            if(ck!='' && pa!=''){
                $('.res').val(Math.round(parseInt(ck)*(parseInt(pa)/12.5)))
                $('.pk').val(Math.round((parseInt(pa)/12.5)))
            }
        })

        $('.calculatorx').keyup(function(){
            let pa = Math.round($('.pax').val().substring(1).replace('.',''));
            let ck = $('.ckx').val().replace('.','')
            if(ck!='' && pa!=''){
                $('.resx').val(Math.round(parseInt(ck)*(parseInt(pa)/12.5)))
                $('.pkx').val(Math.round((parseInt(pa)/12.5)))
            }
        })

        $(document).on('click','.delete',function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("contratos/eliminar") }}/'+id;
            }
        });

		$('.prov').change(function(){
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			let id = $('option:selected',this).val();
			if(id!=-1){
				tabla.ajax.url('{{ asset("liquidaciones/salida/contratos/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("liquidaciones/salida/contratos/data") }}').load();
			}
            if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.contratos.pendientes.salidas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
		})

		var tabla = $('#main').DataTable({
            serverSide:true,
            paging: true,
			pageLength: 20,
            ajax: {
                url: '{{ asset("liquidaciones/salida/contratos/data") }}',
                dataSrc: 'data',
                type:'post',
            },
            columns: [
                {
                    data: null,name:'numero',
                    render: function (data){
                        return data.numero+"<br><br> Creado el:<br>"+data.fecha_contrato.substring(8,10)+'/'+data.fecha_contrato.substring(5,7)+'/'+data.fecha_contrato.substring(0,4)+"<br><br>Actualizado el:<br>"+data.contrato_updated_at.substring(8,10)+'/'+data.contrato_updated_at.substring(5,7)+'/'+data.contrato_updated_at.substring(0,4);
                    }
                },
                {
                    data: null,name:'fecha_contrato',
                    render: function (data) {
                        return data.fecha_contrato.substring(8,10)+'/'+data.fecha_contrato.substring(5,7)+'/'+data.fecha_contrato.substring(0,4);
                    }
                },
                {
                    data: null,name:'kilos_compromiso',
                    render: function (data) {
                        return number_format(data.kilos_compromiso,0,',','.');
                    }
                },
				{
                    data: null,name:'kilos_entregados',
                    render: function (data) {
                        return number_format(data.kilos_entregados,0,',','.');
                    }
                },
                {data:'tipo_cafe',name:'000_tipos_cafe.tipo_cafe'},
                {
                    data:null,name:'precio_arroba',
                    "render": function (data) {
                        return '$'+number_format(data.precio_arroba,2,',','.');
                    }
                },
                {
                    data: null,name:'000_catalogo_empresas.nombre',
                    render: function (data) {
                        try{
                            return data.nombre+'<br> NIT: '+data.nit+'-'+data.digito_verificacion_nit;
                        }catch(error){
                            return 'Sin Cliente Asociado';
                        }
                    }
                }
            ],
            language: langDataTable,
            footerCallback: function (row,data) {
                //totalizador
                var total = 0;
                var total_contrato = 0;
                $('#main').DataTable().rows({page:'current'}).data().each(function(el, index){
                    total += parseFloat(el.kilos_compromiso);
                    total_contrato += parseFloat(el.valor_contrato);
                });
                $('.dx1').html(number_format(total,0,',','.')+' Kgs.');
                $('.dx2').html('$'+number_format(total_contrato,2,',','.'));
            }
        });
        //cargar tabla con el ultimo cliente liquidado
        if(@json($id)!=0){
            let id=@json($id);
            $(".prov option[value="+ id +"]").attr("selected",true);
            alert(id);
            tabla.ajax.url('{{ asset("liquidaciones/salida/listado/data") }}?id_prov='+id).load();
        };
        $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
            let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.contratos.pendientes.salidas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                                                        //indice de la columna
                var columna_timestamp = new Date(data[1].substring(6,10)+'-'+data[1].substring(3,5)+'-'+data[1].substring(0,2)).getTime();
                if (timeInit && !isNaN(timeInit)) {
                    if(columna_timestamp < timeInit){
                        return false;
                    }
                }
                if (timeEnd && !isNaN(timeEnd)) {
                    if(columna_timestamp > timeEnd){
                        return false;
                    }
                }
                return true;
            }
        );

        $('#customDateFilter').daterangepicker(
            {
                showDropdowns:true,
                locale: configDatepicker
            },
            function(start,end,label)
            {
                console.log(start);
                timeInit = new Date(start).getTime();
                timeEnd = new Date(end).getTime();
                tabla.draw();
            }
        );
    });
</script>
@stop
