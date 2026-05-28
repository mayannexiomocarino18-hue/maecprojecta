<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'address',
        'contact_number',
        'email',
        'degree_id',
        'user_account_id'
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'course__students', 'student_id', 'course_id');
    }

    public function userAccounts() 
    {
        return $this->belongsTo(UserAccounts::class, 'user_account_id');
    }
}
