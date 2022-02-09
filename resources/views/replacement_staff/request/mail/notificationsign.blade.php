@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa que se encuentra disponible en {{ env('APP_NAME') }}
    una solicitud de contratación correspondiente a su Unidad Organizacional, favor ingresar
    al módulo <strong>Solicitud de Contratación</strong> para aceptar o declinar el requerimiento.
  </p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $requestReplacementStaff->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $requestReplacementStaff->name }}</li>
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $requestReplacementStaff->user->FullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $requestReplacementStaff->organizationalUnit->name }}</li>
  </ul>

  <br>

  <p>Esto es un mensaje automatico de: {{ settings('site.title') }} -  {{ settings('site.organization') }} .</p>




</div>

@endsection
