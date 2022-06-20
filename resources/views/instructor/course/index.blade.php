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
				<b>Daftar Course</b>
			</div>
			<div class="card-body">
				<a href="/dashboard/instructor/course/add" class="btn btn-primary">Tambah Course</a> <br>

				<table class="table mt-3">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width:10%"></th>
							<th style="width: 25%">Course</th>
							<th>Total Materi</th>
							<th>Durasi</th>
							<th class="text-center">Harga</th>
							<th>Waktu Buat</th>
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
								<td>{{$row->total_material}}</td>
								<td>{{$row->total_duration}} Menit</td>
								<td class="text-right">
									<?= $row->price_type == 'paid' ? format_rp($row->course_price) : "<span class='badge bg-success text-white'>Gratis</span>" ?>
								</td>
								<td>
									{{indonesian_date($row->created_at, true)}}
								</td>
								<td>
									<a href="/dashboard/instructor/course/{{$row->course_id}}" class="btn btn-sm btn-outline-primary">Lihat</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection