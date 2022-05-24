@extends('layout/template')

@section('content')
	<div class="mdk-header-layout__content page-content ">

        <div class="navbar navbar-light border-0 navbar-expand">
            <div class="container page__container">
                <div class="media flex-nowrap">
                    <div class="media-left mr-16pt">
                        <a href="student-course.html"><img src="/images/user/{{$course->photo}}"
                                 width="40"
                                 alt="Angular"
                                 class="rounded"></a>
                    </div>
                    <div class="media-body">
                        <a href="/course/{{$course->course_id}}"
                           class="card-title text-body mb-0">{{$course->course_name}}</a>
                        <p class="lh-1 d-flex align-items-center mb-0">
                            <span class="text-50 small font-weight-bold mr-8pt">{{$material->material_title}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-primary pb-lg-64pt py-32pt">
            <div class="container page__container">
                <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                    <iframe width="988" height="556" src="https://www.youtube.com/embed/cHnKrLksWGk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>

                <div class="d-flex flex-wrap align-items-end mb-16pt">
                    <h1 class="text-white flex m-0">{{$material->material_title}}</h1>
                    <p class="h1 text-white-50 font-weight-light m-0">{{$material->duration}} Menit</p>
                </div>

                <p class="hero__lead measure-hero-lead text-white-50 mb-24pt">
                	{{$material->material_description}}
                </p>
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
                        {{$material->duration}} Menit
                    </li>
                </ul>
            </div>
        </div>

    </div>
@endsection