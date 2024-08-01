
<!DOCTYPE html>
<html lang="en" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ env('APP_NAME') }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">
			<div class="signup">
                <form action="{{ route('login.submit') }}" method="post">
                    @csrf
					<label aria-hidden="true">Log In</label>
                    @if(Session::has("error_message"))
                        <p class="server-error-message">     {!!Session::get('error_message')!!}</p>
                    @endif

                    <input type="email" name="email" placeholder="Email" required="" value="{{ old('email') }}">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

					<input type="password" name="password" placeholder="Password" required="">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
					<button type="submit">Log In</button>
                    <p style="text-align:center">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
				</form>
			</div>

	</div>
</body>
</html>
<!-- partial -->

</body>
</html>

