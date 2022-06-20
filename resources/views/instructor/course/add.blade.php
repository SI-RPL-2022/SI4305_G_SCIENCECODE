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
				<a href="/dashboard/instructor/course" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
				
				<form class="mt-4" method="POST" action="/dashboard/instructor/course/insert" enctype="multipart/form-data">
				  @csrf
				  <div class="row">
				  	<div class="col-md-8">
				  		<div class="row">
				  			<div class="form-group col-md-8">
							    <label>Judul Course</label>
							    <input type="text" class="form-control" placeholder="Belajar HTML Dasar" name="course_name" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-4">
								<label>Kategori</label>
							    <select class="form-control" required name="category_id">
							    	<option value="">Pilih</option>
							    	@foreach($category as $row)
							    		<option value="{{$row->id}}">{{$row->category_name}}</option>
							    	@endforeach
							    </select>
							</div>

							<div class="form-group col-md-12">
							    <label>Deskripsi</label>
							    <textarea class="form-control" placeholder="Ketik deskripsi disini..." name="course_description" required="" required=""></textarea>
							</div>

							<div class="form-group col-md-3">
							    <label>Tipe Course</label>
							    <select class="form-control" required id="priceType" name="price_type">
							    	<option value="">Pilih</option>
							    	<option value="paid">Berbayar</option>
							    	<option value="free">Gratis</option>
							    </select>
							</div>

							<div class="form-group col-md-9" id="priceBody">
							    <label>Harga</label>
							    <input type="number" class="form-control" name="course_price" placeholder="Rp. 0" autocomplete="off">
							</div>
				  		</div>
				  	</div>
				  	<div class="col-md-4">
				  		<div class="row">
					  		<div class="form-group col-md-12">
					  			<label>Thumbnail</label>
						  		<input name="course_image" required type="file" class="btn btn-light">
					  		</div>
						</div>
				  	</div>
				  </div>

				  <button type="submit" class="btn btn-success">Simpan</button>
				</form>

			</div>
		</div>

	</div>

	<script type="text/javascript">
		$('#priceBody').hide();

		$(document).on('change', '#priceType', function(){
			if($(this).val() != 'paid'){
				$('#priceBody').hide();
			}else{
				$('#priceBody').show();
			}
		})
	</script>
	
@endsection