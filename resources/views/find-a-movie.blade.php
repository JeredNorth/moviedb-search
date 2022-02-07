<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Find a Movie</title>

		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	</head>

	<body>
		@if (session('error'))
			<div class="alert alert-danger movie-error">{{ session('error') }}</div>
		@endif
		
		<h1 class="find-header">Find a Movie!</h1>

		<form class="search-form" method="GET" action="/movies">
			@csrf
			<input class="search-input" type="text" name="title">
		</form>

	</body>


</html>