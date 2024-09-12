<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Eventiz\Admin\AdminController;
use App\Http\Controllers\Eventiz\Admin\SubscriptionPlanController;

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
    Route::get('/userdetails/{userId}', [AdminController::class, 'userDetails'])->name('admin.details.user');

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

    // Payments Management
    Route::get('/paymentslist', [AdminController::class, 'paymentsList'])->name('admin.list.payments');
    Route::get('/payment/{paymentId}', [AdminController::class,'showPayment'])->name('admin.show.payment');
    // Route::get('/approvepayment/{paymentId}', [AdminController::class,'approvePayment'])->name('admin.approve.payment');
    // Route::get('/rejectpayment/{paymentId}', [AdminController::class,'rejectPayment'])->name('admin.reject.payment');

    // Subscription plans
    Route::get('/subscriptionplanslist', [SubscriptionPlanController::class, 'plansList'])->name('admin.list.subscriptionplans');
    Route::get('/subscriptionplandetails/{subscriptionId}', [SubscriptionPlanController::class, 'planDetails'])->name('admin.details.subscriptionplan');
    Route::get('/addsubscriptionplan', [SubscriptionPlanController::class, 'addPlanForm'])->name('admin.add.subscriptionplan');
    Route::post('/storesubscriptionplan', [SubscriptionPlanController::class,'storePlanForm'])->name('admin.store.subscriptionplan');
    // Route::get('/editsubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'editPlanForm'])->name('admin.edit.subscriptionplan');
    Route::post('/updatesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'updatePlanForm'])->name('admin.update.subscriptionplan');
    Route::get('/deletesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'deletePlanForm'])->name('admin.deleteform.subscriptionplan');
    Route::post('/deletesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'deletePlan'])->name('admin.delete.subscriptionplan');


    // Events Management
    Route::get('/admineventlist', [AdminController::class, 'adminEventList'])->name('admin.list.events');
    Route::get('/admineventdetail/{eventId}', [AdminController::class, 'adminEventDetails'])->name('admin.details.event');
    Route::post('/updateevent/{eventId}', [AdminController::class, 'adminEventUpdate'])->name('admin.update.event');

    // Reviews 
    Route::get('/adminreviewlist', [AdminController::class, 'adminReviewsList'])->name('admin.list.reviews');
    Route::get('/adminreviewdetails/{reviewId}', [AdminController::class, 'adminReviewDetails'])->name('admin.show.review');
    Route::post('/adminreviewupdate/{reviewId}', [AdminController::class, 'adminReviewUpdate'])->name('admin.update.review'); //Only the status
    

    // user OTP management 
    Route::get('/userresendotp', [AuthController::class, 'userResendOTPForm'])->name('admin.resendform.otp');
    Route::post('/userresendotp', [AuthController::class, 'resendOTP'])->name('admin.resend.otp'); //send the new otp

    // Content management | addContentTextForm-addContentText-contentTextList-showContentText-updateContentText
    Route::get('/contenttext', [AdminController::class, 'addContentTextForm'])->name('admin.add.contenttextform'); // Add form
    Route::post('/contenttext', [AdminController::class, 'addContentText'])->name('admin.add.contenttext'); // Add POST action
    Route::get('/contentstextlist', [AdminController::class, 'contentTextList'])->name('admin.list.contenttext'); // List
    Route::get('/contenttext/{contentTextId}', [AdminController::class, 'showContentText'])->name('admin.show.contenttext'); // View details and edit
    Route::post('/contenttext/{contentTextId}', [AdminController::class, 'updateContentText'])->name('admin.update.contenttext'); // Edit POST action
    
    // addContentImageForm-addContentImage-contentImageList-showContentImage-updateContentImage
    Route::get('/contentimage', [AdminController::class, 'addContentImageForm'])->name('admin.add.contentimageform'); // Add form
    Route::post('/contentimage', [AdminController::class, 'addContentImage'])->name('admin.add.contentimage'); // Add POST action
    Route::get('/contentsimagelist', [AdminController::class, 'contentImageList'])->name('admin.list.contentimage'); // List
    Route::get('/contentimage/{contentImageId}', [AdminController::class, 'showContentImage'])->name('admin.show.contentimage'); // View details and edit
    Route::post('/contentimage/{contentImageId}', [AdminController::class, 'updateContentImage'])->name('admin.update.contentimage'); // Edit POST action

    // Vendor class management | listVendorClass-addVendorClassForm-addVendorClass-showVendorClass-updateVendorClass
    Route::get('/listvendorclass', [AdminController::class, 'listVendorClass'])->name('admin.list.vendorclass'); // Add form
    Route::get('/addvendorclass', [AdminController::class, 'addVendorClassForm'])->name('admin.add.vendorclassform'); // Add form
    Route::post('/addvendorclass', [AdminController::class, 'addVendorClass'])->name('admin.add.vendorclass'); // Add POST
    Route::get('/showvendorclass/{vendorClassId}', [AdminController::class, 'showVendorClass'])->name('admin.show.vendorclass'); // Show vendor class and edit form
    Route::post('/updatevendorclass/{vendorClassId}', [AdminController::class, 'updateVendorClass'])->name('admin.update.vendorclass'); // Update

    // Taxe management |  listPaymentTaxe-addPaymentTaxeForm-addPaymentTaxe-showPaymentTaxe-updatePaymentTaxe-deletePaymentTaxeForm-deletePaymentTaxe
    Route::get('/listpaymenttaxe', [AdminController::class, 'listPaymentTaxe'])->name('admin.list.paymenttaxe'); // Add form
    Route::get('/addpaymenttaxe', [AdminController::class, 'addPaymentTaxeForm'])->name('admin.add.paymenttaxeForm'); // Add form
    Route::post('/addpaymenttaxe', [AdminController::class, 'addPaymentTaxe'])->name('admin.add.paymenttaxe'); // Add POST
    Route::get('/showpaymenttaxe/{paymentTaxeId}', [AdminController::class, 'showPaymentTaxe'])->name('admin.show.paymenttaxe'); // Show vendor class and edit form
    Route::post('/updatepaymenttaxe/{PaymentTaxeId}', [AdminController::class, 'updatePaymentTaxe'])->name('admin.update.paymenttaxe'); // Update
    Route::get('/deletepaymenttaxeform/{PaymentTaxeId}', [AdminController::class, 'deletePaymentTaxeForm'])->name('admin.deleteform.paymenttaxe'); // delete form
    Route::post('/deletepaymenttaxe/{PaymentTaxeId}', [AdminController::class, 'deletePaymentTaxe'])->name('admin.delete.paymenttaxe'); // delete

});
