@extends('layout/template')

@section('content')
	<div class="mdk-header-layout__content page-content ">
            
        <div class="page-section bg-alt border-bottom-2">

            <div class="container page__container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <img src="/images/course/{{$course->course_image}}" class="img-fluid">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="page-separator">
                            <div class="page-separator__text">{{$course->course_name}}</div>
                        </div>
                        {{$course->course_description}}
                    </div>
                </div>

                @if (session('alert'))
                    <div class="row mt-4">
                        <div class="col-md-12">
                            {!! session('alert') !!}
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
            <div class="container page__container">
                <ul class="nav navbar-nav flex align-items-sm-center">
                    <li class="nav-item navbar-list__item">
                        <div class="media align-items-center">
                            <span class="media-left mr-16pt">
                                <img src="/images/user/{{$course->photo}}"
                                     width="40"
                                     alt="avatar"
                                     class="rounded-circle">
                            </span>
                            <div class="media-body">
                                <a class="card-title m-0"
                                   href="teacher-profile.html">{{$course->name}}</a>
                                <p class="text-50 lh-1 mb-0">Instructor</p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">schedule</i>
                        {{$course->total_duration}} Menit
                    </li>
                    <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">assessment</i>
                        {{$course->total_material}} Materi
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-section border-bottom-2">
            <div class="container page__container">

                <div class="row mb-0">
                    <div class="col-lg-7">
                        <div class="page-separator">
                            <div class="page-separator__text">Daftar Materi</div>
                        </div>

                        <div class="accordion js-accordion accordion--boxed list-group-flush"
                             id="parent">
                             @foreach($sections as $section)
                             	<div class="accordion__item <?= $loop->iteration == '1' ? 'open' : '' ?>">
	                                <a href="#"
	                                   class="accordion__toggle collapsed"
	                                   data-toggle="collapse"
	                                   data-target="#course-toc-{{$loop->iteration}}"
	                                   data-parent="#parent">
	                                    <span class="flex">{{$section->section_name}}</span>
	                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
	                                </a>
	                                <div class="accordion__menu collapse <?= $loop->iteration == '1' ? 'show' : '' ?>"
	                                     id="course-toc-{{$loop->iteration}}">
	                                     
	                                    @foreach($section->material as $material)
	                                    	<div class="accordion__menu-link">
                                                
		                                    	<span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
	                                            	<i class="material-icons icon-16pt">
                                                    <?= $material->material_type == 'video' ? 'play_circle_outline' : 'quiz' ?>
                                                    </i>
	                                        	</span>
		                                        
		                                        <a class="flex"
		                                           href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}/material/{{$material->id}}">{{$material->material_title}}</a>

                                                @if($material->score != '')
                                                    Skor : {{$material->score}} &nbsp;
                                                @endif

                                                @if($material->is_understand == '1')
                                                    <span class="mr-1 text-success">
                                                        <i class="material-icons icon-16pt">check_circle</i>
                                                    </span>
                                                @endif

		                                        <span class="text-muted">{{$material->duration}} m</span>
		                                    </div>
	                                    @endforeach
	                                </div>
	                            </div>
                             @endforeach
                            
                        </div>

                    </div>
                    <div class="col-lg-5 justify-content-center">
                        <div class="page-separator">
                            <div class="page-separator__text">Sertifikat</div>
                        </div>

                        <div class="card">
                            <div class="card-body py-16pt text-center">
                                

                                @if($enroll->is_done == '1')
                                    <span class="icon-holder icon-holder--outline-secondary rounded-circle d-inline-flex mb-8pt">
                                        <i class="material-icons">insert_drive_file</i>
                                    </span>
                                    <br>
                                    <a target="_blank" href="/dashboard/enrollment/{{request()->route('enroll_id')}}/{{$course->course_id}}/certificate" class="btn btn-success">
                                        Download Sertifikat
                                    </a>
                                @else
                                    <span class="icon-holder icon-holder--outline-secondary rounded-circle d-inline-flex mb-8pt">
                                        <i class="material-icons">timer</i>
                                    </span>
                                    <h6 class="text-danger">Kamu belum menyelesaikan course ini</h6>
                                    <?php 
                                        $percentage = $course->total_material > 0 ? round($totalDone / $course->total_material * 100) : 0;
                                    ?>

                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$percentage}}% completed {{$totalDone}}/{{$course->total_material}}"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-secondary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$percentage}}"
                                                     style="width: {{$percentage}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                        <div class="page-separator">
                            <div class="page-separator__text">Rating</div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                @if(isset($rating->id))
                                    <div class="text-center">
                                        @for($i = 0; $i < $rating->rating; $i++)
                                            <i class="material-icons text-warning">star</i>
                                        @endfor

                                        <hr>
                                        {{$rating->review}}
                                        <br>
                                        <small class="text-muted">{{indonesian_date($rating->created_at, true)}}</small>
                                    </div>
                                @else
                                    <form method="POST" action="/dashboard/enrollment/insert_rating/{{request()->route('enroll_id')}}/{{$course->course_id}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <label>Rating</label>
                                                <select class="form-control" name="rating" required="">
                                                    <option value="">Pilih</option>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-12 text-left mt-3">
                                                <label>Review</label>
                                                <textarea class="form-control" required="" name="review" placeholder="Ketik review disini..."></textarea>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <button class="btn btn-success">Kirim</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        

        
    </div>
@endsection