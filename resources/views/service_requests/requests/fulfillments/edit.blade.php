@extends('layouts.app')

@section('title', 'Cumplimiento de solicitud')

@section('content')

@include('service_requests.partials.nav')

<h3>Cumplimiento de solicitud:
  <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}">{{ $serviceRequest->id }}</a>
</h3>

<div class="form-row">
  <fieldset class="form-group col-12 col-md-2">
      <label for="for_request_date">ID Solicitud</label>
      <input type="text" class="form-control" value="{{$serviceRequest->id}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_request_date">C.Responsabilidad</label>
      <input type="text" class="form-control" value="{{$serviceRequest->responsabilityCenter->name}}" disabled style="background-color:#F5A7A7;">
  </fieldset>

  <fieldset class="form-group col-12 col-md-3">
      <label for="for_request_date">Responsable</label>
      <input type="text" class="form-control" value="{{$serviceRequest->SignatureFlows->where('sign_position',1)->first()->user->getFullNameAttribute()}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-3">
      <label for="for_start_date">Supervisor</label>
      <input type="text" class="form-control" value="{{$serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->getFullNameAttribute()}}" disabled>
  </fieldset>

</div>

<div class="form-row">

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_start_date">Fecha de Inicio</label>
      <input type="text" class="form-control" value="{{$serviceRequest->start_date->format('Y-m-d')}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Fecha de Término</label>
      <input type="text" class="form-control" value="{{$serviceRequest->end_date->format('Y-m-d')}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Tipo de contrato</label>
      <input type="text" class="form-control" value="{{$serviceRequest->program_contract_type}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Jornada de trabajo</label>
      <input type="text" class="form-control" value="{{$serviceRequest->working_day_type}}" disabled>
  </fieldset>

</div>

<div class="form-row">

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_request_date">Rut</label>
      <input type="text" class="form-control" value="{{$serviceRequest->employee->runNotFormat()}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-6">
      <label for="for_start_date">Funcionario</label>
      <input type="text" class="form-control" value="{{$serviceRequest->employee->getFullNameAttribute()}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Estamento</label>
      <input type="text" class="form-control" value="{{$serviceRequest->estate}}" disabled>
  </fieldset>

</div>

<div class="form-row">
    <div class="col-6">
        @livewire('service-request.upload-resolution', ['serviceRequest' => $serviceRequest])
    </div>

    @can('be god')
    <div class="col-6 text-right">
        <a type="button" class="btn btn-outline-primary"
           href="{{ route('rrhh.service-request.report.budget-availability',$serviceRequest->id) }}" target="_blank">Ver
            C. Disp. Presupuestaria <i class="fas fa-file"></i> </a>

        @livewire('service-request.sign-budget-availability', ['serviceRequest' => $serviceRequest])
    </div>
    @endcan


</div>

<hr>

@if($serviceRequest->program_contract_type == "Mensual")
    @include('service_requests.requests.fulfillments.edit_monthly',['serviceRequest' => $serviceRequest])
@else
    @if($serviceRequest->working_day_type == "HORA MÉDICA")
        @include('service_requests.requests.fulfillments.edit_hours_medics',['serviceRequest' => $serviceRequest])
    @else
        @include('service_requests.requests.fulfillments.edit_hours_others',['serviceRequest' => $serviceRequest])
    @endif
@endif

@canany(['Service Request: audit'])
<br /><hr />
<div style="height: 300px; overflow-y: scroll;">
  @foreach($serviceRequest->fulfillments as $key => $fulfillment)
    @include('service_requests.requests.partials.audit', ['audits' => $fulfillment->audits] )
  @endforeach
</div>
@endcanany

@endsection

@section('custom_js')

<script type="text/javascript">

	// $(".add-row").click(function(){
  //     var type = $("#type").val();
  //     var shift_start_date = $("#shift_start_date").val();
  //     var start_hour = $("#start_hour").val();
	// 		var shift_end_date = $("#shift_end_date").val();
	// 		var end_hour = $("#end_hour").val();
	// 		var observation = $("#observation").val();
  //     var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='type[]' id='type' value='"+ type +"'>"+ type +"</td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
  //     $("table tbody").append(markup);
  // });
  //
	// // Find and remove selected table rows
  // $(".delete-row").click(function(){
  //     $("table tbody").find('input[name="record"]').each(function(){
  //     	if($(this).is(":checked")){
  //             $(this).parents("tr").remove();
  //         }
  //     });
  // });

  $('.for_type').on('change', function() {
    $('.start_date').attr('readonly', false);
    $(".start_date").val('');
    $('.start_hour').attr('readonly', false);
    $('.start_hour').val('');
    $('.end_date').attr('readonly', false);
    $(".end_date").val('');
    $('.end_hour').attr('readonly', false);
    $('.end_hour').val('');
    if (this.value == "Inasistencia Injustificada") {

    }
    if (this.value == "Licencia no covid") {
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }
    if (this.value == "Renuncia voluntaria") {
      $('.start_date').attr('readonly', true);
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }
    if (this.value == "Abandono de funciones") {
      $('.start_date').attr('readonly', true);
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }

    // start_date
    // start_hour
    // end_date
    // end_hour
  });



</script>

@endsection
