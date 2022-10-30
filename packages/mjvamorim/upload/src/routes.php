<?php


    Route::get ('image', '\Amorim\Upload\Controllers\UploadController@create');
    Route::post('image-save', '\Amorim\Upload\Controllers\UploadController@store');
    Route::post('image-delete', '\Amorim\Upload\Controllers\UploadController@destroy');
    Route::get ('image-show', '\Amorim\Upload\Controllers\UploadController@index');
