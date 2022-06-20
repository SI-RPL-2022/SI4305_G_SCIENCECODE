<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Session;

class FrontpageController extends Controller
{
    public function index(){
        $course = new Course();
        $category = new Category();

        $data = [
            'course' => $course->data()->limit(3)->where('total_material', '>', '0')->orderBy('course.id', 'desc')->get(),
            'category' => $category->data()->get(),
        ];
    	return view('home', $data);
    }

    public function course(Request $request){
        $course = new Course();
        $category = new Category();
        $search = [];

        if($request->get('category_id') != ''){
            $search['category_id'] = $request->get('category_id');
        }

        $data = [
            'course' => $course->data($search)->get(),
            'category' => $category->data()->get(),
        ];
        return view('frontend/course/index', $data);
    }

    public function courseDetail(Request $request, $course_id){
        $course = new Course();
        $search = [];

        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('course');
        }

        $data = [
            'course'  => $query->first(),
            'sections' => $course->getSectionWithMaterial($course_id),
            'rating'   => $course->getRatingOverview($course_id)
        ];

        return view('frontend/course/detail', $data);
    }

    public function courseContent($course_id, $material_id){
        $course = new Course();
        $courseQuery = $course->data('course.id', $course_id);
        if($courseQuery->count() == 0){
            return redirect('course');
        }

        $materialQuery = $course->getMaterialByID($material_id);
        if($materialQuery->count() == 0){
            return redirect('course/'.$course_id);
        }
        $courseData = $courseQuery->first();
        $materialData = $materialQuery->first();

        if($materialData->is_overview == '0'){
            if(!Session::has('user')){
                return redirect('auth/login');
            }
            
            $userData = Session::get('user');
            if(!$course->checkEnrollmentAccess($userData->id, $course_id)){
                redirect('course/'.$course_id.'/material/'.$material_id);
            }
        }

        $data = [
            'course' => $courseData,
            'material' => $materialData
        ];
        return view('frontend/course/content', $data);
    }

    public function login(){
    	return view('auth/login');
    }

    public function register(){
    	return view('auth/register');
    }

    public function do_register(Request $request){
    	$request->validate([
            'name'    	=> 'required',
            'email'     => 'required',
            'password'  => 'required',
            'phone'   	=> 'required'
        ]);

        $input = $request->except(['_token']);
        $input['role'] = 'user';
        $user = new User();

        if($user->data('email', $input['email'])->count() > 0){
        	return redirect('auth/register')->with('alert', show_alert('Email sudah terdaftar, coba gunakan email yang lain', 'danger'));
        }

        $user->create($input);
        return redirect('auth/login')->with('alert', show_alert('Pendaftaran berhasil, silahkan login menggunakan akun anda', 'success'));
    }

    public function do_login(Request $request){
    	$request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        $input = $request->except(['_token']);
        $user = new User();
        $query = $user->data($input);
        if($query->count() == 0){
        	return redirect('auth/login')->with('alert', show_alert('Akun tidak terdaftar, silahkan melakukan registrasi akun terlebih dahulu', 'danger'));
        }

        $userData = $query->first();
        Session::put('user', $userData);

        $redirectTo = in_array($userData->role, ['admin', 'instructor']) ? 'dashboard' : '';
        return redirect($redirectTo);
    }

    public function dashboard(){
        if(!Session::has('user')){
            return redirect('auth/login');
        }

        $data = [];
    	$userData = Session::get('user');
    	return view('dashboard/index', $data);
    }

    public function profile(){
    	$userData = Session::get('user');
    	if(!$userData){
    		return redirect('auth/login');
    	}
    	
    	return view('profile');
    }

    public function do_logout(){
    	Session::flush();
    	return redirect('auth/login');
    }
}
