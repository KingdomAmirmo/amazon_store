@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>فروشگاه آمازون</title>
@endsection

@section('content')




    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">

                @include('customer.layouts.partials.sidebar')

                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                        <section class="filters mb-3">
                            @if(request('search'))
                                <span class="d-inline-block border p-1 rounded bg-light">نتیجه جستجو برای :
                                <span class="badge bg-primary">
                                    {{ request('search') }}
                                </span>
                            </span>
                            @endif
                            @if(request('brands'))
                                <span class="d-inline-block border p-1 rounded bg-light">برند :
                                    <span class="badge bg-primary">
                                        {{ implode(', ', $selectedBrandsArray) }}
                                    </span>
                                </span>
                            @endif
                            @if(request('categories'))
                                <span class="d-inline-block border p-1 rounded bg-light">دسته :
                                    <span class="badge bg-primary">

                                    </span>
                                </span>
                            @endif
                            @if(request('min_price'))
                                <span class="d-inline-block border p-1 rounded bg-light">قیمت از :
                                    <span class="badge bg-primary">
                                        {{ priceFormat(request('min_price')) }} تومان
                                    </span>
                                </span>
                            @endif
                            @if(request('max_price'))
                               <span class="d-inline-block border p-1 rounded bg-light">قیمت تا :
                                    <span class="badge bg-primary">
                                        {{ priceFormat(request('max_price')) }} تومان
                                    </span>
                               </span>
                            @endif
                        </section>

                        <section class="sort ">
                            <span>مرتب سازی بر اساس : </span>
                            <a class="btn {{ request('sort') == 1 ? 'btn-danger' : ''}} btn-sm px-1 py-0" href="{{ route('customer.products', ['search' => request('search'), 'sort' => '1', 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'brands' => request('brands'), 'category' => request()->category ? request()->category->id : null]) }}">جدیدترین</a>
                            <a class="btn {{ request('sort') == 2 ? 'btn-danger' : ''}} btn-sm px-1 py-0" href="{{ route('customer.products', ['search' => request('search'), 'sort' => '2', 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'brands' => request('brands'), 'category' => request()->category ? request()->category->id : null]) }}">گران ترین</a>
                            <a class="btn {{ request('sort') == 3 ? 'btn-danger' : ''}} btn-sm px-1 py-0" href="{{ route('customer.products', ['search' => request('search'), 'sort' => '3', 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'brands' => request('brands'), 'category' => request()->category ? request()->category->id : null]) }}">ارزان ترین</a>
                            <a class="btn {{ request('sort') == 4 ? 'btn-danger' : ''}} btn-sm px-1 py-0" href="{{ route('customer.products', ['search' => request('search'), 'sort' => '4', 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'brands' => request('brands'), 'category' => request()->category ? request()->category->id : null]) }}">پربازدیدترین</a>
                            <a class="btn {{ request('sort') == 5 ? 'btn-danger' : ''}} btn-sm px-1 py-0" href="{{ route('customer.products', ['search' => request('search'), 'sort' => '5', 'min_price' => request('min_price'), 'max_price' => request('max_price'),'brands' => request('brands'), 'category' => request()->category ? request()->category->id : null]) }}">پرفروش ترین</a>
                        </section>


                        <section class="main-product-wrapper row my-4" >


                            @forelse($products as $product)
                                <section class="col-md-3 p-0">
                                    <section class="product">
                                        <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section>



                                        <section class="product-add-to-favorite">
                                            {{--favorite--}}
                                            @guest
                                                <section class="product-add-to-favorite position-relative" style="top: 0;right: 4px">
                                                    <button type="button" class="btn bg-white btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                        <i class="fa fa-heart text-dark"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if($product->user->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite position-relative" style="top: 0;right: 4px">
                                                        <button type="button" class="btn bg-white btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite position-relative" style="top: 0;right:4px">
                                                        <button type="button" class="btn bg-white btn-sm text-decoration-none" data-url="{{ route('customer.market.add-to-favorite', $product) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth

                                        </section>


                                        <a class="product-link" href="{{ route('customer.market.product', $product->slog) }}">
                                            <section class="product-image">
                                                <img class="" src="{{ asset($product->image['indexArray']['medium']) }}" alt="">
                                            </section>
                                            <section class="product-colors"></section>
                                            <section class="product-name"><h3>{{ $product->name }}</h3></section>
                                            <section class="product-price-wrapper">
                                                <section class="product-price">{{ priceFormat($product->price) }} تومان</section>
                                            </section>
                                        </a>
                                    </section>
                                </section>
                            @empty
                                <h4 class="text-danger">محصولی یافت نشد</h4>
                            @endforelse




                                <section class="my-4 d-flex justify-content-center border-0">
                                        {{ $products->links('pagination::bootstrap-5') }}
                                </section>

                        </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->


    @include('customer.layouts.alert-toast')




@endsection


@section('script')

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













@endsection
