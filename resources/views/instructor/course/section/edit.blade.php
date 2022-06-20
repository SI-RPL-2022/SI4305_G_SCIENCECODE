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
				<b>Ubah Section</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="/dashboard/instructor/course/{{$course->course_id}}/material" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
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

				<form method="POST" action="/dashboard/instructor/course/update_section/{{$course->course_id}}/{{$course->section_id}}">
					@csrf
					<div class="row mt-3">
						<div class="col-md-12">
							<label>Judul Section</label>
							<input value="{{$course->section_name}}" type="text" autocomplete="off" class="form-control" required name="section_name" placeholder="Fundamental Website">
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