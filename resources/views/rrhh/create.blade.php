@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<h3>Nuevo usuario</h3>

@can('Users: create')
<form method="POST" action="{{ route('rrhh.users.store') }}" enctype="multipart/form-data">
    @csrf


    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="formGroupIDInput">ID*</label>
            <input type="number" class="form-control" id="formGroupIDInput" name="id" required="required" min="6" max="99999999" step="">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="formGroupDVInput">DV*</label>
            <input type="text" class="form-control" id="formGroupDVInput" name="dv" required="required" title="Digito verificador">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="formGroupNameInput">Nombre*</label>
            <input type="text" class="form-control" id="formGroupNameInput" placeholder="Nombre" name="name" required="required">
        </fieldset>

        <div class="form-group col">
            <label for="name">Apellido Paterno*</label>
            <input type="text" class="form-control" name="fathers_family" required="required">
        </div>

        <div class="form-group col">
            <label for="name">Apellido Materno*</label>
            <input type="text" class="form-control" name="mothers_family" required="required">
        </div>

        <fieldset class="form-group col-md-2">
            <label for="forbirthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="forbirthday" name="birthday">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="forPosition">Función que desempeña</label>
            <input type="text" class="form-control" id="forPosition" placeholder="Subdirector(S), Enfermera, Referente..., Jefe." name="position">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="formGroupEmailInput">Email*</label>
            <input type="email" class="form-control" id="formGroupEmailInput" placeholder="Email" name="email" required="required">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="formGroupEmailInput">Email Personal</label>
            <input type="email" class="form-control" id="formGroupEmailInput" placeholder="Email Personal" name="email_personal" readonly>
        </fieldset>
    </div>

    <!--
    <fieldset class="form-group">
        <label for="forPhoto">Foto</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="photo" lang="es">
            <label class="custom-file-label" for="customFile">Seleccionar Foto</label>
        </div>
    </fieldset>
        
    -->

    <div class="form-row">
        <fieldset class="form-group col-md-12">
            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                    'select_id' => 'organizationalunit'
                ])
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>

</form>
@endcan

@endsection
