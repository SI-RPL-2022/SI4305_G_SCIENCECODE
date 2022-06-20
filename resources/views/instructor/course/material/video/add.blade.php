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
				<b>Tambah Section</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="/dashboard/instructor/course/{{$course->course_id}}/material" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
					</div>

					<div class="col-md-3">
						<small class="text-muted">Judul Section</small><br>
						<b>{{$course->section_name}}</b>
					</div>

					<div class="col-md-3">
						<small class="text-muted">Judul Course</small><br>
						<b>{{$course->course_name}}</b>
					</div>
					<div class="col-md-3">
						<small class="text-muted">Kategori</small><br>
						<b>{{$course->category_name}}</b>
					</div>
				</div>

				<form method="POST" action="/dashboard/instructor/course/insert_material/video/{{$course->course_id}}/{{$course->section_id}}">
					@csrf
					<div class="row mt-3">
						<div class="col-md-12">
							<label>Judul Materi</label>
							<input type="text" autocomplete="off" class="form-control" required name="material_title" placeholder="Template Blade Laravel">
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-md-6">
							<label>Url Youtube (Embed)</label>
							<input placeholder="https://www.youtube.com/embed/cHnKrLksWGk" type="text" required name="material_video_url" class="form-control" autocomplete="off">
							<small class="text-muted">*Klik kanan pada video youtube dan pilih kode semat</small>
						</div>

						<div class="col-md-2">
							<label>Durasi Video</label>
							<input placeholder="20 Menit" type="number" required name="duration" class="form-control" autocomplete="off">
						</div>

						<div class="col-md-4">
							<label>Overview</label>
							<select class="form-control" name="is_overview" required="">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>
							</select>
							<small class="text-muted">Video dapat dilihat sebagai overview tanpa enroll</small>
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-md-12">
							<label>Deskripsi</label>
							<textarea class="form-control" required="" name="material_description" placeholder="Ketik deskripsi disini..."></textarea>
						</div>

						<div class="col-md-12 mt-3">
							<button class="btn btn-success">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection