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
    <link href="/assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="/assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="/assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!-- Main CSS-->
    <link href="/assets/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 p-t-165 p-b-100">
        <div class="wrapper wrapper--w720">
            <div class="">
                <a href="{{ url('/logout') }}" class="btn btn-danger" style="float:right">Logout</a>
                <div class="container">
                    <form>
                        <span class="text-danger" id="error"></span>
                        <div class="row">
                            <h4>&nbsp;</h4>
                            <div class="input-icon">Full Name</div>
                            
                            <div class="input-group input-group-icon"><input type="text" required="" id="fullname" placeholder="Full Name" />
                                <div class="input-icon"><i class="fa fa-user"></i></div>
                            </div>
                            <div class="input-icon">Email</div>
                            <div class="input-group input-group-icon"><input type="email" required="" id="email" placeholder="Email Adress" />
                                <div class="input-icon"><i class="fa fa-envelope"></i></div>
                            </div>
                            <div class="input-icon">Amount</div>
                            <div class="input-group input-group-icon"><input type="number" min="1" minlength="1" value="" required="" id="amount" placeholder="Amount" />
                                <div class="input-icon"><i class="fa fa-user"></i></div>
                            </div>
                            <div class="input-icon">Services</div>
                            <div class="input-group input-group-icon">                
                                <select name="service" class="form-control selectpicker" required="" id="service" placeholder="Services" multiple id="" >
                                    <option disabled>Select Services</option>
                                    <option value="Web Development">Web Development</option>
                                    <option value="Web Design">Web Design</option>
                                    <option value="App Development"> App Development</option>
                                    <option value="Brand Development "> Brand Development </option>
                                    <option value="Video Animation"> Video Animation</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="input-group input-group-icon">
                                <div class="input-group">
                                    <label style="width: 100%;" for="payment-method-card">
                                        <button type="button" id="generate-link" style="display: inline-block;width: 100%;text-align: center;float: left;border-radius: 0;background-color: #f0a500;color: #fff;border-color: #bd8200;padding: 1em;">Generate Link</button>
                                    </label>
                                </div>
                            </div>
                            <span id="link" style="color:green;"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="/assets/vendor/select2/select2.min.js"></script>
    <script src="/assets/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="/assets/vendor/bootstrap-wizard/bootstrap.min.js"></script>
    <script src="/assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="/assets/vendor/datepicker/moment.min.js"></script>
    <script src="/assets/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="/assets/js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#generate-link').click(function(e){
        e.preventDefault();

        var fullname = $('#fullname').val();
        if(fullname == ''){
            $('#error').html('please input full Name');
            return false;
        }
        var email = $('#email').val();
        if(email == ''){
            $('#error').html('please input email');
            return false;
        }
        var amount = $('#amount').val();
         if(amount == ''){
            $('#error').html('please input amount');
            return false;
            }
           
         if(amount == 0){
            $('#error').html('please input amount grater than $1');
            return false;
            }
           
        var service = $('#service').val();
        
        if(service == null){
            $('#error').html('please select service');
            return false;
        }
        
        $.ajax({
           type:'POST',
           url:"{{ route('generate_link') }}",
           data:{fullname:fullname,email:email,service:service,amount:amount},
           success:function(data){
              $('#link').empty().append(data.link);
              alert(data.success);
           }
        });
    });
</script>
</html>
<!-- end document-->