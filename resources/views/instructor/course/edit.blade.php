@extends('layout/dashboard')

@section('title')
	Makanan
@endsection

@section('content')
	<div class="container">
		

		@if (session('alert'))
		    <div class="row mt-4">
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
				<b>Tambah Course</b>
			</div>
			<div class="card-body">
				<a href="/dashboard/instructor/course/{{$course->course_id}}" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
				
				<form class="mt-4" method="POST" action="/dashboard/instructor/course/{{$course->course_id}}/update" enctype="multipart/form-data">
				  @csrf
				  <div class="row">
				  	<div class="col-md-8">
				  		<div class="row">
				  			<div class="form-group col-md-8">
							    <label>Judul Course</label>
							    <input value="{{$course->course_name}}" type="text" class="form-control" placeholder="Belajar HTML Dasar" name="course_name" required="" autocomplete="off">
							</div>

							<div class="form-group col-md-4">
								<label>Kategori</label>
							    <select class="form-control" required name="category_id">
							    	<option value="">Pilih</option>
							    	@foreach($category as $row)
							    		<option <?= $course->category_id == $row->id ? 'selected="selected"' : "" ?> value="{{$row->id}}">{{$row->category_name}}</option>
							    	@endforeach
							    </select>
							</div>

							<div class="form-group col-md-12">
							    <label>Deskripsi</label>
							    <textarea class="form-control" placeholder="Ketik deskripsi disini..." name="course_description" required="" required="">{{$course->course_description}}</textarea>
							</div>

							<div class="form-group col-md-3">
							    <label>Tipe Course</label>
							    <select class="form-control" required id="priceType" name="price_type">
							    	<option value="">Pilih</option>
							    	<option <?= $course->price_type == 'paid' ? "selected='selected'" : '' ?> value="paid">Berbayar</option>
							    	<option <?= $course->price_type == 'free' ? "selected='selected'" : '' ?> value="free">Gratis</option>
							    </select>
							</div>

							<div class="form-group col-md-9" id="priceBody">
							    <label>Harga</label>
							    <input value="{{$course->course_price}}" type="number" class="form-control" name="course_price" placeholder="Rp. 0" autocomplete="off">
							</div>
				  		</div>
				  	</div>
				  	<div class="col-md-4">
				  		<div class="row">
					  		<div class="form-group col-md-12">
					  			<label>Thumbnail</label>
						  		<input name="course_image" type="file" class="btn btn-light">
						  		<small class="text-muted">*Upload gambar jika ingin mengubah</small>
						  		<br>

						  		<img class="img-fluid mt-3" src="/images/course/{{$course->course_image}}">
					  		</div>
						</div>
				  	</div>
				  </div>

				  <button type="submit" class="btn btn-warning">Ubah</button>
				</form>

			</div>
		</div>

	</div>

	<script type="text/javascript">
		<?php if($course->price_type == 'paid'){ ?>
				$('#priceBody').show();
		<?php }else{ ?>
				$('#priceBody').val('').hide();
		<?php } ?>
		

		$(document).on('change', '#priceType', function(){
			if($(this).val() != 'paid'){
				$('#priceBody').hide();
			}else{
				$('#priceBody').show();
			}
		})
	</script>
	
@endsection