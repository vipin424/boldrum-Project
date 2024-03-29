<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | Page</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
    <style>
            .alert {
            padding: 5px 30px 5px 0px;
            margin-bottom: -20px;
            border: 1px solid transparent;
            border-radius: 4px;
            }
        </style>
        </head>

    <body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><h2>Boldrum</h2></div>
								<p class="lead">Login to your account</p>
                                @if($message = Session::get('error'))
                                <div class="alert alert-danger text-center alert-dismissible" role="alert">{{$message}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                                </div>
                                @endif
							</div>
							<form class="form-auth-small" action="/login" method="Post">
                            @csrf
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" name="email" class="form-control" id="signin-email" placeholder="Email" required>
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password" class="form-control" id="signin-password" placeholder="Password" required>
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox">
										<span>Remember me</span>
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
								</div>
							</form>
						</div>
					</div>
	
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
</body>

</html>
