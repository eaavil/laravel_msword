<table width="746" border="1" cellspacing="0" cellpadding="0">
    <tbody><tr>
      <td height="146" colspan="4"><div align="center">
          <table width="952" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
            <td width="510"><img src="data:image/png;base64, {{ $imagen }}" width="300" height="85"></td>
              <td width="442"><div align="center">
                  <div align="center">
                    <p class="Estilo18">COFFEEWORLD S.A.S</p>
                  </div>
                  <p align="center" >NIT. 901383798-1 </p>
                </div></td>
            </tr>
          </tbody></table>
          <div align="LEFT" class="Estilo14">
            <table width="951" height="23" border="0" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="center"><span class="Estilo144"><span class="Estilo124">FECHA:
                </span>{{ date('d/m/Y',strtotime($registro[0]->fecha_ticket)) }}</span></div></td>
                <td><div align="center"><strong>SALIDA DE PRODUCTOS</strong></div></td>
            <td><div align="center"><span class="Estilo16"><span class="Estilo17">No. {{ $registro[0]->numero_ticket}}</span></span></div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="318">&nbsp;</td>
                <td width="290">&nbsp;</td>
                <td width="343">&nbsp;</td>
              </tr>
            </tbody></table>
            <p align="center" class="Estilo16"> </p></div>
        </div></td>
    </tr>
    <tr>
      <td width="401" rowspan="2" bgcolor="#D6D6E9"><div align="center" class="Estilo14 Estilo148"><strong>CLASE</strong></div></td>
      <td height="21" colspan="3" bgcolor="#D6D6E9"><div align="center" class="Estilo150">CANTIDAD</div></td>
    </tr>
    <tr>
      <td width="193" bgcolor="#D6D6E9"><div align="center" class="Estilo150">KILOS</div></td>
      <td width="177" height="21" bgcolor="#D6D6E9"><div align="center" class="Estilo150">SACOS</div></td>
      <td width="175" bgcolor="#D6D6E9"><div align="center"><span class="Estilo150">TULAS</span></div></td>
    </tr>
    <tr>
    <td bgcolor="#D6D6E9"><div align="center" class="Estilo149">{{ $registro[0]->cafe->tipo_cafe }}</div></td>
       <td bgcolor="#D6D6E9"><div align="right" class="Estilo149"> </div></td>
      <td bgcolor="#D6D6E9"><div align="right" class="Estilo149">{{ $registro[0]->cantidad_sacos}}</div></td>
      <td bgcolor="#D6D6E9"><div align="right"><span class="Estilo148"><span class="Estilo149">{{ $registro[0]->catidad_tulas }}</span></span></div></td>
    </tr>
    <tr>
              </tr>
    <tr>
              </tr>
    <tr>
              </tr>
    <tr>
                        </tr>
    <tr>
      <td>&nbsp;</td>
      <td bgcolor="#D6D6E9"><div align="right" class="Estilo148"><span class="Estilo151"><strong>
          </strong></span></div></td>
      <td bgcolor="#D6D6E9"><div align="LEFT" class="Estilo148"><span class="Estilo151"><strong>TOTAL
          SACOS:</strong> </span><span class="Estilo149"><strong>
            {{ $registro[0]->cantidad_sacos}}              </strong></span></div></td>
      <td bgcolor="#D6D6E9"><div align="LEFT"><span class="Estilo149"><strong>TOTAL
          TULAS:</strong> <strong>
            {{ $registro[0]->catidad_tulas }}              </strong></span></div></td>
    </tr>
            <tr>
      <td height="30"><span class="Estilo140">Nombre del Conductor:</span><span class="Estilo125"><span class="Estilo25">
      {{ $registro[0]->conductor->nombre }}</span></span></td>
      <td height="30"><span class="Estilo140">Cédula: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->conductor->nit }}</span></span></td>
      <td height="30" colspan="2"><span class="Estilo140"> Celular: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->conductor->numero_telefono_1 }}</span></span></td>
    </tr>
    <tr>
      <td height="28"><span class="Estilo140">Placa del Vehículo: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->placa }}</span></span></td>
      <td height="28" colspan="3"><strong><span class="Estilo140">Empresa
        Transportadora: </span></strong><span class="Estilo125">{{ $registro[0]->empresa_transportadora }}</span></td>
    </tr>
    <tr>
      <td height="27"><span class="Estilo140">Destino: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->lugar_destino }}</span></span></td>
      <td height="27" colspan="3"><span class="Estilo140">Dirección
        Destinatario: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->direccion_destino }}</span></span></td>
    </tr>
    <tr>
      <td height="27" colspan="4"><span class="Estilo140">Destinatario: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->cliente->nombre }}</span></span></td>
    </tr>
    <tr>
      <td height="27" colspan="4"><span class="Estilo140">Observaciones: </span><span class="Estilo25">{{ $registro[0]->observaciones }}</span>
        <div align="right" class="Estilo140"></div>
        <div align="right" class="Estilo140"></div></td>
    </tr>
    <tr>
      <td height="98" colspan="4"><div align="center">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span class="Estilo140">Firma de Quien Recibe: ___________________<font color="#FFFFFF">
            </font></span><font color="#FFFFFF"><span class="Estilo128">.........</span>
            </font><span class="Estilo140">Firma de Quien Entrega: ___________________</span></p>
          <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr>
      <td height="29" colspan="4"><div align="center"><span class="Estilo146"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Dirección:
          km. 11.5 Vial La Romelia el Pollo - Complejo Industrial la Isabela
          Bodega No. 3 - Dosquebradas (Risaralda) - Teléfono: 3434058
          - Cel: 3178942108<font color="#FFFFFF"> --------------------------</font>E_mail:
          <span class="Estilo122"><a href="mailto:coffeeworld@coffeeworld.com.co"><span class="Estilo122"><font color="#000099" size="2">coffeeworld@coffeeworld.com.co</font></span></a></span></font></span></div></td>
    </tr>
  </tbody></table>
<!--
<br><br>
<table width="746" border="1" cellspacing="0" cellpadding="0">
    <tbody><tr>
      <td height="146" colspan="4"><div align="center">
          <table width="952" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
            <td width="510"><img src="data:image/png;base64, {{ $imagen }}" width="250" height="85"></td>
              <td width="442"><div align="center">
                  <div align="center">
                    <p class="Estilo18">COFFEEWORLD S.A.S</p>
                  </div>
                  <p align="center" class="Estilo18">NIT. 901383798-1 </p>
                </div></td>
            </tr>
          </tbody></table>
          <div align="LEFT" class="Estilo14">
            <table width="951" height="23" border="0" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="center"><span class="Estilo144"><span class="Estilo124">FECHA:
                </span>{{ date('d/m/Y',strtotime($registro[0]->fecha_ticket)) }}</span></div></td>
                <td><div align="center"><strong>SALIDA DE PRODUCTOS</strong></div></td>
            <td><div align="center"><span class="Estilo16"><span class="Estilo17">No. {{ $registro[0]->numero_ticket}}</span></span></div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="318">&nbsp;</td>
                <td width="290">&nbsp;</td>
                <td width="343">&nbsp;</td>
              </tr>
            </tbody></table>
            <p align="center" class="Estilo16"> </p></div>
        </div></td>
    </tr>
    <tr>
      <td width="401" rowspan="2" bgcolor="#D6D6E9"><div align="center" class="Estilo14 Estilo148"><strong>CLASE</strong></div></td>
      <td height="21" colspan="3" bgcolor="#D6D6E9"><div align="center" class="Estilo150">CANTIDAD</div></td>
    </tr>
    <tr>
      <td width="193" bgcolor="#D6D6E9"><div align="center" class="Estilo150">KILOS</div></td>
      <td width="177" height="21" bgcolor="#D6D6E9"><div align="center" class="Estilo150">SACOS</div></td>
      <td width="175" bgcolor="#D6D6E9"><div align="center"><span class="Estilo150">TULAS</span></div></td>
    </tr>
    <tr>
    <td bgcolor="#D6D6E9"><div align="center" class="Estilo149">{{ $registro[0]->cafe->tipo_cafe }}</div></td>
       <td bgcolor="#D6D6E9"><div align="right" class="Estilo149"> </div></td>
      <td bgcolor="#D6D6E9"><div align="right" class="Estilo149">{{ $registro[0]->cantidad_sacos}}</div></td>
      <td bgcolor="#D6D6E9"><div align="right"><span class="Estilo148"><span class="Estilo149">{{ $registro[0]->catidad_tulas }}</span></span></div></td>
    </tr>
    <tr>
              </tr>
    <tr>
              </tr>
    <tr>
              </tr>
    <tr>
                        </tr>
    <tr>
      <td>&nbsp;</td>
      <td bgcolor="#D6D6E9"><div align="right" class="Estilo148"><span class="Estilo151"><strong>
          </strong></span></div></td>
      <td bgcolor="#D6D6E9"><div align="LEFT" class="Estilo148"><span class="Estilo151"><strong>TOTAL
          SACOS:</strong> </span><span class="Estilo149"><strong>
            {{ $registro[0]->cantidad_sacos}}              </strong></span></div></td>
      <td bgcolor="#D6D6E9"><div align="LEFT"><span class="Estilo149"><strong>TOTAL
          TULAS:</strong> <strong>
            {{ $registro[0]->catidad_tulas }}              </strong></span></div></td>
    </tr>
            <tr>
      <td height="30"><span class="Estilo140">Nombre del Conductor:</span><span class="Estilo125"><span class="Estilo25">
      {{ $registro[0]->conductor->nombre }}</span></span></td>
      <td height="30"><span class="Estilo140">Cédula: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->conductor->nit }}</span></span></td>
      <td height="30" colspan="2"><span class="Estilo140"> Celular: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->conductor->numero_telefono_1 }}</span></span></td>
    </tr>
    <tr>
      <td height="28"><span class="Estilo140">Placa del Vehículo: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->placa }}</span></span></td>
      <td height="28" colspan="3"><strong><span class="Estilo140">Empresa
        Transportadora: </span></strong><span class="Estilo125">{{ $registro[0]->empresa_transportadora }}</span></td>
    </tr>
    <tr>
      <td height="27"><span class="Estilo140">Destino: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->lugar_destino }}</span></span></td>
      <td height="27" colspan="3"><span class="Estilo140">Dirección
        Destinatario: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->direccion_destino }}</span></span></td>
    </tr>
    <tr>
      <td height="27" colspan="4"><span class="Estilo140">Destinatario: </span><span class="Estilo125"><span class="Estilo25">{{ $registro[0]->cliente->nombre }}</span></span></td>
    </tr>
    <tr>
      <td height="27" colspan="4"><span class="Estilo140">Observaciones: </span><span class="Estilo25">{{ $registro[0]->observaciones }}</span>
        <div align="right" class="Estilo140"></div>
        <div align="right" class="Estilo140"></div></td>
    </tr>
    <tr>
      <td height="98" colspan="4"><div align="center">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span class="Estilo140">Firma de Quien Recibe: ___________________<font color="#FFFFFF">
            </font></span><font color="#FFFFFF"><span class="Estilo128">.........</span>
            </font><span class="Estilo140">Firma de Quien Entrega: ___________________</span></p>
          <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr>
      <td height="29" colspan="4"><div align="center"><span class="Estilo146"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Dirección:
          km. 11.5 Vial La Romelia el Pollo - Complejo Industrial la Isabela
          Bodega No. 3 - Dosquebradas (Risaralda) - Teléfono: 3434058
          - Cel: 3178942108<font color="#FFFFFF"> --------------------------</font>E_mail:
          <span class="Estilo122"><a href="mailto:coffeeworld@coffeeworld.com.co"><span class="Estilo122"><font color="#000099" size="2">coffeeworld@coffeeworld.com.co</font></span></a></span></font></span></div></td>
    </tr>
  </tbody></table>
<br><br>
-->