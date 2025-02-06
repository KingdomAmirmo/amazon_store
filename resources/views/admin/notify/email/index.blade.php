@extends('admin.layouts.master')

@section('head-tag')
    <title>اطلاعیه ایمیلی</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">اطلاعیه ایمیلی</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>اطلاعیه ایمیلی</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.notify.email.create') }}" class="btn btn-info btn-sm">ایجاد اطلاعیه ایمیلی</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان اطلاعیه</th>
                                <th>متن اطلاعیه</th>
                                <th>تاریخ ارسال</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($email as $key => $singleEmail)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ $singleEmail->subject }}</td>
                                <td>{{ $singleEmail->body }}</td>
                                <td>{{ jalaiDate($singleEmail->published_at) }}</td>
                                <td>{{ $singleEmail->status == 0 ? "غیرفعال" : "فعال"}}</td>
                                <td class="width-18-rem text-left">
                                    {{-- for change status --}}
                                    <form class="d-inline" action="{{ route('admin.notify.email.status', $singleEmail->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if($singleEmail->status == 1)
                                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-window-close"></i> غیرفعال</button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm text"><i class="fa fa-check"></i> فعال</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.notify.email-file.index', $singleEmail->id) }}" class="btn btn-info btn-sm"><i class="fa fa-image"> </i>فایل های ضمیمه شده</a>
                                    <a href="{{ route('admin.notify.email.edit', $singleEmail->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"> </i>ویرایش</a>
                                    <form class="d-inline" action="{{ route('admin.notify.email.destroy', $singleEmail->id) }}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
                                    </form>
                                    <a href="{{ route('admin.notify.email.send-mail', $singleEmail) }}" class="btn btn-primary btn-sm">ارسال</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>


            </section>
        </section>
    </section>


@endsection

@section('script')

    @include("admin.alerts.sweetalert.delete-confirm", ['className'=> 'delete'])

@endsection

