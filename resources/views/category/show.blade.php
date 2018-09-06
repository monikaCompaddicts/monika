@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Categories
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px; padding-right: 20px">
                   <?php //echo "<pre>";print_r($categories); ?>
                   @foreach($categories as $category)
                        <?php $count_child_category = DB::table('categories')->where('parent_category', $category->id)->count(); ?>
                        @if($count_child_category > 0)
                            <?php $cursor = 'pointer'; ?>
                        @else
                            <?php $cursor = ''; ?>
                        @endif
                        <div id="category_{{ $category->id }}" class="parentDiv" data-child="{{ $count_child_category }}" data-id="{{ $category->id }}">
                            {{ $category->name }}
                            @if($count_child_category > 0)
                            <span style="float: right;cursor: {{ $cursor }}" class="parentDivChildren" data-child="{{ $count_child_category }}" data-id="{{ $category->id }}"><i class="fas fa-sort-down"></i></span>
                            @endif
                        </div>
                   @endforeach
                    <a href="{!! route('tests.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var base_url = $('#base-url').attr('data-url');
    $( ".parentDivChildren" ).on( "click", function() {
        if($( this ).parent().find('.parentDiv').length !== 0){
         $( this ).parent().find('.parentDiv').remove();
        }else{
        //alert("sfsdf");
      var child = $( this ).attr('data-child');
      if(child > 0){
        var parent_id = $( this ).attr('data-id');
        var this_div = $(this);
        $.ajax({
            type: "POST",
            url: base_url + '/admin/getChildCategory',
            data: {parent_id: parent_id},
            success: function( response ) {
                var result = jQuery.parseJSON(response);
                for (var i = 0; i < result.length; i++) {
                    var cat_div = '';
                    var count_child_category = result[i].child_category;
                    if (count_child_category > 0) {
                        var cursor = 'pointer';
                    }else{
                        var cursor = '';
                    }
                    if (i == 0) {
                        var margin_top = '10px';
                    }else{
                        var margin_top = '';
                    }
                    cat_div = cat_div+'<div id="category_'+result[i].id+'" style="margin-right: 20px; margin-top: '+margin_top+'" class="parentDiv" data-child="'+count_child_category+'" data-id="'+result[i].id+'">'+
                        result[i].name;
                        if(count_child_category > 0){
                            cat_div = cat_div+'<span style="float: right;cursor: '+cursor+';" class="parentDivChildren" data-child="'+count_child_category+'" data-id="'+result[i].id+'" style=""><i class="fas fa-sort-down"></i></span>';
                        }
                    cat_div = cat_div+'</div>';
                    $(this_div).parent().append(cat_div);
                }
            }
        });
      }
  }
    });
</script>
@endsection