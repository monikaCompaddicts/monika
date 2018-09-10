@extends('layouts.app')

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
            <div class="box-body">
                    @include('vendors.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('scripts')
<script>
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
            url: base_url + '/admin/changeVendorStatus',
            data: {vendor_id: vendor_id, status: status},
            success: function( response ) {
                //location.reload();
            }
        });
    });
</script>
@endsection

