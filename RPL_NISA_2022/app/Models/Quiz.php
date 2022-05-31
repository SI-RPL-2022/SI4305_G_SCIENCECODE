<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{   
    protected $table = 'course_section_material_quiz';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table);
        
        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                     $tb->where($k, $v);
                }
               
            }else{
                $tb->where($key, $value);
            }
        }

        return $tb;
    }

    public function getDataQuiz($key = '', $value = ''){
        $tb = DB::table($this->table)
              ->selectRaw('*, '.$this->table.'.id as quiz_id, '.$this->table.'_option.id as option_id')
              ->join('course_section_material_quiz_option' , 'course_section_material_quiz_option.quiz_id', '=', $this->table.'.id')
              ->join('course_section_material', 'course_section_material.id', '=', $this->table.'.material_id')
              ->join('course_section', 'course_section.id', '=', 'course_section_material.section_id')
              ->join('course', 'course.id', '=', 'course_section.course_id')
              ->join('category', 'category.id', '=', 'course.category_id');
        
        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                     $tb->where($k, $v);
                }
               
            }else{
                $tb->where($key, $value);
            }
        }

        return $tb;
    }

    public function create($data){
        return DB::table($this->table)->insertGetId($data);
    }

    public function updates($data, $id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function deletes($id){
        return DB::table($this->table)->where('id', $id)->delete();
    }

    public function insertOption($data){
        return DB::table('course_section_material_quiz_option')->insertGetId($data);
    }

    public function updateOption($data, $id){
        return DB::table('course_section_material_quiz_option')->where('id', $id)->update($data);
    }

    public function getFullQuizWithOption($material_id){
        $data = DB::table($this->table)
                ->selectRaw('*, '.$this->table.'.id as quiz_id, '.$this->table.'_option.id as option_id')
                ->join($this->table.'_option', $this->table.'_option.quiz_id', '=', $this->table.'.id')
                ->where('material_id', $material_id)
                ->orderBy($this->table.'.id', 'asc')
                ->get();

        return $data;
    }

    public function getQuizControl($material_id, $quiz_id){
        $control = [
            'prev' => '<',
            'next' => '>'
        ];

        foreach($control as $key => $val){
            $data[$key] = DB::table($this->table)
                          ->where('id', $val, $quiz_id)
                          ->orderBy('id', 'asc')->first();
        }

        return $data;
    }

    public function getFirstQuestion($material_id){
        return DB::table($this->table)
               ->where('material_id', $material_id)
               ->orderBy('id', 'asc')->first();
    }

    public function getOption($quiz_id){
        return DB::table($this->table."_option")
               ->select($this->table."_option.*", 'course_user_enroll_answer.answer as option_num')
               ->leftJoin('course_user_enroll_answer', function($join){
                    $join->on('course_user_enroll_answer.quiz_id', '=', $this->table.'_option.quiz_id');
               })
               ->where($this->table.'_option.quiz_id', $quiz_id)->first();
    }

    public function getQuizNumber($material_id, $user_id){
        $query = DB::table($this->table)
                 ->select($this->table.'.id', 'course_user_enroll_answer.id as answer_id', $this->table.'_option.correct_answer', 'course_user_enroll_answer.answer')
                 ->leftJoin('course_user_enroll_answer', function($join) use ($user_id){
                    $join->on('course_user_enroll_answer.quiz_id', '=', $this->table.'.id')
                         ->on('course_user_enroll_answer.user_id', '=', DB::raw($user_id));
                 })
                 ->join($this->table.'_option', $this->table.'_option.quiz_id', '=', $this->table.'.id')
                 ->where('material_id', $material_id)->orderBy('id', 'asc');
        
        return [
            'data' => $query->get(),
            'total' => $query->count()
        ];
    }

    public function insertAnswer($user_id, $quiz_id, $option_num){
        $answerQuery = DB::table('course_user_enroll_answer')
                       ->where('user_id', $user_id)
                       ->where('quiz_id', $quiz_id);
        
        $data = [
            'user_id' => $user_id,
            'quiz_id' => $quiz_id,
            'answer'  => $option_num
        ];

        if($answerQuery->count() == 0){
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('course_user_enroll_answer')->insert($data);

        }else{
            $answer = $answerQuery->first();
            $data['updated_at'] = date('Y-m-d H:i:s');
            DB::table('course_user_enroll_answer')->where('id', $answer->id)->update($data);
        }

        return true;
    }

    public function enrollQuizDone($user_id, $enroll_id, $material_id){
        $query = DB::table('course_user_enroll_answer')
                 ->selectRaw('
                    SUM(CASE WHEN course_user_enroll_answer.answer = '.$this->table.'_option.correct_answer THEN 1 ELSE 0 END) AS total_correct,
                    COUNT(course_user_enroll_answer.id) AS total_quiz
                 ')
                 ->join($this->table, $this->table.'.id', '=', 'course_user_enroll_answer.quiz_id')
                 ->join($this->table.'_option', $this->table.'_option.quiz_id', '=', 'course_user_enroll_answer.quiz_id')
                 ->where('course_user_enroll_answer.user_id', $user_id)
                 ->where($this->talbe.'.material_id', $material_id)->first();

        DB::table('course_user_enroll_section')
        ->insert([
            'material_id'   => $material_id,
            'enroll_id'     => $enroll_id,
            'is_understand' => '1',
            'score'         => round($query->total_correct / $query->total_quiz * 100),
            'total_quiz'    => $query->total_quiz,
            'total_correct' => $query->total_correct,
            'total_false'   => $query->total_quiz - $query->total_correct,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}
