<?php

/**
 * 
 * This contains all the web routes
 * 
 */

use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;



$app->group('',function(){
    $this->get('/','LoginController:index')->setName('auth.login');
    $this->post('/','LoginController:authenticate');
})->add( new GuestMiddleware($container));


$app->group('', function(){
    $this->get('/logout','LoginController:logout')->setName('auth.logout');
    
    $this->get('/dashboard','HomeController:index')->setName('dashboard');
    
    $this->get('/register','RegistrationController:create')->setName('auth.register');
    $this->post('/register','RegistrationController:store')->setName('auth.store');
    
    // users
    $this->get('/users','UserController:index')->setName('user.index');
    $this->post('/users','UserController:search')->setName('user.search');
    $this->get('/users/{id}/edit','UserController:edit')->setName('user.edit');
    $this->put('/users/{id}/edit','UserController:update'); 
    $this->put('/users/{id}/trash','UserController:trashUser')->setName('user.trash');

    // subjects
    $this->get('/subjects','SubjectController:index')->setName('subject.index');
    
    $this->get('/subjects/create','SubjectController:create')->setName('subject.create');
    $this->post('/subjects/create','SubjectController:store');
    $this->post('/subjects','SubjectController:search');

    $this->get('/subject/{id}/edit','SubjectController:edit')->setName('subject.edit');
    $this->put('/subject/{id}/edit','SubjectController:update');
    $this->put('/subject/{id}/trash','SubjectController:trash')->setName('subject.trash');

    // courses

    $this->get('/courses','CourseController:index')->setName('course.index');
    
    $this->get('/courses/create','CourseController:create')->setName('course.create');
    $this->post('/courses/create','CourseController:store');

    $this->get('/course/{id}/edit','CourseController:edit')->setName('course.edit');
    $this->put('/course/{id}/edit','CourseController:update');
    $this->put('/course/{id}/trash','CourseController:trash')->setName('course.trash');
  
    // Students
    $this->get('/students','StudentController:index')->setName('student.index');
    
    $this->get('/students/create','StudentController:create')->setName('student.create');
    $this->post('/students/create','StudentController:store');

    $this->get('/students/secondary','SecondaryController:create')->setName('secondary.create');
    $this->post('/students/secondary','SecondaryController:store');


    // schools
    $this->get('/schools','SchoolController:index')->setName('school.index');
    $this->post('/schools','SchoolController:search');
    
    // create
    $this->get('/schools/create','SchoolController:create')->setName('school.create');
    $this->post('/schools/create','SchoolController:store');

    //update
    $this->get('/schools/{id}/update','SchoolController:edit')->setName('school.edit');
    $this->post('/schools/{id}/update','SchoolController:update'); 


    // Banks
    $this->get('/banks','BankController:index')->setName('bank.index');
    $this->post('/banks','BankController:search');
    // create
    $this->get('/banks/create','BankController:create')->setName('bank.create');
    $this->post('/banks/create','BankController:store');
    // update
    $this->get('/banks/{id}/update','BankController:edit')->setName('bank.edit');
    $this->post('/banks/{id}/update','BankController:update');


})->add( new AuthMiddleware($container));


