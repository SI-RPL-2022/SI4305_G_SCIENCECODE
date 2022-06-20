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
							<th style="width: 25%">Course</th>
							<th>Tanggal Transaksi</th>
							<th class="text-center">Total Pembayaran</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($transaction as $row)
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
									{{indonesian_date($row->created_at, true)}}
								</td>
								<td class="text-right">
									{{format_rp($row->total_price)}}
								</td>
								<td>
									@if($row->status == 'pending')
										<span class="badge bg-primary text-white">Pending</span>
									@elseif($row->status == 'complete')
										<span class="badge bg-success text-white">Selesai</span>
									@elseif($row->status == 'deny')
										<span class="badge bg-danger text-white">Ditolak</span>
									@elseif($row->status == 'need_confirmation')
										<span class="badge bg-info text-white">Menunggu Konfirmasi</span>
									@endif
								</td>
								<td>
									<a href="/dashboard/transaction/{{$row->id}}" class="btn btn-sm btn-outline-primary">Lihat Transaksi</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection