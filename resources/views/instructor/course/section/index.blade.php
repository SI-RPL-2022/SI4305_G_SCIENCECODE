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
				<b>Detail</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="/dashboard/instructor/course" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
					</div>
					<div class="col-md-4">
						<small class="text-muted">Judul Course</small><br>
						<b>{{$course->course_name}}</b>
					</div>
					<div class="col-md-4">
						<small class="text-muted">Kategori</small><br>
						<b>{{$course->category_name}}</b>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3"></div>
					<div class="col-md-4">
						<small class="text-muted">Total Materi</small><br>
						<b>{{$course->total_material}}</b>
					</div>
					<div class="col-md-4">
						<small class="text-muted">Total Durasi</small><br>
						<b>{{$course->total_duration}} Menit</b>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<b>Daftar Materi</b>
			</div>
			<div class="card-body">
				<a href="/dashboard/instructor/course/{{$course->course_id}}/material/add_section" class="btn btn-sm btn-primary">Tambah Section</a>
				<table class="table mt-3">
					@foreach($section as $row)
						<tr>
							<th style="width: 10%">{{$loop->iteration}}</th>
							<th>{{$row->section_name}}</th>
							<th style="width: 30%" class="text-right">
								<div class="btn-group">
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">Tambah Materi</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$row->id}}/add_material/video">Video</a>
                                        <a class="dropdown-item"
                                           href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$row->id}}/add_material/quiz">Quiz</a>
                                    </div>
                                </div>
								<a href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$row->id}}/edit_section" class="btn btn-sm btn-outline-warning">Ubah</a>
								<a onclick="confirm('Apakah kamu yakin menghapus section ini, materi yang terhubung dengan section ini akan terhapus otomatis ?')"
								   href="/dashboard/instructor/course/delete_section/{{$course->course_id}}/{{$row->id}}" class="btn btn-sm btn-outline-danger">Hapus</a>
							</th>
						</tr>

						@foreach($row->material as $material)
							<tr>
								<td>
									@if($material->material_type == 'video')
										@if($material->is_overview == '1')
											<span class="badge bg-warning">Overview</span><br>
										@endif
										{{$material->duration}} Menit
									@endif
								</td>
								<td>
									&emsp;
									<span class="icon-holder icon-holder--small icon-holder--outline-primary rounded-circle d-inline-flex icon--left">
                                    	<i class="material-icons icon-16pt"><?= $material->material_type == 'video' ? 'play_circle_outline' : 'question_mark' ?></i>
                                	</span>
									{{$material->material_title}}</td>
								<td class="text-right">
									@if($material->material_type == 'quiz')
										<a class="btn btn-outline-primary btn-sm" href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$material->id}}/quiz">Lihat Soal</a>
									@endif
									<a href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$material->id}}/edit_material/{{$material->material_type}}" class="btn btn-sm btn-outline-warning">Ubah</a>
									<a onclick="confirm('Apakah kamu yakin menghapus materi ini ?')" 
									   href="/dashboard/instructor/course/delete_material/{{$course->course_id}}/{{$row->id}}/{{$material->id}}" class="btn btn-sm btn-outline-danger">Hapus</a>
								</td>
							</tr>
						@endforeach
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection