<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" 
    href="{{asset('public/admin/assets/images/favicon.png')}}">
    
    <title>Login</title>

    <link href="{{asset('public/admin/assets/css/pages/login-register-lock.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/assets/css/style.css')}}" rel="stylesheet">
    <style>
      .error{
        color: red!important;
      }
    </style>
</head>
<body class="skin-default card-no-border">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" 
        style="background-image:url({{asset('public/admin/assets/images/background/login-register.jpg')}});">
            <div class="login-box card">
                <div class="card-body">
                    <form method="post" class="form-horizontal form-material"  id="loginform" action="{{URL::to('/admin/login_submit')}}">
                      @csrf
                        <h3 class="text-center m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="text" required="" placeholder="Email"> 
                                @if($errors->has('email'))
                                 <p class="error" >{{ $errors->first('email') }}</p>
                                @endif  
                              </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Password">
                                @if($errors->has('password'))
                                  <p class="error" >{{ $errors->first('password') }}</p>
                                @endif  
                              </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn w-100 btn-lg btn-info btn-rounded text-white" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" action="index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg w-100 text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script src="{{asset('public/admin/assets/node_modules/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('public/admin/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
        
        
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>

</html>