@extends('layouts.template')

@section('contentBody')

{{ HTML::style('css/plugins/dataTables.bootstrap.css') }}

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Crear pago</h2>
    </div>
</div>
@if ($message !== '' && $message != null)
    <div id="message" class="alert alert-warning">
        {{ $message }}
    </div>
@endif
<div class="col-lg-6">
    <div class="clearfix"></div>
    <div class="panel panel-default">
        <div class="panel-body">
            {{ Form::open(array('action' => 'PseController@createPayment',
        'method' => 'post','name' => 'formCreatePayment')) }}
        <div class="form-group">
            {{ Form::label('bankCode', 'Banco') }}
            {{ Form::select('bankCode', $banks, null, array('class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('bankInterface', 'Interface bancaria') }}
            {{ Form::select('bankInterface', $bank_interfaces, null, array('class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[documentType]', 'Tipo de documento') }}
            {{ Form::select('payer[documentType]', $documenTypes, null, array('class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[document]', 'Documento') }}
            {{ Form::input('Integer', 'payer[document]', null, array('placeholder' => 'Documento', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[firstName]', 'Nombre') }}
            {{ Form::input('String', 'payer[firstName]', null, array('placeholder' => 'Nombre', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[lastName]', 'Apellido') }}
            {{ Form::input('String', 'payer[lastName]', null, array('placeholder' => 'Apellido', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[company]', 'Empresa') }}
            {{ Form::input('String', 'payer[company]', null, array('placeholder' => 'Empresa', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[emailAddress]', 'Email') }}
            {{ Form::email('payer[emailAddress]', null, array('placeholder' => 'Email', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[address]', 'Dirección') }}
            {{ Form::input('String', 'payer[address]', null, array('placeholder' => 'Dirección', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[city]', 'Ciudad') }}
            {{ Form::input('String', 'payer[city]', null, array('placeholder' => 'Ciudad', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[province]', 'Departamento') }}
            {{ Form::input('String', 'payer[province]', null, array('placeholder' => 'Departamento', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[phone]', 'Teléfono') }}
            {{ Form::input('Integer', 'payer[phone]', null, array('placeholder' => 'Teléfono', 'class' => 'form-control', 'required' => true)) }}
        </div>
        <div class="form-group">
            {{ Form::label('payer[mobile]', 'Móvil') }}
            {{ Form::input('Integer', 'payer[mobile]', null, array('placeholder' => 'Móvil', 'class' => 'form-control', 'required' => true)) }}
        </div>
        
        <div class="form-group">
            {{ Form::submit('Enviar', array('class' => 'btn btn-success')) }}
            <a href="{{url('/')}}">
                <button class="btn btn-danger" type='button'>Cancelar</button>
            </a>
        </div>
    {{ Form::close() }}
        </div>
    </div>
</div>


@stop


