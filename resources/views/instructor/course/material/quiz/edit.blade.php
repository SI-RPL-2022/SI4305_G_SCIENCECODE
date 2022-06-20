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

				<form method="POST" action="/dashboard/instructor/course/update_material/quiz/{{$course->course_id}}/{{$course->section_id}}/{{$course->material_id}}">
					@csrf
					<div class="row mt-3">
						<div class="col-md-12">
							<label>Judul Quiz</label>
							<input value="{{$course->material_title}}" type="text" autocomplete="off" class="form-control" required name="material_title" placeholder="Quiz Fundamental Template Blade Laravel">
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-md-12">
							<label>Deskripsi</label>
							<textarea class="form-control" required="" name="material_description" placeholder="Ketik deskripsi disini...">{{$course->material_description}}</textarea>
						</div>

						<div class="col-md-12 mt-3">
							<button class="btn btn-warning">Ubah</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection