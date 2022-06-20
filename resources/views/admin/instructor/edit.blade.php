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
				Ubah Instruktur
			</div>
			<div class="card-body">
				<a href="/dashboard/admin/instructor" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
				
				<form class="mt-4" method="POST" action="/dashboard/admin/instructor/update/{{$instructor->id}}" enctype="multipart/form-data">
				  @csrf
				  <div class="row">
				  	<div class="col-md-8">
				  		<div class="row">
				  			<div class="form-group col-md-12">
							    <label>Nama Instruktur</label>
							    <input value="{{$instructor->name}}" type="text" class="form-control" placeholder="John Doe" name="name" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>Email</label>
							    <input value="{{$instructor->email}}" type="text" class="form-control" placeholder="john.doe@gmail.com" name="email" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>No Handphone</label>
							    <input value="{{$instructor->phone}}" type="text" class="form-control" placeholder="08318238213" name="phone" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>Password</label>
							    <input type="password" class="form-control" placeholder="********" name="password" autocomplete="off">
							    <small class="text-muted">*Isi password jika ingin mengganti</small>
							</div>
				  		</div>
				  	</div>
				  	<div class="col-md-4">
				  		<div class="row">
					  		<div class="form-group col-md-12">
					  			<label>Foto</label>
						  		<input name="photo" type="file" class="btn btn-light">
						  		<small class="text-muted">*Upload foto jika ingin mengganti</small>
					  		</div>

					  		<br>
					  		<div class="text-center col-md-12">
					  			<img src="/images/user/{{ $instructor->photo }}" class="img-fluid text-center" style="border-radius:50%; width: 100px; height: 100px">
					  		</div>
						</div>
				  	</div>
				  </div>

				  <button type="submit" class="btn btn-warning">Ubah</button>
				</form>

			</div>
		</div>

	</div>
	
@endsection