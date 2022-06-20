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
				<b>Detail Course</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="/dashboard/instructor/course" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
					</div>
					<div class="col-md-9 text-right">
						<a href="/dashboard/instructor/course/{{$course->course_id}}/material" class="btn btn-primary">Daftar Materi</a> &emsp;

						<a href="/dashboard/instructor/course/{{$course->course_id}}/edit" class="btn btn-outline-warning">Ubah</a>
						<a href="/dashboard/instructor/course/{{$course->course_id}}/delete" onclick="return confirm('Apakah kamu yakin ingin menghapus course ini ?')" class="btn btn-outline-danger">Hapus</a>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-4">
						<img class="img-fluid" src="/images/course/{{$course->course_image}}">
						
						<div class="row mt-3">
							<div class="col-md-3">
								<img style="width: 45px;height: 45px; border-radius:50%" src="/images/user/{{$course->photo}}">
							</div>
							<div class="col-md-9">
								<b>{{$course->name}}</b><br>
								{{$course->email}}
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
										{{$course->course_name}}
									</td>
									<td>
										<small class="text-muted">Kategori</small><br>
										{{$course->category_name}}
									</td>
									<td>
										<small class="text-muted">Waktu Buat</small><br>
										{{indonesian_date($course->created_at, true)}}
									</td>
								</tr>
								<tr>
									<td>
										<small class="text-muted">Durasi</small><br>
										{{$course->total_duration}} Menit
									</td>
									<td>
										<small class="text-muted">Jumlah Materi</small><br>
										{{$course->total_material}}
									</td>
									<td>
										<small class="text-muted">Harga</small><br>
										<?= $course->price_type == 'paid' ? format_rp($course->course_price) : "<span class='badge bg-success text-white'>Gratis</span>" ?>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										{!! nl2br($course->course_description) !!}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<b>Daftar Enrollment</b>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<td></td>
							<th>User</th>
							<th>Email</th>
							<th>No. Handphone</th>
							<th>Waktu Enroll</th>
							<th class="text-center">Selesai</th>
						</tr>
					</thead>
					<tbody>
						@foreach($enrollmentUser as $row)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>
									<img style="width: 30px;height: 30px; border-radius:50%" src="/images/user/{{$course->photo}}">
								</td>
								<td>{{$row->name}}</td>
								<td>{{$row->email}}</td>
								<td>{{$row->phone}}</td>
								<td>{{indonesian_date($row->created_at, true)}}</td>
								<td class="text-center">
									@if($row->is_done == '1')
										<i class="material-icons text-success">check_circle</i><br>
										<small class="text-muted">{{indonesian_date($row->finished_at, true)}}</small>
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