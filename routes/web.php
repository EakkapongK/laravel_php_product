<?php

use Illuminate\Support\Facades\Route;
// use App\Models\User; //ดึงข้อมูลจาก models
use Illuminate\Support\Facades\DB; //ใช้กับการดึงข้อมูลdb ที่ไม่มีmodel
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        //
        // $Users = User::all(); ดึงข้อมูลจาก models
        $Users = DB::table('users') ->get();
        return view('dashboard',compact('Users'));
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Department
    Route::get('/department/all', [DepartmentController::class,'index'])->name('department');
    Route::post('/department/add', [DepartmentController::class,'add'])->name('addDepartment');
    Route::get('/department/edit/{id}', [DepartmentController::class,'edit'])->name('editDepartment');
    Route::post('/department/update/{id}', [DepartmentController::class,'update'])->name('updateDepartment');
    //softDelete
    Route::get('/department/softdelete/{id}', [DepartmentController::class,'softdelete'])->name('softdeleteDepartment');
    Route::get('/department/restore/{id}', [DepartmentController::class,'restore'])->name('restoreDepartment');
    Route::get('/department/delete/{id}', [DepartmentController::class,'delete'])->name('deleteDepartment');
    

    //department
    Route::get('/service/all', [ServiceController::class,'index'])->name('service');
    Route::post('/service/add', [ServiceController::class,'add'])->name('addService');
    Route::get('/service/edit/{id}', [ServiceController::class,'edit'])->name('editService');
    Route::post('/service/update/{id}', [ServiceController::class,'update'])->name('updateService');
    Route::get('/service/delete/{id}', [ServiceController::class,'delete'])->name('deleteService');


    Route::get('/product/all', [ProductController::class,'index'])->name('product');   
    Route::post('/product/add', [ProductController::class,'add'])->name('addProduct');
    Route::get('/product/edit/{id}', [ProductController::class,'edit'])->name('editProduct');
    Route::post('/product/update/{id}', [ProductController::class,'update'])->name('updateProduct'); 
    Route::get('/product/delete/{id}', [ProductController::class,'delete'])->name('deleteProduct');

});