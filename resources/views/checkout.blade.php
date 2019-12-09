@extends('layouts.app')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Checkout</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">Penerima
                                <h4 class="card-title">{{ $usr_buyer[0]['name'] }}</h4>
                                <p class="card-text">{{ $usr_buyer[0]['phone_number'] }}</p>
                                <p class="card-text">
                                    {{ $usr_buyer[0]['address'] }}
                                    {{ $usr_buyer[0]['district'] }}
                                    <div id="city2">{{ $usr_buyer[0]['city_name'] }}</div>
                                    <div id="province2">{{ $usr_buyer[0]['province_name'] }}</div>
                                    {{ $usr_buyer[0]['postal_code'] }}
                                </p>
                            </div>

                    <button class="btn btn-primary" data-toggle="modal" data-target="#detailTransactionModal"
                            id="btnCartList">Detail</button>
                        <div class="modal fade" id="detailTransactionModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Pembayaran</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="detailTransaction"></div>
                                        <div>
                                            <img class="card-img-top w-100" src="{{ asset('data_file/'.Request::Segment(2).'_trx') }}">
                                            <form action="{{ route('storeTransaction') }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                        
                                                <input type="hidden" name="purchase_id" value="{{ Request::Segment(2) }}">
                        
                                                <input type="file" name="file_transaction">
                        
                                                <button type="submit" class="btn btn-primary">
                                                    Upload
                                                </button>
                        
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="" class="btn btn-primary"><i class="fa fa-upload"></i> Upload bukti pembayaran</a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    <!-- </div> -->

                    <!-- <div class="row"> -->
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="tap bold" onclick="getProfilePelapak({{ $cartSeller[0]['id'] }})">
                                        <i class="fa fa-university"></i>
                                        {{ $cartSeller[0]['seller'] }}</p>
                                    </div>
                                    <div class="card-body">
                                        <p>City     : {{ $cartSeller[0]['city_name'] }}</p>
                                        <p>Province : {{ $cartSeller[0]['province_name'] }}</p>
                                    </div>
                                    <hr>
                                    @php
                                        $total_price = 0;
                                        $total_weight = 0;
                                    @endphp
                                    @foreach($cartList as $j)
                                    @if($cartSeller[0]['seller'] == $j['seller'])
                                        <div class="card-text mx-3">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <p class="tap" onclick="getItemDetail({{ $j['item_id'] }})">Item Name : {{ $j['name'] }}</p>
                                                    <p>Amount : {{ $j['amount'] }}</p>
                                                    <p>
                                                        Rp{{ number_format($j['selling_price'],2,',','.') }}
                                                    </p>  
                                                </div>
                                                <div class="col-md-2">
                                                        <i class="fa fa-trash lightGrey" onclick="deleteItem({{ $j['item_id'] }})"></i>
                                                        delete
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @php
                                            $total_price+=$j['selling_price']*$j['amount'];
                                            $total_weight+=$j['weight']*$j['amount'];
                                        @endphp
                                    @endif
                                @endforeach
                                
                                    <div id="ongkir">Ongkir::null</div>
                                    <div class="card-footer bold">
                                    Total price {{ number_format(($total_price),2,',','.') }}

                                    <input id="note" type='text' class="form-control" placeholder="Notice" name='note'>
                                    <button class="btn btn-sm btn-primary" onclick="storePayment({{ $cartSeller[0]['seller_id'] }}, {{ $total_price }})">Bayar</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>


    <script>
        $("#detailTransaction").load("{{ route('detailTransaction', Request::segment(2)) }}");
        // $("#detailTransactionModal").modal("show");

        var origin = "{{ $cartSeller[0]['city_id'] }}";
        var dst = "{{ $usr_buyer[0]['city_id'] }}";
        //var courier = $('#kurir').val();
        var weight = "{{ $total_weight }}";

        $.ajax({
            type: "GET",
            url: "{{ route('checkshipping') }}",
            data: {
                'dst': dst,
                'courier': 'pos',
                'origin': origin,
                'weight': weight,
            },
            beforeSend: function () {
                $('#ongkir').html("loading...");
            },
            success: function (data) {
                $('#ongkir').html(data);
            },
        });

        function storePayment(seller_id, total_price) {
            var note = document.getElementById('note').value;
            var shipping_price = document.getElementById('shipping').value;

            $.ajax({
                type: "POST",
                url: "{{ route('storePayment') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "seller_id": seller_id, 
                    "total_price": total_price,
                    "shipping_price": shipping_price,
                    "note": note,
                }
            }).done(function () {
                $("#detailTransaction").load("{{ route('detailTransaction', Request::segment(2)) }}");
                $('#detailTransactionModal').modal('show');
            });
        }
    </script>

    @endsection
