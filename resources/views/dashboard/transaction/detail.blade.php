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
										@if($transaction->status == 'pending')
											<div class="alert alert-warning text-center">
												Lakukan pembayaran ke rekening <br><b>BRI</b> - <b>2341212312412</b> <br>a/n <b>Nisa Sabyan</b>
											</div>

											<hr>

											<div class="mt-3">
												<input type="file" name="payment_proof" required class="btn btn-light">
												<button class="btn btn-success btn-sm btn-block mt-3" type="submit">Upload Bukti Transfer</button>
											</div>
										@elseif($transaction->status == 'need_confirmation')
											<div class="alert alert-info text-center">
												<b>Bukti pembayaran berhasil dikirim</b><br>
												Silahkan tunggu hingga admin melaukan proses dan verifikasi pembayaran kamu.
											</div>

											<small class="text-muted">Bukti Transfer</small>
											<img src="/images/payment/{{$transaction->payment_proof}}" class="img-fluid">
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