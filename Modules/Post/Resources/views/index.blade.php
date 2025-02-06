@extends('post::layouts.master')

@section('head-tag')
    <title>پست</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پست ها</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>پست ها</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.post.create') }}" class="btn btn-info btn-sm">ایجاد پست</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان پست</th>
                            <th>دسته</th>
                            <th>تصویر</th>
                            <th>وضعیت</th>
                            <th>امکان درج کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($posts as $key => $post)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->postCategory->name }}</td>
                                <td>
                                    <img src="{{ asset($post->image['indexArray'][$post->image['currentImage']] ) }}" alt="" width="100" height="auto">
                                </td>
                                <td class="">
                                    <label>
                                        {{-- for change status --}}
                                        <form class="d-inline" action="{{ route('admin.content.post.status', $post->id) }}" method="post">
                                            @csrf
                                            {{ method_field('put') }}
                                            @if ($post->status === 0)
                                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                            @else
                                                <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                            @endif
                                        </form>

                                    </label>
                                </td>
                                <td class="">
                                    <label>
                                        {{-- for change commentable --}}
                                        <form class="d-inline" action="{{ route('admin.content.post.commentable', $post->id) }}" method="post">
                                            @csrf
                                            {{ method_field('put') }}
                                            @if ($post->commentable === 0)
                                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                            @else
                                                <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                            @endif
                                        </form>

                                    </label>
                                </td>

                                <td class="width-16-rem text-left">
                                    <a href="{{ route('admin.content.post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>ویرایش</a>

                                    <form class="d-inline" action="{{ route('admin.content.post.destroy', $post->id) }}" method="post">
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
