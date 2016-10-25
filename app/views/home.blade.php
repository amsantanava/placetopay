@extends('layouts.template')

@section('contentBody')

{{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
{{ HTML::style('css/plugins/sweetalert.css') }}

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Historial de transacciones</h2>
    </div>
</div>
<div class="col-lg-12">
    <div class="btn-create">
        <a href="{{url('/createPayment')}}">
            <button id="bCreate" type="button" class="btn btn-success btn-circle">
                <i class="fa fa-plus"></i> Nueva transacción
            </button>
        </a>
    </div>
    <br>
    <br>
    <br>
    <div class="clearfix"></div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="table">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>TransactionID</th>
                            <th>Return Code</th>
                            <th style="width: 200px">Response Reason Text</th>
                            <th>Reference</th>
                            <th>Transaction State</th>
                            <th>Bank Process Date</th>
                            <th>Etapa</th>
                            <th>Fecha</th>
                            <th>Request</th>
                            <th>Response</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->transactionID}}</td>
                            <td>{{$transaction->returnCode}}</td>
                            <td>{{$transaction->responseReasonText}}</td>
                            <td>{{$transaction->reference}}</td>
                            <td>{{$transaction->transactionState}}</td>
                            <td>{{$transaction->bankProcessDate}}</td>
                            <td>{{$transaction->type}}</td>
                            <td>{{$transaction->created_at}}</td>
                            <td>
                                <div id='request_{{$transaction->id}}' style='display:none'><pre>{{$transaction->xml_request}}</pre></div>
                                <buttton class='btn btn-primary' onclick="swal({   
                                        title: 'Request!',   
                                        text: $('#request_{{$transaction->id}}').html(),   
                                        html: true 
                                        });">Ver request</button>
                            </td>
                            <td>
                                <div id='response_{{$transaction->id}}' style='display:none'><pre>{{$transaction->xml_response}}</pre></div>
                                <buttton class='btn btn-success' onclick="swal({   
                                        title: 'Response!',   
                                        text: $('#response_{{$transaction->id}}').html(),   
                                        html: true 
                                        });">Ver response</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{ HTML::script('js/plugins/dataTables/jquery.dataTables.js') }}
{{ HTML::script('js/plugins/dataTables/dataTables.bootstrap.js') }}
{{ HTML::script('js/plugins/sweetalert.min.js') }}

@stop


@section('scriptView')
<script>
    $(document).ready(function(){
        $("#table table").dataTable({
            aaSorting: []
        });
    });
</script>
@stop