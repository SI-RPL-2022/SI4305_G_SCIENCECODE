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
				<h6>Daftar Course</h6>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width:10%"></th>
							<th>Course</th>
							<th>Tanggal Enroll</th>
							<th>Progress</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($course as $row)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>
									<img class="img-fluid" src="/images/course/{{$row->course_image}}">
								</td>
								<td>
									{{$row->course_name}}<br>
									<small class="text-muted">Kategori : {{$row->category_name}}</small>
								</td>
								<td>
									{{indonesian_date($row->enroll_date)}}
								</td>
								<td>
									@if($row->is_done == '1')
										<span class="badge bg-success text-white">Selesai</span>
									@else
										<span class="badge bg-primary text-white">On Progress</span>
									@endif
								</td>
								<td>
									<a href="/dashboard/enrollment/{{$row->enroll_id}}/{{$row->course_id}}" class="btn btn-sm btn-outline-primary">Lihat Course</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection