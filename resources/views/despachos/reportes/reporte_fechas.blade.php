

<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte Despachos de cafe</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} {{date(" (H:i:s)",time())}}</p>
            </td><td><td ></td></td>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table><br>
<table class="paleBlueRows" style="font-size:80%;margin: 0 auto; " width="100%">
	<thead>
        <tr>
		  <th>Despacho</th>
      <th>cliente</th>
		  <th>Factor Promedio</th>
          <th>Factor Despacho</th>
          <th>Entrada</th>
          <th>Proveedor</th>
          <th>Kilogramos</th>
          <th>Factor</th>
          <th>Factor %</th>
        </tr>
	</thead>
	<tbody>
        @foreach($data_reporte as $rows)
            @php
                $contador = 0;
                $long = count($rows->detalle);
                foreach($rows->cliente_despacho as $clientex){
                $cliente=$clientex->nombre;
                $salida=$clientex->numero_ticket;
                }
                $tot_a = 0;
                $tot_b = 0;
                $tot_c = 0;
                $tot_d = 0;
                $tot_e = 0;
                $tot_f = 0;
                $tot_g = 0;
                $tot_h = 0;
                $tot_i = 0;
                $tot_j = 0;
                $tot_k = 0;
            @endphp
            @foreach($rows->detalle as $index => $rowsx)
                <tr>
                    @if($contador==0)
                        <td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $salida }}
						@php }catch(\Exception $e){} @endphp
						</th>
            <td rowspan="{{ $long }}">
						@php try{ @endphp
							{{$cliente }}
						@php }catch(\Exception $e){} @endphp
						</th>
						<td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $rows->factor_promedio }}
						@php }catch(\Exception $e){} @endphp
						</th>
						<td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $rows->factor_promedio_referencia }}
						@php }catch(\Exception $e){} @endphp
						</th>
                    @endif
						<td>{{ $rowsx->numero_ticket }}</th>
                        <td>{{ $rowsx->nombre }}</th>
						<td>{{ number_format($rowsx->kilogramos_despacho,0,',','.') }}</th>
						<td>{{ $rowsx->factor_despacho }}</th>
						<td>{{ $rowsx->factor_promedio_despacho }}</th>




                </tr>

				@php $tot_a = $tot_a+$rowsx->kilogramos_despacho; $contador++; @endphp

            @endforeach

                <tr class="totales">
                    <td colspan="6">TOTALES</td>
                    <td>{{ number_format($tot_a,0,',','.') }}</td>
                    <td colspan="2"></td>
                </tr>

		@endforeach
	</tbody>

</table>

<style>
table.paleBlueRows {
  font-family: "Arial";
  border: 1px solid #000;
  text-align: center;
  border-collapse: collapse;
}
table.paleBlueRows td, table.paleBlueRows th {
  border: 1px solid #000;
}
table.paleBlueRows tbody td {
  font-size: 12px;
  padding: 5px;
}
table.paleBlueRows tr:nth-child(even) {
  background: #D0E4F5;
}
table.paleBlueRows thead {
  background: #0B6FA4;
  border-bottom: 2px solid #000;
}
table.paleBlueRows thead th {
  font-size: 12px !important;
  font-weight: bold;
  color: white;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
}
	.totales td{
		background:#0B6FA4; color:white
	}

@media print {
	table.paleBlueRows thead th {
	  font-size: 12px !important;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  padding: 5px;
	  border-left: 2px solid #000;
	}
	table.paleBlueRows tfoot {
	  font-size: 12px;
	  font-weight: bold;
	  color: #333333;
	  background: #D0E4F5;
	  border-top: 2px solid #444444;
	}
	.totales td{
		background:#0B6FA4; color:black
	}
}

table.paleBlueRows thead th:first-child {
  border-left: none;
}

table.paleBlueRows tfoot {
  font-size: 12px;
  font-weight: bold;
  color: #333333;
  background: #D0E4F5;
  border-top: 2px solid #444444;
}
table.paleBlueRows tfoot td {
  font-size: 12px;
}
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
</style>
