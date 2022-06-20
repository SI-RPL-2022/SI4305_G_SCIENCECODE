@extends('layout/dashboard')

@section('title')
	Profil
@endsection

@section('content')
	<div class="container">
		@if (session('alert'))
		    <div class="row">
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

		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>GANTI BIODATA</b>
					</div>
					<div class="card-body">
						<form method="POST" action="/dashboard/profile/change_bio" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-6">
									<div class="form-group">
									    <label for="exampleInputEmail1">Email Address</label>
									    <h6>{{$profile->email}}</h6>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-md-3">
											<img src="/images/user/{{$profile->photo}}" style="width: 60px; height: 60px; border-radius:50%"> 
										</div>
										<div class="col-md-9">
											<input name="photo" type="file" class="mt-2">
											<small class="text-muted">*Upload foto jika ingin mengubah	</small>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
							    <label for="exampleInputEmail1">Nama Lengkap</label>
							    <input name="name" required="" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Nama Lengkap" value="{{$profile->name}}">
							</div>
						  
							<div class="form-group">
							    <label for="exampleInputEmail1">Nomor Handphone</label>
							    <input name="phone" required="" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan No. Handphone" value="{{$profile->phone}}">
							</div>

							<button type="submit" class="btn btn-warning text-white">Ubah Profile</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<b>GANTI PASSWORD</b>
					</div>
					<div class="card-body">
						<form method="POST" action="/dashboard/profile/change_password">
							@csrf
							<div class="form-group">
							    <label for="exampleInputEmail1">Password Baru</label>
							    <input name="password" required="" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Password">
							</div>

							<button type="submit" class="btn btn-danger text-white">Ganti Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection