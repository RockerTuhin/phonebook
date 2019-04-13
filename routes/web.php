<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/myphonebook/{name}', function () {
    return Redirect('/');
})->where('name','[A-Za-z]+');

Route::resource('myphonebook','PhonebookController');
Route::post('getData','PhonebookController@getData');