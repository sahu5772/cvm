<?php

use App\Http\Controllers\BusinessUnitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PavementController;
use App\Http\Controllers\TerrainsController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CompanyPerkController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchFilterController;
use App\Http\Controllers\EducationModeController;
use App\Http\Controllers\FundingAgencyController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CandidateAddressController;
use App\Http\Controllers\CandidateCommentController;
use App\Http\Controllers\CandidateCvController;
use App\Http\Controllers\CandidateKeywordController;
use App\Http\Controllers\CandidateProjectController;
use App\Http\Controllers\CandidateTrainingController;
use App\Http\Controllers\CandidateEducationController;
use App\Http\Controllers\CandidateMembershipController;
use App\Http\Controllers\CandidateWorkExperienceController;
use App\Http\Controllers\FormateController;
use App\Http\Controllers\SocialShareController;
use App\Http\Controllers\InterviewRoundController;
use App\Http\Controllers\InterviewScheduleController;

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
    return view('auth.login');
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
});

Route::middleware(['auth', 'verified','mail'])->group(function () {

    //Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/candidate-by-sector', [DashboardController::class, 'getChartData']);
    Route::get('/getSubjects', [DashboardController::class, 'getSubjectData']);

    //Roles and Permission
    Route::get('/role-data', [RoleController::class, 'roleData'])->name('roles');
    Route::post('/reset-permission', [RoleController::class, 'resetPermission'])->name('resetPermission');
    Route::post('/permission-store', [RoleController::class, 'permissionStore'])->name('permission-store');
    Route::post('/permission-show', [RoleController::class, 'permissionShow'])->name('permission-show');
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionsController::class);

    //Employee
    Route::resource('users', UserController::class);
    Route::match(['get', 'post'], 'profile-settings', [UserController::class, 'profileSettings'])->name('users.profile-settings');

    Route::resource('currency', CurrencyController::class);
    Route::resource('category', CategoryController::class);

    Route::resource('sub-category', SubCategoryController::class);
    Route::get('/getSubcategories/{id}', [SubCategoryController::class, 'getSubcategories'])->name('getSubcategories');

    Route::resource('designation', DesignationController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('company-setting', CompanySettingController::class);
    Route::resource('job-type', JobTypeController::class);
    Route::resource('skill', SkillController::class);

    //Business Unit
    Route::resource('business', BusinessUnitController::class);
    Route::get('/company-business-unit', [BusinessUnitController::class, 'companyBusinessUnit'])->name('business.company-unit');
    Route::post('/location-store', [BusinessUnitController::class, 'companyLocationStore'])->name('business.location-store');
    Route::post('/company-location-destroy', [BusinessUnitController::class, 'companyLocationDelete'])->name('business.location.destroy');

    //company
    Route::resource('company', CompanyController::class);
    Route::post('/delete-company', [CompanyController::class, 'deleteAllCompany'])->name('company.delete-company');
    Route::post('/states', [CompanyController::class, 'getState'])->name('states');
    Route::post('/cities', [CompanyController::class, 'getCity'])->name('cities');

    Route::resource('industry', IndustryController::class);
    Route::resource('education', EducationController::class);
    Route::resource('company-perk', CompanyPerkController::class);

    //Job
    Route::resource('job', JobController::class);
    Route::get('job/status-change/{id}/{newStatus}', [JobController::class, 'changeStatus'])->name('job.status-change');
    Route::get('job/share-detail-modal-job/{id}', [JobController::class, 'shareDetailEmailModal'])->name('share-detail-modal-job');
    Route::post('share-detail-job', [JobController::class,'shareDetailEmailJob'])->name('share-detail-job');

    Route::resource('language-setting', LanguageController::class);
    Route::resource('education-mode', EducationModeController::class);
    Route::resource('funding-agency', FundingAgencyController::class);
    Route::resource('university', UniversityController::class);
    Route::resource('sector', SectorController::class);
    Route::resource('terrains', TerrainsController::class);
    Route::resource('pavement', PavementController::class);

    Route::resource('phase', PhaseController::class);
    Route::post('/sector-list', [PhaseController::class, 'sectorList'])->name('sector-list');

    Route::resource('employee-type', EmployeeTypeController::class);
    Route::resource('subject', SubjectController::class);

    Route::get('candidate-report', [ReportController::class,'index'])->name('report.index');
    Route::get('project-report', [ReportController::class,'projectReport'])->name('report.candidate-project');
    Route::get('employee-report', [ReportController::class,'employeeReport'])->name('employee.report');

    Route::get('search', [SearchFilterController::class,'index'])->name('search.index');
    Route::get('filter', [SearchFilterController::class,'filter'])->name('search.filter');

    //candidate data
    Route::resource('candidate', CandidateController::class);
    Route::post('verify-phone', [CandidateController::class,'VerifyPhone'])->name('candidate.phone');
    Route::post('resend-otp-phone', [CandidateController::class,'resendOtp'])->name('candidate.resend');
    Route::post('mobile-verify-otp', [CandidateController::class,'verifyOtp'])->name('candidate.mobile-verify-otp');
    Route::post('verify-email', [CandidateController::class,'VerifyEmail'])->name('candidate.email');
    Route::get('share-detail-modal/{id}', [CandidateController::class,'shareDetailEmailModal'])->name('share-detail-modal');
    Route::post('share-detail', [CandidateController::class,'shareDetailEmail'])->name('share-detail');
    Route::post('resend-otp-email', [CandidateController::class,'resendOtpEmail'])->name('candidate.resend-email');

    Route::resource('candidate-education', CandidateEducationController::class);
    Route::resource('candidate-work-experience', CandidateWorkExperienceController::class);
    Route::resource('candidate-project', CandidateProjectController::class);
    Route::post('/phase-list', [CandidateProjectController::class, 'phaseList'])->name('phase-list');
    Route::resource('candidate-training', CandidateTrainingController::class);
    Route::resource('candidate-membership', CandidateMembershipController::class);
    Route::resource('candidate-address', CandidateAddressController::class);
    Route::get('get-candidate-sector', [CandidateKeywordController::class,'index'])->name('candidate-sector.index');
    Route::get('get-candidate-phase', [CandidateKeywordController::class,'getCandidatePhase'])->name('candidate-phase.phase');
    Route::get('get-candidate-keyword', [CandidateKeywordController::class,'getCandidateKeyword'])->name('candidate-keyword.keyword');
    Route::resource('candidate-comment', CandidateCommentController::class);
    Route::get('candidate-keyword-data', [CandidateKeywordController::class,'keywordStore'])->name('keyword.data');

    Route::resource('keyword', KeywordController::class);

    //Email
    Route::get('email-setting', [EmailSettingController::class,'index'])->name('emailSetting.index');
    Route::Post('email-setting', [EmailSettingController::class,'store'])->name('emailSetting.save');
    Route::Post('send-mail', [EmailSettingController::class,'sendMail'])->name('sendEmail.store');
    Route::Post('email-notification', [EmailSettingController::class,'notificationEmail'])->name('email-notification');

    Route::get('notification', [NotificationController::class,'index'])->name('notification.index');
    Route::get('formate/{id}/{formate}', [FormateController::class,'formate'])->name('formate');

    Route::get('social-share', [SocialShareController::class, 'index']);

    //Interview
    Route::resource('interview-schedule', InterviewScheduleController::class);
    Route::get('interview-schedule/schedule/{id}', [InterviewScheduleController::class, 'schedule'])->name('schedule');
    Route::resource('interview-round', InterviewRoundController::class);
    Route::resource('interview-schedule', InterviewScheduleController::class);
    Route::resource('candidate-cv', CandidateCvController::class);
});