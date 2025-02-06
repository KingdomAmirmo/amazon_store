@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>لیست علاقه مندی ها</title>
@endsection


@section('content')




    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success')}}
                    </div>
                @endif


                @include('customer.layouts.partials.profile-sidebar')


                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>لیست علاقه مندی های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        @forelse(auth()->user()->products as $key => $product)
                            <section class="cart-item d-flex py-3">
                                    <a href="{{ route('customer.market.product', $product->slog) }}">
                                        <section class="cart-img align-self-start flex-shrink-1"><img src="{{ asset($product->image['indexArray']['medium']) }}" alt="{{ $product->slog }}"></section>
                                    </a>
                                    <section class="align-self-start w-100">
                                    <p class="fw-bold">{{ $product->name }}</p>
                                    @php
                                        $colors = $product->colors()->get();
                                    @endphp
                                    <p>
                                        @if($colors->count() != 0)
                                            رنگ های موجود :
                                            @foreach($colors as $color)
                                            <span style="background-color: {{ $color->color ?? '-' }};" class="cart-product-selected-color me-1"></span>
                                            <span>{{ $color->color_name ?? '-'}}</span>
                                            @endforeach
                                        @endif
                                    </p>
                                    @php
                                        $guarantees = $product->guarantees()->get();
                                    @endphp
                                    <p>
                                        @if($guarantees->count() != 0)
                                            گارانتی ها :
                                                @foreach($guarantees as $key => $guarantee)
                                                <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span>{{ $guarantee->name }}</span>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p>
                                        @if($product->marketable_number > 0)
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>
                                        @else
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span class="text-danger">کالا ناموجود</span>
                                        @endif
                                    </p>
                                    <section>
                                        <a class="text-decoration-none cart-delete" href="{{ route('customer.profile.my-favorites.delete', $product->id) }}"><i class="fa fa-trash-alt"></i> حذف از لیست علاقه مندی ها</a>
                                    </section>
                                </section>
                                <section class="align-self-end flex-shrink-1">

                                    @php
                                        $amazingSale = $product->activeAmazingSale();
                                    @endphp
                                    @if(!empty($amazingSale))
                                        <section class="cart-item-discount text-danger text-nowrap mb-1" id="product_discount_price" data-product-discount-price="{{ ($product->price * ($amazingSale->percentage / 100) ) }}">
                                            <span>تخفیف :</span>
                                            {{ priceFormat($product->price * ($amazingSale->percentage / 100) ) }}
                                            <span class="small">تومان</span>
                                        </section>
                                    @endif

                                    <section class="text-nowrap fw-bold">{{ priceFormat($product->price) }} تومان</section>
                                </section>
                            </section>
                        @empty
                            <section class="order-item">
                                <section class="d-flex justify-content-between">
                                    <p>سفارشی یافت نشد</p>
                                </section>
                            </section>
                        @endforelse



                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->











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
@endsection
