@extends('layouts.template')

@section('contentBody')

{{ HTML::style('css/plugins/dataTables.bootstrap.css') }}

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Finalizar pago</h2>
    </div>
</div>
<div id="message" class="alert alert-warning">
    Respuesta: {{$message}}
</div>
<a href="{{url('/')}}">
    <button class="btn btn-info">Inicio</button>
</a>

@stop
