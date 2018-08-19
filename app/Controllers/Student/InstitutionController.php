<?php
namespace App\Controllers\Student;


use App\Controllers\Controller;
use App\Models\Category\Hostel;
use App\Models\Student\Student;
use App\Models\Student\Reason;
use App\Models\Student\Course;
use App\Models\Category\School;
use App\Models\Student\Institution;
use App\Models\Category\Qualification;
use Respect\Validation\Validator as v;
class InstitutionController extends Controller
{
   

    /**
     * Return institution create view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function create($request,$response,$args)
    {
        // check for student session
        if(!isset($_SESSION['student_id']))
        {
            $this->flash->addMessage('danger','Please start a new student registration from here');
            return $response->withRedirect($this->router->pathFor('student.create'));
        }
        

       $institutions = $this->helper->allInstitutions();
       $qualification = Qualification::all();
    
        return $this->view->render($response,'student/institution/create.twig',[
            'institutions'   => $institutions,
            'qualifications' => $qualification
        ]);
    }

    /**
     * Store additional info
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function store($request,$response,$args)
    {

        // validation
        $validator = $this->Validator->validate($request,[
            'institution_name'          => v::notEmpty(),
            'course_id'                 => v::notEmpty(),
            'qualification'             => v::notEmpty(),
            'registration_number'       => v::notEmpty(),
            'hostel_id'                 => v::notEmpty(),
            's_form'                    => v::notEmpty(),
            'student_bank_name'         => v::notEmpty(),
            'student_bank_account'      => v::notEmpty(),
            'student_bank_address'      => v::notEmpty(),
            // 'student_number'            => v::notEmpty(),
            // 'other_bank_name'           => v::notEmpty(),
            // 'other_bank_account'        => v::notEmpty(),
            // 'other_bank_address'        => v::notEmpty(),
        ]);

        // validation failed
        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('institution.create'));
        }

          //    check if the student id is already in the databse
     
          $isAvailable = Institution::where('student_id','=',$_SESSION['student_id'])->count();
        
       
         if($isAvailable < 3){

        // Save data

        $institution = Institution::create([
                        'school_id'                => ucwords($request->getParam('institution_name')),
                        'course_id'                => $request->getParam('course_id'),
                        'student_id'               => $_SESSION['student_id'],
                        'qualification'            => $request->getParam('qualification'),
                        'student_number'           => $request->getParam('student_number'),
                        'registration_number'      => $request->getParam('registration_number'),
                        'hostel_id'                => $request->getParam('hostel_id'),
                        's_form'                   => $request->getParam('s_form'),
                        'student_bank_name'        => $request->getParam('student_bank_name'),
                        'student_bank_account'     => $request->getParam('student_bank_account'),
                        'student_bank_address'     => $request->getParam('student_bank_address'),
                        'other_bank_name'          => $request->getParam('other_bank_name'),
                        'other_bank_account'       => $request->getParam('other_bank_account'),
                        'other_bank_address'       => $request->getParam('other_bank_address'),
                        'myear_start'              => $_SESSION['year_start'],
                        'myear_stop'              => $_SESSION['year_stop'],
                        'created_by'               => ucwords($this->auth->user()->name)
                    ]);


         }
         else
         {
            $institution = Institution::where('student_id','=',$_SESSION['student_id'])
                                        ->orderBy('id','DESC')
                                        ->first();
            
            
         }
    
        /**
         * Update student school and level
         * 
         */
        
        $student =  Student::where('bursary_id','=',$institution->student_id)->first();
        
        $update  = $student->update([
                'school'   => $institution->school_id,
                's_form'   => $institution->s_form,
                'level'    => $_SESSION['level'],
                'draft'    => '0'
            ]);   
        
        // unsetting session
        unset($_SESSION['student_id']);
        unset($_SESSION['year_start']);
        unset($_SESSION['year_stop']);
        unset($_SESSION['level']);
        
        // flash message
        $this->flash->addMessage('success','Student registration has been successfully completed');

        return $response->withRedirect($this->router->pathFor('student.index'));  

    }

    /**
     * Return institution edit
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $institution = Institution::find($args['id']);

        
        //get student
        $student = Student::where('bursary_id', '=',$institution->student_id)->first();
               
        // get school name
        $school = School::where('id','=',$institution->school_id)->get();

        // pull category
        $institutions = $this->helper->allInstitutions();
        $qualification = Qualification::all();

        // hostel
        $hostel = Hostel::find($institution->hostel_id);
        // course
        $course  = Course::find($institution->course_id);



        return $this->view->render($response,'student/personal/partial/institution_edit.twig',[
            'info'               => $institution,
            'school'             => $school[0],
            'student'            => $student,
            'path'               => $this->files->fileDir(),
            'institutions'       => $institutions,
            'qualifications'     => $qualification,
            'hostel'             => $hostel,
            'course'             => $course,
        ]);

    }

    /**
     * Update information
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {

        $institution = Institution::find($args['id']);
         // validation
         $validator = $this->Validator->validate($request,[
            'institution_name'          => v::notEmpty(),
            'course_id'                 => v::notEmpty(),
            'qualification'             => v::notEmpty(),
            'registration_number'       => v::notEmpty(),
            'hostel_id'                 => v::notEmpty(),
            's_form'                    => v::notEmpty(),
            'student_bank_name'         => v::notEmpty(),
            'student_bank_account'      => v::notEmpty(),
            'student_bank_address'      => v::notEmpty(),
      
            'reasons'                   => v::notEmpty(),
            // 'other_bank_name'           => v::notEmpty(),
            // 'other_bank_account'        => v::notEmpty(),
            // 'other_bank_address'        => v::notEmpty(),
        ]);

        // validation failed
        if($validator->failed())
        {

            return $response->withRedirect($this->router->pathFor('institution.edit',[
                'id' => $args['id']
            ]));
        }

        /**
         * Update the information
         */

        $update = $institution->update([
            'school_id'                => ucwords($request->getParam('institution_name')),
            'course_id'                => $request->getParam('course_id'),
            'qualification'            => $request->getParam('qualification'),
            'student_number'           => $request->getParam('student_number'),
            'registration_number'      => $request->getParam('registration_number'),
            'hostel_id'                => $request->getParam('hostel_id'),
            's_form'                   => $request->getParam('s_form'),
            'student_bank_name'        => $request->getParam('student_bank_name'),
            'student_bank_account'     => $request->getParam('student_bank_account'),
            'student_bank_address'     => $request->getParam('student_bank_address'),
            'other_bank_name'          => $request->getParam('other_bank_name'),
            'other_bank_account'       => $request->getParam('other_bank_account'),
            'other_bank_address'       => $request->getParam('other_bank_address'),
            
        ]);

        /**
        * Update student school and level
        * 
        */
        $new_data = Institution::find($args['id']);

        // $this->students->schoolForm($new_data->student_id,$new_data);

        $latest = Student::where('bursary_id', '=',$new_data->student_id)->first();

        $update  = $latest->update([
            'school'   => $new_data->school_id,
            's_form'   => $new_data->s_form,
            'draft'    => '0'
        ]); 
        
        
         /**
         * 
         * Create Reason for update
         * 
         */

        Reason::create([
            'reason'       => nl2br(ltrim(rtrim($request->getParam('reasons')))),
            'student_name' => $latest->name,
            'bursary_id'   => $latest->bursary_id,
            'user_name'    => $this->auth->user()->name,
            'user_id'      => $this->auth->user()->id,
        ]);
       /**
        * 
        * Log update information
        */
       $this->log->updateLog('UPDATE',$latest->name,$latest->bursary_id,nl2br(ltrim(rtrim($request->getParam('reasons')))));
       


        //   add a flash message
        $this->flash->addMessage('success', 'Information has been updated successfully');
        
        return $response->withRedirect($this->router->pathFor('institution.edit',[
            'id' => $new_data->id
        ]));

    }

}
