<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Selected Movie</title>

		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		
		<style type="text/css">
			.main-background {
				background-image: url({{'https://image.tmdb.org/t/p/original' . $details['backdrop']}});
				background-size: cover;
				height: 100vh;
				width: 100%;
			}
		</style>

	</head>

	<body>
		
		<div class="main-background">
			<div class="background-gradiant">
				<a href="/">
					<button class="back-button">Back to Search</button>
				</a>

				<div class="information-panel">

					<div class="information-left">
						<h1 class="header">{{$details['title']}}</h1>
						<p>Runtime - {{$details['runtime_hours']}} hour, {{$details['runtime_minutes']}} minutes</p>
						<p>Release Date - {{$details['release_date']}}</p>
						<p>Overview - {{$details['overview']}}</p>
					</div>

					<div class="information-right">
						<h2 class="header">Actors/Characters</h1>
						@foreach ($credits as $credit)
							<ul class="list-of-actors">
								<li>Actor: {{$credit->name}}</li>
								<li>Character: {{$credit->character}}</li>
							</ul>
						@endforeach
					</div>

				</div>
			</div>
		</div>

	</body>

</html>