<?php
Route::group(['middleware' => ['web','auth','tenant']], function () {

    // Route::get('crud/getdata/doctor', function () {
    //     return view('crud::index');
    // });
    Route::get('crud/{model}', 'Amorim\Crud\Controllers\CrudController@index');
    Route::get('crud/getdata/{model}', 'Amorim\Crud\Controllers\CrudController@getData')->name('crud/getdata');;
    Route::get('crud/fetchdata/{model}', 'Amorim\Crud\Controllers\CrudController@fetchData');
    Route::post('crud/postdata/{model}', 'Amorim\Crud\Controllers\CrudController@postData');

});
