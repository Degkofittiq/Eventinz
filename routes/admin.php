<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Eventiz\Admin\AdminController;

// Préfixe toutes les routes avec "admin"


Route::prefix('admin')->group(function() {
    // Route pour le tableau de bord admin
    Route::get('/adminlogin', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
});


Route::prefix('admin')->middleware('auth')->group(function() {
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    // Route pour le tableau de bord admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Autres routes d'administration
    Route::get('/userslist', [AdminController::class, 'usersList'])->name('admin.userslist.index');

    // Categories Management
    Route::get('/addcategory', [AdminController::class, 'addCategory'])->name('admin.add.category');
    Route::get('/listcategory', [AdminController::class, 'listCategory'])->name('admin.list.category');
    Route::get('/showcategory/{categorieId}', [AdminController::class, 'showCategory'])->name('admin.show.category');
    Route::get('/editcategory/{categorieId}', [AdminController::class, 'editCategory'])->name('admin.edit.category');
    Route::get('/deletecategory/{categorieId}', [AdminController::class, 'deleteCategoryForm'])->name('admin.deleteform.category');
    Route::post('/deletecategory/{categorieId}', [AdminController::class, 'deleteCategory'])->name('admin.delete.category');
    Route::post('/updatecategory/{categorieId}', [AdminController::class, 'updateCategory'])->name('admin.update.category');
    Route::post('/storecategory', [AdminController::class, 'storeCategory'])->name('admin.store.category');
    
    // Companies Management
    Route::get('/companieslist', [AdminController::class, 'companiesList'])->name('admin.list.companies');
    Route::get('/showcompany/{companyId}', [AdminController::class, 'showCompany'])->name('admin.show.company');
    Route::get('/editcompany/{companyId}', [AdminController::class, 'editCompany'])->name('admin.edit.company');
    Route::post('/updatecompany/{companyId}', [AdminController::class, 'updateCompany'])->name('admin.update.company');
    // Route::get('/deletecompany/{companyId}', [AdminController::class, 'deleteCompanyForm'])->name('admin.delete.company');
    // Route::post('/deletecompany/{companyId}', [AdminController::class, 'deleteCompany'])->name('admin.delete.company');
    
    // Company Services 
    Route::post('/updatecompanyservice/{companyId}', [AdminController::class, 'updateCompanyServices'])->name('admin.update.companyservices');
    Route::post('/deletecompanyservice/{companyId}', [AdminController::class, 'deleteCompanyServices'])->name('admin.delete.companyservices');
    
    // services Categories Management servicesCategoriesList
    Route::get('/servicescategorieslist', [AdminController::class, 'servicesCategoriesList'])->name('admin.list.servicescategories');
    Route::get('/addservicescategory', [AdminController::class, 'addServicesCategory'])->name('admin.add.servicescategory');
    Route::post('/storeservicescategory', [AdminController::class,'storeServicesCategory'])->name('admin.store.servicescategory');
    Route::get('/editservicescategory/{servicesCategoryId}', [AdminController::class,'editServicesCategory'])->name('admin.edit.servicescategory');
    Route::post('/updateservicescategory/{servicesCategoryId}', [AdminController::class,'updateServicesCategory'])->name('admin.update.servicescategory');
    // Route::get('/deleteservicescategory/{servicesCategoryId}', [AdminController::class,'deleteServicesCategoryForm'])->name('admin.deleteform.servicescategory');
    // Route::post('/deleteservicescategory/{servicesCategoryId}', [AdminController::class,'deleteServicesCategory'])->name('admin.delete');


    // Events Management
});
