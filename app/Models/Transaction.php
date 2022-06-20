<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{   
    protected $table = 'transaction';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)
              ->selectRaw('transaction.*, transaction.id as transaction_id,
                           user.name as user_name, user.photo as user_photo, 
                           user.email as user_email, user.phone as user_phone,
                           course_name, course_image, course_description, category_name, price_type, course_price, total_material, total_duration')
              ->orderBy($this->table.".id", 'desc');
        
        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                     $tb->where($k, $v);
                }
               
            }else{
                $tb->where($key, $value);
            }
        }

        $tb->join('user', $this->table.'.user_id', '=', 'user.id')
           ->join('course', 'course.id', '=', 'transaction.course_id')
           ->join('category', 'category.id', '=', 'course.category_id');

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

    public function getListTransactionAdmin(){
      return DB::table($this->table)
             ->selectRaw('transaction.*, transaction.id as transaction_id,
                           user.name as user_name, user.photo as user_photo, 
                           user.email as user_email, user.phone as user_phone,
                           course_name, course_image, course_description, category_name, price_type, course_price, total_material, total_duration')
             ->join('user', $this->table.'.user_id', '=', 'user.id')
             ->join('course', 'course.id', '=', 'transaction.course_id')
             ->join('category', 'category.id', '=', 'course.category_id')
             ->where('status', '!=', 'pending')
             ->orderBy($this->table.".id", 'desc')->get();
    }
}
