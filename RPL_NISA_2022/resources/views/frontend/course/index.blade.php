@extends('layout/template')

@section('content')
	<div class="mdk-header-layout__content page-content ">
        <div data-push
             data-responsive-width="992px"
             class="mdk-drawer-layout js-mdk-drawer-layout">
            <div class="mdk-drawer-layout__content">

                <div class="page-section">
                    <div class="container page__container">

                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach($category as $row)
                                        <option value="{{$row->id}}">{{$row->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="page-separator mt-4">
                            <div class="page-separator__text">Daftar Course</div>
                        </div>

                        <div class="row card-group-row">
                            @foreach($course as $row) 
                                <div class="col-md-6 col-lg-4 col-xl-4 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
                                         data-toggle="popover"
                                         data-trigger="click">

                                        <a href="/course/{{$row->course_id}}"
                                           class="card-img-top js-image"
                                           data-position=""
                                           data-height="140">
                                            <img src="/images/course/{{$row->course_image}}"
                                                 alt="course">
                                            <span class="overlay__content">
                                                <span class="overlay__action d-flex flex-column text-center">
                                                    <i class="material-icons icon-32pt">play_circle_outline</i>
                                                    <span class="card-title text-white">Preview</span>
                                                </span>
                                            </span>
                                        </a>

                                        <div class="card-body flex">
                                            <div class="d-flex">
                                                <div class="flex">
                                                    <a class="card-title"
                                                       href="/course/{{$row->course_id}}">{{$row->course_name}}</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">{{$row->category_name}}</small>

                                                    <h6 class="mb-0"><?= $row->price_type == 'paid' ? format_rp($row->course_price) : '<span class="text-success">Gratis</span>' ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row justify-content-between">
                                                <div class="col-auto d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>{{$row->total_duration}} Minutes</small></p>
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>{{$row->total_material}} Materi</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection