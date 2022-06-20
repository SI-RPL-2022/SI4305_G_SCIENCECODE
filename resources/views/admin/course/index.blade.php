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
				<h6>Daftar Course</h6>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width:10%"></th>
							<th style="width: 20%">Course</th>
							<th>Instruktur</th>
							<th>Waktu Buat</th>
							<th class="text-center">Harga</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($course as $row)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>
									<img class="img-fluid" src="/images/course/{{$row->course_image}}">
								</td>
								<td>
									{{$row->course_name}}<br>
									<small class="text-muted">Kategori : {{$row->category_name}}</small>
								</td>
								<td>
									{{$row->name}}<br>
									<small class="text-muted">{{$row->email}}</small>
								</td>
								<td>
									{{indonesian_date($row->created_at, true)}}
								</td>
								<td class="text-right">
									<?= $row->price_type == 'paid' ? format_rp($row->course_price) : "<span class='badge bg-success text-white'>Gratis</span>" ?>
								</td>
								<td>
									<a href="/dashboard/admin/course/{{$row->course_id}}" class="btn btn-sm btn-outline-primary">Lihat</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection