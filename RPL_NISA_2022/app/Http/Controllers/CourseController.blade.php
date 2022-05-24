<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Session;

class CourseController extends Controller
{
    public function index(){
        $course = new Course();
        $category = new Category();

        $data = [
            'course' => $course->data()->get(),
            'category' => $category->data()->get(),
        ];
    	return view('dashboard/course/index', $data);
    }
}
