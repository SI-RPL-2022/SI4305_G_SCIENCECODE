<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Session;
use Illuminate\Support\Facades\DB;

class DiscussionController extends Controller
{
    public function index(){
        if(!is_instructor()) return redirect('auth/login');

        $discussion = new Discussion();
        $userData = Session::get('user');
        $data['discussion'] = $discussion->data([
            'course.instructor_id' => $userData->id
        ])->get();
        return view('instructor/discussion/index', $data);
    }

    public function detail($discussion_id){
        if(!is_instructor()) return redirect('auth/login');
        
        $discussion = new Discussion();
        $userData = Session::get('user');

        $query =  $discussion->data([
                    'course.instructor_id'=> $userData->id,
                    'course_discussion.id' => $discussion_id
                  ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/discussion')->with('alert', show_alert('Data diskusi tidak ditemukan', 'danger'));
        }

        $discussionData = $query->first();
        if($discussionData->reply_id != ''){
            return redirect('dashboard/instructor/discussion')->with('alert', show_alert('Pertanyaan ini sudah pernah dijawab', 'danger'));
        }

        $data['discussion'] = $discussionData;
        return view('instructor/discussion/detail', $data);
    }

    public function insertReply(Request $request, $discussion_id){
        $discussion = new Discussion();
        $userData = Session::get('user');

        $query =  $discussion->data([
                    'course.instructor_id'=> $userData->id,
                    'course_discussion.id' => $discussion_id
                  ]);

        if($query->count() == 0){
            return redirect('dashboard/instructor/discussion')->with('alert', show_alert('Data diskusi tidak ditemukan', 'danger'));
        }

        $discussionData = $query->first();
        if($discussionData->reply_id != ''){
            return redirect('dashboard/instructor/discussion')->with('alert', show_alert('Pertanyaan ini sudah pernah dijawab', 'danger'));
        }

        $request->validate([
            'reply' => 'required',
        ]);

        $input = $request->except(['_token']);

        $userData = Session::get('user');
        $discussion->insertReply([
            'course_discussion_id' => $discussion_id,
            'instructor_id' => $userData->id,
            'reply' => $input['reply'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('dashboard/instructor/discussion')->with('alert', show_alert('Pertanyaan berhasil dijawab', 'success'));
    }
}
