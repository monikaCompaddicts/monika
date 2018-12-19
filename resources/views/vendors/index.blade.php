@extends('layouts.app')

@section('css')
<style>
    .alphabets-list{
        margin: 15px;
        text-align: center;
    }
    .alphabets-list a{
        padding-right: 18px;
        font-weight: bold;
        color: #3c8dbc;
        font-size: 16px;
        line-height: 35px;  
    }
    .alphabets-list a.active{
        font-size: 22px;
    }
</style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Vendors</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('vendors.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="alphabets-list">
                <b style="display: block;">Search By Alphabets</b>
                @foreach (range('A', 'Z') as $char) 
                    @if(isset($alpha) && $alpha == $char)
                        <a class="active" href="{{ url('vendorslist/'.$char) }}">{{ $char }}</a>
                    @else
                        <a href="{{ url('vendorslist/'.$char) }}">{{ $char }}</a>
                    @endif
                @endforeach
                @if(!isset($alpha))
                    <a class="active" href="{{ url('vendors') }}">All</a>
                @else
                    <a href="{{ url('vendors') }}">All</a>
                @endif
            </div>
            @if(count($vendors) == 0)
                <div style="text-align: center;padding: 20px 0;font-size: 17px;">"No vendors found!"</div>
            @else
                <input id="vendor-search-input" class="input-search" type="text" placeholder="Search..">
                <div class="box-body">
                        @include('vendors.table')
                </div>
            @endif
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('scripts')
<script>

    $(document).ready(function(){
      $("#vendor-search-input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#vendors-table .vendor-data-rows").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    var base_url = $('#base-url').attr('data-url');
    $(document).on("change", ".vendor-status input[type=checkbox]", function(){
        var vendor_id = $(this).attr('data-id');
        if($(this).is(":checked")){
            var status = 1;
        }else{
            var status = 0;
        }
        $.ajax({
            type: "POST",
            url: base_url + '/changeVendorStatus',
            data: {vendor_id: vendor_id, status: status},
            success: function( response ) {
                //location.reload();
            }
        });
    });
</script>
@endsection

