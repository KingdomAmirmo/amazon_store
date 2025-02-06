@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>{{ $product->name }}</title>
    <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        .starrating > input {display: none;}  /* Remove radio buttons */
        .starrating > label:before {
            content: "\f005"; /* Star */
            margin: 2px;
            font-size: 2em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating > label
        {
            color: #222222; /* Start color when not clicked */
        }

        .starrating > input:checked ~ label
        { color: #ffca08 ; } /* Set yellow color when star checked */

        .starrating > input:hover ~ label
        { color: #ffca08 ;  } /* Set yellow color when star hover */


    </style>
@endsection

@section('content')


    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl" >
            <section class="row">
                @if(session('errorCart'))
                    <div class="alert alert-warning">
                        {{ session('errorCart') }}
                    </div>
                @endif
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{ $product->name }}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <!-- start image gallery -->
                        <section class="col-md-4">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                <section class="product-gallery">
                                    @php
                                        $imageGallery = $product->images()->get();
                                        $images = collect();
                                        $images->push($product->image);
                                        foreach ($imageGallery as $image){
                                            $images->push($image->image);
                                        }
                                    @endphp
                                    <section class="product-gallery-selected-image mb-3">
                                        <img src="{{ asset($images->first()['indexArray']['medium']) }}" alt="">
                                    </section>
                                    <section class="product-gallery-thumbs">
                                        @foreach($images as $key => $image)
                                            <img class="product-gallery-thumb" src="{{ asset($image['indexArray']['medium']) }}" alt="{{ asset($images->first()['indexArray']['medium']) . '-' . ($key+1) }}" data-input="{{ asset($image['indexArray']['medium']) }}">
                                        @endforeach
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- end image gallery -->

                        <!-- start product info -->
                        <section class="col-md-5">

                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            {{ $product->name }}
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>


                                <section class="product-info">
                                    <form action="{{ route('customer.sales-process.add-to-cart', $product) }}" method="post" id="add_to_cart" class="product-info">
                                    @csrf
                                    @php
                                        $colors = $product->colors()->get();
                                    @endphp

                                    @if($colors->count() != 0)
                                        <p>
                                            <span>رنگ انتخاب شده:
                                                <span id="selected_color_name">{{$colors->first()->color_name}}</span>
                                            </span>
                                        </p>
                                        <p>
                                            @foreach($colors as $key => $color)

                                                <label for="{{ 'color_' . $color->id }}" style="background-color: {{ $color->color ?? '#ffffff' }};" class="product-info-colors me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $color->color_name }}"></label>
                                                <input type="radio" name="color" id="{{ 'color_' . $color->id }}" class="d-none" value="{{ $color->id }}"
                                                data-color-name="{{ $color->color_name }}" data-color-price="{{ $color->price_increase }}" @if($key == 0) checked @endif>
                                            @endforeach
                                        </p>
                                    @endif

                                    @php
                                        $guarantees = $product->guarantees()->get();
                                    @endphp
                                    @if($guarantees->count() != 0)
                                            <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                گارانتی :
                                                <select name="guarantee" id="guarantee" class="p-1">
                                                    @foreach($guarantees as $key => $guarantee)
                                                        <option data-guarantee-price="{{ $guarantee->price_increase }}" value="{{ $guarantee->id }}" @if($key == 0) selected @endif>{{ $guarantee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </p>
                                    @endif

                                        <section>
                                            @if($product->marketable_number > 0)
                                                <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>
                                            @else
                                                <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span class="text-danger">کالا ناموجود</span>
                                            @endif
                                        </section>



                                    <div class="d-flex">
                                        {{--favorite--}}
                                        @guest
                                            <section class="product-add-to-favorite position-relative" style="top:0;">
                                                <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                    <i class="fa fa-heart text-dark"></i>
                                                </button>
                                            </section>
                                        @endguest
                                        @auth
                                            @if($product->user->contains(auth()->user()->id))
                                                <section class="product-add-to-favorite position-relative" style="top:0;">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                                        <i class="fa fa-heart text-danger"></i>
                                                    </button>
                                                </section>
                                            @else
                                                <section class="product-add-to-favorite position-relative" style="top:0;">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endif
                                        @endauth


                                        {{--compare--}}
                                        @guest
                                            <section class="product-add-to-compare position-relative" style="top:0;">
                                                <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-compare', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به مقایسه">
                                                    <i class="fa fa-chart-bar text-dark mt-1"></i>
                                                </button>
                                            </section>
                                        @endguest
                                        @auth
                                            @if($product->compares->contains(function ($compare, $key) {
                                                return $compare->id === auth()->user()->compare->id;
                                            }))
                                                <section class="product-add-to-compare position-relative" style="top:0;">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-compare', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از مقایسه">
                                                        <i class="fa fa-chart-bar text-danger mt-1"></i>
                                                    </button>
                                                </section>
                                            @else
                                                <section class="product-add-to-compare position-relative" style="top:0;">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-compare', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به مقایسه">
                                                        <i class="fa fa-chart-bar mt-1"></i>
                                                    </button>
                                                </section>
                                            @endif
                                        @endauth

                                    </div>


                                    <section>
                                        <section class="cart-product-number d-inline-block ">
                                            <button class="cart-number cart-number-down" type="button">-</button>
                                            <input id="number" name="number" type="number" min="1" max="5" step="1" value="1" readonly="readonly">
                                            <button class="cart-number cart-number-up" type="button">+</button>
                                        </section>
                                    </section>
                                    <p class="mb-3 mt-5">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی  خرید شما هنوز نهایی نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد. پس از ثبت سفارش کالا بر اساس نحوه ارسال که شما انتخاب کرده اید کالا برای شما در مدت زمان مذکور ارسال می گردد.
                                    </p>
                                </section>
                            </section>

                        </section>
                        <!-- end product info -->

                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالا</p>
                                    <p class="text-muted"><span id="product_price" data-product-original-price="{{ $product->price }}">{{ priceFormat($product->price) }}</span> <span class="small">تومان</span></p>
                                </section>

                                @php
                                    $amazingSale = $product->activeAmazingSale();
                                @endphp
                                @if(!empty($amazingSale))
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">تخفیف کالا</p>
                                        <p class="text-danger fw-bolder" id="product_discount_price" data-product-discount-price="{{ ($product->price * ($amazingSale->percentage / 100) ) }}">{{ priceFormat($product->price * ($amazingSale->percentage / 100) ) }} <span class="small">تومان</span></p>
                                    </section>
                                @endif

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-end align-items-center">
                                    <p class="fw-bolder" ><span id="final_price" class="small"></span><span>تومان</span></p>
                                </section>

                                <section class="">
                                    @if($product->marketable_number > 0)
                                        <button id="next-level" onclick="document.getElementById('add_to_cart').submit();" class="btn btn-danger d-block w-100">افزودن به سبد خرید</button>
                                    @else
                                        <button id="next-level" class="btn btn-secondary d-block disabled">محصول ناموجود می باشد</button>
                                    @endif
                                </section>

                                </form>

                            </section>
                        </section>













                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->


{{-- start Related Product --}}
    @include('customer.layouts.partials.related-products')
{{-- end Related Product --}}



    <!-- start description, features and comments -->
    <section class="mb-4">
        <section class="container-xxl" >
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start content header -->
                        <section id="introduction-features-comments" class="introduction-features-comments">
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#introduction">معرفی</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#features">ویژگی ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#comments">دیدگاه ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#rating">امتیاز ها</a></span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- start content header -->

                        <section class="py-4">

                            <!-- start vontent header -->
                            <section id="introduction" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        معرفی
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-introduction mb-4">
                                {!! $product->introduction !!}
                            </section>

                            <!-- start vontent header -->
                            <section id="features" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        ویژگی ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-features mb-4 table-responsive">
                                <table class="table table-bordered border-white">
                                    @foreach($product->values as $value)
                                        <tr>
                                            <td>{{ $value->attribute->name }}</td>
                                            <td>{{ json_decode($value->value)->value . ' ' . $value->attribute->unit }}</td>
                                        </tr>
                                    @endforeach


                                        @foreach($product->metas as $meta)
                                            <tr>
                                                <td>{{ $meta->meta_key }}</td>
                                                <td>{{ $meta->meta_value }}</td>
                                            </tr>
                                        @endforeach
                                </table>
                            </section>

                            <!-- start vontent header -->
                            <section id="comments" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        دیدگاه ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-comments mb-4">

                                <section class="comment-add-wrapper">
                                    <button class="comment-add-button" type="button" data-bs-toggle="modal" data-bs-target="#add-comment" ><i class="fa fa-plus"></i> افزودن دیدگاه</button>
                                    <!-- start add comment Modal -->
                                    <section class="modal fade" id="add-comment" tabindex="-1" aria-labelledby="add-comment-label" aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-comment-label"><i class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </section>

                                                @guest
                                                    <section class="">
                                                        <p>کاربر گرامی لطفا برای ثبت نظر ابتدا وارد حساب کاربری خود شوید</p>
                                                        <p>لینک ثبت نام و یا ورود
                                                            <a href="{{ route('auth.customer.login-register-form') }}">کلیک کنید</a>
                                                        </p>
                                                    </section>
                                                @endguest
                                                @auth
                                                <section class="modal-body">
                                                    <form class="row" action="{{ route('customer.market.add-comment', $product) }}" method="post">
                                                        @csrf
                                                        <section class="col-12 mb-2">
                                                            <label for="comment" class="form-label mb-1">دیدگاه شما</label>
                                                            <textarea class="form-control form-control-sm" name="body" id="comment" placeholder="دیدگاه شما ..." rows="4"></textarea>
                                                        </section>
                                                <section class="modal-footer py-1">
                                                    <button type="submit" class="btn btn-sm btn-primary">ثبت دیدگاه</button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بستن</button>
                                                </section>
                                                    </form>
                                                </section>

                                                @endauth

                                            </section>
                                        </section>
                                    </section>
                                </section>

                                @foreach($product->activeComments() as $activeComment)
                                    <section class="product-comment">
                                        <section class="product-comment-header d-flex justify-content-start">
                                            <section class="product-comment-date">{{ jalaiDate($activeComment->created_at) }}</section>

                                            @php
                                                $author = $activeComment->user;
                                            @endphp
                                            <section class="product-comment-title">
                                                @if(empty($author->first_name) && empty($author->last_name))
                                                    ناشناس
                                                @else
                                                    {{ $activeComment->user->fullName }}
                                                @endif
                                            </section>
                                        </section>
                                        <section class="product-comment-body @if($activeComment->answers()->count() > 0) border-bottom @endif">
                                            {!! $activeComment->body !!}
                                        </section>



                                        @foreach($activeComment->answers as $answerComment)
                                            <section class="product-comment p-0 m-5">
                                                <section class="product-comment-header d-flex justify-content-start">
                                                    <section class="product-comment-date">{{ jalaiDate($answerComment->created_at) }}</section>

                                                    @php
                                                        $author = $answerComment->user;
                                                    @endphp
                                                    <section class="product-comment-title">
                                                        @if(empty($author->first_name) && empty($author->last_name))
                                                            ناشناس
                                                        @else
                                                            {{ $answerComment->user->fullName }}
                                                        @endif
                                                    </section>
                                                </section>
                                                <section class="product-comment-body">
                                                    {!! $answerComment->body !!}
                                                </section>
                                            </section>

                                        @endforeach


                                    </section>
                                @endforeach


                            </section>

                            @auth
                                @if(auth()->user()->isUserPurchasedProduct($product->id)->count() > 0)
                                    <!-- start Rating -->
                                    <section id="rating" class="content-header mt-2 mb-4">
                                        <section class="d-flex justify-content-between align-items-center">
                                            <h2 class="content-header-title content-header-title-small">
                                                امتیاز ها
                                            </h2>
                                            <section class="content-header-link">
                                                <!--<a href="#">مشاهده همه</a>-->
                                            </section>
                                        </section>
                                    </section>
                                    <section class="product-ratings mb-4">
                                        <div class="container">
                                            <h5 class="text-danger">امتیاز خود را به این محصول اختصاص دهید</h5>
                                            <form action="{{ route('customer.market.add-rate', $product) }}" method="post" class="starrating risingstar d-flex justify-content-end flex-row-reverse align-items-center">
                                                @csrf
                                                <div class="mx-3">
                                                    <button class="btn btn-primary btn-sm">ثبت امتیاز</button>
                                                </div>
                                                    <input type="radio" id="star5" name="rating" value="5" />
                                                    <label for="star5" title="5 star"></label>
                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label for="star4" title="4 star"></label>
                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label for="star3" title="3 star"></label>
                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label for="star2" title="2 star"></label>
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label for="star1" title="1 star"></label>
                                            </form>
                                            <h6>میانگین امتیاز محصول :
                                                @if($product->ratingsAvg())
                                                    {{ number_format($product->ratingsAvg(), 1, '/') }}
                                                @else
                                                    {{ "شما اولین نفر باشید که امتیاز میدهید!!!"  }}
                                                @endif
                                            </h6>
                                            <h6>تعداد افراد شرکت کننده : {{ $product->ratingsCount() ?? '0' }}</h6>
                                        </div>
                                    </section>
                                @endif
                            @endauth
                            @guest
                                <section class="">
                                    <p>کاربر گرامی لطفا برای ثبت امتیاز ابتدا وارد حساب کاربری خود شوید</p>
                                    <p>لینک ثبت نام و یا ورود
                                        <a href="{{ route('auth.customer.login-register-form') }}">کلیک کنید</a>
                                    </p>
                                </section>
                            @endguest

                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end description, features and comments -->



@include('customer.layouts.alert-toast')




@endsection


@section('script')
    <script>
        $(document).ready(function(){
            bill();
            //input color
            $('input[name="color"]').change(function(){
                bill();
            })
            //guarantee
            $('select[name="guarantee"]').change(function(){
                bill();
            })
            //number
            $('.cart-number').click(function(){
                bill();
            })
        })

        function bill() {
            if($('input[name="color"]:checked').length != 0){
                var selected_color = $('input[name="color"]:checked');
                $("#selected_color_name").html(selected_color.attr('data-color-name'));
            }

            //price computing
            var selected_color_price = 0;
            var selected_guarantee_price = 0;
            var number = 1;
            var product_discount_price = 0;
            var product_original_price = parseFloat($('#product_price').attr('data-product-original-price'));

            if($('input[name="color"]:checked').length != 0)
            {
                selected_color_price = parseFloat(selected_color.attr('data-color-price'));
            }

            if($('#guarantee option:selected').length != 0)
            {
                selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
            }

            if($('#number').val() > 0)
            {
                number = parseFloat($('#number').val());
            }

            if($('#product_discount_price').length != 0)
            {
                product_discount_price = parseFloat($('#product_discount_price').attr('data-product-discount-price'));
            }

            //final price
            var product_price = product_original_price + selected_color_price + selected_guarantee_price;
            var final_price = number * (product_price - product_discount_price);
            $('#product_price').html(toFarsiNumber(product_price));
            $('#final_price').html(toFarsiNumber(final_price));
        }


        //JavaScript Helper for englishNumber To farsiNumber
        function toFarsiNumber(number)
        {
            const farsiDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            //add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }
    </script>





// add to favorite
    <script>

        $('.product-add-to-favorite button').click(function (){
            var url = $(this).attr('data-url');
            var element = $(this);
            $.ajax({
                url : url,
                success : function (result){
                    if (result.status == 1)
                    {
                        $(element).children().first().addClass('text-danger');
                        $(element).attr('data-original-title', 'حذف از علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                    }
                    else if(result.status == 2)
                    {
                        $(element).children().first().removeClass('text-danger');
                        $(element).attr('data-original-title', 'افزودن به علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'افزودن به علاقه مندی ها');
                    }
                    else if(result.status == 3)
                    {
                        $('.toast').toast('show');
                    }

                }


            });


        });
    </script>


    // add to compare
    <script>

        $('.product-add-to-compare button').click(function (){
            var url = $(this).attr('data-url');
            var element = $(this);
            $.ajax({
                url : url,
                success : function (result){
                    if (result.status == 1)
                    {
                        $(element).children().first().addClass('text-danger');
                        $(element).attr('data-original-title', 'حذف از مقایسه ها');
                        $(element).attr('data-bs-original-title', 'حذف از مقایسه ها');
                    }
                    else if(result.status == 2)
                    {
                        $(element).children().first().removeClass('text-danger');
                        $(element).attr('data-original-title', 'افزودن به مقایسه ها');
                        $(element).attr('data-bs-original-title', 'افزودن به مقایسه ها');
                    }
                    else if(result.status == 3)
                    {
                        $('.toast').toast('show');
                    }

                }


            });


        });
    </script>



    <script>
        //start product introduction, features and comment
        $(document).ready(function() {
            var s = $("#introduction-features-comments");
            var pos = s.position();
            $(window).scroll(function() {
                var windowpos = $(window).scrollTop();

                if (windowpos >= pos.top) {
                    s.addClass("stick");
                } else {
                    s.removeClass("stick");
                }
            });
        });
        //end product introduction, features and comment

    </script>


@endsection
