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
			<div class="alert alert-danger mb-3">
			    {!! implode('', $errors->all('<div>:message</div>')) !!}
			</div>
		@endif

		<div class="card">
			<div class="card-header">
				<h6>Detail Transaksi</h6>
			</div>
			<div class="card-body">
				<a class="btn btn-white btn-outline-light border-1"><i class="material-icons">arrow_left</i> Kembali</a>
				
				<div class="row mt-3">
					<div class="col-md-8">
						<h6>Produk</h6>

						<table class="table">
							<tbody>
								<tr>
									<td style="width:15%">
										<img class="img-fluid" src="/images/course/{{$transaction->course_image}}">
									</td>
									<td>
										<small class="text-muted">Course</small><br>
										{{$transaction->course_name}}
									</td>
									<td>
										<small class="text-muted">Kategori</small><br>
										{{$transaction->category_name}}
									</td>
									<td>
										<small class="text-muted">Tanggal Transaksi</small><br>
										{{indonesian_date($transaction->created_at, true)}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-4">
						<h6>Pembayaran</h6>

						<form method="POST" enctype="multipart/form-data" action="/dashboard/transaction/upload_payment/{{$transaction->id}}">
							@csrf
							<table class="table">
								<tr>
									<td>
										<small class="text-muted">Status</small> <br>
										@if($transaction->status == 'pending')
											<span class="badge bg-primary text-white">Pending</span>
										@elseif($transaction->status == 'complete')
											<span class="badge bg-success text-white">Selesai</span>
										@elseif($transaction->status == 'deny')
											<span class="badge bg-danger text-white">Ditolak</span>
										@elseif($transaction->status == 'need_confirmation')
											<span class="badge bg-info text-white">Menunggu Konfirmasi</span>
										@endif
									</td>
									<td>
										<small class="text-muted">Total Pembayaran</small> <br>
										<b>{{format_rp($transaction->total_price)}}</b>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<small class="text-muted">Bukti Transfer</small>
										<img src="/images/payment/{{$transaction->payment_proof}}" class="img-fluid">
										
										@if($transaction->status == 'need_confirmation')
											<div class="row mt-3">
												<div class="col-md-6">
													<a href="/dashboard/admin/transaction/validation_payment/{{$transaction->id}}/confirm" onclick="confirm('Apakah kamu yakin menyetujui transaksi ini ?')" class="btn btn-sm btn-success btn-block">Terima</a>
												</div>
												<div class="col-md-6">
													<a href="/dashboard/admin/transaction/validation_payment/{{$transaction->id}}/deny" onclick="confirm('Apakah kamu yakin menolak transaksi ini ?')" class="btn btn-sm btn-danger btn-block">Tolak</a>
												</div>
											</div>
										@endif
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection