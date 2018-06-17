<?php
namespace App\Controllers;

use App\Models\User\User;
use App\Models\Category\Bank;
use App\Models\Student\Course;
use App\Models\Student\Subject;
use App\Models\Category\School;
use App\Models\Category\Hostel;
use App\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\Student\District;
use App\Models\Student\Secondary;
use App\Models\Student\Institution;
use App\Models\Student\StudentSubject;

class HomeController  extends Controller
{

    /**
     * home
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function index($request,$response,$args)
    {
        $students = Student::where('deleted','0')->count();
        $courses  = Course::where('deleted','0')->count();
        $schools  = School::count();
        $hostels  = Hostel::where('deleted','0')->count();
        $subjects = Subject::where('deleted','0')->count();
        $users    = User::where('deleted','0')->count();
        $banks    = Bank::count();
 
        return $this->view->render($response,'dashboard/dashboard.twig',[
            'students' => $students,
            'courses'  => $courses,
            'schools'  => $schools,
            'hostels'  => $hostels,
            'subjects' => $subjects,
            'users'    => $users,
            'banks'    => $banks
        ]);

    }

    public function home($request,$response)
    {
        return 'home';
    }


}