@extends('layout/dashboard')

@section('title')
	Dashboard
@endsection

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h6>Daftar Course</h6>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th></th>
							<th>Course</th>
							<th>Tanggal Enroll</th>
							<th>Progress</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection