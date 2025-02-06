@extends('admin.layouts.master')

@section('head-tag')
    <title>نظرات</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نظرات</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>نظرات</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="#" class="btn btn-info btn-sm disabled">ایجاد نظر</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نظر</th>
                            <th>پاسخ به</th>
                            <th>کد کاربر</th>
                            <th>نویسنده نظر</th>
                            <th>کد پست</th>
                            <th>پست</th>
                            <th>وضعیت تایید</th>
                            <th>وضعیت کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $key => $comment)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ \Illuminate\Support\Str::limit($comment->body,10) }}</td>
                                <td>{{ $comment->parent_id ? \Illuminate\Support\Str::limit($comment->parent->body , 10) : '' }}</td>
                                <td>{{ $comment->author_id }}</td>
                                <td>{{ $comment->user->fullName }}</td>
                                <td>{{ $comment->commentable_id }}</td>
                                <td>{{ $comment->commentable->title }}</td>
                                <td>{{ $comment->approved == 0 ? "درانتظار تایید" : "تایید شده"}}</td>
                                <td>{{ $comment->status == 0 ? "غیرفعال" : "فعال"}}</td>

                                <td class="width-18-rem text-left">


                                    {{-- for change status --}}
                                    <form class="d-inline" action="{{ route('admin.content.comment.status', $comment->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if($comment->status == 1)
                                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-window-close"></i> غیرفعال</button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm text"><i class="fa fa-check"></i> فعال</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.content.comment.show', $comment->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>نمایش </a>

                                    @if($comment->approved == 1)
                                        <a href="{{ route('admin.content.comment.approved', $comment->id) }} " type="submit" class="btn btn-warning btn-sm"><i class="fa fa-clock"></i> عدم تایید</a>
                                    @else
                                        <a href="{{ route('admin.content.comment.approved', $comment->id) }}" type="submit" class="btn btn-success btn-sm text-white"><i class="fa fa-check"></i> تایید</a>
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
