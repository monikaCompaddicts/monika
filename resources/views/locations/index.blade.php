@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Locations</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('locations.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <input id="location-search-input" class="input-search" type="text" placeholder="Search..">
            <div class="box-body">
                    @include('locations.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('scripts')
<script>

    $(document).ready(function(){
      $("#location-search-input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#locations-table .data-rows").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
@endsection