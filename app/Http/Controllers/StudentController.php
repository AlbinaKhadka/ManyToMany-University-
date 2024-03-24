<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; 
use App\Models\Course;  

class StudentController extends Controller
{
    public function addStudent(Request $request) {
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->contact = $request->contact; 
        if (is_array($request->course)) {
            $courses = $request->course; 
        } else {
            $courses = [$request->course]; 
        }
    
        if ($student->save()) {
            
            $student->courses()->sync($courses); 
        }
    
        return response()->json(['message' => 'Student added successfully']);
    }
    public function editStudent($id) {
        {
            $student = Student::with('courses')->findOrFail($id);
            $courses = Course::all();
            return view('editStudent', compact('student', 'courses'));
        }
    }
            public function update(Request $request, $id)
            {
                $student = Student::findOrFail($id);
                $student->update($request->only(['name', 'email', 'address', 'contact']));
                
                if ($request->has('courses')) {
                    $student->courses()->sync($request->courses);
                }
            
                return redirect()->route('students.index')->with('success', 'Student updated successfully');
            }
    
    public function deleteStudent($id) {
        $students = Student::find($id);
        // $student->courses()->detach();
        
        $students->delete();
       
        // if(!$student){
        //     return Response::json(['error' => 'Student not found'], 404);

        // }
       return response()->json(['message'=>'Student deleted successfully']);
   

}




    public function getStudent($id) {
        $students = Student::with('courses')->find($id);

        if (!$students) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        return response()->json($students);
    }
    

   
    public function studentList() {
     // $students = Student::with('courses')->get();
      $students = Student::with('courses')->paginate(5);
    //  dd($students);
        //return response()->json($students);
        return view('studentList', compact('students'));
    }
    public function show() {
        $students = Student::all(); 
        return view('Dashboard', compact('students'));
    }
   public function trash(){
    $trashedstudents = Student::onlyTrashed()->get();
    return view('student_trash', compact('trashedstudents'));
    // return response()->json($trashedstudents);


   }
   public function destroy($id)
   {
       $student = Student::withTrashed()->findOrFail($id);
       $student->courses()->detach();
       $student->forceDelete(); 
   
    //    return redirect()->route('student_trash')->with('success', 'Student deleted successfully.');
    return response()->json(['message' => 'Student deleted successfully.']);
   }
   

    public function restore($id)
    {
        
        $student = Student::withTrashed()->find($id);
        if ($student) {
            $student->restore();
            // return redirect()->route('student_trash')->with('success', 'Student restored successfully.');
            return response()->json(['message' => 'Student restored successfully.']);
        }
        return response()->json(['error' => 'Student not found.'], 404);
    }
    public function showDashboard() {
        return view('dashboard'); 
    }
    public function index() {
       
        return view('dashboard');
    }
    
    // public function getStudents() {
    //     $students = Student::paginate(5); 
    //     return response()->json($students);
    // }
}



    


