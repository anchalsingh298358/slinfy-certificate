<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ url('/public/both/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('public/admin/login/css/style.css')}}">
    <link rel="stylesheet" href="{{url('public/admin/login/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>

    <style type="text/css">
      .invalid-feedback{
        display: block;
      }
    </style>
  </head>
  <body>
      <div class="login-wrap">
         <div class="rounded alignVertical w-100 my-auto bg-white">
              <div class="row">
                
                <div class="col-12 col-sm-6 col-md-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img class="h-100 w-100" src="{{ url('/public/images/certificate/1.jpg') }}" alt="First slide">
                      </div>
                      <div class="carousel-item">
                        <img class="h-100 w-100" src="{{ url('/public/images/certificate/2.jpg') }}" alt="Second slide">
                      </div>
                      <div class="carousel-item">
                        <img class="h-100 w-100" src="{{ url('/public/images/certificate/3.jpg') }}" alt="Third slide">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                  
                      <div class="w-100 logo-wrap text-center pt-4 px-3">
                        <a href="{{ url('/admin') }}">
                          <img src="{{ url('/public/admin/login/img/logo.png') }}" alt="Logo Image" class="img-fluid">
                          <!-- <h1>Bervor App</h1> -->
                        </a>
                      </div>
                    <div id="login_form" class="container pr-5 login-form-box">
                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                              @if(Session::has('error'))
                                <div class="alert alert-danger pad-0">
                                  <span class="login_error">
                                    {{Session::get('error') }}
                                  </span>
                                </div>
                              @endif

                              <div class="form-group material-behaviour">
                                <input id="emailid" type="email" class="form-control" name="email" value="{{old('email')}}" required="">
                                
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <label class="movelabel" for="emailid">{{ __('E-Mail Address') }}</label>
                              </div>

                               <div class="form-group material-behaviour">
                                <input id="password" type="password" class="form-control" name="password" value="{{old('password')}}" required="">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <label class="movelabel" for="password">{{ __('Password') }}</label>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-12 col-md-6">
                                    <div class="checkbox-wrap">
                                      <input type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember">
                                      <label>Remember Me</label>
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6 text-center text-md-right mt-2 mt-sm-0">
                                    <a href="{{ route('password.request') }}" class="text-blue">Forgot Password?</a>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary login_btn">
                                    {{ __('Log In') }}
                                </button>
                            </div>
                        </div>

                              <!-- <div class="form-group mb-5">
                                <button type="submit" class="btn btn-block border-0">login</button>
                              </div> -->

                            </form>
                       
                    </div>
                
                </div>
              </div>
            </div>
      </div>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <!-- <script src="{{ url('/public/both/jquery.min.js') }}"></script> -->
    <script src="{{url('public/admin/login/js/popper.min.js')}}"></script>
    <script src="{{ url('/public/both/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{url('public/admin/login/js/script.js')}}"></script>
  </body>
</html>