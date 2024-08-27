<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;





Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOPTCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPass'])
->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class,'userProfile'])
->middleware([TokenVerificationMiddleware::class]);

Route::post('/update-profile',[UserController::class,'userProfileUpdate'])
->middleware([TokenVerificationMiddleware::class]);


Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOtpPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/profileUpdate',[UserController::class,'ProfileUpdate'])->middleware([TokenVerificationMiddleware::class]);


//userLogout

Route::get('/logOut',[UserController::class,'UserLogout']);



//Category
Route::get('list-category',[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('create-category',[CategoryController::class,'CreateCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::post('delete-category',[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('category-by-id',[CategoryController::class,'CategoryById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('update-category',[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);

//Category Page
Route::get('categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);

//Customer Page
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);

//Create Customer
Route::post('/create-customer',[CustomerController::class,'CreateCustomer'])->middleware([TokenVerificationMiddleware::class]);

//Get Customer
Route::get('/list-customer',[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);

//Delete Customer
Route::post('/delete-customer',[CustomerController::class,'DeleteCustomer'])->middleware([TokenVerificationMiddleware::class]); 

//Customer Update
Route::post('/update-customer',[CustomerController::class,'UpdateCustomer'])->middleware([TokenVerificationMiddleware::class]); 

//Customer by ID
Route::post('/customer-by-id',[CustomerController::class,'CustomerById'])->middleware([TokenVerificationMiddleware::class]);


//Product


//create product
Route::post('/create-product',[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
//Delete product
Route::post('/delete-product',[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
//Product by id
Route::post('/product-by-id',[ProductController::class,'ProductById'])->middleware([TokenVerificationMiddleware::class]);
//ProductList
Route::get('/product-list',[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);
//ProductUpdate
Route::post('/update-product',[ProductController::class,'ProductUpdate'])->middleware([TokenVerificationMiddleware::class]);


// Product PageURL
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);




//Invoice

Route::post('/create-invoice',[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/select-invoice',[InvoiceController::class,'InvoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/details-invoice',[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-invoice',[InvoiceController::class,'DeleteInvoice'])->middleware([TokenVerificationMiddleware::class]);


//Invoice Page
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);



Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/',[HomeController::class,'HomePage']);




Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);









