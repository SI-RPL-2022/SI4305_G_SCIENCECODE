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
				Tambah User
			</div>
			<div class="card-body">
				<a href="/dashboard/admin/user" class="btn btn-white border-1"><i class="material-icons">arrow_left</i> Kembali</a>
				
				<form class="mt-4" method="POST" action="/dashboard/admin/user/insert" enctype="multipart/form-data">
				  @csrf
				  <div class="row">
				  	<div class="col-md-8">
				  		<div class="row">
				  			<div class="form-group col-md-12">
							    <label>Nama User</label>
							    <input type="text" class="form-control" placeholder="John Doe" name="name" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>Email</label>
							    <input type="text" class="form-control" placeholder="john.doe@gmail.com" name="email" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>No Handphone</label>
							    <input type="text" class="form-control" placeholder="08318238213" name="phone" required="" autocomplete="off" required="">
							</div>

							<div class="form-group col-md-12">
							    <label>Password</label>
							    <input type="password" class="form-control" placeholder="********" name="password" required="" autocomplete="off" required="">
							</div>
				  		</div>
				  	</div>
				  	<div class="col-md-4">
				  		<div class="row">
					  		<div class="form-group col-md-12">
					  			<label>Foto</label>
						  		<input name="photo" required type="file" class="btn btn-light">
					  		</div>
						</div>
				  	</div>
				  </div>

				  <button type="submit" class="btn btn-success">Simpan</button>
				</form>

			</div>
		</div>

	</div>
	
@endsection