<?php


Auth::routes(['verify' => true]);



Route::middleware(['auth','tenant'])->group(function () {

    Route::get('user', 'UserController@index')->name('admin.user');
    // Route::get('user/getdata', 'UserController@getData')->name('admin.user.getdata');
    // Route::get('user/fetchdata', 'UserController@fetchData')->name('admin.user.fetchdata');
    // Route::post('user/postdata', 'UserController@postData')->name('admin.user.postdata');
    Route::post('user/storePhoto', 'UserController@storeUserPhoto')->name('admin.user.storephoto');

});

Route::get('phpinfo', function(){ 
    echo "test 4";
    echo "test 2";
    echo "test 3";
    phpinfo();
});
Route::get('subscribe', 'UtilController@subscribe')->name('subscribe');
Route::get('faleConosco', 'UtilController@faleConosco')->name('faleConosco');
Route::get('manual', 'UtilController@manual')->name('manual');
Route::get('planilha', 'UtilController@planilha')->name('planilha');
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','verified','tenant'])->group(function () {

    // Route::get('/home', 'HomeController@index')->name('home');

    //Formulario de Débitos
    Route::get('debitos', 'DebitoController@index')->name('frmDebitos');
    Route::get('debitos/getdata', 'DebitoController@getData');
    Route::post('debitos/getdata', 'DebitoController@getData');
    //Route::get('crud/fetchdata/{model}', 'Amorim\Crud\Controllers\CrudController@fetchData');
    //Route::post('crud/postdata/{model}', 'Amorim\Crud\Controllers\CrudController@postData');

    Route::get('financeiro/boletos', 'FinanceiroController@boleto')->name('boleto');

    Route::get('financeiro/frmGerarMensalidades', 'FinanceiroController@frmGerarMensalidades')->name('frmGerarMensalidades');
    Route::post('financeiro/gerarMensalidades', 'FinanceiroController@gerarMensalidades')->name('gerarMensalidades');

    Route::get('financeiro/frmImprimirBoletos', 'FinanceiroController@frmImprimirBoletos')->name('frmImprimirBoletos');
    Route::get('financeiro/imprimirBoletos', 'FinanceiroController@imprimirBoletos')->name('imprimirBoletos');
    Route::post('financeiro/imprimirBoletos', 'FinanceiroController@imprimirBoletos')->name('imprimirBoletos');
    Route::get('financeiro/emailBoletos', 'FinanceiroController@emailBoletos')->name('emailBoletos');
    Route::post('financeiro/emailBoletos', 'FinanceiroController@emailBoletos')->name('emailBoletos');
    Route::get('financeiro/listagemDebitos', 'FinanceiroController@listagemDebitos')->name('listagemDebitos');
    Route::post('financeiro/listagemDebitos', 'FinanceiroController@listagemDebitos')->name('listagemDebitos');


    Route::get('financeiro/frmBaixasBancaria', 'FinanceiroController@frmBaixasBancaria')->name('frmBaixasBancaria');
    Route::post('financeiro/baixasBancaria', 'FinanceiroController@baixasBancaria')->name('baixasBancaria');

    Route::get('financeiro/frmGerarRemessa', 'FinanceiroController@frmGerarRemessa')->name('frmGerarRemessa');
    Route::post('financeiro/gerarRemessa', 'FinanceiroController@gerarRemessa')->name('gerarRemessa');

    Route::get('log/get', 'UtilController@getlog')->name('getlog');
    Route::post('log/save', 'UtilController@savelog')->name('savelog');

    Route::get('importacao', 'ImportController@index')->name('get-importacao');
    Route::post('importacao', 'ImportController@importacao')->name('importacao');

    Route::get('acordos', 'AcordoController@index')->name('acordos');
    Route::get('acordos/getdata', 'AcordoController@getData');
    Route::post('acordos/getdata', 'AcordoController@getData');

});

//Apis
Route::middleware(['auth','verified','tenant'])->group(function () {
    Route::any('/admin/{any?}', 'AdminController@index')->where('any','.*');
    Route::apiResource('api/proprietarios', 'Api\ProprietarioController');
    Route::apiResource('api/unidades', 'Api\UnidadeController');
    Route::apiResource('api/taxas', 'Api\TaxaController');
    Route::apiResource('api/debitos', 'Api\DebitoController');
    Route::apiResource('api/estados', 'Api\EstadoController');
    Route::apiResource('api/acordos', 'Api\AcordoController');
    Route::post('api/gerarAcordo', 'Api\AcordoController@gerarAcordo');

});
Route::middleware(['auth','verified','tenant'])->group(function () {
    Route::apiResource('api/users', 'AdminApi\UserController');
    Route::apiResource('api/roles', 'AdminApi\RoleController');
    Route::apiResource('api/permissions', 'AdminApi\PermissionController');
});

Route::group(['middleware' => ['web','auth','tenant']], function () {
    Route::get('consulta', 'HomeController@consulta')->name('consulta');
    Route::get('consulta/{model}', 'Amorim\Crud\Controllers\CrudController@index');
    Route::get('consulta/getdata/{model}', 'Amorim\Crud\Controllers\CrudController@getData');
});
Route::get('logout', 'Auth\LoginController@logout');


//Route::get('payments', 'FinanceiroController@payments')->name('payments');
