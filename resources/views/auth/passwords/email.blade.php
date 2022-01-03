<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="{{ url('/public/both/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{url('public/admin/login/css/style.css')}}">
  <link rel="stylesheet" href="{{url('public/admin/login/css/responsive.css')}}">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Forgot Password</title>
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
              <img class="h-100 w-100" src="{{ url('/public/admin/login/img/slide-img.jpg') }}" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="h-100 w-100" src="{{ url('/public/admin/login/img/slide-img.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="h-100 w-100" src="{{ url('/public/admin/login/img/slide-img.jpg') }}" alt="Third slide">
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
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group material-behaviour">
              <input id="emailid" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              <label class="movelabel" for="emailid">Email</label>

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror

            </div>

            <div class="form-group row mb-0">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary login_btn">
                  {{ __('Forgot Password') }}
                </button>
              </div>
            </div>
            
            <!-- <div class="form-group mb-5">
              <button type="submit" class="btn btn-primary" id="login_button">
                {{ __('Forgot Password') }}
              </button>
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
