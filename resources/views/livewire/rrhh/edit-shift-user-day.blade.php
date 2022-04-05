<div>
    @php
    $turno = 'Abierto';
    if (isset($shiftUserDay->closeStatus)) {
        switch ($shiftUserDay->closeStatus->status) {
            case 1:
                $turno = 'Confirmado';
                break;
            case 2:
                $turno = 'Cerrado';
                break;
            default:
                $turno = 'Abierto';
                break;
        }
    }
    @endphp
    <h5>
        <i class="fa fa-calendar"></i> {{ isset($shiftUserDay->shift_close_id) ? 'Ver' : 'Modificar' }} día de personal -
        {{ 'Turno ' . $turno }}
    </h5>
    <a href="{{ url()->previous() }}" type="button"  class="btn btn-secondary">Volver</a>
    <hr>
    <form>
        <div class="form-group">
            <input type="hidden" wire:model="user_id">
            <label for="exampleFormControlInput1"><i class="fa fa-info"></i> INFORMACIÓN  ID
                <b>#</b>{{ isset($shiftUserDay) && $shiftUserDay->ShiftUser ? $shiftUserDay->id : '' }}</label>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Pertence a</th>
                            <td>
                                {{ $shiftUserDay->ShiftUser->user->name }}
                                {{ $shiftUserDay->ShiftUser->user->fathers_family }}
                                {{ $shiftUserDay->ShiftUser->user->mothers_family }}
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Tipo de jornada</th>
                            <td>
                                @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser && substr($shiftUserDay->working_day, 0, 1) != '+')
                                    {{ $shiftUserDay->working_day }} -
                                    {{ strtoupper($tiposJornada[$shiftUserDay->working_day]) }}
                                @elseif(isset($shiftUserDay) && $shiftUserDay->ShiftUser && substr($shiftUserDay->working_day, 0, 1) == '+')
                                    {{ $shiftUserDay->working_day }}
                                @else
                                    <i class="fas fa-spinner fa-pulse"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Fecha</th>
                            <td>
                                @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser)
                                    {{ \Carbon\Carbon::parse($shiftUserDay->day)->format('d-m-Y') }}
                                @else
                                    <i class="fas fa-spinner fa-pulse"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Estado </th>
                            <td>
                                @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser)
                                    {{ $shiftUserDay->status }} - {{ strtoupper($estados[$shiftUserDay->status]) }}
                                    <i class="fa fa-circle "
                                        style="color:{{ $statusColors[$shiftUserDay->status] }}"></i>
                                    @if ($shiftUserDay->status == 3)
                                        {!! $shiftUserDay->confirmationStatus() == 1 ? '<small style="color:blue">Confirmado</small>' : ($shiftUserDay->confirmationStatus() == 3 ? '<small style="color:red">Rechazado</small>' : '<small style="color:red">Sin Confirmar</small>') !!}
                                    @endif
                                @else
                                    <i class="fas fa-spinner fa-pulse"></i>

                                @endif
                                @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser && $shiftUserDay->status == 3 && $shiftUserDay->confirmationStatus() == 0)
                                <button type="button" class="btn btn-success ml-auto" data-dismiss="modal"
                                    wire:click.prevent="confirmExtraDay()">Confirmar <i class="fa fa-check"></i></button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Comentario </th>
                            <td>
                                @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser)
                                    {{ $shiftUserDay->commentary }}
                                @else
                                    <i class="fas fa-spinner fa-pulse"></i>
                                @endif
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        @if(!isset($shiftUserDay->shift_close_id))
        <div class="form-group">

            <input type="hidden" wire:model="user_id">

            <label for="exampleFormControlInput1"><i class="fa fa-cog"></i> ACCION </label>


            <select class="form-control" name="slcAction" wire:model="action" wire:change="changeAction">
                <option value="0"> <b> </b> - - - </option>
                <option value="1"> <b> </b>1 - Intercambiar Turno con </option>
                <option value="7"> 2 - <b style="color:">Cambiar Tipo de Jornada Por</b> </option>
                <!-- <option value="2"> <b> </b>2 - Marcar como Cumplido </option> -->
                <option value="3"> <b> </b>3 - Marcar como Licencia Medica </option>
                <option value="4"> 4 - <b style="color:">Marcar como Fuero Gremial</b> </option>
                <option value="5"> 5 - <b style="color:">Marcar como Feriado Legal</b> </option>
                <option value="6"> 6 - <b style="color:">Marcar como Permiso Excepcional</b> </option>
                <option value="8"> 8 - <b style="color:">Marcar como Permiso Sin goce de sueldo</b> </option>

                <option value="9"> 9 - <b style="color:">Marcar como Descanzo Compensatorio</b> </option>
                <option value="10"> 10 - <b style="color:">Marcar como Permiso Administrativo Completo</b> </option>
                <option value="11"> 11 - <b style="color:">Marcar como Permiso Administrativo Medio Turno Diurno</b> </option>
                <option value="12"> 12 - <b style="color:">Marcar como Permiso Administrativo Medio Turno Nocturno</b> </option>
                <option value="13"> 13 - <b style="color:">Marcar como Permiso a Curso</b> </option>
                <option value="15"> 14 - <b style="color:">Marcar como Ausencia sin Justificar</b> </option>
                <option value="16"> 15 - <b style="color:">Cambiar jornada por necesidad de servicio</b> </option>
                <option value="14"> 16 - <b style="color:">Agregar horas por necesidad de servicio</b> </option>
                <option value="17"> 16 - <b style="color:">Marcar como Abandono de funcion</b> </option>


            </select>


            <span class="text-danger"></span>

        </div>
        <div class="form-group " style="display: {{$usersSelect}}">

            <label for="exampleFormControlInput1"><i class="fa fa-user"></i> PERSONAL </label>

             <select class="selectpickerx  form-control" wire:model="userIdtoChange" wire:change="findAvailableExternalDaysToChange">
                <option value="0" >0 - Dejar disponible </option>
                @if( isset($users) )
                    @foreach($users as $u)

                        <option value="{{$u->id}}" >{{$u->id}} - {{$u->name}} {{ $u->fathers_family }} {{ $u->mothers_family }} </option>

                    @endforeach
                @endif
            </select>

        </div>
        <div class="form-group" style="display: {{$changeDayType}}">

            <label for="exampleFormControlInput1"><i class="fa fa-sun-o"></i> Tipo de Jornada </label>
             <select class="form-control" wire:model="newWorkingDay" name="slcAction">
                @foreach( $tiposJornada as $index=>$tj )
                    <option value="{{$index}}">
                    {{$index}} - {{strtoupper($tj)}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display: {{$addHours}}">
            <label for="exampleFormControlInput1"><i class="fa fa-time"></i> CANT. HORAS </label>
            <input type="time" class="form-control" wire:model="cantNewHours">
        </div>

        <div class="form-group " style="display: {{$usersSelect2}}">
            <div class="row">
            <div class="col-md-6">
                 <label for="exampleFormControlInput1"><i class="fa fa-user"></i> REMPLAZAR CON </label>
             <select class="form-control selectpickerx" wire:model="userIdtoChange2" name="slcAction">
                <option value="0" >0 - Dejar disponible </option>
                @if( isset($users) )
                    @foreach($users as $u)

                        <option value="{{$u->id}}" >{{$u->id}} - {{$u->name}} {{ $u->fathers_family }} {{ $u->mothers_family }} </option>

                    @endforeach
                @endif
            </select>
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlInput1">  Es suplente</label>
                <br>
            <input type="checkbox"   wire:model="chkSuplente">
            </div>
            </div>

        </div>


        <div class="form-group" style="display: {{$repeatAction}}">

            <label for="exampleFormControlInput1"><i class="fa fa-calendar"></i> Repetir acción hasta </label>
             <input type="date" name="toDate" class="form-control" wire:model="repeatToDate">
        </div>
        @if($availableOwnDaysToChangeVisible == "visible")
        <div class="form-group" style="display: {{$availableOwnDaysToChangeVisible}}">

            <label for="exampleFormControlInput1"><i class="fa fa-calendar"></i> Cambiar día por</label>
            {{--sizeof($availableOwnDaysToChange)--}}
            <select class="form-control" wire:model.defer="dayToToChange2" name="slcAction">
                @foreach( $availableOwnDaysToChange as $day )
                @if(isset($day) && isset($day->id))
                    <option value="{{$day->id}}">
                    {{$loop->iteration}} - {{strtoupper($day->day)}} {{ $day->working_day }}
                     @if ( substr( $day->working_day,0, 1) != "+" )
                        {{ $tiposJornada [ $day->working_day ]}}
                    @elseif(  substr( $day->working_day,0, 1) == "+" )
                        {{-- $day->working_day --}}
                        <!-- no cambiar las oras -->
                    @endif

                    </option>
                    </option>
                @endif
                @endforeach

            </select>

        </div>

        @endif
        <div class="form-group" style="display: {{$availableExternalDaysToChangeVisible}}">
            <label for="exampleFormControlInput1"><i class="fa fa-calendar"></i> Cambiar día por</label>
            <select class="form-control" wire:model.defer="dayToToChange">
                <option value="0"> 0 - No intercambiar por otro día</option>
                @foreach( $availableExternalDaysToChange as $day )
                    @if ( isset(  $day->working_day ) && substr( $day->working_day,0, 1) != "+" )
                        <option value="{{$day->id}}">
                            {{$loop->iteration}} - {{strtoupper($day->day)}} {{ $day->working_day }}

                            {{ $tiposJornada [ $day->working_day ]}}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endif

        <div class="form-group" style="overflow-y:auto;height: 200px;">
            <input type="hidden" wire:model="user_id">
            <label for="exampleFormControlInput1"><i class="fa fa-history "></i> HISTORIAL DE MODIFICACIONES </label>
            @if (isset($shiftUserDay) && $shiftUserDay->ShiftUser)
                @if ($shiftUserDay->derived_from != '' && $shiftUserDay->derived_from > 0)

                    <p><i> >> {{ $shiftUserDay->DerivatedShift->created_at }} - La jornada ha sido creada </i></p>

                    @foreach ($shiftUserDay->DerivatedShift->shiftUserDayLog as $sDerivatedLog)
                        <p><i> >> {{ $sDerivatedLog->created_at }} - {!! $sDerivatedLog->commentary !!} </i></p>
                    @endforeach

                    <p><i> >> {{ $shiftUserDay->created_at }} - La jornada ha sido asginada </i></p>
                @else
                    <p><i> >> {{ $shiftUserDay->created_at }} - La jornada ha sido creada </i></p>
                @endif
                @foreach ($shiftUserDay->shiftUserDayLog as $log)
                    <p><i> >> {{ $log->created_at }} - {!! $log->commentary !!} </i></p>
                @endforeach
            @else
                <p> <i class="fas fa-spinner fa-pulse"></i>
                </p>
            @endif
        </div>
    </form>


    <div class="form-row">
        @if (!isset($shiftUserDay->shift_close_id))
            <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar
            </button>
        @endif
    </div>
</div>
