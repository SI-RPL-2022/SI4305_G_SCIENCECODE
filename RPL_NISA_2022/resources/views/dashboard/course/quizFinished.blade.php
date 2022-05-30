@extends('layout/template')

@section('content')
	<div class="container">

		<div class="mdk-header-layout__content page-content">

            <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm"
                 style="white-space: nowrap;">
                <div class="container page__container">
                    <nav class="nav navbar-nav">
                        <div class="nav-item navbar-list__item">
                            <a href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}"
                               class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> Kembali ke Course</a>
                        </div>
                        <div class="nav-item navbar-list__item">
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="flex">
                                    <a href="student-take-course.html"
                                       class="card-title text-body mb-0">{{$material->material_title}}</a>
                                    <p class="lh-1 d-flex align-items-center mb-0">
                                        <span class="text-50 small font-weight-bold mr-8pt">
                                            {{$material->section_name}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card no-shadow">
                        <div class="card-body">
                             <div class="page-separator pt-0 pb-0">
                                <div class="page-separator__text">Skor Quiz</div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 text-center ml-2" style="border: 2px dashed #eee">
                                    <div class="mt-2">
                                        <small>Nilai</small><br>
                                        <span style="font-size:35px" class="text-success pb-0"><b>50</b></span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center text-success">
                                    <small><i class="material-icons icon--left">check_circle</i> Total Benar</small>
                                    <h3>7</h3>
                                </div>
                                <div class="col-md-2 text-center text-danger">
                                    <small><i class="material-icons icon--left">cancel</i> Total Salah</small>
                                    <h3>3</h3>
                                </div>
                                <div class="col-md-2 text-center">
                                    <small>Jumlah Soal</small>
                                    <h3>10</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card no-shadow">
                        <div class="card-body">
                             <div class="page-separator pt-0 pb-0">
                                <div class="page-separator__text">Urutan Soal</div>
                            </div>

                            <div>
                                <?php $currentNum = 0; ?>
                                @foreach($quizNumber['data'] as $row)
                                    <?php 
                                        $style = $row->correct_answer == $row->answer ? 'btn-success' : 'btn-danger';
                                        $current = $row->id == $quiz->id ? true : false;
                                        if($current) $currentNum = $loop->iteration;
                                    ?>
                                    <a 
                                        href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}/material/{{request()->route('material_id')}}?quiz_id={{$row->id}}" 
                                        class="btn border-1 {{$style}}">
                                        {{$loop->iteration}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('alert'))
                <div class="row">
                    <div class="col-md-12">
                        {!! session('alert') !!}
                    </div>
                </div>
            @endif

            <div class="bg-primary pb-lg-64pt py-32pt">
                <div class="container page__container">

                    <div class="d-flex flex-wrap align-items-end justify-content-end mb-16pt">
                        <h3 class="text-white flex m-0">No {{$currentNum}}</h3>
                    </div>

                    <p class="hero__lead text-white">{{$quiz->quiz}}</p>
                </div>
            </div>

            <div class="navbar navbar-expand-md navbar-list navbar-light bg-white border-bottom-2 "
                 style="white-space: nowrap;">
                <div class="container page__container">
                    <div class="nav navbar-nav ml-sm-auto navbar-list__item">
                        <div class="nav-item d-flex flex-column flex-sm-row ml-sm-16pt">
                            @if($quizControl['prev'])
                                <a href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}/material/{{request()->route('material_id')}}?quiz_id={{$quizNumber['data'][$currentNum - 2]->id}}"
                               class="btn justify-content-center btn-outline-primary w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt"><i class="material-icons icon--left">keyboard_arrow_left</i> Sebelumnya</a> 
                            @else
                                 <a href="#" disabled
                               class="btn justify-content-center btn-outline-primary disabled w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt"><i class="material-icons icon--left">keyboard_arrow_left</i> Sebelumnya</a> 
                            @endif
                        	

                             @if($quizControl['next'])
                                <a href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}/material/{{request()->route('material_id')}}?quiz_id={{$quizControl['next']->id}}"
                               class="btn justify-content-center btn-outline-primary w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt">Selanjutnya <i class="material-icons icon--left">keyboard_arrow_right</i></a> 
                            @else
                                 <a href="#" disabled
                               class="btn justify-content-center btn-outline-primary disabled w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt">Selanjutnya <i class="material-icons icon--left">keyboard_arrow_right</i></a> 
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
            	<div class="card">
            		<div class="card-body">
            			<div class="page-section pt-0 pb-0">
		                    <div class="page-separator">
		                        <div class="page-separator__text">Opsi</div>
		                    </div>

                            <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input id="customCheck01"
                                               name="option"
                                               value="1"
                                               type="radio"
                                               disabled=""
                                               class="custom-control-input"
                                               <?= $quizOption->option_num == '1' ? 'checked="checked"' : '' ?>
                                        >
                                        <label for="customCheck01"
                                               class="custom-control-label <?= $quizOption->correct_answer == '1' ? 'text-success' : 'text-danger' ?>">
                                            <?= $quizOption->option_1 ?>           
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input id="customCheck02"
                                               name="option"
                                               value="2"
                                               type="radio"
                                               class="custom-control-input"
                                               disabled=""
                                               <?= $quizOption->option_num == '2' ? 'checked="checked"' : '' ?>
                                        >
                                        <label for="customCheck02"
                                               class="custom-control-label <?= $quizOption->correct_answer == '2' ? 'text-success' : 'text-danger' ?>">
                                            <?= $quizOption->option_2 ?>           
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input id="customCheck03"
                                               type="radio"
                                               name="option"
                                               value="3"
                                               disabled=""
                                               class="custom-control-input"
                                               <?= $quizOption->option_num == '3' ? 'checked="checked"' : '' ?>
                                        >
                                        <label for="customCheck03"
                                               class="custom-control-label <?= $quizOption->correct_answer == '3' ? 'text-success' : 'text-danger' ?>">
                                            <?= $quizOption->option_3 ?>           
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input id="customCheck04"
                                               type="radio"
                                               name="option"
                                               value="4"
                                               disabled=""
                                               class="custom-control-input"
                                               <?= $quizOption->option_num == '4' ? 'checked="checked"' : '' ?>
                                        >
                                        <label for="customCheck04"
                                               class="custom-control-label <?= $quizOption->correct_answer == '4' ? 'text-success' : 'text-danger' ?>">
                                            <?= $quizOption->option_4 ?>           
                                        </label>
                                    </div>
                                </div>
		                </div>
            		</div>
            	</div>
            </div>

        </div>

        <script type="text/javascript">
            $(document).on('change', 'input[type="radio"][name="option"]', function(){
                $('#formOption').submit();
            })
        </script>
@endsection