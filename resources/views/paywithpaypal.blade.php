<!-- <html>
<head>
	<meta charset="utf-8">
	<title>How to integrate paypal payment in Laravel - websolutionstuff.com</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
    <div class="row">    	
        <div class="col-md-8 col-md-offset-2">        	
        	<h3 class="text-center" style="margin-top: 30px;"></h3>
            <div class="panel panel-default" style="margin-top: 60px;">

                @if ($message = Session::get('error'))
                <div class="custom-alerts alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {!! $message !!}
                </div>
                <?php Session::forget('error');?>
                @endif
                <div class="panel-heading"><b>Paywith Paypal</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('paypal')}}" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ $service->amount }}" readonly autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Paywith Paypal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colrolib Templates">
    <meta name="author" content="Colrolib">
    <meta name="keywords" content="Colrolib Templates">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Title Page-->
    <title>Laravel</title>

    <!-- Icons font CSS-->
    <link href="{{asset('/')}}vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="{{asset('/')}}vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{asset('/')}}vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{asset('/')}}vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!-- Main CSS-->
    <link href="{{asset('/')}}css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 p-t-165 p-b-100">
        <div class="wrapper wrapper--w720">
            <div class="">
                <div class="container">
                <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('paypal')}}" >
                        {{ csrf_field() }}


                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                        <div class="row">
                            <h4>&nbsp;</h4>
                            <div class="input-icon">Full Name</div>
                            <div class="input-group input-group-icon"><input type="text" id="fullname" placeholder="Full Name" name="fullname" readonly value="{{ $service->fullname }}" />
                                <div class="input-icon"><i class="fa fa-user"></i></div>
                            </div>
                            <div class="input-icon">Email</div>
                            <div class="input-group input-group-icon"><input type="email" id="email" placeholder="Email Adress" name="email" readonly value="{{ $service->email }}" />
                                <div class="input-icon"><i class="fa fa-envelope"></i></div>
                            </div>
                            <div class="input-icon">Amount</div>
                            <div class="input-group input-group-icon"><input type="text" id="price" placeholder="Price"  name="price" value="$ {{ $service->amount }}" readonly/>
                         <input type="hidden" id="amount" placeholder="Amount"  name="amount" value="{{ $service->amount }}"/>

                                <div class="input-icon"><i class="fa fa-user"></i></div>
                            </div>
                            <div class="input-icon">Services</div>
                            <div class="input-group input-group-icon">    

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Service</th>
                                    </tr>
                                </thead>
                                @php $id=1 @endphp
                                <tbody>

                                    @foreach(json_decode($service->service) as $row)           
                                    
                                    <tr>
                                        <td>{{$id++}}</td>
                                        <td>{{$row}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                
                            </div>
                        </div>
                        <div class="row" >
                            <div class="input-group input-group-icon">
                                <div class="input-group">
                                    <label style="width: 100%;" for="payment-method-card">
                                        <button type="submit" style="display: inline-block;width: 100%;text-align: center;float: left;border-radius: 0;background-color: #f0a500;color: #fff;border-color: #bd8200;padding: 1em;">Pay $ {{ $service->amount }} With Paypal</button>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Jquery JS-->
    <script src="{{asset('/')}}vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="{{asset('/')}}vendor/select2/select2.min.js"></script>
    <script src="{{asset('/')}}vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="{{asset('/')}}vendor/bootstrap-wizard/bootstrap.min.js"></script>
    <script src="{{asset('/')}}vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="{{asset('/')}}vendor/datepicker/moment.min.js"></script>
    <script src="{{asset('/')}}vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="{{asset('/')}}js/global.js"></script>
<script>
    $(document).ready(function (){
        
        $('.dropdown-item selected').prop('disabled',true);
        $('.dropdown-item selected').attr('aria-disabled',true);
    })
</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
<!-- end document-->