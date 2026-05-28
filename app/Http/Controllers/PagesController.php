<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;

class PagesController extends Controller
{
    public function about() {
    
    $a = 1;
    $b = 2;
    $sum = $a + $b;
    return "Sum is: " . $sum;
    }

    public function userProfile() {
        $user = User::find(1);
        echo $user->name." - ".$user->profile->bio;
    }

    public function userPosts() {
        $user = User::find(1);
        foreach($user->posts as $post) {
            echo "$user->name: $post->title - $post->content<br>";
        }
    }

    public function studentCourses() {
        $student = Student::find(1);
        foreach($student->courses as $course) {
            echo "$student->first_name $student->last_name is enrolled in: $course->course_name<br>";
        }
    }

    public function maintenance() {
        return view('maintenance');
    }
}
