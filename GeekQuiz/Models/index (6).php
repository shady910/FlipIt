<?php

require('../model/database.php');
require('../model/movie_db.php');
require('../model/genre_db.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_movies';
    }
}

if ($action == 'list_movies') {
    $genre_id = filter_input(INPUT_GET, 'genre_id', FILTER_VALIDATE_INT);
    if ($genre_id == NULL || $genre_id == FALSE) {
        $genre_id = 1;
    }
    $genre_name = get_genre_name($genre_id);
    $genres = get_genres();
    $movies = get_movies_by_genre($genre_id);
    include('movie_list.php');
}
//     delete button validation
 else if ($action == 'delete_movie') {
    $movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);
    $genre_id = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT);
    if ($genre_id == NULL || $genre_id == FALSE ||
            $movie_id == NULL || $movie_id == FALSE) {
        $error = "Missing or incorrect movie id or genre id.";
        include('../errors/error.php');
    } else {
    $message = "Successfully deleted movie.";
        delete_movie($movie_id);
        header("Location: .?genre_id=$genre_id");
    }
    // edit button validation

} else if ($action == 'show_edit_form') {
    $genres = get_genres();
    $movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);
    $genre_id = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT);
    $votes = filter_input(INPUT_POST, 'votes');
    $name = filter_input(INPUT_POST, 'movieName');
    $rating = filter_input(INPUT_POST, 'rating');
    $comments = filter_input(INPUT_POST, 'comments');
   
    if ($genre_id == NULL || $genre_id == FALSE || $votes == FALSE ||
            $name == NULL || $rating == FALSE || $comments == NULL || $movie_id == null || $movie_id == false) {
        $error = "Invalid movie data. Check all fields and try again.";
        include('movie_edit.php');
    } else {
    $message = "Successfully edited movie.";
        include('movie_edit.php');
    }
} else if ($action == 'edit_movie') {
    $movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);
    $genre_id = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT);
    $votes = filter_input(INPUT_POST, 'votes');
    $name = filter_input(INPUT_POST, 'movieName');
    $rating = filter_input(INPUT_POST, 'rating');
    $comments = filter_input(INPUT_POST, 'comments');
    if ($genre_id == NULL || $genre_id == FALSE || $votes == FALSE ||
            $name == NULL || $rating == FALSE || $comments == NULL || $movie_id == NULL || $movie_id == FALSE) {
        $error = "Invalid movie data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        edit_movie($movie_id, $votes, $name, $rating, $genre_id, $comments);
        header("Location: .?genre_id=$genre_id");
    }
} else if ($action == 'list_genres') {
    $genres = get_genres();
    include('genre_list.php');

// Add Product button
} else if ($action == 'show_add_form') {
    $genres = get_genres();
    include('movie_add.php');
} else if ($action == 'add_movie') {
    $genre_id = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT);
    $votes = filter_input(INPUT_POST, 'votes');
    $name = filter_input(INPUT_POST, 'name');
    $rating = filter_input(INPUT_POST, 'rating');
    $comments = filter_input(FILTER_POST, 'comments');
    if ($genre_id == NULL || $genre_id == FALSE || $votes == FALSE ||
            $name == NULL || $rating == FALSE || $comments == NULL) {
        $error = "Invalid movie data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        add_movie($genre_id, $votes, $name, $rating, $comments);
        header("Location: .?genre_id=$genre_id");
    }
    
} else if ($action == 'list_genres') {
    $genres = get_genres();
    include('genre_list.php');
    
} else if ($action == 'add_genre') {
    $name = filter_input(INPUT_POST, 'name');

    // Validate inputs
    if ($name == NULL) {
        $error = "Invalid genre name. Check name and try again.";
        include('view/error.php');
    } else {
        add_genre($name);
        header('Location: .?action=list_genres');  // display the Category List page
    }
} else if ($action == 'delete_genre') {
    $genre_id = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT);
    delete_genre($genre_id);
    header('Location: .?action=list_genres');      // display the Category List page
}
?>