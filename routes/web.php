<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\TeacherAccountController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\ModuleNineController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

Route::get('/', [StudentAuthController::class, 'showLogin'])
    ->middleware('no.back.history')
    ->name('student.login');
Route::get('/login', [StudentAuthController::class, 'showLogin'])
    ->middleware('no.back.history');
Route::post('/login', [StudentAuthController::class, 'login'])
    ->withoutMiddleware([ValidateCsrfToken::class])
    ->middleware('no.back.history')
    ->name('student.login.submit');

Route::get('/about', function () {
    return view('about');
});

Route::get('/maintenance', [PagesController::class, 'maintenance'])->name('maintenance');

Route::middleware(['student.auth', 'no.back.history'])->group(function () {
    Route::get('/change-password', [StudentAuthController::class, 'showChangePassword'])->name('student.password.edit');
    Route::post('/change-password', [StudentAuthController::class, 'updatePassword'])
        ->withoutMiddleware([ValidateCsrfToken::class])
        ->name('student.password.update');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['student.auth', 'student.password.updated', 'no.back.history'])->group(function () {
    Route::get('/student/dashboard', [PortalController::class, 'studentDashboard'])
        ->middleware('role:student')
        ->name('student.dashboard');

    Route::get('/teacher/dashboard', [PortalController::class, 'teacherDashboard'])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('role:student')
        ->name('students.index');

    Route::get('/students/{student}', [StudentController::class, 'show'])
        ->middleware('role:student')
        ->name('students.show');
});

Route::middleware(['student.auth', 'student.password.updated', 'no.back.history', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::patch('/students/{student}', [StudentController::class, 'update']);
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::resource('degrees', DegreeController::class)->names('degrees');

        Route::get('/teachers/create', [TeacherAccountController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [TeacherAccountController::class, 'store'])->name('teachers.store');

        Route::get('/pdf-report', [ModuleNineController::class, 'generatePDF'])->name('pdf.report');

        Route::get('/user_profile', [PagesController::class, 'userProfile'])->name('user_profile');
        Route::get('/user_posts', [PagesController::class, 'userPosts'])->name('user_posts');
        // Route::get('/student_courses', [PagesController::class, 'studentCourses'])->name('student_courses');
});
Route::get('/student_courses', [PagesController::class, 'studentCourses'])->name('student_courses');

// Route::get('/greetings', [StudentController::class, 'greet']);

// //Laboratory Activity 5:
// Route::get('/', [StudentController::class, 'home']);
// Route::get('/about', [StudentController::class, 'displayAbout']);
// Route::resource('students', StudentController::class);


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/greetings', );

// Route::get('/greetings', [StudentController::class, 'greet']);
// Route::get('/profile', [StudentController::class, 'displayProfile']);
// Route::get('/dashboard', [StudentController::class, 'displayDashboard']);
// Route::get('/aboutUs', [StudentController::class, 'displayAboutUs']);

// Route::resource('/student', StudentController::class);

// //Laboratory Activity 4:
// //Part 1: Basic Routing Controller
// Route::get('/welcome', [PSUController::class, 'welcome'])->name("Welcome");
// Route::get('/mission', [PSUController::class, 'mission'])->name("Mission");
// Route::get('/vision', [PSUController::class, 'vision'])->name("Vision");
// Route::get('/EOMSPolicy', [PSUController::class, 'EOMSPolicy'])->name("EOMSPolicy");

// //Part 2: Parameterized Routes
// Route::get('/student/{name?}/{course?}', [PSUController::class, 'student'])->name("Student");

// //Part 3: Resource Controller (Without Database)
// Route::resource(name: 'students', controller: StudentController::class);

// Route::get('/about', [PagesController::class, 'about']);

// Route::get('/add', [CalculateController::class, 'add']);

// Route::get('/subtract', [CalculateController::class, 'subtract']);

// Route::get('/divide', [CalculateController::class, 'divide']);

// Route::get('/multiply', [CalculateController::class, 'multiply']);

// Route::get('/modulo', [CalculateController::class, 'modulo']);

// Route::get('/students', [StudentController::class, 'students']);

// //Task 1: Creating Named Routes
// Route::get('/home', function ($home = "Anne") {
//     return "I am " .$home .". Welcome to the Home Page!";
// })->name("home.page");

// //Task 2: Using Named Routes
// Route::get('/back', function () {
//     return redirect()->route("home.page");
// })->name("backRoute");

// //Task 3: Required Route Parameter
// Route::get('/greet/{name}', function ($name) {
//     return "Hello, " .$name;
// });

// //Task 4: Optional Route Parameter
// Route::get('/student/{name?}', function ($name = "display") {
//     return "Hello Student, " .$name;
// });

// //Task 5: Route Group with Prefix
// Route::prefix('administrator')->group(
//     function(){
//         Route::get('dashboard', function () {
//             return "Dashboard";
//         })->name("administratorDashboard");

//         Route::get('profile', function () {
//             return "Welcome to my Profile";
//         })->name("administratorProfile");

//         Route::get('settings', function () {
//             return "Settings Page";
//         })->name("administratorSettings");
//     }
// );

// //Task 6: Redirect on Route Group
// Route::get('redirectAdminDashboard', function () {
//     return redirect()->route("administratorDashboard");
// })->name("redirectAdminDashboard");


// Route::get('/home', function () {
//     return "Welcome to Home Page";
// })->name("homeRoute");

// Route::get('/login', function () {
//     return "Enter your Username and Password";
// })->name("loginRoute");

// Route::get('/logout', function () {
//     return redirect()->route("loginRoute");
// })->name("logoutRoute");

// Route::get('users/{id}', function ($id) {
//     return "User ID" .$id;
// })->where('id','[0-9]+')->name("userRoute");

// //student routes
// Route::prefix('student')->group(
//     function(){
//         Route::get('/profile', function () {
//             return "This is Student Profile Page";
//         })->name("studentProfileRoute");

//         Route::get('/dashboard', function () {
//             return "This is Student Dashboard Page";
//         })->name("studentDashboardRoute");

//         Route::get('/friendlist', function () {
//             return "This is Student Friend List Page";
//         })->name("studentFriendRoute");
//     }
// );
