@extends('layouts.app')

@section('title', 'Crear Ingreso')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.control.generate-reception', [
    'store' => $store,
])

@endsection
