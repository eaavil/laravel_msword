<table width="100%" class="tg">
  <tr style="background:#ccc">
    <td width="50%" style="text-align:center; font-weight:bold">COMPRADOR</td>
    <td width="50%" style="text-align:center; font-weight:bold">VENDEDOR</td>
  </tr>
  <tr>
    <td>
        <table width="100%" class="tgx">
            <tr>
                <td><b>Dirección:</b> km. 11.5 vial la Romelia el Pollo - Complejo Industrial la Isabela Bodega no. 3</td>
            </tr>
            <tr>
                <td><b>Correo electrónico:</b> coffeegold@coffeegold.com.co</td>
            </tr>
            <tr>
                <td><b>Teléfono:</b> (6) 3434058</td>
            </tr>
            <tr>
                <td><b>Ciudad:</b> Dosquebradas8</td>
            </tr>
        </table>
    </td>
    <td>
        <table width="100%" class="tgx">
            <tr>
                <td><b>Dirección:</b> {{ $data[0]->proveedor[0]->direccion }}</td>
            </tr>
            <tr>
                <td><b>Correo electrónico:</b> {{ $data[0]->proveedor[0]->email_empresa }}</td>
            </tr>
            <tr>
                <td><b>Teléfono:</b> {{ $data[0]->proveedor[0]->numero_telefono_1 }}</td>
            </tr>
            <tr>
                <td><b>Ciudad:</b> {{ $data[0]->proveedor[0]->ubicacion[0]->nombre_ciudad }},{{ $data[0]->proveedor[0]->ubicacion[0]->departamento }}</td>
            </tr>
        </table>
    </td>
  </tr>
</table>