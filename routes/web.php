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


//route dasar
Route::get('/', function () {
    return view('welcome');
});
//example route 
Route::get('foo', function () { 
    return 'Hello World'; 
});
//route dengan parameter
Route::get('user/{id}', function ($id) { 
    return 'User ' . $id; //menampilkan id yang dikirim melalui url
});
//route dengan beberapa parameter
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Post ke: ' . $postId . ', dengan Komentar ke: ' . $commentId;
});

//prosedur kerja acara 3
Route::get('/halo', function () {  //route get
    return "Ini route GET"; //route get untuk menampilkan form
});
//HTTP method 
Route::post('/kirim', function () { //route post
    return "Data berhasil dikirim dengan POST"; //route post untuk memproses data yang dikirim dari form
});
Route::get('/form', function () { 
    return '
        <form method="POST" action="/kirim">
            ' . csrf_field() . ' //untuk keamanan form
            <button type="submit">Kirim</button>
        </form> //menampilkan form untuk mengirim data dengan method POST
    ';
});
//route put
Route::put('/update', function () {
    return "Data berhasil diupdate"; //route put untuk mengupdate data yang sudah ada
});

Route::get('/form-update', function () {
    return '
        <form method="POST" action="/update">
            ' . csrf_field() . '
            <input type="hidden" name="_method" value="PUT">
            <button type="submit">Update</button>
        </form>
    ';
});
//route delete
Route::delete('/hapus', function () {
    return "Data berhasil dihapus";
});
Route::get('/form-hapus', function () {
    return '
        <form method="POST" action="/hapus">
            ' . csrf_field() . '
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Hapus Data</button>
        </form>
    ';
});
//route patch
Route::patch('/edit', function () {
    return "Data berhasil diedit"; //route patch untuk mengedit sebagian data yang sudah ada
});
Route::get('/form-edit', function () {
    return '
        <form method="POST" action="/edit">
            ' . csrf_field() . '
            <input type="hidden" name="_method" value="PATCH">
            <button type="submit">Edit Data</button>
        </form>
    ';
});
//route match 
Route::match(['get', 'post'], '/multi', function () {
    return "Bisa GET dan POST"; //route match untuk menerima beberapa method sekaligus
});
Route::get('/form-multi', function () {
    return '
        <form method="POST" action="/multi">
            ' . csrf_field() . '
            <button type="submit">Kirim POST</button>
        </form>
    ';
});
//route any
Route::any('/semua', function () {
    return "Semua method bisa akses"; //route any untuk menerima semua method HTTP
});
Route::get('/form-semua', function () {
    return '
        <form method="POST" action="/semua"> 
            ' . csrf_field() . ' 
            <button type="submit">Kirim</button>
        </form>
    ';
});

Route::get('/there', function () {
    return "Halaman THERE"; //route tujuan untuk redirect
});
//route redirect
Route::redirect('/here', '/there');

Route::redirect('/lama', '/there', 301);

Route::permanentRedirect('/old', '/there'); //direct permanen

//route view, menampilkan view tanpa controler
Route::view('/welcome', 'welcome');
//route view dengan data
Route::view('/welcome2', 'welcome', [
    'name' => 'Febri'
]);
//route dengan parameter opsional
Route::get('/user/{name?}', function ($name = null) {
    return "Nama: " . $name;
});

//regular expression fungsinya untuk menetapkan aturan pada parameter route, sehingga hanya menerima nilai yang sesuai dengan pola yang ditentukan
Route::get('/user/{name}', function ($name) {
    return "Nama user: " . $name;
})->where('name', '[A-Za-z]+'); //hanya menerima huruf
Route::get('/user/{id}', function ($id) {
    return "ID User: " . $id;
})->where('id', '[0-9]+'); //hanya menerima angka

//global constraints fungsinya untuk menetapkan aturan global pada parameter tertentu, sehingga tidak perlu menulis aturan yang sama berulang kali pada setiap route yang menggunakan parameter tersebut
Route::get('/user/{id}', function ($id) { 
    return "User ID: " . $id; 
});

//Encoded Forward Slashes fungsinya untuk mengizinkan karakter garis miring menjadi bagian dari parameter route dengan cara mengatur pola regular expression agar tidak diperlakukan sebagai pemisah URL
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
//middleware berfungsi untuk memproses request sebelum mencapai route, bisa digunakan untuk autentikasi, logging, dll
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

//Route Prefixes fungsinya untuk menambahkan prefix pada URL route, sehingga semua route dalam grup tersebut akan memiliki prefix yang sama, memudahkan pengelompokan dan manajemen route
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


