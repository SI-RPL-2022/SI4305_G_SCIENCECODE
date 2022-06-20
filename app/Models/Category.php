<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    protected $table = 'category';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)->selectRaw($this->table.'.*, COUNT(course.id) AS total_course');
        
        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                     $tb->where($k, $v);
                }
               
            }else{
                $tb->where($key, $value);
            }
        }

        $tb->leftJoin('course', function($join)
             {
                 $join->on('course.category_id', '=', $this->table.'.id');
                 $join->on('course.total_material','>',DB::raw("'0'"));
             })
           ->orderBy('category.id', 'desc')
           ->groupBy('category.id');

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
}
