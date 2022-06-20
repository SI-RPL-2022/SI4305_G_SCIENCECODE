<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    public function index(){
        if(!is_admin()) return redirect('auth/login');

        $user = new User();
        $data['instructor'] = $user->data('role', 'instructor')->get();
        return view('admin/instructor/index', $data);
    }

    public function add(){
        if(!is_admin()) return redirect('auth/login');
        return view('admin/instructor/add');
    }

    public function insert(Request $request){
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|exists:user,email',
            'phone'     => 'required|exists:user,phone',
            'password'  => 'required',
            'photo'      => 'required|mimes:jpeg,jpg,png'
        ]);

        $imageName = 'instructor_'.time().'.'.$request->file('photo')->extension();  
        $request->file('photo')->move(public_path('images/user'), $imageName);

        $input = $request->except(['_token']);
        $input['photo'] = $imageName;
        $input['role'] = 'instructor';
        $input['created_at'] = date('Y-m-d H:i:s');

        $user = new User();
        $user->create($input);

        return redirect('dashboard/admin/instructor')->with('alert', show_alert('Data Instruktur berhasil ditambahkan', 'success'));    
    }

    public function delete($id){
        $instructor = new User();
        $instructor->deletes($id);

        return redirect('dashboard/admin/instructor')->with('alert', show_alert('Data instruktur berhasil dihapus', 'success'));
    }

    public function edit($id){
        $user = new User();

        $query = $user->data('user.id', $id);
        if($query->count() == 0){
            return redirect('dashboard/admin/instructor')->with('alert', show_alert('Data instruktur tidak ditemukan', 'danger'));
        }

        $data = [
            'instructor' => $query->first()
        ];
        return view('admin/instructor/edit', $data);
    }

    public function update(Request $request, $id){
         $request->validate([
            'name'      => 'required',
            'email'     => 'required|exists:user,email',
            'phone'     => 'required|exists:user,phone',
            'photo'      => 'mimes:jpeg,jpg,png'
        ]);
        $input = $request->except(['_token']);
        $input['updated_at'] = date('Y-m-d H:i:s');

        if(isset($input['photo'])){
            $imageName = 'instructor_'.time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('images/user'), $imageName);
            $input['photo'] = $imageName;
        }

        if($input['password'] == ''){
            unset($input['password']);
        }
        
        $driver = new User();
        $driver->updates($input, $id);

        return redirect('dashboard/admin/instructor')->with('alert', show_alert('Data instruktur berhasil diubah', 'success'));
    }
}
