<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{   
    protected $table = 'course_discussion';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)->selectRaw('*, '.$this->table.'.id as discussion_id, '.$this->table.'_reply.id as reply_id, '.$this->table.'.created_at as discussion_created_at, '.$this->table.'_reply.created_at as reply_created_at');
        
        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                     $tb->where($k, $v);
                }
               
            }else{
                $tb->where($key, $value);
            }
        }

        $tb->join('course_section_material', 'course_section_material.id', '=' ,$this->table.'.material_id')
           ->join('course_section', 'course_section.id', '=', 'course_section_material.section_id')
           ->join('course', 'course.id', '=', 'course_section.course_id')
           ->join('category', 'category.id', '=', 'course.category_id')
           ->join('user', 'user.id', '=', $this->table.'.user_id')
           ->leftJoin($this->table.'_reply', $this->table.'_reply.course_discussion_id', '=', $this->table.'.id')
           ->orderBy($this->table.'.id', 'desc');

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

    public function insertReply($data){
        return DB::table($this->table.'_reply')->insert($data);
    }
}
