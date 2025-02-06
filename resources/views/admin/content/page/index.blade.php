@extends('admin.layouts.master')

@section('head-tag')
    <title>پیج ساز</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> پیج ساز</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>پیج ساز</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.page.create') }}" class="btn btn-info btn-sm">ایجاد پیج جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>تگ ها</th>
                                <th>اسلاگ</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->tags }}</td>
                                <td>{{ $page->slog }}</td>
                                <td>{{ $page->status == 0 ? "غیرفعال" : "فعال" }}</td>

                                <td class="width-16-rem text-center">
                                    {{-- for change status --}}
                                    <form class="d-inline" action="{{ route('admin.content.page.status', $page->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if ($page->status === 0)
                                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                        @else
                                            <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.content.page.edit', $page->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>ویرایش </a>
                                    <form class="d-inline" action="{{ route('admin.content.page.destroy', $page->id) }}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
                                    </form>
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

