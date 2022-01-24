<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CASO_CRM_{{$rpta1[0]->nNumeroPedido}}</title>
    <style>
        @page{
            margin: 1.3rem;
            margin-top:1.9rem;
            padding: 1rem;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: verdana, arial, sans-serif;
        }
        .cabecera {
            background-color: #FEFEFE;
            color: #000000;
            padding: 2rem;
            padding-top: .2rem;
            padding-bottom: 0px;
        }
        .cabecera .logo{
            margin: 5px;
        }
        .cabecera table {
            padding: 1px;
            margin-bottom: .2rem;
        }
        table {
            font-size: x-small
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
    </style>
</head>
<body>
    <div class="cabecera">
        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center" style="bordercolor: black">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellspacing="0" align="center">
                        <tr>
                            <td align="center">
                                <img src="https://media.magneto365.com/image_assets/files/89/medium-logo-konecta_%281%29-.png?1513182490" alt="Logo" class="logo" width="200" height="70">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%" cellspacing="0" cellspacing="1" align="center" style="bordercolor: black">
                        <tr>
                            <td><strong>No. Caso</strong></td>
                            <td>{{$rpta1[0]->nNumeroPedido}}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Creación</strong></td>
                            <td>{{$rpta1[0]->dFechaPedido}}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td>{{$rpta1[0]->cEstadoPedido}}</td>
                        </tr>
                        <tr>
                            <td><strong>Asesor</strong></td>
                            <td>{{$rpta1[0]->cAgente}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center" style="bordercolor: black">
            <tr align="center" align="middle">
                <td colspan="2" style="background-color: #010c3d; color:white;">
                    <h3><strong>INFORMACIÓN DEL CLIENTE</strong></h3>
                </td>
            </tr>
            <tr>
                <td><strong>Cliente</strong></td>
                <td>{{$rpta1[0]->cCliente}}</td>
            </tr>
            <tr>
                <td><strong>Documento</strong></td>
                <td>{{$rpta1[0]->cDocumento}}</td>
            </tr>
            <tr>
                <td><strong>Correo Electronico</strong></td>
                <td>{{$rpta1[0]->cCorreo}}</td>
            </tr>
            <tr>
                <td><strong>Teléfono</strong></td>
                <td>{{$rpta1[0]->cTelefono}}</td>
            </tr>
        </table>

        @if (count($rpta2) > 0)
            <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center" style="bordercolor: black">
                <thead style="background-color: #010c3d; color:white; bordercolor: black">
                    <tr align="center" align="middle">
                        <th colspan="2">DETALLE DEL CASO</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>PRODUCTO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rpta2 as $key => $value)
                    <tr>
                        <td align="center"><span>{{$key + 1}}</span></td>
                        <td align="center"><span>{{$value->cProducto}}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (!empty($rpta1[0]->cComentario))
            <table width="100%" cellspacing="0" cellspacing="0" align="center" border="1" style="bordercolor: black">
                <tr>
                    <td><h3><strong>Comentarios Adicionales</strong></h3></td>
                </tr>
                <tr>
                    <td>{{$rpta1[0]->cComentario}}</td>
                </tr>
            </table>
        @endif
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <table width="100%" cellspacing="0" cellspacing="1" align="center" >
            <thead>
                <tr align="center" align="middle">
                    <th colspan="1" style="color: rgb(3, 11, 53)"><strong>INFORMACIÓN AUTOGENERADA</strong></th>
                </tr>
                <tr>
                    <th><small>La información que aparece en este documento nombrado CASO_CRM_{{$rpta1[0]->nNumeroPedido}} es de uso confidencial y fue suministrada por el Grupo Konecta. Cualquier tipo de divulgación no autorizada por el BPO, entidad bancaria o el cliente puede ser penalizada según la ley.</small></th>
                </tr>
            </thead>
        </table>

    </div>
</body>
</html>
