<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('userprofile/{user_id}', [UserController::class, 'profile']);
Route::get('companyprofile/{user_id}', [CompanyController::class, 'profile']);
Route::get('associationprofile/{user_id}', [AssociationController::class, 'profile']);
Route::get('schoolprofile/{user_id}', [SchoolController::class, 'profile']);
Route::get('usersearch/{name}', [UserController::class, 'usersearch']);
Route::get('companysearch/{name}', [CompanyController::class, 'companysearch']);
Route::get('associationsearch/{name}', [AssociationController::class, 'associationsearch']);
Route::get('schoolsearch/{name}', [SchoolController::class, 'schoolsearch']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('closed', [UserDataController::class, 'closed']);
    Route::post('addexperience', [UserDataController::class, 'addexperience']);
    Route::get('experience/{id}/', [UserDataController::class, 'experience']);
    Route::put('updateexperience/{id}/', [UserDataController::class, 'updateexperience']);
    Route::delete('deleteexperience', [UserDataController::class, 'deleteexperience']);
    Route::get('experiences', [UserDataController::class, 'experiences']);
    Route::post('addeducation', [UserDataController::class, 'addeducation']);
    Route::get('educations', [UserDataController::class, 'educations']);
    Route::get('education/{id}/', [UserDataController::class, 'education']);
    Route::put('updateeducation/{id}/', [UserDataController::class, 'updateeducation']);
    Route::delete('deleteeducation', [UserDataController::class, 'deleteeducation']);
    Route::post('addcertification', [UserDataController::class, 'addcertification']);
    Route::put('updatecertification/{id}/', [UserDataController::class, 'updatecertification']);
    Route::delete('deletecertification', [UserDataController::class, 'deletecertification']);
    Route::get('certifications', [UserDataController::class, 'certifications']);
    Route::post('addportfolio', [UserDataController::class, 'addportfolio']);
    Route::put('updateportfolio/{id}/', [UserDataController::class, 'updateportfolio']);
    Route::delete('deleteportfolio', [UserDataController::class, 'deleteportfolio']);
    Route::get('portfolios', [UserDataController::class, 'portfolios']);
    Route::post('adddocument', [UserDataController::class, 'adddocument']);
    Route::put('updatedocument/{id}/', [UserDataController::class, 'updatedocument']);
    Route::delete('deletedocument', [UserDataController::class, 'deletedocument']);
    Route::get('documents', [UserDataController::class, 'documents']);
    Route::post('addskill', [UserDataController::class, 'addskill']);
    Route::get('skills', [UserDataController::class, 'skills']);
    Route::post('addproskill', [UserDataController::class, 'addproskill']);
    Route::put('updateproskill/{id}/', [UserDataController::class, 'updateproskill']);
    Route::delete('deleteproskill', [UserDataController::class, 'deleteproskill']);
    Route::get('proskills', [UserDataController::class, 'proskills']);
    Route::post('addotherskill', [UserDataController::class, 'addotherskill']);
    Route::put('updateotherskill/{id}/', [UserDataController::class, 'updateotherskill']);
    Route::delete('deleteotherskill', [UserDataController::class, 'deleteotherskill']);
    Route::get('otherskills', [UserDataController::class, 'otherskills']);
    Route::post('addonlinelink', [UserDataController::class, 'addonlinelink']);
    Route::put('updateonlinelink/{id}/', [UserDataController::class, 'updateonlinelink']);
    Route::delete('deleteonlinelink', [UserDataController::class, 'deleteonlinelink']);
    Route::get('onlinelinks', [UserDataController::class, 'onlinelinks']);
    Route::get('userdetails', [UserController::class, 'userdetails']);
    Route::get('searchprofessions/{id}/', [UserController::class, 'searchprofessions']);
    Route::get('getrelatedprofessions/{id}/', [UserController::class, 'getrelatedprofessions']);
    Route::get('professions', [UserController::class, 'professions']);
    Route::get('languages', [UserController::class, 'languages']);
    Route::post('updatebio', [UserController::class, 'updatebio']);
    Route::post('profilesetup', [UserController::class, 'profilesetup']);
    Route::post('changeprofilepic', [UserController::class, 'changeprofilepic']);
    Route::post('changecoverimage', [UserController::class, 'changecoverimage']);
    Route::post('addfollower', [UserController::class, 'addfollower']);
    Route::delete('deletefollowing', [UserController::class, 'deletefollowing']);
    Route::get('followers/{user_id}', [UserController::class, 'followers']);
    Route::post('createteam', [UserDataController::class, 'createteam']);
    Route::get('teams', [UserDataController::class, 'teams']);
    Route::post('createuserjob', [UserDataController::class, 'createuserjob']);
    Route::get('userjobs', [UserDataController::class, 'userjobs']);
    Route::post('cregister', [CompanyController::class, 'cregister']);
    Route::get('companies', [CompanyController::class, 'companies']);
    Route::get('company/{id}/', [CompanyController::class, 'companydetails']);
    Route::put('updatecompanyinfo/{id}/', [CompanyController::class, 'updatecompanyinfo']);
    Route::post('makecompanyadmin/{id}/', [CompanyController::class, 'makecompanyadmin']);
    Route::post('removecompanyadmin/{id}/', [CompanyController::class, 'removecompanyadmin']);
    Route::post('updatecompanyabout/{id}/', [CompanyController::class, 'updatecompanyabout']);
    Route::post('createcompanybranch/{id}/', [CompanyController::class, 'createcompanybranch']);
    Route::get('companybranches/{id}/', [CompanyController::class, 'companybranches']);
    Route::get('companybranch/{company_id}/{branch_id}', [CompanyController::class, 'companybranch']);
    Route::post('updatecompanybranch/{company_id}/{branch_id}', [CompanyController::class, 'updatecompanybranch']);
    Route::delete('deletecompanybranch/{company_id}/{branch_id}', [CompanyController::class, 'deletecompanybranch']);
    Route::post('updatecompanysocials/{id}/', [CompanyController::class, 'updatecompanysocials']);
    Route::put('updatecompanyprofile/{id}/', [CompanyController::class, 'updatecompanyprofile']);
    Route::post('createcompanyevent/{company_id}/', [CompanyController::class, 'createcompanyevent']);
    Route::put('updatecompanyevent/{company_id}/', [CompanyController::class, 'updatecompanyevent']);
    Route::delete('deletecompanyevent', [CompanyController::class, 'deletecompanyevent']);
    Route::get('companyevents/{company_id}/', [CompanyController::class, 'companyevents']);
    Route::post('addcompanygallery/{company_id}/', [CompanyController::class, 'addcompanygallery']);
    Route::post('updatecompanygallery/{gallery_id}/', [CompanyController::class, 'updatecompanygallery']);
    Route::delete('deletecompanygallery', [CompanyController::class, 'deletecompanygallery']);
    Route::get('companygalleries/{company_id}/', [CompanyController::class, 'companygalleries']);
    Route::post('createcompanyebroadcast/{company_id}/', [CompanyController::class, 'createcompanyebroadcast']);
    Route::get('companyebroadcasts/{company_id}/', [CompanyController::class, 'companyebroadcasts']);
    Route::post('cchangelogo/{company_id}/', [CompanyController::class, 'cchangelogo']);
    Route::post('cchangecoverimage/{company_id}/', [CompanyController::class, 'cchangecoverimage']);
    Route::post('aregister', [AssociationController::class, 'aregister']);
    Route::get('associations', [AssociationController::class, 'associations']);
    Route::get('association/{association_id}/', [AssociationController::class, 'associationdetails']);
    Route::put('updateassociationinfo/{asscociation_id}/', [AssociationController::class, 'updateassociationinfo']);
    Route::put('updateassociationprofile/{id}/', [AssociationController::class, 'updateassociationprofile']);
    Route::post('makeassociationadmin/{asscociation_id}/', [AssociationController::class, 'makeassociationadmin']);
    Route::post('removeassociationadmin/{asscociation_id}/', [AssociationController::class, 'removeassociationadmin']);
    Route::post('updateassociationabout/{asscociation_id}/', [AssociationController::class, 'updateassociationabout']);
    //Route::post('createassociationbranch/{asscociation_id}/', [AssociationController::class, 'createassociationbranch']);
    Route::get('associationbranches/{asscociation_id}/', [AssociationController::class, 'associationbranches']);
    Route::get('associationbranch/{asscociation_id}/{branch_id}', [AssociationController::class, 'associationbranch']);
    Route::post('updateassociationbranch/{asscociation_id}/{branch_id}', [AssociationController::class, 'updateassociationbranch']);
    Route::delete('deleteassociationbranch/{asscociation_id}/{branch_id}', [AssociationController::class, 'deleteassociationbranch']);
    Route::post('updateassociationsocials/{asscociation_id}/', [AssociationController::class, 'updateassociationsocials']);
    Route::post('createassociationevent/{asscociation_id}/', [AssociationController::class, 'createassociationevent']);
    Route::get('associationevents/{asscociation_id}/', [AssociationController::class, 'associationevents']);
    Route::post('addassociationgallery/{asscociation_id}/', [AssociationController::class, 'addassociationgallery']);
    Route::post('updateassociationgallery/{gallery_id}/', [AssociationController::class, 'updateassociationgallery']);
    Route::delete('deleteassociationgallery', [AssociationController::class, 'deleteassociationgallery']);
    Route::get('associationgalleries/{asscociation_id}/', [AssociationController::class, 'associationgalleries']);
    Route::post('createassociationebroadcast/{asscociation_id}/', [AssociationController::class, 'createassociationebroadcast']);
    Route::get('associationebroadcasts/{asscociation_id}/', [AssociationController::class, 'associationebroadcasts']);
    Route::post('achangelogo/{asscociation_id}/', [AssociationController::class, 'achangelogo']);
    Route::post('achangecoverimage/{asscociation_id}/', [AssociationController::class, 'achangecoverimage']);
    Route::post('sregister', [SchoolController::class, 'sregister']);
    Route::get('schools', [SchoolController::class, 'schools']);
    Route::get('school/{school_id}/', [SchoolController::class, 'Schooldetails']);
    Route::post('updateschoolinfo/{school_id}/', [SchoolController::class, 'updateschoolinfo']);
    Route::post('makeschooladmin/{school_id}/', [SchoolController::class, 'makeschooladmin']);
    Route::post('removeschooladmin/{school_id}/', [SchoolController::class, 'removeschooladmin']);
    Route::post('updateschoolabout/{school_id}/', [SchoolController::class, 'updateschoolabout']);
    Route::post('createschoolbranch/{school_id}/', [SchoolController::class, 'createschoolbranch']);
    Route::get('schoolbranches/{school_id}/', [SchoolController::class, 'schoolbranches']);
    Route::get('schoolbranch/{school_id}/{branch_id}', [SchoolController::class, 'schoolbranch']);
    Route::post('updateschoolbranch/{school_id}/{branch_id}', [SchoolController::class, 'updateschoolbranch']);
    Route::delete('deleteschoolbranch/{school_id}/{branch_id}', [SchoolController::class, 'deleteschoolbranch']);
    Route::post('updateschoolsocials/{school_id}/', [SchoolController::class, 'updateschoolsocials']);
    Route::put('updateschoolprofile/{id}/', [SchoolController::class, 'updateschoolprofile']);
    Route::post('createschoolevent/{school_id}/', [SchoolController::class, 'createschoolevent']);
    Route::get('schoolevents/{school_id}/', [SchoolController::class, 'schoolevents']);
    Route::post('addschoolgallery/{school_id}/', [SchoolController::class, 'addschoolgallery']);
    Route::post('updateschoolgallery/{gallery_id}/', [SchoolController::class, 'updateschoolgallery']);
    Route::delete('deleteschoolgallery', [SchoolController::class, 'deleteschoolgallery']);
    Route::get('schoolgalleries/{school_id}/', [SchoolController::class, 'schoolgalleries']);
    Route::post('createschoolebroadcast/{school_id}/', [SchoolController::class, 'createschoolebroadcast']);
    Route::get('schoolebroadcasts/{school_id}/', [SchoolController::class, 'schoolebroadcasts']);
    Route::post('schangelogo/{asscociation_id}/', [SchoolController::class, 'schangelogo']);
    Route::post('schangecoverimage/{asscociation_id}/', [SchoolController::class, 'schangecoverimage']);
    
});