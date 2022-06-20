<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{   
    protected $table = 'course';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)->selectRaw('*, course.id as course_id')
                ->orderBy($this->table.".id", "desc")
                ->join('user', 'user.id', '=', $this->table.'.instructor_id')
                ->join('category', 'category.id', '=', $this->table.'.category_id');
        
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

    public function getDataMaterial($key = '', $value = ''){
        $tb = DB::table('course_section_material')->selectRaw('*, course_section.id as section_id, course_section_material.id as material_id')
                ->orderBy('course_section_material.id', "desc")
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

    public function getDataSection($key = '', $value = ''){
        $tb = DB::table('course_section')->selectRaw('*, course_section.id as section_id')
                ->orderBy('course_section.id', "desc")
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

    public function getSectionWithMaterial($course_id){
        $data = [];
        $section = DB::table('course_section')->where('course_id', $course_id)->get();

        $i = 0;
        foreach ($section as $row) {
            $material = DB::table('course_section_material')->where('section_id', $row->id)->get();

            $data[$i] = $row;
            $data[$i]->material = $material;
            $i++;
        }

        return $data;
    }

    public function getRatingOverview($course_id){
        $averageRating = DB::table('course_review')
                       ->where('course_id', $course_id)
                       ->avg('rating');

        $totalRating = DB::table('course_review')
                       ->where('course_id', $course_id)
                       ->count();

        $rating = [5, 4, 3, 2, 1];
        foreach($rating as $row){
            $count = DB::table('course_review')
                     ->where('course_id', $course_id)
                     ->where('rating', $row)
                     ->count();
            $ratingOverview[$row] = $count;
        }
        
        $ratingList = DB::table('course_review')
                      ->selectRaw('*, course_review.created_at as review_created_at')
                      ->join('user', 'user.id', '=', 'course_review.user_id')
                      ->where('course_id', $course_id)
                      ->orderBy('course_review.id', 'desc')->get();

        return [
            'average'     => $averageRating,
            'totalRating' => $totalRating, 
            'overview' => $ratingOverview,
            'list' => $ratingList
        ];
    }

    public function getRatingByUserID($course_id, $user_id){
      return DB::table('course_review')
             ->where('course_id', $course_id)
             ->where('user_id', $user_id)->first();
    }

    public function getSectionWithMaterialEnroll($enroll_id, $course_id){
        $data = [];
        $section = DB::table('course_section')->where('course_id', $course_id)->get();

        $i = 0;
        foreach ($section as $row) {
            $material = DB::table('course_section_material')
                        ->select('course_section_material.*', 'is_understand', 'course_user_enroll_section.id as enroll_material_id','score')
                        ->where('section_id', $row->id)
                        ->leftJoin('course_user_enroll_section', function($join) use ($enroll_id){
                            $join->on('course_user_enroll_section.material_id', '=', 'course_section_material.id')
                                 ->on('course_user_enroll_section.enroll_id', '=', DB::raw($enroll_id));
                        })
                        ->get();

            $data[$i] = $row;
            $data[$i]->material = $material;
            $i++;
        }

        return $data;
    }

    public function getMaterialByID($material_id){
        $tb = DB::table('course_section_material')
              ->selectRaw('course_section_material.*, course_section.section_name')
              ->join('course_section', 'course_section.id', '=', 'course_section_material.section_id')
              ->where('course_section_material.id', $material_id);
        return $tb;
    }

    public function checkEnrollmentAccess($user_id, $course_id){
        $tb = DB::table('course_user_enroll')
              ->where([
                'user_id' => $user_id,
                'course_id' => $course_id
              ]);

        if($tb->count() == 0){
            return false;
        }

        return true;
    }

    public function checkEnrollIsExist($user_id, $course_id){
        $tb = DB::table('course_user_enroll')
              ->where([
                'user_id' => $user_id,
                'course_id' => $course_id
              ]);
        if($tb->count() > 0) return true;
        return false;
    }

    public function insertEnrollment($data){
        return DB::table('course_user_enroll')->insert($data);
    }

    public function insertRating($data){
        return DB::table('course_review')->insert($data);
    }

    public function getEnrollmentList($user_id){
        $tb = DB::table('course_user_enroll')
              ->selectRaw('*, course_user_enroll.id as enroll_id, course_user_enroll.created_at as enroll_date')
              ->join('course', 'course.id', '=', 'course_user_enroll.course_id')
              ->join('user', 'user.id', '=', 'course.instructor_id')
              ->join('category', 'category.id', '=', 'course.category_id')
              ->where('course_user_enroll.user_id', $user_id);
        return $tb->get();
    }

    public function countEnrollment($course_id){
        $tb = DB::table('course_user_enroll')
              ->where('course_id', $course_id);
        return $tb->count();
    }

    public function getEnrollData($user_id, $course_id){
        $tb = DB::table('course_user_enroll')->where([
                'course_id' => $course_id,
                'user_id'   => $user_id 
              ]);
        return $tb->first();
    }

    public function getProgressDoneByEnroll($enroll_id){
        return DB::table('course_user_enroll_section')
               ->where([
                    'enroll_id' => $enroll_id,
                    'is_understand' => '1'
               ])->count();
    }

    public function getEnrollMaterial($enroll_id, $material_id){
        return DB::table('course_user_enroll_section')
               ->where([
                    'enroll_id' => $enroll_id,
                    'material_id' => $material_id
               ])->first();
    }

    public function checkEnrollIsDone($enroll_id, $material_id){
      return DB::table('course_user_enroll_section')
               ->where([
                    'is_understand' => '1',
                    'enroll_id' => $enroll_id,
                    'material_id' => $material_id
               ])->count() == 0 ? false : true;
    }

    public function enrollMaterialDone($enroll_id, $material_id){
        return DB::table('course_user_enroll_section')
               ->insert([
                'enroll_id' => $enroll_id,
                'material_id' => $material_id,
                'is_understand' => '1',
                'created_at' => date('Y-m-d H:i:s')
               ]);
    }

    public function enrollDone($enroll_id){
      return DB::table('course_user_enroll')
             ->where('id', $enroll_id)
             ->update([
                'is_done' => '1',
                'finished_at' => date('Y-m-d H:i:s')
             ]);
    }

    public function getEnrollDiscussion($user_id, $material_id){
      return DB::table('course_discussion')
             ->select('course_discussion.*', 'user.name as user_name', 'user.photo as user_photo', 'instructor.name as instructor_name', 'instructor.photo as instructor_photo', 'disscussion', 'reply', 'course_discussion.created_at as discussion_at', 'course_discussion_reply.created_at as reply_at', 'course_discussion_reply.id as reply_id')
             ->join('user', 'user.id', '=', 'course_discussion.user_id')
             ->leftJoin('course_discussion_reply', 'course_discussion_reply.course_discussion_id', '=', 'course_discussion.id')
             ->leftJoin('user as instructor', 'instructor.id', '=', 'course_discussion_reply.instructor_id')
             ->where('user_id', $user_id)
             ->where('material_id', $material_id)->get();
    }

    public function insertDiscussion($data){
        return DB::table('course_discussion')->insert($data);
    }

    public function getEnrollmentUserList($course_id){
      return DB::table('course_user_enroll')
             ->select('course_user_enroll.*', 'name', 'email', 'phone', 'photo')
             ->join('user', 'user.id', '=', 'course_user_enroll.user_id')
             ->where('course_id', $course_id)->get();
    }

    public function insertSection($data){
      return DB::table('course_section')->insert($data);
    }

    public function updateSection($data, $id){
        return DB::table('course_section')->where('id', $id)->update($data);
    }

    public function deleteSection($id){
        return DB::table('course_section')->where('id', $id)->delete();
    }

    public function insertMaterial($data){
      return DB::table('course_section_material')->insert($data);
    }

    public function updateMaterial($data, $id){
        return DB::table('course_section_material')->where('id', $id)->update($data);
    }

    public function deleteMaterial($id){
        return DB::table('course_section_material')->where('id', $id)->delete();
    }
}