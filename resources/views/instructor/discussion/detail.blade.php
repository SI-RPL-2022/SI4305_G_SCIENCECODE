@extends('layout/dashboard')

@section('title')
	Dashboard
@endsection

@section('content')
	<div class="container">

		@if (session('alert'))
            <div class="row mb-3">
                <div class="col-md-12">
                    {!! session('alert') !!}
                </div>
            </div>
        @endif

        @if($errors->any())
			<div class="alert alert-danger mt-3">
			    {!! implode('', $errors->all('<div>:message</div>')) !!}
			</div>
		@endif

		<div class="card">
			<div class="card-header">
				<b>Detail Diskusi</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="/dashboard/instructor/discussion" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-4">
						<img class="img-fluid" src="/images/course/{{$discussion->course_image}}">
						
						<div class="row mt-3">
							<div class="col-md-3">
								<img style="width: 45px;height: 45px; border-radius:50%" src="/images/user/{{$discussion->photo}}">
							</div>
							<div class="col-md-9">
								<b>{{$discussion->name}}</b><br>
								{{$discussion->email}}
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<h6>Course</h6>

						<table class="table">
							<tbody>
								<tr>
									<td>
										<small class="text-muted">Judul</small><br>
										{{$discussion->course_name}}
									</td>
									<td>
										<small class="text-muted">Kategori</small><br>
										{{$discussion->category_name}}
									</td>
									<td>
										<small class="text-muted">Waktu Pertanyaan</small><br>
										{{indonesian_date($discussion->discussion_created_at, true)}}
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<small class="text-muted">Pertanyaan</small><br>
										{!! nl2br($discussion->disscussion) !!}
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<form method="POST" action="/dashboard/instructor/discussion/insert_reply/{{$discussion->discussion_id}}">
											@csrf
											<label>Jawaban</label>
											<textarea class="form-control" required="" name="reply" placeholder="Ketik jawaban disini..."></textarea>
											<button class="btn btn-success mt-3">Jawab</button>
										</form>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>

	</div>
@endsection