<?php

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
    return view('pages.admins.category.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
        // ACCOUNT
    Route::prefix('accounts')->group(function () {
        // PROFILE
        Route::get('/profile', "Master\AccountController@profile")->name('accounts/profile');

        // UPDATE PROFILE
        Route::post('/update_profile/{user_id}', 'Master\AccountController@update_profile')->name('accounts/update_profile');

        // LOGOUT
        Route::get('/profile/logout', 'Master\AccountController@logout')->name('accounts/logout');

        // JOBS
        Route::get('/jobs', 'Master\AccountController@jobs')->name('accounts/jobs');

        // ADD WORK FOR ALUMNI
        Route::post('/add_work_submit', 'Master\AccountController@add_work_submit')->name('accounts/add_work_submit');

        // HIỂN THỊ TÁT CẢ CÔNG VIỆC CỦA MÌNH ĐÃ LÀM VỪA QUA
        Route::get('/show_work_yourself', 'Master\AccountController@show_work')->name('accounts/show_work_yourself');

        // XỬ LÝ BUTTON NGHỈ VIỆC
        Route::post('/resign_ajax', 'Master\AccountController@resign_ajax')->name('accounts/resign_ajax');

        // HIỂN THỊ CÔNG VIỆC HIỆN TẠI CỦA MÌNH VÀ THỰC HIỆN CHỨC NĂNG NGHỈ VIỆC
        Route::get('/show_current_work_and_resign', 'Master\AccountController@show_current_work_and_resign')->name('accounts/show_current_work_and_resign');

        // THAY ĐỔI MẬT KHẨU CÁ NHÂN 
        Route::get('/change_password','Master\AccountController@change_password')->name('account/change_password');
        Route::post('/update_password','Master\AccountController@update_password')->name('accounts/update_password');
    });

    // ACADEMY
    Route::prefix('khoa-vien')->group(function () {
        Route::get('/', "Master\AcademyController@index")->name('khoa-vien/index');
        // ADD
        Route::get('/them', "Master\AcademyController@create_render")->name('khoa-vien/them');
        Route::post('/them', "Master\AcademyController@create_submit")->name('khoa-vien/them/submit');
        // EDIT
        Route::get('/edit/{academy_id}', 'Master\AcademyController@edit')->name('khoa-vien/edit');
        Route::post('/edit/submit/{academy_id}', 'Master\AcademyController@update')->name('khoa-vien/edit/submit');
        // DELETE
        Route::post('/destroy/{academy_id}', 'Master\AcademyController@destroy')->name('khoa-vien/destroy');
    });

    // STUDENT
    Route::prefix('students')->group(function () {
        Route::get('/', 'Master\StudentController@index')->name('students.index');
        //IMPORT EXPORT
        Route::get('export', 'Master\StudentController@export')->name('students.export');
        Route::get('importExportView', 'Master\StudentController@importExportView');
        Route::post('import', 'Master\StudentController@import')->name('students.import');
        // ADD
        Route::get('/create', 'Master\StudentController@create')->name('students.create');
        Route::post('/create_submit', 'Master\StudentController@store')->name('students.store');
        // EDIT
        Route::get('/edit/{user_id}', 'Master\StudentController@edit')->name('students.edit');
        Route::post('/edit_submit/{user_id}', 'Master\StudentController@update')->name('students.update');
        // SHOW
        Route::get('/show/{user_id}', 'Master\StudentController@show')->name('students.show');
        // DELETE
        Route::post('/delete/{user_id}', 'Master\StudentController@destroy')->name('students.destroy');

        // LIVE SEARCH STUDENT
        Route::get('/live_search_student', 'Master\StudentController@live_search_student')->name('students.live_search_action');
    });

    // TEST
    Route::get('/test', 'Master\StudentController@test');
    Route::get('/test', 'Master\StudentController@test');

    // ALUMNI
    Route::prefix('alumnies')->group(function () {
        Route::get('/', 'Master\AlumniController@index')->name('alumnies/index');

        // ADD
        Route::get('/create', 'Master\AlumniController@create')->name('alumnies/create');
        Route::post('/create_submit', 'Master\AlumniController@store')->name('alumnies/store');
        // EDIT
        Route::get('/edit/{user_id}', 'Master\AlumniController@edit')->name('alumnies/edit');
        Route::post('/edit_submit/{user_id}', 'Master\AlumniController@update')->name('alumnies/update');
        // SHOW
        Route::get('/show/{user_id}', 'Master\AlumniController@show')->name('alumnies/show');
        // DELETE
        Route::post('/delete/{user_id}', 'Master\AlumniController@destroy')->name('alumnies/destroy');

        // EXPORT
        // Route::get('/export', 'Master\AlumniController@export')->name('alumnies/export');
        // IMPORT
        Route::post('/import', 'Master\AlumniController@import')->name('alumnies/import');

        // IMPORT GRADUATE
        Route::post('/import_graduate', 'Master\AlumniController@import_graduate')->name('alumnies/import_register_graduate');

        // SHOW DETAILS WORK OF USERS HAVE STATUS_ID === 3 : DI LAM
        Route::get('/show_details_work/{alumni_id}', 'Master\AlumniController@show_details_work')->name('alumnies/show_details_work');

        // LIVE SEARCH ALUMNIES
        // Route::get('/live_search', 'Master\AlumniController@live_search')->name('alumnies/live_search_action');
    });

    // POST
    Route::prefix('posts')->group(function () {
        // // REGISTER
        // Route::get('/register', 'Master\PostController@register')->name('posts.register');
        // Route::post('/register', 'Master\PostController@register_store')->name('posts.register_store');
        // Route::get('/sucess', 'Master\PostController@success')->name('posts.success');

        // // LOGIN
        // Route::get('/login', 'Master\PostController@login')->name('posts.login');
        // Route::get('/login2', 'Master\PostController@login2')->name('posts.login2');
        // Route::post('/checklogin', 'Master\PostController@checklogin')->name('posts.checklogin');

        // // LOGOUT
        // Route::get('/logout', 'Master\PostController@logout')->name('posts.logout');

        // TRANG INDEX
        Route::get('/', 'Master\PostController@index')->name('posts.index');

        // CHỨC NĂNG ĐĂNG BÀI
        Route::get('/add_posts', 'Master\PostController@add_posts')->name('posts.add_posts');
        Route::post('/store', 'Master\PostController@store')->name('posts.store');

        // Xử lý duyệt bài trên Admin
        Route::get('/list_post', 'Master\PostController@list_post')->name('posts.list_post');
        Route::post('/list_post_ajax', 'Master\PostController@list_post_ajax')->name('posts.list_post_ajax');

        // HIỂN THỊ CHI TIẾT BÀI VIẾT TRÊN CHỨC NĂNG DUYỆT BÀI CỦA ADMIN
        Route::get('/show_post_detail_of_admin/{post_id}', 'Master\PostController@show_post_detail_of_admin')->name('posts.show_post_detail_of_admin');

        // CHỨC NĂNG KHÓA TÀI KHOẢN NGƯỜI DÙNG NẾU ĐĂNG NHỮNG BÀI KHÔNG HỢP LÝ
        Route::post('/block_user_ajax', 'Master\PostController@block_user_ajax')->name('posts.block_user_ajax');

        // HIỂN THỊ DANH SÁCH TÀI KHOẢN BỊ KHÓA VÀ CHỨC NĂNG MỞ KHÓA TÀI KHOẢN ĐÓ
        Route::get('/lists_account_blocked', 'Master\PostController@lists_account_blocked')->name('posts.lists_account_blocked');
        Route::post('/unblock_account_ajax', 'Master\PostController@unblock_account_ajax')->name('posts.unblock_account_ajax');

        // LIST POST STUDENTS
        Route::get('/list_post_students', 'Master\PostController@list_post_students')->name('posts.list_post_students');

        // HIỂN THỊ CHI TIẾT BÀI VIẾT KHI CLICK VÀO
        
        Route::get('{category_slug}/{slug}','Master\PostController@posts_slug')->name('posts.slug');

        // LIST POST YOUR CLASS
        Route::get('/post_your_class/{id}', 'Master\PostController@post_your_class')->name('posts.post_your_class');

        // LIST POST TEACHERS
        Route::get('/list_post_teachers', 'Master\PostController@list_post_teachers')->name('posts.list_post_teachers');

        // COMMENT
        Route::post('/comment_ajax', 'Master\PostController@comment_ajax')->name('posts.comment_ajax');

        // POST OF YOURSELF
        // Route::get('/post_yourself', 'Master\PostController@post_yourself')->name('posts.post_yourself');

        // CATEGORIES Tìm việc làm
        Route::get('/categories_find_job', 'Master\PostController@categories_find_job')->name('posts.categories_find_job');

        // CATEGORIES Tuyển việc làm
        Route::get('/categories_apply_job', 'Master\PostController@categories_apply_job')->name('posts.categories_apply_job');

        // CATEGORIES Họp lớp
        Route::get('/categories_class_meeting', 'Master\PostController@categories_class_meeting')->name('posts.categories_class_meeting');

        // CATEGORIES Hổ trợ học bổng
        Route::get('/categories_support_scholarship', 'Master\PostController@categories_support_scholarship')->name('posts.categories_support_scholarship');

        // CATEGORIES Quyên góp
        Route::get('/categories_donations', 'Master\PostController@categories_donations')->name('posts.categories_donations');

        // CATEGORIES Thông báo
        Route::get('/categories_notifications', 'Master\PostController@categories_notifications')->name('posts.categories_notifications');
    });

    //Major
    Route::group(['prefix' => 'major'], function () {
        Route::get('/', "Master\MajorController@index")->name('major/index');
        // ADD
        Route::get('/create', "Master\MajorController@create_render")->name('major/create');
        Route::post('/create', "Master\MajorController@create_submit")->name('major/create/submit');
        // EDIT
        Route::get('/edit/{major_id}', 'Master\MajorController@edit')->name('major/edit');
        Route::post('/edit/submit/{major_id}', 'Master\MajorController@update')->name('major/edit/submit');
        // DELETE
        Route::post('/destroy/{major_id}', 'Master\MajorController@destroy')->name('major/destroy');
    });
    //Major Branch
    Route::group(['prefix' => 'major_branch'], function () {
        Route::get('/', "Master\MajorBranchController@index")->name('major_branch/index');
        // ADD
        Route::get('/create', "Master\MajorBranchController@create_render")->name('major_branch/create');
        Route::post('/create', "Master\MajorBranchController@create_submit")->name('major_branch/create/submit');
        // EDIT
        Route::get('/edit/{major_branch_id}', 'Master\MajorBranchController@edit')->name('major_branch/edit');
        Route::post('/edit/submit/{major_branch_id}', 'Master\MajorBranchController@update')->name('major_branch/edit/submit');
        // DELETE
        Route::post('/destroy/{major_branch_id}', 'Master\MajorBranchController@destroy')->name('major_branch/destroy');
    });
    //Class
    Route::group(['prefix' => 'class'], function () {
        Route::get('/', "Master\ClassController@index")->name('class/index');
        // ADD
        Route::get('/create', "Master\ClassController@create_render")->name('class/create');
        Route::post('/create', "Master\ClassController@create_submit")->name('class/create/submit');
        // EDIT
        Route::get('/edit/{class_id}', 'Master\ClassController@edit')->name('class/edit');
        Route::post('/edit/submit/{class_id}', 'Master\ClassController@update')->name('class/edit/submit');
        // SHOW
        Route::get('/show/{class_id}', 'Master\ClassController@show')->name('class/show');
        // DELETE
        Route::post('/destroy/{class_id}', 'Master\ClassController@destroy')->name('class/destroy');
    });
    //Survey
    Route::group(['prefix' => 'survey'], function () {
        Route::get('/', 'Master\SurveyController@index')->name('survey.index');
        //create survey
        Route::get('/create', 'Master\SurveyController@create_render')->name('survey.create_render');
        Route::post('/create_submit', 'Master\SurveyController@create_submit')->name('survey/create/submit');
        //add question
        Route::get('/{survey}', 'Master\SurveyController@detail_survey')->name('survey.detail');
        //update survey
        Route::post('/destroy/{survey_id}', 'Master\SurveyController@destroy')->name('survey/destroy');
        Route::get('/{survey}/edit', 'Master\SurveyController@edit')->name('survey.edit');
        Route::post('/{survey}/update', 'Master\SurveyController@update')->name('survey.update');

        Route::get('/view/{survey}', 'Master\SurveyController@view_survey')->name('survey.view');
        //xem đáp án
        Route::get('/answers/{survey}', 'Master\SurveyController@view_survey_answers')->name('view.survey.answers');
        //export
        Route::get('/view/{survey}/export', 'Master\AnswerController@excel')->name('survey.export');
        //trả lời
        Route::post('/view/{survey}/completed', 'Master\AnswerController@store')->name('survey.complete');

        //thêm câu hỏi
        Route::post('/{survey}/questions', 'Master\QuestionController@store')->name('survey.store');
        Route::post('/export', 'Master\SurveyController@export')->name('survey.export');
    });
    Route::get('/chart', 'Master\SurveyController@chart');
    //Question
        Route::group(['prefix' => 'question'], function () {
            Route::get('/{question}/edit', 'Master\QuestionController@edit')->name('question.edit');
            Route::post('/{question}/update', 'Master\QuestionController@update')->name('question.update');
            Route::get('/{question_id}/{value}/delete/', 'Master\QuestionController@delete')->name('question.delete');
        });
    //Thống kê
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/', 'Master\StatisticController@index')->name('statistic');
        Route::get('/showsurvey/{survey_id}', 'Master\StatisticController@get_survey')->name('statistic.get_survey');
        Route::post('/show', 'Master\StatisticController@show')->name('statistic.show');
        Route::post('/export', 'Master\StatisticController@export')->name('statistic.export');
        Route::get('/student', 'Master\StatisticController@student')->name('statistic.student');
        Route::post('/student/course', 'Master\StatisticController@course')->name('statistic.student_sort');
        // ajax lấy marjor_branch theo major_id
        Route::get('major_branch/{major_id}', 'Master\StatisticController@get_major_branch')->name('statistic.major_branch');
        Route::get('class/{major_id}/{major_branch_id}/{course}', 'Master\StatisticController@get_class')->name('statistic.class');
    });

    // ROLE_SURVEY

    route::prefix('rolesurveys')->group(function () {
        route::get('/', 'Master\RoleSurveyController@index')->name('rolesurveys/index');

        //add
        route::get('/create', 'Master\RoleSurveyController@create_render')->name('rolesurveys/create');
        route::post('/create', 'Master\RoleSurveyController@create_submit')->name('rolesurveys/create/submit');
        //edit
        route::get('/edit/{role_survey_id}', 'Master\RoleSurveyController@edit');
        route::post('/edit/{role_survey_id}', 'Master\RoleSurveyController@update');
        //delete
        route::post('/destroy/{role_survey_id}', 'Master\RoleSurveyController@destroy')->name('rolesurveys/destroy');
    });

    // CITY
    Route::prefix('city')->group(function () {
        Route::get('/', 'Master\CityController@index')->name('city/index');
        //create
        Route::get('/create', 'Master\CityController@create_render')->name('city/create');
        Route::post('/create', 'Master\CityController@create_submit')->name('city/create/submit');
        //edit
        Route::get('/edit/{city_id}', 'Master\CityController@edit')->name('city/edit');
        Route::post('/edit/submit/{city_id}', 'Master\CityController@update')->name('city/edit/submit');
        // delete
        Route::post('/destroy/{city_id}', 'Master\CityController@destroy')->name('city/destroy');
    });

    // DISTRICT
    Route::prefix('district')->group(function () {
        Route::get('/', 'Master\DistrictController@index')->name('district/index');
        //create
        Route::get('/create', 'Master\DistrictController@create_render')->name('district/create');
        Route::post('/create', 'Master\DistrictController@create_submit')->name('district/create/submit');
        //edit
        Route::get('/edit/{district_id}', 'Master\DistrictController@edit')->name('district/edit');
        Route::post('/edit/submit/{district_id}', 'Master\DistrictController@update')->name('district/edit/submit');
        // delete
        Route::post('/destroy/{district_id}', 'Master\DistrictController@destroy')->name('district/destroy');
    });

    // WARD
    Route::prefix('ward')->group(function () {
        Route::get('/', 'Master\WardController@index')->name('ward/index');
        //create
        Route::get('/create', 'Master\WardController@create_render')->name('ward/create');
        Route::post('/create', 'Master\WardController@create_submit')->name('ward/create/submit');
        //edit
        Route::get('/edit/{ward_id}', 'Master\WardController@edit')->name('ward/edit');
        Route::post('/edit/submit/{ward_id}', 'Master\WardController@update')->name('ward/edit/submit');
        // delete
        Route::post('/destroy/{ward_id}', 'Master\WardController@destroy')->name('ward/destroy');
        // ajax lấy district theo city_id
        Route::get('/district/{city_id}', 'Master\WardController@getDistrict');
    });

    // COMPANY
    Route::prefix('company')->group(function () {
        Route::get('/', 'Master\CompanyController@index')->name('company/index');
        //create
        Route::get('/create', 'Master\CompanyController@create_render')->name('company/create');
        Route::post('/create', 'Master\CompanyController@create_submit')->name('company/create/submit');
        //edit
        Route::get('/edit/{company_id}', 'Master\CompanyController@edit')->name('company/edit');
        Route::post('/edit/submit/{company_id}', 'Master\CompanyController@update')->name('company/edit/submit');
        // delete
        Route::post('/destroy/{company_id}', 'Master\CompanyController@destroy')->name('company/destroy');
        // Ajax lấy districts theo city_id
        Route::get('/district/{city_id}', 'Master\CompanyController@getDistrict');
        // Ajax lấy wards theo district_id
        Route::get('/ward/{district_id}', 'Master\CompanyController@getWard');
    });

    // WORK
    Route::prefix('work')->group(function () {
        Route::get('/', 'Master\WorkController@index')->name('work/index');
        //create
        Route::get('/create', 'Master\WorkController@create_render')->name('work/create');
        Route::post('/create', 'Master\WorkController@create_submit')->name('work/create/submit');
        //edit
        Route::get('/edit/{work_id}', 'Master\WorkController@edit')->name('work/edit');
        Route::post('/edit/submit/{work_id}', 'Master\WorkController@update')->name('work/edit/submit');
        // delete
        Route::post('/destroy/{work_id}', 'Master\WorkController@destroy')->name('work/destroy');
    });

    // WORK_USER
    Route::prefix('work_user')->group(function () {
        Route::get('/', 'Master\WorkUserController@index')->name('work_user/index');
        // show work_history
        Route::get('/work_history/{user_id}', 'Master\WorkUserController@work_history')->name('work_user/work_history');
        //create
        Route::get('/create', 'Master\WorkUserController@create_render')->name('work_user/create');
        Route::post('/create', 'Master\WorkUserController@create_submit')->name('work_user/create/submit');
        //edit
        Route::get('/edit/{work_user_id}', 'Master\WorkUserController@edit')->name('work_user/edit');
        Route::post('/edit/submit/{work_user_id}', 'Master\WorkUserController@update')->name('work_user/edit/submit');
        // delete
        Route::post('/destroy/{work_user_id}', 'Master\WorkUserController@destroy')->name('work_user/destroy');
    });
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/salary', 'Master\StatisticController@salary')->name('statistic.salary');
    });

    // SEND-MAIL
    Route::prefix('mails')->group(function () {

        // TRANG INDEX
        Route::get('/', 'Master\SendEmailController@index')->name('mails.index');

        //STORE
        Route::get('/store', 'Master\SendEmailController@store')->name('mails.store');
        Route::post('/store', 'Master\SendEmailController@store')->name('mails.store');

        // IMPORT LIST MAILS
        Route::post('/import_list_mails','Master\SendEmailController@import_list_mails')->name('mails.import_list_mails');
    });

    // PHÂN QUYỀN 
    Route::group(['prefix' => 'permissions'], function () {
        
        // 
        Route::get('/','Master\PermissionController@index')->name('permissions/index');

        // INDEX CỦA PHÂN QUYỀN ADMIN
        Route::get('/index_role_admin','Master\PermissionController@index_role_admin')->name('permissions/index_role_admin');

         // INDEX CỦA PHÂN QUYỀN GIẢNG VIÊN
         Route::get('/index_role_teacher','Master\PermissionController@index_role_teacher')->name('permissions/index_role_teacher');

          // INDEX CỦA PHÂN QUYỀN CƯU SINH VIÊN
        Route::get('/index_role_alumni','Master\PermissionController@index_role_alumni')->name('permissions/index_role_alumni');

         // INDEX CỦA PHÂN QUYỀN SINH VIÊN
         Route::get('/index_role_student','Master\PermissionController@index_role_student')->name('permissions/index_role_student');


        Route::get('/create','Master\PermissionController@create')->name('permissions/create');

        Route::post('/store','Master\PermissionController@store')->name('permissions/store');

        Route::get('/show/{role_id}','Master\PermissionController@show')->name('permissions/show');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
