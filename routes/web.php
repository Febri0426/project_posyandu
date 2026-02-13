<?php

use App\Http\Controllers\UserController;
Route::get('/user', [UserController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('foo', function () {
    return 'Hello World';
});

Route::get('user/{id}', function ($id) {
    return 'User ' . $id;
});

Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Post ke: ' . $postId . ', dengan Komentar ke: ' . $commentId;
});

//prosedur kerja acara 3
Route::get('/halo', function () {  //route get
    return "Ini route GET";
});

Route::post('/kirim', function () { //route post
    return "Data berhasil dikirim dengan POST";
});
Route::get('/form', function () {
    return '
        <form method="POST" action="/kirim">
            '.csrf_field().'
            <button type="submit">Kirim</button>
        </form>
    ';
});

Route::put('/update', function () { //route put
    return "Data berhasil diupdate";
});

Route::get('/form-update', function () {
    return '
        <form method="POST" action="/update">
            '.csrf_field().'
            <input type="hidden" name="_method" value="PUT">
            <button type="submit">Update</button>
        </form>
    ';
});

Route::delete('/hapus', function () { //route delete
    return "Data berhasil dihapus";
});
Route::get('/form-hapus', function () {
    return '
        <form method="POST" action="/hapus">
            '.csrf_field().'
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Hapus Data</button>
        </form>
    ';
});

Route::patch('/edit', function () { //route patch
    return "Data berhasil diedit";
});
Route::get('/form-edit', function () {
    return '
        <form method="POST" action="/edit">
            '.csrf_field().'
            <input type="hidden" name="_method" value="PATCH">
            <button type="submit">Edit Data</button>
        </form>
    ';
});

Route::match(['get', 'post'], '/multi', function () { //route match
    return "Bisa GET dan POST";
});
Route::get('/form-multi', function () {
    return '
        <form method="POST" action="/multi">
            '.csrf_field().'
            <button type="submit">Kirim POST</button>
        </form>
    ';
});

Route::any('/semua', function () { //route any
    return "Semua method bisa akses";
});
Route::get('/form-semua', function () {
    return '
        <form method="POST" action="/semua"> 
            '.csrf_field().' 
            <button type="submit">Kirim</button>
        </form>
    ';
});

Route::get('/there', function () {
    return "Halaman THERE";
});

Route::redirect('/here', '/there');

Route::redirect('/lama', '/there', 301);

Route::permanentRedirect('/old', '/there');

//route view
Route::view('/welcome', 'welcome');

Route::view('/welcome2', 'welcome', [
    'name' => 'Febri'
]);
//parameter opsional
Route::get('/user/{name?}', function ($name = null) {
    return "Nama: " . $name;
});

//regular expression
Route::get('/user/{name}', function ($name) {
    return "Nama user: " . $name;
})->where('name', '[A-Za-z]+');
Route::get('/user/{id}', function ($id) {
    return "ID User: " . $id;
})->where('id', '[0-9]+');

//global constraints 
Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

//Encoded Forward Slashes
Route::get('search/{search}', function ($search) {
    return $search;
})->where('search', '.*');

//prosedur kerja acara 4
//Generate URL ke Route Bernama
Route::get('/profile', function () {
    return 'Halaman Profile';
})->name('profile');
Route::get('/test-url', function () {
    return route('profile'); 
});

//Memeriksa Rute Saat Ini
Route::get('/profile', function () {
    return 'Halaman Profile';
})->name('profile')->middleware('check.profile');

//Middleware Group di Route
Route::middleware(['first', 'second'])->group(function () {

    Route::get('/', function () {
        return 'Halaman Home';
    });

    Route::get('/user/profile', function () {
        return 'Halaman Profile User';
    });

});

//Route Namespace Grouping
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [DashboardController::class, 'index']);

//Subdomain Routing 
Route::domain('{account}.myapp.test')->group(function () {
    Route::get('/user/{id}', function ($account, $id) {
        return "Subdomain: $account | User ID: $id";
    });
});

//Route Prefixes
Route::prefix('admin')->group(function () {

    Route::get('/users', function () {
        return "Halaman Users Admin";
    });

    Route::get('/dashboard', function () {
        return "Halaman Dashboard Admin";
    });

});

//route name prefixes
Route::name('admin.')->group(function () {

    Route::get('/admin/users', function () {
        return 'Halaman Users Admin';
    })->name('users');

});


