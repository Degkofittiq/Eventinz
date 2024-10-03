<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Eventiz\PaymentController;
use App\Http\Controllers\Eventiz\Admin\AdminController;
use App\Http\Controllers\Eventiz\Admin\AdminEventController;
use App\Http\Controllers\Eventiz\Admin\AdminUsersController;
use App\Http\Controllers\Eventiz\Admin\SubscriptionPlanController;

// Préfixe toutes les routes avec "admin"


Route::prefix('admin')->group(function() {
    // Route pour le tableau de bord admin
    Route::get('/adminbackoffice', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
});


// Route::get('/getcurrency', [PaymentController::class, 'testCurrency'])->name('get.current.currency'); 

Route::prefix('admin')->middleware(['auth','rights','checkAccountStatus'])->group(function() {
    Route::get('admin/logs', [AdminController::class, 'indexLog'])->name('admin.logs.index');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    // Route pour le tableau de bord admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Autres routes d'administration
    Route::get('/userslist', [AdminController::class, 'usersList'])->name('admin.userslist.index')->middleware('rights:view_users_hosts_and_vendors_list');
    Route::get('/userdetails/{userId}', [AdminController::class, 'userDetails'])->name('admin.details.user')->middleware('rights:view_details_about_hosts_and_vendors');

    // user Support & Help Form
    Route::get('/supporthelpform/{userId}', [AdminController::class, 'userSupportHelpForm'])->name('admin.addlogform.supporthelp')/*->middleware('rights:resend_otp')*/; //send the new otp
    Route::post('/supporthelp/{userId}', [AdminController::class, 'userSupportHelp'])->name('admin.addlog.supporthelp')/*->middleware('rights:resend_otp')*/; //send the new otp

    // Categories Management
    Route::get('/addcategory', [AdminController::class, 'addCategory'])->name('admin.add.category')->middleware('rights:add_new_category');
    Route::get('/listcategory', [AdminController::class, 'listCategory'])->name('admin.list.category')->middleware('rights:view_categories_list');
    Route::get('/showcategory/{categorieId}', [AdminController::class, 'showCategory'])->name('admin.show.category')->middleware('rights:edit_category');
    Route::get('/editcategory/{categorieId}', [AdminController::class, 'editCategory'])->name('admin.edit.category')->middleware('rights:edit_category');
    Route::get('/deletecategory/{categorieId}', [AdminController::class, 'deleteCategoryForm'])->name('admin.deleteform.category')->middleware('rights:delete_category');
    Route::post('/deletecategory/{categorieId}', [AdminController::class, 'deleteCategory'])->name('admin.delete.category')->middleware('rights:delete_category');
    Route::post('/updatecategory/{categorieId}', [AdminController::class, 'updateCategory'])->name('admin.update.category')->middleware('rights:edit_category');
    Route::post('/storecategory', [AdminController::class, 'storeCategory'])->name('admin.store.category')->middleware('rights:add_new_category');
    
    // Companies Management
    Route::get('/companieslist', [AdminController::class, 'companiesList'])->name('admin.list.companies')->middleware('rights:view_companies_list');
    Route::get('/showcompany/{companyId}', [AdminController::class, 'showCompany'])->name('admin.show.company')->middleware('rights:view_company_details');
    Route::get('/editcompany/{companyId}', [AdminController::class, 'editCompany'])->name('admin.edit.company')->middleware('rights:edit_company_details');
    Route::post('/updatecompany/{companyId}', [AdminController::class, 'updateCompany'])->name('admin.update.company')->middleware('rights:edit_company_details');
    // Route::get('/deletecompany/{companyId}', [AdminController::class, 'deleteCompanyForm'])->name('admin.delete.company')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    // Route::post('/deletecompany/{companyId}', [AdminController::class, 'deleteCompany'])->name('admin.delete.company')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    
    // Company Services 
    Route::post('/updatecompanyservice/{companyId}', [AdminController::class, 'updateCompanyServices'])->name('admin.update.companyservices')->middleware('rights:edit_company_details');
    Route::post('/deletecompanyservice/{companyId}', [AdminController::class, 'deleteCompanyServices'])->name('admin.delete.companyservices')->middleware('rights:edit_company_details');
    
    // services Categories Management servicesCategoriesList
    Route::get('/servicescategorieslist', [AdminController::class, 'servicesCategoriesList'])->name('admin.list.servicescategories')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::get('/addservicescategory', [AdminController::class, 'addServicesCategory'])->name('admin.add.servicescategory')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::post('/storeservicescategory', [AdminController::class,'storeServicesCategory'])->name('admin.store.servicescategory')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::get('/editservicescategory/{servicesCategoryId}', [AdminController::class,'editServicesCategory'])->name('admin.edit.servicescategory')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::post('/updateservicescategory/{servicesCategoryId}', [AdminController::class,'updateServicesCategory'])->name('admin.update.servicescategory')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    // Route::get('/deleteservicescategory/{servicesCategoryId}', [AdminController::class,'deleteServicesCategoryForm'])->name('admin.deleteform.servicescategory')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    // Route::post('/deleteservicescategory/{servicesCategoryId}', [AdminController::class,'deleteServicesCategory'])->name('admin.delete')/*->middleware('rights:xxxxxxxxxxxxx')*/;

    // Payments Management
    Route::get('/paymentslist', [AdminController::class, 'paymentsList'])->name('admin.list.payments')->middleware('rights:view_payments_list');
    Route::get('/payment/{paymentId}', [AdminController::class,'showPayment'])->name('admin.show.payment')->middleware('rights:view_payment_details');
    // Route::get('/approvepayment/{paymentId}', [AdminController::class,'approvePayment'])->name('admin.approve.payment')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    // Route::get('/rejectpayment/{paymentId}', [AdminController::class,'rejectPayment'])->name('admin.reject.payment')/*->middleware('rights:xxxxxxxxxxxxx')*/;

    // Subscription plans
    Route::get('/subscriptionplanslist', [SubscriptionPlanController::class, 'plansList'])->name('admin.list.subscriptionplans')->middleware('rights:view_subscription_list');
    Route::get('/subscriptionplandetails/{subscriptionId}', [SubscriptionPlanController::class, 'planDetails'])->name('admin.details.subscriptionplan')->middleware('rights:view_subscription_details');
    Route::get('/addsubscriptionplan', [SubscriptionPlanController::class, 'addPlanForm'])->name('admin.add.subscriptionplan')->middleware('rights:add_new_subscription');
    Route::post('/storesubscriptionplan', [SubscriptionPlanController::class,'storePlanForm'])->name('admin.store.subscriptionplan')->middleware('rights:add_new_subscription');
    // Route::get('/editsubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'editPlanForm'])->name('admin.edit.subscriptionplan')->middleware('rights:xxxxxxxxxxxxx');
    Route::post('/updatesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'updatePlanForm'])->name('admin.update.subscriptionplan')->middleware('rights:edit_subscription');
    Route::get('/deletesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'deletePlanForm'])->name('admin.deleteform.subscriptionplan')->middleware('rights:delete_subscritpion');
    Route::post('/deletesubscriptionplan/{subscriptionId}', [SubscriptionPlanController::class,'deletePlan'])->name('admin.delete.subscriptionplan')->middleware('rights:delete_subscritpion');


    // Events Management
    Route::get('/admineventlist', [AdminEventController::class, 'adminEventList'])->name('admin.list.events')->middleware('rights:view_events_list');
    Route::get('/admineventdetail/{eventId}', [AdminEventController::class, 'adminEventDetails'])->name('admin.details.event')->middleware('rights:view_event_details');
    Route::post('/updateevent/{eventId}', [AdminEventController::class, 'adminEventUpdate'])->name('admin.update.event')->middleware('rights:edit_event_details');

    Route::get('/admineventbidsdetails/{QuoteCode}', [AdminEventController::class, 'adminEventBidsDetails'])->name('admin.bidsdetails.event')->middleware('rights:view_event_details');

    // Events Type Management | eventTypeList-eventTypeDetails-eventTypeAddForm-eventTypeAdd-eventTypeEditForm-eventTypeUpdate-eventTypeDelete
    Route::get('/eventtypelist', [AdminEventController::class, 'eventTypeList'])->name('admin.list.eventtypes')->middleware('rights:view_event_type_list');
    Route::get('/eventtypeadd', [AdminEventController::class, 'eventTypeAddForm'])->name('admin.add.eventtypeform')->middleware('rights:add_new_event_type');
    Route::post('/eventtypeadd', [AdminEventController::class, 'eventTypeAdd'])->name('admin.add.eventtype')->middleware('rights:add_new_event_type');
    Route::get('/eventtypeedit/{eventTypeId}', [AdminEventController::class, 'eventTypeEditForm'])->name('admin.edit.eventtypeform')->middleware('rights:edit_event_type');
    Route::post('/eventtypeupdate/{eventTypeId}', [AdminEventController::class, 'eventTypeUpdate'])->name('admin.update.eventtype')->middleware('rights:edit_event_type');
    Route::get('/eventtypedeleteForm/{eventTypeId}', [AdminEventController::class, 'eventTypeDeleteForm'])->name('admin.deleteform.eventtype')->middleware('rights:delete_event_type');
    Route::post('/eventtypedelete/{eventTypeId}', [AdminEventController::class, 'eventTypeDelete'])->name('admin.delete.eventtype')->middleware('rights:delete_event_type');

    //Events Subcategory | eventSubcategoryList-eventSubcategoryDetails-eventSubcategoryAddForm-eventSubcategoryAdd-eventSubcategoryEditForm-eventSubcategoryUpdate-eventSubcategoryDeleteForm-eventSubcategoryDelete
    Route::get('/eventsubcategorylist', [AdminEventController::class, 'eventSubcategoryList'])->name('admin.list.eventsubcategories')->middleware('rights:view_event_subcategories_list');
    Route::get('/eventsubcategoryadd', [AdminEventController::class, 'eventSubcategoryAddForm'])->name('admin.add.eventsubcategoryform')->middleware('rights:add_new_event_subcategory');
    Route::post('/eventsubcategoryadd', [AdminEventController::class, 'eventSubcategoryAdd'])->name('admin.add.eventsubcategory')->middleware('rights:add_new_event_subcategory');
    Route::get('/eventsubcategoryedit/{eventSubcategoryId}', [AdminEventController::class, 'eventSubcategoryEditForm'])->name('admin.edit.eventsubcategoryform')->middleware('rights:view_event_subcategory_details');
    Route::post('/eventsubcategoryupdate/{eventSubcategoryId}', [AdminEventController::class, 'eventSubcategoryUpdate'])->name('admin.update.eventsubcategory')->middleware('rights:edit_event_subcategory');
    Route::get('/eventsubcategorydeleteForm/{eventSubcategoryId}', [AdminEventController::class, 'eventSubcategoryDeleteForm'])->name('admin.deleteform.eventsubcategory')->middleware('rights:delete_event_subcategory');
    Route::post('/eventsubcategorydelete/{eventSubcategoryId}', [AdminEventController::class, 'eventSubcategoryDelete'])->name('admin.delete.eventsubcategory')->middleware('rights:delete_event_subcategory');


    // Reviews 
    Route::get('/adminreviewlist', [AdminController::class, 'adminReviewsList'])->name('admin.list.reviews')->middleware('rights:view_reviews_list');
    Route::get('/adminreviewdetails/{reviewId}', [AdminController::class, 'adminReviewDetails'])->name('admin.show.review')->middleware('rights:view_review_details');
    Route::post('/adminreviewupdate/{reviewId}', [AdminController::class, 'adminReviewUpdate'])->name('admin.update.review')->middleware('rights:review_edit'); //Only the status
    

    // user OTP management 
    Route::get('/userresendotp', [AuthController::class, 'userResendOTPForm'])->name('admin.resendform.otp')->middleware('rights:resend_otp');
    Route::post('/userresendotp', [AuthController::class, 'resendOTP'])->name('admin.resend.otp')->middleware('rights:resend_otp'); //send the new otp

    // Content management | addContentTextForm-addContentText-contentTextList-showContentText-updateContentText
    Route::get('/contenttext', [AdminController::class, 'addContentTextForm'])->name('admin.add.contenttextform')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add form
    Route::post('/contenttext', [AdminController::class, 'addContentText'])->name('admin.add.contenttext')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add POST action
    Route::get('/contentstextlist', [AdminController::class, 'contentTextList'])->name('admin.list.contenttext')->middleware('rights:view_contents_texts_list'); // List
    Route::get('/contenttext/{contentTextId}', [AdminController::class, 'showContentText'])->name('admin.show.contenttext')->middleware('rights:view_content_text'); // View details and edit
    Route::post('/contenttext/{contentTextId}', [AdminController::class, 'updateContentText'])->name('admin.update.contenttext')->middleware('rights:edit_content_text'); // Edit POST action
    
    // addContentImageForm-addContentImage-contentImageList-showContentImage-updateContentImage
    Route::get('/contentimage', [AdminController::class, 'addContentImageForm'])->name('admin.add.contentimageform')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add form
    Route::post('/contentimage', [AdminController::class, 'addContentImage'])->name('admin.add.contentimage')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add POST action
    Route::get('/contentsimagelist', [AdminController::class, 'contentImageList'])->name('admin.list.contentimage')->middleware('rights:view_contents_images_list'); // List
    Route::get('/contentimage/{contentImageId}', [AdminController::class, 'showContentImage'])->name('admin.show.contentimage')->middleware('rights:view_content_image'); // View details and edit
    Route::post('/contentimage/{contentImageId}', [AdminController::class, 'updateContentImage'])->name('admin.update.contentimage')->middleware('rights:edit_content_image'); // Edit POST action

    // Vendor class management | listVendorClass-addVendorClassForm-addVendorClass-showVendorClass-updateVendorClass
    Route::get('/listvendorclass', [AdminController::class, 'listVendorClass'])->name('admin.list.vendorclass')->middleware('rights:view_vendors_classes_list'); // Add form
    Route::get('/addvendorclass', [AdminController::class, 'addVendorClassForm'])->name('admin.add.vendorclassform')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add form
    Route::post('/addvendorclass', [AdminController::class, 'addVendorClass'])->name('admin.add.vendorclass')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add POST
    Route::get('/showvendorclass/{vendorClassId}', [AdminController::class, 'showVendorClass'])->name('admin.show.vendorclass')->middleware('rights:view_vendor_class_details'); // Show vendor class and edit form
    Route::post('/updatevendorclass/{vendorClassId}', [AdminController::class, 'updateVendorClass'])->name('admin.update.vendorclass')->middleware('rights:view_vendor_class_details'); // Update

    // Taxe management |  listPaymentTaxe-addPaymentTaxeForm-addPaymentTaxe-showPaymentTaxe-updatePaymentTaxe-deletePaymentTaxeForm-deletePaymentTaxe
    Route::get('/listpaymenttaxe', [AdminController::class, 'listPaymentTaxe'])->name('admin.list.paymenttaxe')->middleware('rights:view_taxes_list'); // Add form
    Route::get('/addpaymenttaxe', [AdminController::class, 'addPaymentTaxeForm'])->name('admin.add.paymenttaxeForm')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add form
    Route::post('/addpaymenttaxe', [AdminController::class, 'addPaymentTaxe'])->name('admin.add.paymenttaxe')/*->middleware('rights:xxxxxxxxxxxxx')*/; // Add POST
    Route::get('/showpaymenttaxe/{paymentTaxeId}', [AdminController::class, 'showPaymentTaxe'])->name('admin.show.paymenttaxe')->middleware('rights:view_taxe_details'); // Show vendor class and edit form
    Route::post('/updatepaymenttaxe/{PaymentTaxeId}', [AdminController::class, 'updatePaymentTaxe'])->name('admin.update.paymenttaxe')->middleware('rights:edit_taxe'); // Update
    Route::get('/deletepaymenttaxeform/{PaymentTaxeId}', [AdminController::class, 'deletePaymentTaxeForm'])->name('admin.deleteform.paymenttaxe')->middleware('rights:delete_taxe'); // delete form
    Route::post('/deletepaymenttaxe/{PaymentTaxeId}', [AdminController::class, 'deletePaymentTaxe'])->name('admin.delete.paymenttaxe')->middleware('rights:delete_taxe'); // delete

    // Admin user Management 
    Route::get('/adminuserlist', [AdminUsersController::class, 'adminUserList'])->name('admin.list.adminusers')->middleware('rights:view_list_of_staff_members'); // List admin users
    Route::get('/addadminuser', [AdminUsersController::class, 'addAdminUserForm'])->name('admin.add.adminuserform')->middleware('rights:add_new_staff_member'); // Add form
    Route::post('/addadminuser', [AdminUsersController::class, 'addAdminUser'])->name('admin.add.adminuser')->middleware('rights:add_new_staff_member'); // Add POST action
    Route::get('/editadminuser/{adminUserId}', [AdminUsersController::class, 'editAdminUserForm'])->name('admin.edit.adminuserform')->middleware('rights:view_details_of_each_staff_member'); // Edit form
    Route::post('/updateadminUser/{adminUserId}', [AdminUsersController::class, 'updateAdminUser'])->name('admin.update.adminuser')->middleware('rights:edit_staff_members'); // Edit POST action
    Route::get('/deleteadminuserform/{adminUserId}', [AdminUsersController::class, 'deleteAdminUserForm'])->name('admin.deleteform.adminuser')->middleware('rights:edit_staff_members');
    Route::get('/deleteadminuser/{adminUserId}', [AdminUsersController::class, 'deleteAdminUser'])->name('admin.delete.adminuser')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::post('/updateaccountstatus/{userId}', [AdminController::class, 'updateAccountStatus'])->name('user.updateAccountStatus')/*->middleware('rights:xxxxxxxxxxxxx')*/;

    // Set data limit
    Route::get('/datalimitlist', [AdminController::class,'DataLimitList'])->name('admin.list.datalimit')->middleware('rights:view_limits_list');
    Route::get('/editdatalimit/{datalimitId}', [AdminController::class,'editDataLimitForm'])->name('admin.edit.datalimit')->middleware('rights:edit_limit');
    Route::post('/setdatalimit/{datalimitId}', [AdminController::class,'setDataLimit'])->name('admin.set.datalimit')->middleware('rights:edit_limit');

    
    // Events View Status Management | eventViewStatusList-eventViewStatusAddForm-eventViewStatusAdd-eventViewStatusEditForm-eventViewStatusUpdate-eventViewStatusDelete-eventViewStatusDeleteForm
    Route::get('/eventviewstatuslist', [AdminEventController::class, 'eventViewStatusList'])->name('admin.list.eventviewstatus')/*->middleware('rights:view_event_viewstatus_list')*/;
    Route::get('/eventviewstatusadd', [AdminEventController::class, 'eventViewStatusAddForm'])->name('admin.add.eventviewstatusform')/*->middleware('rights:add_new_event_viewstatus')*/;
    Route::post('/eventviewstatusadd', [AdminEventController::class, 'eventViewStatusAdd'])->name('admin.add.eventviewstatus')/*->middleware('rights:add_new_event_viewstatus')*/;
    Route::get('/eventviewstatusedit/{eventViewStatusId}', [AdminEventController::class, 'eventViewStatusEditForm'])->name('admin.edit.eventviewstatusform')/*->middleware('rights:edit_event_viewstatus')*/;
    Route::post('/eventviewstatusupdate/{eventViewStatusId}', [AdminEventController::class, 'eventViewStatusUpdate'])->name('admin.update.eventviewstatus')/*->middleware('rights:edit_event_viewstatus')*/;
    Route::get('/eventviewstatusdeleteForm/{eventViewStatusId}', [AdminEventController::class, 'eventViewStatusDeleteForm'])->name('admin.deleteform.eventviewstatus')/*->middleware('rights:delete_event_viewstatus')*/;
    Route::post('/eventviewstatusdelete/{eventViewStatusId}', [AdminEventController::class, 'eventViewStatusDelete'])->name('admin.delete.eventviewstatus')/*->middleware('rights:delete_event_viewstatus')*/;

    
    // rightsList-addRightForm-addRight
    Route::get('/rightslist', [AdminUsersController::class,'rightsList'])->name('admin.list.rights')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::get('/addrightform', [AdminUsersController::class,'addRightForm'])->name('admin.addform.right')/*->middleware('rights:xxxxxxxxxxxxx')*/;
    Route::post('/addright', [AdminUsersController::class,'addRight'])->name('admin.add.right')/*->middleware('rights:xxxxxxxxxxxxx')*/;

});
