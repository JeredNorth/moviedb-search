<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Skill;
use App\Models\Applicant;
use View;

class MovieDatabaseController extends Controller {

  function getMovie(Request $request) {
    try { 
      $API_URL = 'https://api.themoviedb.org/3/search/movie?api_key=';

      $movieTitle = $request->input('title'); //user input

      $httpClient = new \GuzzleHttp\Client();
      $clientRequest = $httpClient->get($API_URL . $_ENV["MOVIE_API_KEY"] . "&query=" . $movieTitle); //search for movie

      $response = json_decode($clientRequest->getBody()->getContents());

      $movieId = $response->results[0]->id; //get movie id of the first movie returned

      $movieDetails = $this->getMovieDetails($movieId);
      $movieCredits = $this->getMovieCredits($movieId);
    }
    catch (\Exception $exception) {
      return back()->withError("Oops! No Movie Found! Please try again!");
    }

    return view::make('movie', ['details' => $movieDetails, 'credits' => $movieCredits]);
  }

  function getMovieDetails($movieId) { //title, overview, release_date, runtime, backdrop path

    $MOVIE_URL = 'https://api.themoviedb.org/3/movie/' . $movieId . '?api_key=';

    $httpClient = new \GuzzleHttp\Client();
    $clientRequest = $httpClient->get($MOVIE_URL . $_ENV["MOVIE_API_KEY"]);

    $response = json_decode($clientRequest->getBody()->getContents());

    $runtime = $this->formatMovieRuntime($response->runtime);

    $movieDetails = [
      "title" => $response->title,
      "overview" => $response->overview,
      "release_date" => $response->release_date,
      "runtime_hours" => $runtime['hours'],
      "runtime_minutes" => $runtime['minutes'],
      "backdrop" => $response->backdrop_path
    ];

    return $movieDetails;
  }

  function getMovieCredits($movieId) { //name and character of the first 10 members of the cast

    $movieCredits = [];

    $CREDITS_URL = 'https://api.themoviedb.org/3/movie/' . $movieId . '/credits?api_key=';

    $httpClient = new \GuzzleHttp\Client();
    $clientRequest = $httpClient->get($CREDITS_URL . $_ENV["MOVIE_API_KEY"]);

    $response = json_decode($clientRequest->getBody()->getContents());

    for ($i=0; $i < 10; $i++) { //get the first 10 cast members
      // if(array_key_exists($i, $response->cast)) {
        array_push($movieCredits, $response->cast[$i]);
      // }
      // else {
      //   continue;
      // }
    }

    return $movieCredits;
  }

  function formatMovieRuntime($runtime) { //get the runtime in hours and minutes instead of just minutes
    $hours = floor($runtime / 60);
    $minutes = ($runtime % 60);

    $formattedTime = ['hours' => $hours, 'minutes' => $minutes];

    return $formattedTime;
  }

}