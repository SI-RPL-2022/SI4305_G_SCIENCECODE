<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    public function index(){
        if(!is_admin()) return redirect('auth/login');

        $user = new User();
        $data['user'] = $user->data('role', 'user')->get();
        return view('admin/user/index', $data);
    }

    public function add(){
        if(!is_admin()) return redirect('auth/login');
        return view('admin/user/add');
    }

    public function insert(Request $request){
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'password'  => 'required',
            'photo'      => 'required|mimes:jpeg,jpg,png'
        ]);

        $imageName = 'user_'.time().'.'.$request->file('photo')->extension();  
        $request->file('photo')->move(public_path('images/user'), $imageName);

        $input = $request->except(['_token']);
        $input['photo'] = $imageName;
        $input['role'] = 'user';
        $input['created_at'] = date('Y-m-d H:i:s');

        $user = new User();
        $user->create($input);

        return redirect('dashboard/admin/user')->with('alert', show_alert('Data user berhasil ditambahkan', 'success'));    
    }

    public function delete($id){
        $user = new User();
        $user->deletes($id);

        return redirect('dashboard/admin/user')->with('alert', show_alert('Data user berhasil dihapus', 'success'));
    }

    public function edit($id){
        $user = new User();

        $query = $user->data('user.id', $id);
        if($query->count() == 0){
            return redirect('dashboard/admin/user')->with('alert', show_alert('Data user tidak ditemukan', 'danger'));
        }

        $data = [
            'user' => $query->first()
        ];
        return view('admin/user/edit', $data);
    }

    public function update(Request $request, $id){
         $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'photo'      => 'mimes:jpeg,jpg,png'
        ]);
        $input = $request->except(['_token']);
        $input['updated_at'] = date('Y-m-d H:i:s');

        if(isset($input['photo'])){
            $imageName = 'user_'.time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('images/user'), $imageName);
            $input['photo'] = $imageName;
        }

        if($input['password'] == ''){
            unset($input['password']);
        }
        
        $driver = new User();
        $driver->updates($input, $id);

        return redirect('dashboard/admin/user')->with('alert', show_alert('Data user berhasil diubah', 'success'));
    }
}
