<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación Papajohns HelpDesk</title>
    <style>
        .enlace {
            color: #ffffff;
            background-color: #2d63c8;
            font-size: 19px;
            border: 1px solid #2d63c8;
            padding: 15px 50px;
            cursor: pointer
        }

        .enlace:hover {
            color: #2d63c8;
            background-color: #ffffff;
        }
    </style>
</head>

<body style="padding:20px;background-color:#D0D3D4;">
    <div style="background-color:white;padding:20px;">
        <center>
            <img style="width:60%" src="https://www.papajohns.com.mx/images/logos/pji_arch_red_en.png">
        </center>
        <br>
        <center>
            <h1 style="color: #3498DB">Mesa de ayuda<br>"MyHelpDeskPJ"</h1>
        </center>
        <p style="font-size: 22px;">
            @if ($tipo_notificacion == 'nuevo_caso')
                Se ha creado un nuevo ticket
            @endif
            @if ($tipo_notificacion == 'nuevo_seguimiento')
                Se ha agregado un nuevo seguimiento a un ticket
            @endif
            @if ($tipo_notificacion == 'nuevo_archivo')
                Se ha agregado un nuevo archivo a un ticket
            @endif
            @if ($tipo_notificacion == 'cambio_estatus')
                Se ha cambiado el estatus de un ticket
            @endif

            a travéz del portal
            <a href="http://dotech.dyndns.biz:16666/help_ppj_api" target="_BLANK">MyHelpDeskPJ</a>
            con el folio <strong>{{ $caso->num_case }}</strong> por el contacto
            <strong>{{ $caso->contacto->name }}</strong> en el área de
            <strong>{{ $caso->area_servicio->name }}</strong> de tipo
            <strong>{{ $caso->tipo_servicio->name }}</strong> con la siguiente descripción:
            <br><br>
            <i>"{{ $caso->description }}"</i>

        </p>
        Para dar seguimiento al caso por favor ingrese al siguiente enlace:
        <br><br><br>
        <center>
            <a href="http://dotech.dyndns.biz:16666/help_ppj_api" target="_BLANK" class="enlace">
                IR AL PORTAL
            </a>
        </center>
        <br>
        <br>
        <small>
            <b>
                La información contenida en este correo electrónico se considera material estrictamente confidencial.
                Por lo cual, cualquier uso que se le dé y que no se haya autorizado previamente por DOTECH., sus
                empresas subsidiarias y afiliadas, así como sus empleados debidamente facultados, se estará
                utilizando en contravención. El presente correo electrónico cumple efectos meramente informativos entre
                “DOTECH” y el receptor de este. Si usted recibió este mensaje por error, por favor contacte
                al emisor y borre su contenido de cualquier computadora en la que resida.
            </b>
        </small>
    </div>
</body>

</html>
