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

		<div class="card">
			<div class="card-header">
				Daftar Instruktur
			</div>
			<div class="card-body">
				<a href="/dashboard/admin/instructor/add" class="btn btn-primary">Tambah Instruktur</a>
				
				<table class="table mt-4">
					<thead>
						<tr>
							<th style="width: 5%">#</th>
							<th style="width: 5%">Foto</th>
							<th>Instructor</th>
							<th style="width: 20%">Kontak</th>
							<th style="width: 15%" class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($instructor) > 0)
							@foreach ($instructor as $row) 
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>
										<img src="/images/user/{{ $row->photo }}" class="img-fluid" style="border-radius:50%; width: 40px; height: 40px">
									</td>
									<td>{{ $row->name }}</td>
									<td>{{ $row->phone }}<br><small class="text-muted">{{$row->email}}</small></td>
									<td class="text-center">
										<a href="/dashboard/admin/instructor/edit/{{ $row->id }}" class="btn btn-outline-warning btn-sm">Ubah</a>
										<a onclick="return confirm('Apakah kamu yakin menghapus data ini ?')" href="/dashboard/admin/instructor/delete/{{ $row->id }}" class="btn btn-outline-danger btn-sm">Hapus</a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5" class="text-center">
									<h6>Data is empty</h6>
								</td>
							</tr>
						@endif
						
					</tbody>
				</table>

			</div>
		</div>

	</div>
	
@endsection