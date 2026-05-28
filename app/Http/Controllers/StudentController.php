<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Degree;
use App\Models\UserAccounts;
use Illuminate\Support\Facades\DB;
use Log;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('degree')->paginate(5);
        return view('students.index', compact('students'));
    }

    public function create() 
    {
        $degrees = Degree::all();
        return view('students.create', compact('degrees')); 
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'first_name'=>'required|alpha|min:2',
            'last_name'=>'required|alpha|min:2',
            'age'=>'required|numeric',
            'address'=>'required',
            'contact_number'=>'required|digits:11',
            'email'=>'required|email|unique:students,email|unique:user_accounts,email',
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'password' => 'required|string|min:8',
            'degree_id'=>'required'
        ]);

        $msg = "Student is Added!";
        Log::notice($msg);

        // $validator = Validator::make($request->all(),[
        //     'first_name'=>'required|min:2',
        //     'last_name'=>'required|min:2',
        //     'age'=>'required|numeric',
        //     'address'=>'required',
        //     'contact_number'=>'required|digits:11',
        //     'email'=>'required|email|unique:students,email',
        //     'degree_id'=>'required'
        // ]);

        // if($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $student = null;

        DB::transaction(function () use ($request, &$student) {
            $userAccount = UserAccounts::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_BCRYPT),
                'role' => 'student',
                'is_active' => 1,
                'must_change_password' => 1,
            ]);

            $student = Student::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'age' => $request->age,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'degree_id' => $request->degree_id,
                'user_account_id' => $userAccount->id,
            ]);
        });

        if ($request->ajax()) {
            $request->session()->flash('message', 'Student Added Successfully!');
            return response()->json($student);
        }

        return redirect()->route($this->indexRoute())->with('message', 'Student Added Successfully!');
    }
    
    public function show(string $id) 
    {

        $student = Student::findOrFail($id);
        return view('students.show', compact('student')); 
    }
    
    public function edit(string $id) 
    { 
        $student = Student::findOrFail($id);
        $degrees = Degree::all();
        return view('students.edit', compact('student','degrees'));
    }

    public function update(Request $request, string $id) 
    {
        $request->validate([
            'first_name'=>'required|alpha|min:2',
            'last_name'=>'required|alpha|min:2',
            'age'=>'required|numeric',
            'address'=>'required',
            'contact_number'=>'required|digits:11',
            'email'=>'required|email|unique:students,email,' . $id,
            'degree_id'=>'required'
        ]);

        $msg = "Student is Edited!";
        Log::notice($msg);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        if ($request->ajax()) {
            $request->session()->flash('message', 'Student updated successfully.');
            return response()->json($student->fresh());
        }

        return redirect()->route($this->indexRoute());
    }

    public function destroy(Request $request, string $id) 
    {
        $msg = "Student is Deleted!";
        Log::warning($msg);
        
        $student = Student::findOrFail($id);
        $studentData = $student->toArray();
        $student->delete();

        if ($request->ajax()) {
            $request->session()->flash('message', 'Student deleted successfully.');
            return response()->json($studentData);
        }

        return redirect()->route($this->indexRoute());
    }

    protected function indexRoute(): string
    {
        return session('user_role') === 'admin'
            ? 'admin.students.index'
            : 'students.index';
    }
}
