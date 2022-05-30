@extends('layout/template')

@section('content')
	<div class="mdk-header-layout__content page-content ">

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
        <div class="bg-primary pb-lg-64pt py-32pt">
            <div class="container page__container">
                <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                    <iframe width="988" height="556" src="{{$material->material_video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
                    <li class="nav-item navbar-list__item">
                        @if(isset($enrollMaterial->is_understand))
                            <span class="text-success">
                                <i class="material-icons">check_circle</i>
                                <b>Materi sudah ditandai</b>
                            </span>
                        @else
                            <a href="/dashboard/enrollment/done/{{request()->route('enroll_id')}}/{{$course->course_id}}/{{$material->id}}" class="btn btn-success">Saya sudah mengerti bagian ini</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        @if (session('alert'))
            <div class="container">
                <div class="row mt-4">
                    <div class="col-md-12">
                        {!! session('alert') !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b>DAFTAR PERTANYAAN</b>
                        </div>
                        <div class="card-body">
                            <div class="mt-3">
                                @foreach($discussion as $row)
                                    <div class="pb-16pt mb-16pt border-bottom row">
                                        <div class="col-md-3 mb-16pt mb-md-0">
                                            <div class="d-flex">
                                                <a href="#"
                                                   class="avatar avatar-sm mr-12pt">
                                                    <img src="/images/user/{{$row->user_photo}}" alt="avatar" class="avatar-img rounded-circle">
                                                </a>
                                                <div class="flex">
                                                    <p class="small text-muted m-0">{{$row->discussion_at}}</p>
                                                    <a href="javascript:void(0)"
                                                       class="card-title">{{$row->user_name}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-100 mb-0">
                                                {{$row->disscussion}}
                                            </p>

                                            <div class="row mt-3">
                                                <div class="col-md-9">
                                                    <span class="text-muted">Jawaban :</span>
                                                    @if($row->reply_id != '')
                                                    <p>
                                                        {{$row->reply}}
                                                    </p>
                                                    <div class="d-flex">
                                                        <a href="#"
                                                           class="avatar avatar-sm mr-12pt">
                                                            <img style="width: 30px; height: 30px" src="/images/user/{{$row->instructor_photo}}" alt="avatar" class="avatar-img rounded-circle">
                                                        </a>
                                                        <div class="flex">
                                                            <p class="small text-muted m-0" style="font-size:12px">{{$row->reply_at}}</p>
                                                            <a href="javascript:void(0)" style="font-size:12px"
                                                               class="card-title">{{$row->instructor_name}}</a>
                                                        </div>
                                                    </div>
                                                    @else
                                                        <span class="text-danger">Menunggu balasan...</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>  
                        </div>
                        <div class="card-footer">
                            <form method="POST" action="/dashboard/enrollment/sendQuestion/{{request()->route('enroll_id')}}/{{$course->course_id}}/{{$material->id}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <textarea class="form-control" required="" name="disscussion" placeholder="Ketik pertanyaanmu disini..."></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection