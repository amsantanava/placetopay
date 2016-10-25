<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PSE</title>

    <!-- Bootstrap Core CSS -->
    {{HTML::style('css/bootstrap.min.css')}}

    
    <!-- Custom Fonts -->
    {{HTML::style('font-awesome-4.1.0/css/font-awesome.min.css')}}

    <!-- Mi estilo -->
    {{HTML::style('css/pse.css')}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {{HTML::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}
    {{HTML::script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}

    <![endif]-->

    {{ HTML::script('js/jquery-1.11.0.js') }}

</head>

<body>

    <div id="wrapper">

        <div id="page-wrapper" style="padding: 30px;">
            @if($errors->has())
                @include('layouts.error')
            @endif
            @yield('contentBody')

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('js/bootstrap.min.js') }}

    
    @section('scriptView')
    @show

</body>

</html>
