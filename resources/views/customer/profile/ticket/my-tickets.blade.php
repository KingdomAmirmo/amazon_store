@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>تیکت های شما</title>
@endsection


@section('content')




    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">


                @include('customer.layouts.partials.profile-sidebar')


                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه تیکت ها</span>
                                </h2>
                                <section class="content-header-link my-2">
                                   <a class="btn btn-success text-white" href="{{ route('customer.profile.my-tickets.create') }}">ارسال تیکت جدید</a>
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        <section class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان تیکت</th>
                                    <th>متن تیکت</th>
                                    <th>دسته تیکت</th>
                                    <th>اولویت تیکت</th>
                                    <th>وضعیت تیکت</th>
                                    <th>تیکت مرجع</th>
                                    <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($ticket->description, 20) }}</td>
                                        <td>{{ $ticket->category->name }}</td>
                                        <td>{{ $ticket->priority->name }}</td>
                                        <td>{{ $ticket->status == 0 ? "بسته" : "باز" }}</td>
                                        <td>{{ $ticket->ticket_id ? $ticket->parent->subject : '-' }}</td>
                                        <td class="text-center" style="width: 11rem">
                                            <a href="{{ route('customer.profile.my-tickets.show', $ticket->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('customer.profile.my-tickets.change', $ticket->id) }}" class="btn btn-warning btn-sm">
                                                <i @if($ticket->status == 1) class="fa fa-times" @else class="fa fa-check" @endif></i>
                                                {{ $ticket->status == 1 ? "بستن" : "بازکردن" }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="my-3 font-weight-bolder">
                                        تیکتی یافت نشد
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                        </section>



                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->










@endsection
