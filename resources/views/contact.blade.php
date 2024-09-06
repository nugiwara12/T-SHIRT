@extends('layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="{{ URL::to('admin_assets/css/indexAbout.css') }}">
        <link rel="stylesheet" href="{{ URL::to('admin_assets/css/contact.css') }}">
        <!-- <link rel="stylesheet" href="{{ URL::to('admin_assets/css/welcome.css') }}"> -->

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    </head>

    <body>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-heading text-uppercase">Contact <br> US</div>
            </div>
    </header>
            
        <div class="container mt-5">

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="" method="post" action="{{ route('contact.store') }}">

            @csrf

            <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name" value="{{ old('name') }}">

            <!-- Error -->
            @if ($errors->has('name'))
            <div class="error">
                {{ $errors->first('name') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Your Email</label>
            <input type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email" id="email" value="{{ old('email') }}">

            @if ($errors->has('email'))
            <div class="error">
                {{ $errors->first('email') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control {{ $errors->has('phone') ? 'error' : '' }}" name="phone" id="phone" value="{{ old('phone') }}">

            @if ($errors->has('phone'))
            <div class="error">
                {{ $errors->first('phone') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Message</label>
            <textarea class="form-control {{ $errors->has('message') ? 'error' : '' }}" name="message" id="message" rows="4">{{ old('message') }}</textarea>

            @if ($errors->has('message'))
            <div class="error">
                {{ $errors->first('message') }}
            </div>
            @endif
        </div>

            <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
            </form><br><br><br><br>
        </div>
</body>
</html>


<!-- Footer-->

<footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright Sarmiento / Mercado; Barangay Tabun</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <!-- <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a> -->
                        <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/profile.php?id=61556005325787" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="https://mail.google.com/mail/u/0/#inbox" aria-label="Email"><i class="fas fa-envelope"></i></a>
                        <!-- <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a> -->
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="https://mail.google.com/mail/u/0/#inbox">barangaytabunmabalacat@gmail.com</a>
                    </div>
                </div>
            </div>
        </footer>
@endsection