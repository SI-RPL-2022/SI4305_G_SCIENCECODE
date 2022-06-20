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

				<div class="row mt-3">
					<div class="col-md-3"></div>
					<div class="col-md-9">
						<small class="text-muted">Judul Quiz</small><br>
						<b>{{$course->material_title}}</b>
					</div>
				</div>
			</div>
		</div>

		<div class="accordion js-accordion accordion--boxed list-group-flush mb-4" id="parent">
            <div class="accordion__item">
                <a href="#"
                   class="accordion__toggle collapsed"
                   data-toggle="collapse"
                   data-target="#course-toc-1"
                   data-parent="#parent">
                    <span class="flex">Tambah Pertanyaan</span>
                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                </a>
                <div class="accordion__menu collapse"
                     id="course-toc-1">

                    <form method="POST" action="/dashboard/instructor/course/insert_quiz/{{$course->course_id}}/{{$course->material_id}}"> 
	                @csrf

	                    <div class="container mb-3">
	                        <div class="row">
	                        	<div class="col-md-12">
	                        		<label>Soal</label>
	                        		<textarea class="form-control" required="" name="quiz" placeholder="Ketik soal disini..."></textarea>
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
									  			<input type="radio" name="correct_answer" value="1">
									  			<label>Kunci Jawaban Benar</label>
									  		</div>
									  		<div class="col-md-9">
									  			<label>Opsi</label>
									  			<textarea class="form-control" required name="option_1" placeholder="Ketik opsi disini..."></textarea>
									  		</div>
									  	</div>
									  </div>
									  <div role="tabpanel" class="tab-pane fade" id="b">
									  	<div class="row mt-3">
									  		<div class="col-md-3">
									  			<input type="radio" name="correct_answer" value="2">
									  			<label>Kunci Jawaban Benar</label>
									  		</div>
									  		<div class="col-md-9">
									  			<label>Opsi</label>
									  			<textarea class="form-control" required name="option_2" placeholder="Ketik opsi disini..."></textarea>
									  		</div>
									  	</div>
									  </div>
									  <div role="tabpanel" class="tab-pane fade" id="c">
									  	<div class="row mt-3">
									  		<div class="col-md-3">
									  			<input type="radio" name="correct_answer" value="3">
									  			<label>Kunci Jawaban Benar</label>
									  		</div>
									  		<div class="col-md-9">
									  			<label>Opsi</label>
									  			<textarea class="form-control" required name="option_3" placeholder="Ketik opsi disini..."></textarea>
									  		</div>
									  	</div>
									  </div>
									  <div role="tabpanel" class="tab-pane fade" id="d">
									  	<div class="row mt-3">
									  		<div class="col-md-3">
									  			<input type="radio" name="correct_answer" value="4">
									  			<label>Kunci Jawaban Benar</label>
									  		</div>
									  		<div class="col-md-9">
									  			<label>Opsi</label>
									  			<textarea class="form-control" required name="option_4" placeholder="Ketik opsi disini..."></textarea>
									  		</div>
									  	</div>
									  </div>
									</div>	

									<button class="btn btn-success">Simpan</button>
	                        	</div>
	                        </div>
	                    </div>
	                </form>
                </div>
            </div>
        </div>

		<div class="card">
			<div class="card-header"><b>Daftar Pertanyaan</b></div>
			<div class="card-body">
				<table class="table mt-3">
					<thead>
						<tr>
							<th style="width: 5%">#</th>
							<th>Pertanyaan</th>
							<th style="width: 20%"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($quiz as $row)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>
									<p>{{$row->quiz}}</p>
									<table class="table">
										<?php 
											$numOption = 4;
											for($i = 1; $i <= $numOption; $i++){
												$option = 'option_';
										?>
												<tr>
													<td style="width: 10%">
														{{numToAlphabet($i)}}
														@if($row->correct_answer == $i)
															<i class="material-icons text-success">check_circle</i>
														@endif
													</td>
													<td><?= $row->{$option.$i} ?></td>
													<td></td>
												</tr>
										<?php
											}
										?>
									</table>
								</td>
								<td class="text-right">
									<a class="btn btn-outline-warning btn-sm" 
									   href="/dashboard/instructor/course/{{$course->course_id}}/material/{{$row->material_id}}/quiz/{{$row->quiz_id}}/edit">Ubah</a>
									<a class="btn btn-outline-danger btn-sm" 
									   onclick="return confirm('Apakah anda yakin menghapus pertanyaan ini ?')"
									   href="/dashboard/instructor/course/delete_quiz/{{$course->course_id}}/{{$row->material_id}}/{{$row->quiz_id}}">Hapus</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection