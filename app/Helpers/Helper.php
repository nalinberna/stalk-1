<?php

namespace App\Helpers;

use App\Models\User\Role;
use App\Models\Student\Subject;
use App\Models\Category\Level;
use App\Models\Student\District;
/**
 * This contains all helper methods
 */
class Helper 
{

    /**
     * Returns all roles
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allRoles($request,$response)
    {
        $roles = Role::all();

        return $roles;

    }

    /**
     * All District
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allDistricts($request,$response)
    {
        return District::orderBy('district_name','ASC')->get();
    }

    /**
     * Levels
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allLevels($request,$response)
    {
        return Level::all();
    }

    /**
     * All subjects
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allSubjects($request,$response)
    { 
        return Subject::where('deleted','0')->orderBy('name','ASC')->get();

    }



}