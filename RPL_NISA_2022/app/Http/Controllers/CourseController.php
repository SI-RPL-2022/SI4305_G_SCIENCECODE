<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Session;

class CourseController extends Controller
{
    public function enrollList(){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $category = new Category();

        $data = [
            'course' => $course->data()->get(),
            'category' => $category->data()->get(),
        ];
    	return view('dashboard/course/index', $data);
    }

    public function enrollNow($course_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);
        if($query->count() == 0){
            return redirect('course');
        }

        $userData = Session::get('user');
        if($course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('course/'.$course_id)->with('alert', show_alert('Course ini sudah pernah di-enroll', 'danger'));
        }

        $course->insertEnrollment([
            'user_id' => $userData->id,
            'course_id' => $course_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('dashboard/enrollment');
    }
}
