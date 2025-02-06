
@extends('admin.layouts.master')

@section('head-tag')
    <title>ادمین تیکت</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ادمین تیکت</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ادمین تیکت</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="#" class="btn btn-info btn-sm disabled">ایجاد ادمین تیکت</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام ادمین</th>
                                <th>ایمیل ادمین</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $key => $admin)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ $admin->fullName }}</td>
                                <td>{{ $admin->email }}</td>
                                <td class="width-16-rem text-left">

                                    @if($admin->ticketAdmin == null)
                                        <a href="{{ route('admin.ticket.admin.set', $admin->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i>
                                        اضافه
                                        </a>
                                    @else
                                        <a href="{{ route('admin.ticket.admin.set', $admin->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-check"></i>
                                            حذف
                                        </a>
                                    @endif
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
