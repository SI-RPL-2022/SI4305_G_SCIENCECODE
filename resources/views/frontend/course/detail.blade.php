@extends('layout/template')

@section('content')
	<div class="mdk-header-layout__content page-content ">
        <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm"
             style="white-space: nowrap;">
            <div class="container page__container">
                <nav class="nav navbar-nav">
                    <div class="nav-item navbar-list__item">
                        <a href="/course"
                           class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> Lihat Daftar Course</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="mdk-box bg-primary js-mdk-box mb-0"
             data-effects="blend-background">
            <div class="mdk-box__content">
                <div class="hero py-64pt text-center text-sm-left">
                    <div class="container page__container">
                    	<img src="/images/course/{{$course->course_image}}" class="img-fluid">
                        <h2 class="text-white mt-3">{{$course->course_name}}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="page-section bg-alt border-bottom-2">

            <div class="container page__container">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="page-separator">
                            <div class="page-separator__text">About this course</div>
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

                <div class="page-separator">
                    <div class="page-separator__text">Daftar Materi</div>
                </div>
                <div class="row mb-0">
                    <div class="col-lg-7">

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
	                                    		@if($material->is_overview == '0')
		                                    		<span class="icon-holder icon-holder--small icon-holder--light rounded-circle d-inline-flex icon--left">
			                                            <i class="material-icons icon-16pt">lock</i>
			                                        </span>
	                                    		@else
			                                    	<span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
		                                            	<i class="material-icons icon-16pt">play_circle_outline</i>
		                                        	</span>
	                                    		@endif
		                                        
		                                        <?php $url = $material->is_overview == '1' ? '/course/'.$course->course_id.'/material/'.$material->id : 'javascript:void(0)' ?>
		                                        <a class="flex"
		                                           href="<?= $url ?>">{{$material->material_title}}</a>
		                                        <span class="text-muted">{{$material->duration}} m</span>
		                                    </div>
	                                    @endforeach
	                                </div>
	                            </div>
                             @endforeach
                            
                        </div>

                    </div>
                    <div class="col-lg-5 justify-content-center">
                        <div class="card">
                            <div class="card-body py-16pt text-center">
                                <span class="icon-holder icon-holder--outline-secondary rounded-circle d-inline-flex mb-8pt">
                                    <i class="material-icons">timer</i>
                                </span>
                                <?php 
                                	$price = $course->price_type == 'paid' ? format_rp($course->course_price) : 'Gratis'
                                ?>
                                <h4 class="card-title"><strong><?= $price ?></strong></h4>

                                <div class="mt-2">
	                                @if(session()->has('user'))
                                        @if(is_user())
    	                                	@if($course->price_type == 'paid')
    	                                		<a href="/course/buy/{{$course->course_id}}" class="btn btn-success">Beli Course Ini Sekarang</a>
    	                                	@else
    	                                		<a href="/course/enroll/{{$course->course_id}}" class="btn btn-success">Enroll Sekarang</a>
    	                                	@endif
                                        @endif
	                                @else
	                                	<a href="/auth/login"
	                                   class="btn btn-accent mb-8pt">Login</a>
	                               		<p class="mb-0">Anda harus login agar dapat melakukan enroll course</p>
	                                @endif
	                            </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       
        <div class="page-section bg-alt border-bottom-2">

            <div class="container page__container">
                <div class="page-separator">
                    <div class="page-separator__text">Course Rating</div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-md-3 mb-32pt mb-md-0">
                        <div class="display-1">
                        	{{round($rating['average'])}}
                        </div>
                        <p class="text-muted mb-0">{{$rating['totalRating']}} Ratings</p>
                    </div>
                    <div class="col-md-9">
                		<?php 
                			$max = 5;
                			for($i = $max; $i >= 1; $i--){
                				if($rating['totalRating'] > 0){
                					$percentage = round($rating['overview'][$i] / $rating['totalRating'] * 100);
                				}else{
                					$percentage = 0;
                				}
                				
                		?>
                				<div class="row align-items-center mb-8pt"
	                             data-toggle="tooltip"
	                             data-title="{{$percentage}}% rated {{$rating['overview'][$i]}}/{{$rating['totalRating']}}"
	                             data-placement="top">
	                            <div class="col-md col-sm-6">
	                                <div class="progress"
	                                     style="height: 8px;">
	                                    <div class="progress-bar bg-secondary"
	                                         role="progressbar"
	                                         aria-valuenow="75"
	                                         style="width: {{$percentage}}%"
	                                         aria-valuemin="0"
	                                         aria-valuemax="100"></div>
	                                </div>
	                            </div>
	                            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
	                                <div class="rating">
	                                	<?php $nonStar = $max - $i;?>
	                                	<?php for($j = 1; $j <= $i; $j++){ ?>
	                                		<span class="rating__item"><span class="material-icons">star</span></span>
	                                	<?php } ?>

	                                	<?php for($k = 1; $k <= $nonStar; $k++){ ?>
	                                		<span class="rating__item"><span class="material-icons">star_border</span></span>
	                                	<?php } ?>
	                                </div>
	                            </div>
	                        </div>
                		<?php
                			}
                		?>

                    </div>
                </div>

                @foreach($rating['list'] as $row)
                	<div class="pb-16pt mb-16pt border-bottom row">
	                    <div class="col-md-3 mb-16pt mb-md-0">
	                        <div class="d-flex">
	                            <a href="#"
	                               class="avatar avatar-sm mr-12pt">
	                                <img src="/images/user/{{$row->photo}}" alt="avatar" class="avatar-img rounded-circle">
	                            </a>
	                            <div class="flex">
	                                <p class="small text-muted m-0">{{$row->review_created_at}}</p>
	                                <a href="#"
	                                   class="card-title">{{$row->name}}</a>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-md-9">
	                        <div class="rating mb-8pt">
	                        	<?php $nonStar = $max - $row->rating;?>
                            	<?php for($j = 1; $j <= $row->rating; $j++){ ?>
                            		<span class="rating__item"><span class="material-icons">star</span></span>
                            	<?php } ?>

                            	<?php for($k = 1; $k <= $nonStar; $k++){ ?>
                            		<span class="rating__item"><span class="material-icons">star_border</span></span>
                            	<?php } ?>
	                        </div>
	                        <p class="text-70 mb-0">
	                        	{{$row->review}}
	                        </p>
	                    </div>
	                </div>
                @endforeach
                

            </div>

        </div>

        
    </div>
@endsection