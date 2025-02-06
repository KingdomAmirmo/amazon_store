@extends('admin.layouts.master')

@section('head-tag')
    <title>اطلاعیه پیامکی</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">اطلاعیه پیامکی</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>اطلاعیه پیامکی</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.notify.sms.create') }}" class="btn btn-info btn-sm">ایجاد اطلاعیه پیامکی</a>
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
                                <th>متن پیامک</th>
                                <th>تاریخ ارسال</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($sms as $key => $singleSms)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ $singleSms->title }}</td>
                                <td>{{ $singleSms->body }}</td>
                                <td>{{ jalaiDate($singleSms->published_at) }}</td>
                                <td>{{ $singleSms->status == 0 ? "غیرفعال" : "فعال"}}</td>
                                <td class="width-16-rem text-left">
                                    {{-- for change status --}}
                                    <form class="d-inline" action="{{ route('admin.notify.sms.status', $singleSms->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if($singleSms->status == 1)
                                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-window-close"></i> غیرفعال</button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm text"><i class="fa fa-check"></i> فعال</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.notify.sms.edit', $singleSms->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                    <form class="d-inline" action="{{ route('admin.notify.sms.destroy', $singleSms->id) }}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
                                    </form>

                                    <a href="{{ route('admin.notify.sms.send-sms', $singleSms) }}" class="btn btn-primary btn-sm">ارسال</a>
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
