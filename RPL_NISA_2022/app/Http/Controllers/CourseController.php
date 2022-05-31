<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Transaction;
use Session;

class CourseController extends Controller
{
    public function enrollList(){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $user_id = Session::get('user')->id;
        $data = [
            'course' => $course->getEnrollmentList($user_id),
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

    public function enrollDetail($enroll_id, $course_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }
        
        $data = [
            'course'   => $query->first(),
            'sections' => $course->getSectionWithMaterialEnroll($enroll_id, $course_id),
            'enroll'   => $course->getEnrollData($userData->id, $course_id),
            'totalDone' => $course->getProgressDoneByEnroll($enroll_id),
            'rating'   => $course->getRatingByUserID($course_id, $userData->id)
        ];
        return view('dashboard/course/detail', $data);
    }

    public function enrollContent(Request $request, $enroll_id, $course_id, $material_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }

        $materialQuery = $course->getMaterialByID($material_id);
        if($materialQuery->count() == 0){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                   ->with('alert', show_alert('Data materi tidak ditemukan', 'danger'));
        }
        
        $data = [
            'course'   => $query->first(),
            'material' => $materialQuery->first(),
            'enrollMaterial' => $course->getEnrollMaterial($enroll_id, $material_id)   
        ];

        if($data['material']->material_type == 'quiz'){
            $quiz = new Quiz();
            $view = $course->checkEnrollIsDone($enroll_id, $material_id) ? 'quizFinished' : 'quiz';

            $searchQuiz['material_id'] = $material_id;
            if($request->input('quiz_id') != ''){
                $data['quiz'] = $quiz->data([
                                    'id' => $request->input('quiz_id'),
                                    'material_id' => $material_id
                                ])->first();

            }else{
                $data['quiz'] = $quiz->getFirstQuestion($material_id);
            }

            if(!$data['quiz']){
                return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id.'/material/'.$material_id)
                       ->with('alert', show_alert('Data quiz tidak ditemukan', 'danger'));
            }

            $data['quizOption']  = $quiz->getOption($data['quiz']->id);
            if(!$data['quizOption']){
                return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                       ->with('alert', show_alert('Quiz tidak memiki opsi jawaban', 'danger'));
            }

            $data['quizControl'] = $quiz->getQuizControl($material_id, $data['quiz']->id);
            $data['quizNumber']  = $quiz->getQuizNumber($material_id, $userData->id);


        }else{
            $view = 'content';
            $data['discussion'] = $course->getEnrollDiscussion($userData->id, $material_id);
        }

        return view('dashboard/course/'.$view, $data);
    }

    public function enrollDone($enroll_id, $course_id, $material_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }

        $materialQuery = $course->getMaterialByID($material_id);
        if($materialQuery->count() == 0){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                   ->with('alert', show_alert('Data materi tidak ditemukan'));
        }
        
        $course->enrollMaterialDone($enroll_id, $material_id);

        $totalDone = $course->getProgressDoneByEnroll($enroll_id);
        $totalMaterial = $query->first()->total_material;
        if($totalDone == $totalMaterial){
            $course->enrollDone($enroll_id);
        }

        return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id.'/material/'.$material_id)
                   ->with('alert', show_alert('Materi berhasil ditandai', 'success'));
    }

    public function certificate($enroll_id, $course_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }

        $enrollData = $course->getEnrollData($userData->id, $course_id);
        if($enrollData->is_done == '0'){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)->with('alert', show_alert('Anda belum menyelesaikan course ini', 'danger'));
        }

        $data = [
            'course' => $course->first(),
            'user'   => $userData
        ];
        return view('dashboard/course/certificate', $data);
    }

    public function sendQuestion(Request $request, $enroll_id, $course_id, $material_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }

        $materialQuery = $course->getMaterialByID($material_id);
        if($materialQuery->count() == 0){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                   ->with('alert', show_alert('Data materi tidak ditemukan', 'danger'));
        }

        $input = $request->except(['_token']);
        $course->insertDiscussion([
            'material_id' => $material_id,
            'user_id'     => $userData->id,
            'disscussion' => $input['disscussion'],
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id.'/material/'.$material_id)
                   ->with('alert', show_alert('Pertanyaan berhasil dikirim', 'success'));
    }

    public function insertRating(Request $request, $enroll_id, $course_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if(!$course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('dashboard/enrollment')->with('alert', show_alert('Anda belum melakukan enroll pada course ini', 'danger'));
        }

        $input = $request->except(['_token']);
        $course->insertRating([
            'course_id'   => $course_id,
            'user_id'     => $userData->id,
            'rating'      => $input['rating'],
            'review'      => $input['review'],
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                   ->with('alert', show_alert('Review berhasil dikirim', 'success'));
    }

    public function buyCourse($course_id){
        if(!is_user()) return redirect('auth/login');

        $course = new Course();
        $query = $course->data('course.id', $course_id);

        if($query->count() == 0){
            return redirect('course/'.$course_id)->with('alert', show_alert('Course tidak ditemukan', 'danger'));
        }

        $userData = Session::get('user');
        if($course->checkEnrollIsExist($userData->id, $course_id)){
            return redirect('course/'.$course_id)->with('alert', show_alert('Anda sudah melakukan enroll pada course ini', 'danger'));
        }

        $transaction = new Transaction();
        $checkTransaction = $transaction->data([
                                'user_id' => $userData->id,
                                'course_id' => $course_id
                            ]);

        if($checkTransaction->count() > 0){
            $transData = $checkTransaction->first();
            if(in_array($transData->status, ['complete', 'pending'])){
                 return redirect('dashboard/transaction/'.$transData->id)->with('alert', show_alert('Course ini sudah pernah kamu proses', 'danger'));
            }
        }

        $trans_id = $transaction->create([
            'course_id' => $course_id,
            'user_id' => $userData->id,
            'status' => 'pending',
            'total_price' => $query->first()->course_price,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('dashboard/transaction/'.$trans_id)->with('alert', show_alert('Silahkan lakukan pembayaran', 'success'));
    }

    public function index(){
        if(!is_admin()) return redirect('auth/login');
        $course = new Course();

        $data['course'] = $course->data()->get();
        return view('admin/course/index', $data);
    }

    public function detail($course_id){
        if(!is_admin()) return redirect('auth/login');
        
        $course = new Course();
        $query = $course->data('course.id', $course_id);
        if($query->count() == 0){
            return redirect('dashboard/admin/course/')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $data = [
            'course' => $query->first(),
            'enrollmentUser'  => $course->getEnrollmentUserList($course_id)
        ];
        return view('admin/course/detail', $data);
    }

    public function instructorCourseList(){
        if(!is_instructor()) return redirect('auth/login');

        $course = new Course();

        $userData = Session::get('user');
        $data['course'] = $course->data('instructor_id', $userData->id)->get();
        return view('instructor/course/index', $data);
    }

    public function instructorCourseDetail($course_id){
        if(!is_instructor()) return redirect('auth/login');
        
        $userData = Session::get('user');
        $course = new Course();
        $query = $course->data([
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course/')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $data = [
            'course' => $query->first(),
            'enrollmentUser'  => $course->getEnrollmentUserList($course_id)
        ];
        return view('instructor/course/detail', $data);
    }

    public function instructorCourseAdd(){
        if(!is_instructor()) return redirect('auth/login');

        $category = new Category();
        $data['category'] = $category->data()->get();
        return view('instructor/course/add', $data);
    }

    public function instructorCourseInsert(Request $request){
        if(!is_instructor()) return redirect('auth/login');

        $request->validate([
            'course_name'          => 'required',
            'course_description'   => 'required',
            'price_type'           => 'required',
            'category_id'          => 'required',
            'course_image'         => 'required|mimes:jpeg,jpg,png'
        ]);

        $imageName = 'course_'.time().'.'.$request->file('course_image')->extension();  
        $request->file('course_image')->move(public_path('images/course'), $imageName);

        $input = $request->except(['_token']);
        if($input['price_type'] == 'free'){
            $input['course_price'] = 0;
        }

        $userData = Session::get('user');
        $input['instructor_id'] = $userData->id;
        $input['course_image'] = $imageName;
        $input['created_at'] = date('Y-m-d H:i:s');

        $course = new Course();
        $course_id = $course->create($input);
        return redirect('dashboard/instructor/course/'.$course_id)->with('alert', show_alert('Course berhasil dibuat', 'success'));
    }

    public function instructorCourseEdit($course_id){
        if(!is_instructor()) return redirect('auth/login');
        
        $userData = Session::get('user');
        $course = new Course();
        $query = $course->data([
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course/')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $category = new Category();
        $data = [
            'course' => $query->first(),
            'category' => $category->data()->get()
        ];
        return view('instructor/course/edit', $data);
    }

    public function instructorCourseUpdate(Request $request, $course_id){
        if(!is_instructor()) return redirect('auth/login');

        $request->validate([
            'course_name'          => 'required',
            'course_description'   => 'required',
            'price_type'           => 'required',
            'category_id'          => 'required',
            'course_image'         => 'mimes:jpeg,jpg,png'
        ]);

        $input = $request->except(['_token']);
        if($input['price_type'] == 'free'){
            $input['course_price'] = 0;
        }

        if(isset($input['course_image'])){
            $imageName = 'course_'.time().'.'.$request->file('course_image')->extension();  
            $request->file('course_image')->move(public_path('images/course'), $imageName);
            $input['course_image'] = $imageName;
        }  

        $input['updated_at'] = date('Y-m-d H:i:s');

        $course = new Course();
        $course->updates($input, $course_id);
        return redirect('dashboard/instructor/course/'.$course_id)->with('alert', show_alert('Course berhasil diubah', 'success'));
    }

    public function instructorCourseDelete(Request $request, $course_id){
        if(!is_instructor()) return redirect('auth/login');

        $course = new Course();
        $userData = Session::get('user');
        $query = $course->data([
                    'course.id' => $course_id,
                    'instructor_id' => $userData->id
                 ]);
        if($query->count() == 0){
            return redirect('dashboard/instructor/course/'.$course_id)->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        if($course->countEnrollment($course_id) > 0){
            return redirect('dashboard/instructor/course/')->with('alert', show_alert('Tidak dapat menghapus course yang sudah dienroll', 'danger'));
        }

        $course->deletes($course_id);
        return redirect('dashboard/instructor/course/'.$course_id)->with('alert', show_alert('Course berhasil dihapus', 'success'));
    }

    public function instructorCourseMaterial($course_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->data([
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course/')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $data = [
            'course' => $query->first(),
            'section' => $course->getSectionWithMaterial($course_id)
        ];
        return view('instructor/course/section/index', $data);
    }

    public function instructorAddSection($course_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->data([
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $data['course'] = $query->first();
        return view('instructor/course/section/add', $data);
    }

    public function instructorEditSection($course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course.id' => $course_id,
            'instructor_id' => $userData->id,
            'course_section.id' => $section_id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course atau section tidak ditemukan', 'danger'));
        }

        $data = [
            'course'  => $query->first(),
        ];
        return view('instructor/course/section/edit', $data);
    }

    public function instructorInsertSection(Request $request, $course_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->data([
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $request->validate([
            'section_name' => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['course_id'] = $course_id;
        $input['created_at'] = date('Y-m-d H:i:s');

        $course = new Course();
        $course->insertSection($input);
        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Section berhasil ditambahkan', 'success'));
    }

    public function instructorUpdateSection(Request $request, $course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course.id' => $course_id,
            'instructor_id' => $userData->id,
            'course_section.id' => $section_id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course atau section tidak ditemukan', 'danger'));
        }

        $request->validate([
            'section_name' => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['course_id'] = $course_id;
        $input['updated_at'] = date('Y-m-d H:i:s');

        $course->updateSection($input, $section_id);
        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Section berhasil diubah', 'success'));
    }

    public function instructorDeleteSection(Request $request, $course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id,
            'course_section.id' => $section_id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course atau section tidak ditemukan', 'danger'));
        }

        $course->deleteSection($section_id);
        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Section berhasil dihapus', 'success'));
    }

    public function instructorAddMaterialVideo($course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');
        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id,
            'course_section.id' => $section_id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course atau section tidak ditemukan', 'danger'));
        }

        $data['course'] = $query->first();
        return view('instructor/course/material/video/add', $data);
    }

    public function instructorAddMaterialQuiz($course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');
        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id,
            'course_section.id' => $section_id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course atau section tidak ditemukan', 'danger'));
        }

        $data['course'] = $query->first();
        return view('instructor/course/material/quiz/add', $data);
    }

    public function instructorInsertMaterial(Request $request, $material_type, $course_id, $section_id){
        if(!is_instructor()) return redirect('auth/login');
        if(!in_array($material_type, ['video', 'quiz']))  return redirect('dashboard/instructor/course')->with('alert', show_alert('Tipe Materi tidak terdeteksi', 'danger'));

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataSection([
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        if($material_type == 'video'){
            $request->validate([
                'material_title' => 'required',
                'material_video_url' => 'required',
                'material_description' => 'required',
                'duration' => 'required|numeric',
                'is_overview' => 'required',
            ]);

        }else{
            $request->validate([
                'material_title' => 'required',
                'material_description' => 'required',
            ]);
            $input['is_overview'] = '0';
        }
        

        $input = $request->except(['_token']);
        $input['section_id'] = $section_id;
        $input['material_type'] = $material_type;
        $input['created_at'] = date('Y-m-d H:i:s');

        $course = new Course();
        $course->insertMaterial($input);

        $courseData = $query->first();
        $updateData = [
            'total_material' => $courseData->total_material + 1
        ];
        if($material_type == 'video'){
            $updateData['total_duration'] = $courseData->total_duration + $input['duration'];
        }

        $course->updates($updateData, $course_id);

        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Materi berhasil ditambahkan', 'success'));
    }

    public function instructorAddQuiz($course_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataMaterial([
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $quiz = new Quiz();
        $data['course'] = $query->first();
        $data['quiz']   = $quiz->getFullQuizWithOption($material_id);
        return view('instructor/course/material/quiz/addQuiz', $data);
    }

    public function instructorEditQuiz($course_id, $material_id, $quiz_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $quiz = new Quiz();
        $query = $quiz->getDataQuiz([
            'course_section_material_quiz.id' => $quiz_id,
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $data['course']   = $query->first();
        return view('instructor/course/material/quiz/editQuiz', $data);
    }

    public function instructorEditMaterialVideo($course_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataMaterial([
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $quiz = new Quiz();
        $data['course'] = $query->first();
        $data['quiz']   = $quiz->getFullQuizWithOption($material_id);
        return view('instructor/course/material/video/edit', $data);
    }

    public function instructorEditMaterialQuiz($course_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataMaterial([
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $quiz = new Quiz();
        $data['course'] = $query->first();
        $data['quiz']   = $quiz->getFullQuizWithOption($material_id);
        return view('instructor/course/material/quiz/edit', $data);
    }

    public function instructorUpdateMaterial(Request $request, $material_type, $course_id, $section_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');
        if(!in_array($material_type, ['video', 'quiz']))  return redirect('dashboard/instructor/course')->with('alert', show_alert('Tipe Materi tidak terdeteksi', 'danger'));

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataMaterial([
            'course_section_material.id' => $material_id,
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        if($material_type == 'video'){
            $request->validate([
                'material_title' => 'required',
                'material_video_url' => 'required',
                'material_description' => 'required',
                'duration' => 'required|numeric',
                'is_overview' => 'required',
            ]);

        }else{
            $request->validate([
                'material_title' => 'required',
                'material_description' => 'required',
            ]);
            $input['is_overview'] = '0';
        }
        
        $materialDataOld = $course->getMaterialByID($material_id)->first();

        $input = $request->except(['_token']);
        $input['section_id'] = $section_id;
        $input['material_type'] = $material_type;
        $input['updated_at'] = date('Y-m-d H:i:s');

        $course = new Course();
        $course->updateMaterial($input, $material_id);

        if($material_type == 'video'){
            $courseData = $query->first();
            $totalDuration = $courseData->total_duration - $materialDataOld->duration + $input['duration'];
            //dd($courseData, $materialDataOld, $totalDuration);
            $course->updates(['total_duration' => $totalDuration], $course_id);
        }

        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Materi berhasil diubah', 'success'));
    }

    public function instructorDeleteMaterial(Request $request, $course_id, $section_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $course = new Course();
        $query = $course->getDataMaterial([
            'course_section_material.id' => $material_id,
            'course_section.id' => $section_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $course->deleteMaterial($material_id);

        return redirect('dashboard/instructor/course/'.$course_id.'/material')->with('alert', show_alert('Materi berhasil dihapus', 'success'));
    }
}
