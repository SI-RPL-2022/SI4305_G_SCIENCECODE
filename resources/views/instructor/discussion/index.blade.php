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

		<div class="card">
			<div class="card-header">
				<b>Daftar Diskusi</b>
			</div>
			<div class="card-body">
				<table class="table mt-3">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width: 25%">Course</th>
							<th>Diskusi Pertanyaan</th>
							<th style="width: 25%">Waktu</th>
							<th style="width: 5%"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($discussion as $row)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>
									{{$row->course_name}}<br>
									<small class="text-muted">Kategori : {{$row->category_name}}</small>
								</td>
								<td>
									{{$row->disscussion}} 
									@if($row->reply_id != '')
										<br><br>
										<small class="text-muted">Jawaban :</small><br>
										{{$row->reply}}
									@endif
								</td>
								<td>
									{{indonesian_date($row->discussion_created_at, true)}}<br><br>

									<img src="/images/user/{{$row->photo}}" style="width: 20px; height: 20px; border-radius: 50%"> {{$row->name}}<br>
									<small class="text-muted">{{$row->email}}</small>
								</td>
								<td>
									@if($row->reply_id == '')
										<a href="/dashboard/instructor/discussion/{{$row->discussion_id}}" class="btn btn-sm btn-outline-primary">Jawab</a>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection