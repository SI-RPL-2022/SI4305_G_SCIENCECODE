<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Session;
use Closure;

class TransactionController extends Controller
{
    public function list(){
        if(!is_user()) return redirect('auth/login');

        $transaction = new Transaction();
        $data['transaction'] = $transaction->data()->get();
        return view('dashboard/transaction/index', $data);
    }

    public function detail($transaction_id){
        if(!is_user()) return redirect('auth/login');

        $userData = Session::get('user');
        $transaction = new Transaction();
        $query = $transaction->data([
                    'user_id' => $userData->id,
                    'transaction.id' => $transaction_id
                 ]);
        if($query->count() == 0){
            return redirect('dashboard/transaction')->with('alert', show_alert('Data transaksi tidak ditemukan', 'danger'));
        }

        $data['transaction'] = $query->first();

        return view('dashboard/transaction/detail', $data);
    }

    public function uploadPayment(Request $request, $transaction_id){
        $request->validate([
            'payment_proof' => 'required|mimes:jpeg,jpg,png'
        ]);

        $input = $request->except(['_token']);

        $imageName = 'payment_'.time().'.'.$request->file('payment_proof')->extension();  
        $request->file('payment_proof')->move(public_path('images/payment'), $imageName);

        $transaction = new Transaction();
        $transaction->updates([
            'payment_proof' => $imageName,
            'status'    => 'need_confirmation',
            'send_proof_at' => date('Y-m-d H:i:s')
        ], $transaction_id);
        return redirect('dashboard/transaction/'.$transaction_id)->with('alert', show_alert('Bukti transfer berhasil diupload', 'success'));    
    }

    public function validationPayment(Request $request, $transaction_id, $status){
        if(!is_admin()) return redirect('auth/login');
        if(!in_array($status, ['confirm', 'deny'])) return redirect('transaction/detail/'.$transaction_id);

        $transaction = new Transaction();
        $transData = $transaction->data('transaction.id', $transaction_id)->first();
        
        if($transData->status != 'need_confirmation'){
            return redirect('dashboard/admin/transaction/'.$transaction_id)->with('alert', show_alert('Status transaksi tidak valid', 'danger'));
        }

        $transaction->updates([
            'status' => $status == 'confirm' ? 'complete' : 'deny',
            'confirm_at' => date('Y-m-d H:i:s')
        ], $transaction_id);

        if($status == 'confirm'){
            $course = new Course();
            $course->insertEnrollment([
                'user_id' => $transData->user_id,
                'course_id' => $transData->course_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect('dashboard/admin/transaction/'.$transaction_id)->with('alert', show_alert('Bukti pembayaran berhasil divalidasi', 'success'));
    }

    public function index(){
        if(!is_admin()) return redirect('auth/login');
        
        $transaction = new Transaction();
        $data['transaction'] = $transaction->getListTransactionAdmin();
        return view('admin/transaction/index', $data);
    }

    public function confirmation($transaction_id){
        if(!is_admin()) return redirect('auth/login');

        $userData = Session::get('user');
        $transaction = new Transaction();
        $query = $transaction->data('transaction.id', $transaction_id);
        if($query->count() == 0){
            return redirect('dashboard/admin/transaction')->with('alert', show_alert('Data transaksi tidak ditemukan', 'danger'));
        }

        $data['transaction'] = $query->first();

        return view('admin/transaction/detail', $data);
    }
}
