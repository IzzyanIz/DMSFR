<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HRController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CEOcontroller;
use App\Http\Controllers\ManagerController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'] )->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/login-page', [LoginController::class, 'loginpage'])->name('login.page');
//Route::post('/login-page', [LoginController::class, 'loginprocess'])->name('login.process');

require __DIR__.'/auth.php';
//login
//Route::get('/login-with-face', [AdminController::class, 'loginWithFaceRegister'])->name('login.face.register');
//Route::post('/login-with-face', [AdminController::class, 'loginWithFace'])->name('login.face');
//Route::post('/login-with-password', [AdminController::class, 'loginWithPassword'])->name('login.password');
//Route::get('/login-with-password', [AdminController::class, 'showPasswordForm'])->name('login.password.register');

///////Admin///////
Route::middleware(['auth', 'check.userlevel:Admin'])->group(function () {
Route::get('/admin-dashboard', [AdminController::class, 'viewDashboard'])->name('view.dashboard');
Route::get('/admin-manage-users', [AdminController::class, 'viewmanageUsers'])->name('manage.users');
Route::get('/admin-register-users', [AdminController::class, 'formRegisterFace'])->name('form.register.face');
Route::post('/admin-register-users', [AdminController::class, 'registerFace'])->name('register.face');
Route::get('/admin-update-users/{id}', [AdminController::class, 'editusers'])->name('user.editusers');
Route::post('/admin-update-users/{id}', [AdminController::class, 'updateusers'])->name('user.update');
Route::delete('/admin-delete-users/{id}', [AdminController::class, 'deleteusers'])->name('user.delete');
Route::get('/admin-view-profile', [AdminController::class, 'viewProfileAdmin'])->name('admin.view.profile');
Route::get('/admin-edit-profile', [AdminController::class, 'editAccount'])->name('admin.edit.profile');
Route::post('/admin-edit-profile', [AdminController::class, 'editAccountProcess'])->name('edit.account.process.admin');
Route::post('/user/save-face', [AdminController::class, 'saveFace'])->name('users.saveFace');



});
///////HR///////
Route::middleware(['auth', 'check.userlevel:Human Resource'])->group(function () {
Route::get('/hr-dashboard', [HRController::class, 'viewDashboardHR'])->name('view.dashboard.hr');
Route::get('/hr-manage-staff', [HRController::class, 'viewListStaff'])->name('view.list.staff');
Route::get('/hr-register-staff', [HRController::class, 'formregisterstaff'])->name('form.register.staff');
Route::post('/hr-register-staff', [HRController::class, 'registerstaffprocess'])->name('register.staff.process');
Route::get('/hr-update-staff/{idStaff}', [HRController::class, 'updatestaffform'])->name('form.update.staff');
Route::put('/hr-update-staff/{idStaff}', [HRController::class, 'updatestaffprocess'])->name('update.staff.process');
Route::get('/hr-details-staff/{idStaff}', [HRController::class, 'seedetailsstaff'])->name('details.staff');
Route::delete('/hr-delete-staff/{idStaff}', [HRController::class, 'deleteStaff'])->name('delete.staff');
Route::get('/hr-manage-client', [HRController::class, 'viewListClient'])->name('view.list.client');
Route::get('/hr-manage-document', [HRController::class, 'viewListDocs'])->name('view.list.docs');
Route::get('/hr-register-document', [HRController::class, 'formregisterdocs'])->name('form.register.docs');
Route::post('/hr-register-document', [HRController::class, 'uploadDocument'])->name('register.docs.process');
Route::get('/hr-generate-document', [HRController::class, 'formgeneratedocs'])->name('form.generate.docs');
Route::post('/hr-generate-document', [HRController::class, 'generateDocument'])->name('generate.document.process');
Route::get('/hr-profile-list', [HRController::class, 'viewProfileHR'])->name('view.profile.list.hr');
Route::get('/hr-profile', [HRController::class, 'viewProfileForm'])->name('view.profile.hr');
Route::post('/hr-profile', [HRController::class, 'registerprofilehr'])->name('process.profile.hr');
Route::get('/hr-generate-document-loa', [HRController::class, 'formgeneratedocloa'])->name('form.generate.docs.loa');
Route::post('/hr-generate-loa', [HRController::class, 'generateloa'])->name('generate.loa.process');
Route::get('/hr-generate-document-nda', [HRController::class, 'formgeneratedocnda'])->name('form.generate.docs.nda');
Route::post('/hr-generate-nda', [HRController::class, 'generatenda'])->name('generate.nda.process');
Route::get('/hr-document-status', [HRController::class, 'listDocumentStatus'])->name('document.status.hr');
Route::get('/hr-document-request-form', [HRController::class, 'viewRegisterDocReq'])->name('document.request.hr');
Route::post('/hr-document-request-form', [HRController::class, 'submitApprovalRequest'])->name('document.submitrequest.hr');
Route::get('/hr-register-client', [HRController::class, 'registerClientHR'])->name('client.register.hr');
Route::post('/hr-register-client', [HRController::class, 'storeClientHR'])->name('client.store.hr');
Route::get('/hr-details-client/{idClient}', [HRController::class, 'seedetailsclient'])->name('details.client.hr');
Route::get('/hr-update-client/{idClient}', [HRController::class, 'updateclientform'])->name('form.update.client.hr');
Route::put('/hr-update-client/{idClient}', [HRController::class, 'updateclienthr'])->name('update.client.hr');
Route::delete('/hr-delete-client/{idClient}', [HRController::class, 'deleteclienthr'])->name('delete.client.hr');
Route::delete('/hr-delete-document-status/{id}', [HRController::class, 'deleteapprovaldocs'])->name('delete.document.approval.hr');
Route::get('/hr-edit-account', [HRController::class, 'editAccountHR'])->name('edit.account.hr');
Route::post('/hr-edit-account', [HRController::class, 'editAccountHRProcess'])->name('hr.edit.profile.process');



});


///////Lawyer///////
Route::middleware(['auth', 'check.userlevel:Lawyer'])->group(function () {
Route::get('/lawyer-dashboard', [LawyerController::class, 'viewDashboardLawyer'])->name('view.dashboard.lawyer');
Route::get('/lawyer-manage-client', [LawyerController::class, 'viewListClientL'])->name('view.list.client.lawyer');
Route::get('/lawyer-register-client', [LawyerController::class, 'formregisterclientL'])->name('register.client.lawyer');
Route::post('/lawyer-register-client', [LawyerController::class, 'storeClientL'])->name('client.store.lawyer');
Route::get('/lawyer-details-client/{idClient}', [LawyerController::class, 'seedetailsclient'])->name('details.client.lawyer');
Route::get('/lawyer-update-client/{idClient}', [LawyerController::class, 'updateclientform'])->name('form.update.client.lawyer');
Route::put('/lawyer-update-client/{idClient}', [LawyerController::class, 'updateclientlawyer'])->name('update.client.lawyer');
Route::delete('/lawyer-delete-client/{idClient}', [LawyerController::class, 'deleteclientlawyer'])->name('delete.client.lawyer');
Route::get('/lawyer-manage-cases', [LawyerController::class, 'viewListCases'])->name('view.list.cases');
Route::get('/lawyer-register-cases', [LawyerController::class, 'formregistercases'])->name('register.cases.form');
Route::post('/lawyer-register-cases', [LawyerController::class, 'registercases'])->name('submit.cases.lawyer');
Route::get('/lawyer-details-cases/{idCases}', [LawyerController::class, 'seedetailscases'])->name('details.cases.lawyer');
Route::get('/lawyer-update-cases/{idCases}', [LawyerController::class, 'updatecasesform'])->name('form.update.cases.lawyer');
Route::put('/lawyer-update-cases/{idCases}', [LawyerController::class, 'updatecases'])->name('cases.update.lawyer');
Route::delete('/lawyer-delete-cases/{idCases}', [LawyerController::class, 'lawyerdeletecases'])->name('lawyer.delete.cases');
Route::get('/lawyer-add-task/{idCases}', [LawyerController::class, 'formaddtask'])->name('add.task.lawyer');
Route::post('/lawyer-add-task/{id}', [LawyerController::class, 'storetask'])->name('store.task.lawyer');
Route::get('/lawyer-view-task', [LawyerController::class, 'viewtasklawyer'])->name('view.task.lawyer');
Route::get('/lawyer-update-task/{idTask}', [LawyerController::class, 'formupdatetask'])->name('update.task.lawyer');
Route::put('/lawyer-update-task/{idTask}', [LawyerController::class, 'updatetask'])->name('update.task.process');
Route::get('/lawyer-view-task-history', [LawyerController::class, 'viewtaskhistory'])->name('view.task.history');
Route::get('/lawyer-view-documents', [LawyerController::class, 'viewDocumentList'])->name('view.document.list');
Route::get('/lawyer-register-documents', [LawyerController::class, 'registerDoc'])->name('register.doc.lawyer');
Route::post('/lawyer-register-document', [LawyerController::class, 'uploadDocumentLawyer'])->name('docs.process.lawyer');
Route::get('/lawyer-generate-documents', [LawyerController::class, 'viewgeneratedocs'])->name('generate.doc.lawyer');
Route::get('/get-client-details/{id}', [LawyerController::class, 'getClientDetailsSPA']);
Route::get('/lawyer-profile', [LawyerController::class, 'viewProfileForm'])->name('view.profile.lawyer');
Route::post('/lawyer-profile', [LawyerController::class, 'registerprofileprocess'])->name('lawyer.profile.process');
Route::get('/lawyer-view-profile', [LawyerController::class, 'viewProfileList'])->name('view.profile.list.lawyer');
Route::post('/lawyer-generate-spa', [LawyerController::class, 'generatespa'])->name('generate.spa.process');
Route::get('/lawyer-generate-loan', [LawyerController::class, 'viewgenerateloan'])->name('generate.loan.agreement');
Route::get('/lawyer-generate-sd', [LawyerController::class, 'viewgeneratesd'])->name('generate.sd.lawyer');
Route::post('/lawyer-generate-sd', [LawyerController::class, 'generatesd'])->name('generate.sd.process');
Route::post('/lawyer-generate-loan', [LawyerController::class, 'generateloan'])->name('generate.loan.process');
Route::get('/lawyer-edit-account', [LawyerController::class, 'editAccount'])->name('edit.account.lawyer');
Route::post('/lawyer-edit-account', [LawyerController::class, 'editAccountProcess'])->name('lawyer.edit.profile.process');



});

Route::middleware(['auth', 'check.userlevel:CEO'])->group(function () {
    Route::get('/ceo-dashboard', [CEOcontroller::class, 'viewDashboardCEO'])->name('view.dashboard.CEO');
    Route::get('/ceo-list-cases', [CEOcontroller::class, 'viewListCasesCEO'])->name('CEO.list.cases');
    Route::get('/ceo-register-cases', [CEOcontroller::class, 'registercasesCEO'])->name('CEO.register.cases');
    Route::post('/ceo-register-cases', [CEOcontroller::class, 'registercasesCEOProcess'])->name('CEO.submit.cases');
    Route::get('/ceo-list-task', [CEOcontroller::class, 'listTaskCEO'])->name('CEO.task');
    Route::get('/ceo-register-task/{case_id}', [CEOcontroller::class, 'registerTaskCEO'])->name('ceo.add.task.form');
    Route::post('/ceo-register-task', [CEOcontroller::class, 'submitTaskCEO'])->name('ceo.submit.task');
    Route::get('/ceo-staff-list', [CEOcontroller::class, 'viewStaff'])->name('ceo.view.staff');
    Route::get('/ceo-staff-details/{idStaff}', [CEOcontroller::class, 'viewStaffDetails'])->name('ceo.staff.details');
    Route::delete('/ceo-delete-staff/{idStaff}', [CEOcontroller::class, 'deleteStaff'])->name('ceo.delete.staff');
    Route::get('/ceo-client-list', [CEOcontroller::class, 'viewClient'])->name('ceo.view.client');
    Route::get('/ceo-details-client/{idClient}', [CEOcontroller::class, 'seedetailsclient'])->name('ceo.details.client');
    Route::get('/ceo-details-cases/{idCases}', [CEOcontroller::class, 'seedetailscases'])->name('ceo.details.cases');
    Route::get('/ceo-update-task/{idTask}', [CEOcontroller::class, 'formupdatetask'])->name('ceo.update.task');
    Route::put('/ceo-update-task/{idTask}', [CEOcontroller::class, 'updatetask'])->name('ceo.update.task.process');
    Route::get('/ceo-profile', [CEOcontroller::class, 'viewProfile'])->name('ceo.see.profile');
    Route::get('/ceo-edit-profile-form', [CEOcontroller::class, 'editProfileCEO'])->name('edit.profile.ceo');
    Route::post('/ceo-post-profile', [CEOcontroller::class, 'editProfileProcess'])->name('ceo.edit.profile.process');
    Route::get('/ceo-approval-document', [CEOcontroller::class, 'viewApprove'])->name('ceo.view.document');
    Route::get('/ceo-update-document/{id}', [CEOcontroller::class, 'updateStatusDoc'])->name('ceo.update.document');
    Route::post('/ceo-update-document/{id}', [CEOcontroller::class, 'updateStatusDocProcess'])->name('ceo.update.document.process');

    Route::post('/validate-face', [CEOcontroller::class, 'validateFace'])->name('validateFace');
    
});

Route::middleware(['auth', 'check.userlevel:Manager'])->group(function () {
    Route::get('/manager-dashboard', [ManagerController::class, 'viewDashboardManager'])->name('view.dashboard.manager');
    Route::get('/manager-view-profile', [ManagerController::class, 'viewProfile'])->name('manager.profile');
    Route::get('/manager-register-profile', [ManagerController::class, 'RegisterProfileManager'])->name('register.profile.manager');
    Route::get('/manager-edit-account', [ManagerController::class, 'editAccount'])->name('edit.account.manager');
    Route::post('/manager-edit-account', [ManagerController::class, 'editAccountProcess'])->name('edit.account.process.manager');
    Route::post('/manager-register-profile', [ManagerController::class, 'RegisterManagerProcess'])->name('manager.profile.process');
    Route::get('/manager-list-cases', [ManagerController::class, 'viewListCasesManager'])->name('list.cases.manager');
    Route::get('/manager-register-cases', [ManagerController::class, 'registercases'])->name('register.cases.manager');
    Route::post('/manager-register-cases', [ManagerController::class, 'registercasesManagerProcess'])->name('submit.cases.manager');
    Route::get('/manager-list-task', [ManagerController::class, 'listTask'])->name('list.task.manager');
    Route::get('/manager-register-task/{case_id}', [ManagerController::class, 'registerTaskManager'])->name('manager.add.task.form');
    Route::post('/manager-register-task', [ManagerController::class, 'submitTaskManager'])->name('manager.submit.task');
    Route::get('/manager-update-task/{idTask}', [ManagerController::class, 'formupdatetask'])->name('manager.update.task');
    Route::put('/manager-update-task/{idTask}', [ManagerController::class, 'updatetask'])->name('manager.update.task.process');
    Route::get('/manager-details-cases/{idCases}', [ManagerController::class, 'seedetailscases'])->name('details.cases.manager');

    
    
});