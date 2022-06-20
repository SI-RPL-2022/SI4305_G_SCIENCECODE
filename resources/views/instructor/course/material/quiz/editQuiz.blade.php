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
				<b>Ubah Pertanyaan</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<a href="dashboard/instructor/course/{{$course->course_id}}/material/{{$course->material_id}}/quiz" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
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

				<div class="row mt-3">
					<div class="col-md-3"></div>
					<div class="col-md-3">
						<small class="text-muted">Judul Quiz</small><br>
						<b>{{$course->material_title}}</b>
					</div>
				</div>

				<form method="POST" action="/dashboard/instructor/course/update_quiz/{{$course->course_id}}/{{$course->material_id}}/{{$course->quiz_id}}"> 
	                @csrf

                    <div class="container mb-3">
                        <div class="row">
                        	<div class="col-md-12">
                        		<label>Soal</label>
                        		<textarea class="form-control" required="" name="quiz" placeholder="Ketik soal disini...">{{$course->quiz}}</textarea>
                        	</div>
                        </div>

                        <div class="row mt-3">
                        	<div class="col-md-12">
                        		<ul class="nav nav-tabs" role="tablist">
								  <li class="nav-item">
								    <a class="nav-link active" href="#a" role="tab" data-toggle="tab">Opsi A</a>
								  </li>
								  <li class="nav-item">
								    <a class="nav-link" href="#b" role="tab" data-toggle="tab">Opsi B</a>
								  </li>
								  <li class="nav-item">
								    <a class="nav-link" href="#c" role="tab" data-toggle="tab">Opsi C</a>
								  </li>
								  <li class="nav-item">
								    <a class="nav-link" href="#d" role="tab" data-toggle="tab">Opsi D</a>
								  </li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
								  <div role="tabpanel" class="tab-pane fade in show active" id="a">
								  	<div class="row mt-3">
								  		<div class="col-md-3">
								  			<input type="radio" name="correct_answer" value="1" <?= $course->correct_answer == '1' ? 'checked="checked"' : ''?>>
								  			<label>Kunci Jawaban Benar</label>
								  		</div>
								  		<div class="col-md-9">
								  			<label>Opsi</label>
								  			<textarea class="form-control" required name="option_1" placeholder="Ketik opsi disini...">{{$course->option_1}}</textarea>
								  		</div>
								  	</div>
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="b">
								  	<div class="row mt-3">
								  		<div class="col-md-3">
								  			<input type="radio" name="correct_answer" value="2" <?= $course->correct_answer == '2' ? 'checked="checked"' : ''?>>
								  			<label>Kunci Jawaban Benar</label>
								  		</div>
								  		<div class="col-md-9">
								  			<label>Opsi</label>
								  			<textarea class="form-control" required name="option_2" placeholder="Ketik opsi disini...">{{$course->option_2}}</textarea>
								  		</div>
								  	</div>
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="c">
								  	<div class="row mt-3">
								  		<div class="col-md-3">
								  			<input type="radio" name="correct_answer" value="3" <?= $course->correct_answer == '3' ? 'checked="checked"' : ''?>>
								  			<label>Kunci Jawaban Benar</label>
								  		</div>
								  		<div class="col-md-9">
								  			<label>Opsi</label>
								  			<textarea class="form-control" required name="option_3" placeholder="Ketik opsi disini...">{{$course->option_3}}</textarea>
								  		</div>
								  	</div>
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="d">
								  	<div class="row mt-3">
								  		<div class="col-md-3">
								  			<input type="radio" name="correct_answer" value="4" <?= $course->correct_answer == '4' ? 'checked="checked"' : ''?>>
								  			<label>Kunci Jawaban Benar</label>
								  		</div>
								  		<div class="col-md-9">
								  			<label>Opsi</label>
								  			<textarea class="form-control" required name="option_4" placeholder="Ketik opsi disini...">{{$course->option_4}}</textarea>
								  		</div>
								  	</div>
								  </div>
								</div>	

								<button class="btn btn-warning">Ubah</button>
                        	</div>
                        </div>
                    </div>
                </form>

			</div>
		</div>
	</div>
@endsection