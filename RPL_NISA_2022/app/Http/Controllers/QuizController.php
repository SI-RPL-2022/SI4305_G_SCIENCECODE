<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;
use Session;

class QuizController extends Controller
{
    public function insertAnswer(Request $request, $enroll_id, $course_id, $material_id){
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
        $quiz = new Quiz();
        $quizQuery = $quiz->data('id', $input['quiz_id']);
        if($quizQuery->count() == 0){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id.'/material/'.$material_id)
                   ->with('alert', show_alert('Data quiz tidak ditemukan', 'danger'));
        }

        $quiz->insertAnswer($userData->id, $input['quiz_id'], $input['option']);
        return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id.'/material/'.$material_id.'?quiz_id='.$input['quiz_id'])
                   ->with('alert', show_alert('Jawaban berhasil disimpan', 'success'));
    }

    public function quizDone($enroll_id, $course_id, $material_id){
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

        if($course->checkEnrollIsDone($enroll_id, $material_id)){
            return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
                   ->with('alert', show_alert('Quiz ini sudah pernah diselesaikan', 'danger'));
        }

        $quiz = new Quiz();
        $quiz->enrollQuizDone($userData->id, $enroll_id, $material_id);

        $totalDone = $course->getProgressDoneByEnroll($enroll_id);
        $totalMaterial = $query->first()->total_material;
        if($totalDone == $totalMaterial){
            $course->enrollDone($enroll_id);
        }
        
        return redirect('dashboard/enrollment/'.$enroll_id.'/'.$course_id)
               ->with('alert', show_alert('Berhasil menyelesaikan quiz', 'success'));
    }

    public function insert(Request $request, $course_id, $material_id){
        if(!is_instructor()) return redirect('auth/login');

        $request->validate([
            'quiz' => 'required',
            'correct_answer' => 'required|numeric',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required'
        ]);
        $input = $request->except(['_token']);

        $quiz = new Quiz();
        $createdAt = date('Y-m-d H:i:s');
        $quiz_id = $quiz->create([
                        'material_id' => $material_id,
                        'quiz' => $input['quiz'],
                        'created_at' => $createdAt
                   ]);

        $quiz->insertOption([
            'quiz_id' => $quiz_id,
            'option_1' => $input['option_1'],
            'option_2' => $input['option_2'],
            'option_3' => $input['option_3'],
            'option_4' => $input['option_4'],
            'correct_answer' => $input['correct_answer'],
            'created_at' => $createdAt
        ]);

        return redirect('dashboard/instructor/course/'.$course_id.'/material/'.$material_id.'/quiz')
               ->with('alert', show_alert('Data quiz berhasil dimasukkan', 'success'));
    }

    public function delete($course_id, $material_id, $quiz_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $quiz = new quiz();
        $query = $quiz->getDataQuiz([
            'course_section_material_quiz.id' => $quiz_id,
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $quiz->deletes($quiz_id);
        return redirect('dashboard/instructor/course/'.$course_id.'/material/'.$material_id.'/quiz')
               ->with('alert', show_alert('Data quiz berhasil dihapus', 'success'));
    }

    public function update(Request $request, $course_id, $material_id, $quiz_id){
        if(!is_instructor()) return redirect('auth/login');

        $userData = Session::get('user');
        $quiz = new quiz();
        $query = $quiz->getDataQuiz([
            'course_section_material_quiz.id' => $quiz_id,
            'course_section_material.id' => $material_id,
            'course.id' => $course_id,
            'instructor_id' => $userData->id
        ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/course')->with('alert', show_alert('Data course tidak ditemukan', 'danger'));
        }

        $request->validate([
            'quiz' => 'required',
            'correct_answer' => 'required|numeric',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required'
        ]);
        $input = $request->except(['_token']);

        $quiz = new Quiz();
        $updatedAt = date('Y-m-d H:i:s');
        $quiz->updates([
            'material_id' => $material_id,
            'quiz' => $input['quiz'],
            'updated_at' => $updatedAt
        ], $quiz_id);

        $dataQuiz = $query->first();
        $quiz->updateOption([
            'quiz_id' => $quiz_id,
            'option_1' => $input['option_1'],
            'option_2' => $input['option_2'],
            'option_3' => $input['option_3'],
            'option_4' => $input['option_4'],
            'correct_answer' => $input['correct_answer'],
            'updated_at' => $updatedAt
        ], $dataQuiz->option_id);

        return redirect('dashboard/instructor/course/'.$course_id.'/material/'.$material_id.'/quiz')
               ->with('alert', show_alert('Data quiz berhasil diubah', 'success'));
    }
}
