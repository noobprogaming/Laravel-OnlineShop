@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<section class="blog_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog_left_sidebar">
                    <div class="product_top_bar mb-4">
                        <div class="left_dorp col col-md-12">
                            <select onchange="sortBy()" id="sort" class="sorting">
                                <option selected>Sort by</option>
                                <option value="priceLowHigh">Price Low to High</option>
                                <option value="priceHighLow">Price High to Low</option>
                            </select>
                            <select class="show">
                                <option value="1">Show 12</option>
                                <option value="2">Show 14</option>
                                <option value="4">Show 16</option>
                            </select>
                        </div>
                    </div>

                    <div class="latest_product_inner">
                        <div class="row" id="item">
                            @foreach($item as $n)

                            <div class="col-md-3">
                                <div class="card ">
                                    <div class="h-250">
                                        <img class="card-img-top h-100"
                                            src="{{ asset('data_file/'.$n['item_id'].'_a') }}">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $n['name'] }}</h4>
                                        <p class="card-text">Rp{{ number_format($n['selling_price']), 2 }}</p>
                                        <a href="{{ route('itemDetail', [$n['item_id']]) }}"
                                            class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>

                            @endforeach

                            <div class="pagination">
                                {{ $item->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Pelapak</h4>
                        <ul class="list cat-list">
                            <li>
                                <div class="">
                                    <img class="d-inline img-thumbnail rounded-circle w-25 h-25" src="{{ asset('data_file/'.$usr[0]['id'].'_profile') }}">
                                    <h4 class="d-inline ml-3">{{ $usr[0]['name'] }}</h4>
                                </div>
                                
                                <p>
                                    <div id="city">
                                        {{ $usr[0]['city_name'] }}
                                    </div>

                                    <div id="province">
                                        {{ $usr[0]['province_name'] }}
                                    </div>
                                </p>
                                <hr>
                                <p>
                                    Penilaian Pembeli<br>

                                    @if (!empty($ratingLapak[0]['ratingLapak']))
                                    @for ($i = 0; $i < ($ratingLapak[0]['ratingLapak']-1); $i++) <i
                                        class="fa fa-star yellow"></i>
                                        @endfor
                                        @if(substr(($ratingLapak[0]['ratingLapak']-0.001), 2) >= 0.5)
                                        <i class="fa fa-star yellow"></i>
                                        @else
                                        <i class="fa fa-star-half yellow"></i>
                                        @endif
                                        {{ $ratingLapak[0]['ratingLapak'] }}
                                    @else
                                    
                                    {{ $ratingLapak[0]['ratingLapak'] }}
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <br>
                                    Belum ada penilaian
                                    @endif


                                </p>
                            </li>
                            <li>
                                <a class="d-flex">
                                    {{ $usr[0]['address'] }}
                                    {{ $usr[0]['district'] }}
                                    {{ $usr[0]['city_name'] }}
                                    {{ $usr[0]['province_name'] }}
                                    {{ $usr[0]['postal_code'] }}
                                </a>
                            </li>
                            <div>
                                <a class="btn btn-success" href="{{ route('createItem') }}"><i class="fa fa-shopping-bag"></i> Sell
                                    Item</a>
                                <a class="btn btn-primary" href="{{ route('profileUpdate', ['id'=>$usr[0]['id']]) }}"><i
                                        class="fa fa-pencil"></i> Update Profil</a>
                            </div>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
