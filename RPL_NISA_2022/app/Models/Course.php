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
        return DB::table($this->table)->insert($data);
    }

    public function updates($data, $id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function deletes($id){
        return DB::table($this->table)->where('id', $id)->delete();
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
                      ->orderBy('course_review.id', 'desc')->get();

        return [
            'average'     => $averageRating,
            'totalRating' => $totalRating, 
            'overview' => $ratingOverview,
            'list' => $ratingList
        ];
    }

    public function getMaterialByID($material_id){
        $tb = DB::table('course_section_material')->where('id', $material_id);
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
}
