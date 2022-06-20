@extends('layout/template')

@section('content')
	

	<div class="mdk-header-layout__content page-content ">

        <div class="border-bottom-2 py-16pt navbar-light bg-white border-bottom-2">
            <div class="container page__container">
                <div class="row align-items-center">
                    <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                        <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                            <i class="material-icons text-white">subscriptions</i>
                        </div>
                        <div class="flex">
                            <div class="card-title mb-4pt">8,000+ Courses</div>
                            <p class="card-subtitle text-70">Explore a wide range of skills.</p>
                        </div>
                    </div>
                    <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                        <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                            <i class="material-icons text-white">verified_user</i>
                        </div>
                        <div class="flex">
                            <div class="card-title mb-4pt">By Industry Experts</div>
                            <p class="card-subtitle text-70">Professional development from the best people.</p>
                        </div>
                    </div>
                    <div class="d-flex col-md align-items-center">
                        <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                            <i class="material-icons text-white">update</i>
                        </div>
                        <div class="flex">
                            <div class="card-title mb-4pt">Unlimited Access</div>
                            <p class="card-subtitle text-70">Unlock Library and learn any topic with one subscription.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-section border-bottom-2">
            <div class="container page__container">

                <div class="page-separator">
                    <div class="page-separator__text">Course Terbaru</div>
                </div>

                <div class="row card-group-row">

                	@foreach($course as $row)
	                    <div class="col-md-6 col-lg-4 card-group-row__col">
	                        <div class="card card--elevated posts-card-popular overlay card-group-row__card">
	                            <img src="/images/course/{{$row->course_image}}"
	                                 alt=""
	                                 class="card-img">
	                            <div class="fullbleed bg-primary"
	                                 style="opacity: .5"></div>
	                            <div class="posts-card-popular__content">
	                                <div class="card-body d-flex align-items-center">
	                                    <div class="avatar-group flex">
	                                        <div class="avatar avatar-xs"
	                                             data-toggle="tooltip"
	                                             data-placement="top"
	                                             title="{{$row->name}}">
	                                            <a href="#"><img src="/images/user/{{$row->photo}}"
	                                                     alt="Avatar"
	                                                     class="avatar-img rounded-circle"></a>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="posts-card-popular__title card-body">
	                                    <small class="text-muted text-uppercase">{{$row->category_name}}</small>
	                                    <a class="card-title"
	                                       href="/course/{{$row->course_id}}">{{$row->course_name}}</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                @endforeach

                </div>

               
            </div>
        </div>

        <div class="page-section border-bottom-2">
            <div class="container page__container">
                <div class="page-separator">
                    <div class="page-separator__text">Kategori</div>
                </div>

                <div class="row card-group-row">
                	@foreach($category as $row)
	                    <div class="col-sm-4 card-group-row__col">

	                        <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card"
	                             data-toggle="popover"
	                             data-trigger="click">

	                            <a href="/course?category_id={{$row->id}}">
		                            <div class="card-body d-flex flex-column">
		                                <div class="d-flex align-items-center">
		                                    <div class="flex">
		                                        <div class="d-flex align-items-center">
		                                            <div class="flex">
		                                                <div class="card-title">{{$row->category_name}}</div>
		                                                <p class="flex text-50 lh-1 mb-0"><small>{{$row->total_course}} Course</small></p>
		                                            </div>
		                                        </div>
		                                    </div>

		                                </div>

		                            </div>
		                        </a>
	                        </div>
	                    </div>
                    @endforeach

                </div>

            </div>
        </div>

        

        <div class="page-section">
            <div class="container page__container">
                <div class="page-headline text-center">
                    <h2>Feedback</h2>
                    <p class="lead measure-lead mx-auto text-70">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
                </div>

                <div class="position-relative carousel-card p-0 mx-auto">
                    <div class="row d-block js-mdk-carousel"
                         id="carousel-feedback">
                        <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                           href="#carousel-feedback"
                           role="button"
                           data-slide="next">
                            <span class="carousel-control-icon material-icons"
                                  aria-hidden="true">keyboard_arrow_right</span>
                            <span class="sr-only">Next</span>
                        </a>
                        <div class="mdk-carousel__content">

                            <div class="col-12 col-md-6">

                                <div class="card card-feedback card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                    </blockquote>
                                </div>
                                <div class="media ml-12pt">
                                    <div class="media-left mr-12pt">
                                        <a href="student-profile.html"
                                           class="avatar avatar-sm">
                                            <!-- <img src="/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">UK</span>
                                        </a>
                                    </div>
                                    <div class="media-body media-middle">
                                        <a href="student-profile.html"
                                           class="card-title">Umberto Kass</a>
                                        <div class="rating mt-4pt">
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="card card-feedback card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                    </blockquote>
                                </div>
                                <div class="media ml-12pt">
                                    <div class="media-left mr-12pt">
                                        <a href="student-profile.html"
                                           class="avatar avatar-sm">
                                            <!-- <img src="/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">UK</span>
                                        </a>
                                    </div>
                                    <div class="media-body media-middle">
                                        <a href="student-profile.html"
                                           class="card-title">Umberto Kass</a>
                                        <div class="rating mt-4pt">
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="card card-feedback card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                    </blockquote>
                                </div>
                                <div class="media ml-12pt">
                                    <div class="media-left mr-12pt">
                                        <a href="student-profile.html"
                                           class="avatar avatar-sm">
                                            <!-- <img src="/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">UK</span>
                                        </a>
                                    </div>
                                    <div class="media-body media-middle">
                                        <a href="student-profile.html"
                                           class="card-title">Umberto Kass</a>
                                        <div class="rating mt-4pt">
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection