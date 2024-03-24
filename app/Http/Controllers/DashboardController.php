<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; 
use App\Models\Course; 

class DashboardController extends Controller
{
    public function index() {
        $studentCount = Student::count();
        $courseCount = Course::count();
       
        
        return view('dashboard', compact('studentCount', 'courseCount'));
    }
}
