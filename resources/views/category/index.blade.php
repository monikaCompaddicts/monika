@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Categories</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right add-parent-category add-sub-category" data-toggle="modal" data-target="#sub-cat-modal" title="Add Parent Category" data-id="0" href="#">Add New Category</a>
        </h1>
    </section>
    <!-- Modal -->
<div id="sub-cat-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Sub Category</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'saveNewCategory', 'class' =>'add-edit-category-form', 'method' => 'POST', 'url' => '/saveNewCategory', 'files' => true]) !!}
            {!! Form::hidden('parent_category', '', ['class' => 'form-control']); !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name') !!}
                {!! Form::text('category_name', '', ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Category Image') !!}
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'cat-image')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Category Description') !!}
                {!! Form::textarea('category_description', '', ['class' => 'form-control', 'rows' => 3]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('unit', 'Unit') !!}
                {!! Form::text('unit', '', ['class' => 'form-control']); !!}
            </div>
            {!! Form::submit('SUBMIT', ['class' => 'btn btn-primary', 'onclick' => 'return validateCategoryForm();']); !!}
        {!! Form::close() !!}
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div-->
    </div>

  </div>
</div>


<!-- Modal -->
<div id="edit-cat-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'editCategory', 'class' =>'add-edit-category-form', 'method' => 'POST', 'url' => '/editCategory', 'files' => true]) !!}
            {!! Form::hidden('category_id', '', ['class' => 'form-control']); !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name') !!}
                {!! Form::text('category_name', '', ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Category Image') !!}
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'cat-image')) !!}
            </div>
            <div class="form-group img-cat">
                <img src="">
            </div>
            <div class="form-group">
                {!! Form::label('category_description', 'Category Description') !!}
                {!! Form::textarea('category_description', '', ['class' => 'form-control', 'rows' => '3']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('unit', 'Unit') !!}
                {!! Form::text('unit', '', ['class' => 'form-control']); !!}
            </div>
            {!! Form::submit('SUBMIT', ['class' => 'btn btn-primary', 'onclick' => 'return validateEditCategoryForm();']); !!}
        {!! Form::close() !!}
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div-->
    </div>

  </div>
</div>

<!-- Modal -->
<div id="view-cat-image-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!--div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category</h4>
      </div-->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <img src="">
        <!--{!! Form::open(['id' => 'editCategory', 'class' =>'add-edit-category-form', 'method' => 'POST', 'url' => '/editCategory', 'files' => true]) !!}
            {!! Form::hidden('category_id', '', ['class' => 'form-control']); !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name') !!}
                {!! Form::text('category_name', '', ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Category Image') !!}
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'cat-image')) !!}
            </div>
            <div class="form-group img-cat">
                <img src="">
            </div>
            {!! Form::submit('SUBMIT', ['class' => 'btn btn-primary', 'onclick' => 'return validateEditCategoryForm();']); !!}
        {!! Form::close() !!}-->
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div-->
    </div>

  </div>
</div>

    <div class="content">
        <div class="clearfix"></div>

        <!--@include('flash::message')-->
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" id="sortable" style="padding-left: 20px; padding-right: 20px">
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
                            <span class="add-sub-category" data-toggle="modal" data-target="#sub-cat-modal" title="Add Sub Category" data-id="{{ $category->id }}"><i class="fas fa-plus"></i></span>
                            <span class="edit-category" data-toggle="modal" data-target="#edit-cat-modal" title="Edit Category" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-image="{{ $category->image }}" data-description="{{ $category->description }}" data-unit="{{ $category->unit }}"><i class="fas fa-edit"></i></span>
                            <span class="delete-this-category" title="Delete Category" data-id="{{ $category->id }}"><i class="fas fa-trash-alt"></i></span>
                            <span class="view-this-category-image" data-toggle="modal" data-target="#view-cat-image-modal" title="View Category Image" data-img="{{ $category->image }}"><img src="{{ $category->image }}"></span>
                        </div>
                   @endforeach
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection


@section('scripts')
<script>
    $( function() {
        $( "#sortable" ).sortable({
            update: function( event, ui ) {
                var id_arr = [];
                $( "#sortable .parentDiv" ).each(function( index ) {
                    id_arr.push($( this ).attr('data-id'));
                });

                $.ajax({
                    type: "POST",
                    url: base_url + '/orderCategory',
                    data: {ids: JSON.stringify(id_arr)},
                    success: function( response ) {
                        //location.reload();
                    }
                });
                  console.log( id_arr );
            }
        });
    } );
    var base_url = $('#base-url').attr('data-url');
    var _URL = window.URL || window.webkitURL;
    
    $(document).on("change", "#saveNewCategory input[name=image]", function(){
        var this_img = $(this);
        var image = $(this).val();
        var ext = image.split('.').pop().toLowerCase();
        
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $(this).val('');
            $('#saveNewCategory input[name=image]').css('border', '1px solid red');
            $('#saveNewCategory input[name=image]').next().remove();
            $('#saveNewCategory input[name=image]').after('<span class="input-error">Invalid image format!</span>');
        }else{
            var file = $(this)[0].files[0];
            img = new Image();
            img.src = _URL.createObjectURL(file);
              img.onload = function() {
               // imgwidth = this.width;
               // imgheight = this.height;
               imgwidth = 64;
               imgheight = 64;
               if(imgwidth != 64 && imgheight != 64){
                    this_img.val('');
                    $('#saveNewCategory input[name=image]').css('border', '1px solid red');
                    $('#saveNewCategory input[name=image]').next().remove();
                    $('#saveNewCategory input[name=image]').after('<span class="input-error">Image size should be 64px*64px!</span>'); 
               }else{
                    $('#saveNewCategory input[name=image]').css('border', '1px solid #d2d6de');
                    $('#saveNewCategory input[name=image]').next().remove();
               }
            }
        }
    });

    function validateCategoryForm(){
        
        var name = $('#saveNewCategory input[name=category_name]').val();
        var description = $('#saveNewCategory textarea[name=category_description]').val();
        var unit = $('#saveNewCategory input[name=unit]').val();
        var image = $('#saveNewCategory input[name=image]').val();
        var error = 0;
        if(name == ''){
            $('#saveNewCategory input[name=category_name]').css('border', '1px solid red');
            $('#saveNewCategory input[name=category_name]').next().remove();
            $('#saveNewCategory input[name=category_name]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#saveNewCategory input[name=category_name]').css('border', '1px solid #d2d6de');
            $('#saveNewCategory input[name=category_name]').next().remove();
        }

        if(description == ''){
            $('#saveNewCategory textarea[name=category_description]').css('border', '1px solid red');
            $('#saveNewCategory textarea[name=category_description]').next().remove();
            $('#saveNewCategory textarea[name=category_description]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#saveNewCategory textarea[name=category_description]').css('border', '1px solid #d2d6de');
            $('#saveNewCategory textarea[name=category_description]').next().remove();
        }

        if(unit == ''){
            $('#saveNewCategory input[name=unit]').css('border', '1px solid red');
            $('#saveNewCategory input[name=unit]').next().remove();
            $('#saveNewCategory input[name=unit]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#saveNewCategory input[name=unit]').css('border', '1px solid #d2d6de');
            $('#saveNewCategory input[name=unit]').next().remove();
        }

        if(image == ''){
            $('#saveNewCategory input[name=image]').css('border', '1px solid red');
            $('#saveNewCategory input[name=image]').next().remove();
            $('#saveNewCategory input[name=image]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#saveNewCategory input[name=image]').css('border', '1px solid #d2d6de');
            $('#saveNewCategory input[name=image]').next().remove();
        }

        if(error == 1){
            return false;
        }else{
            return true;
        }
    }

    $(document).on("change", "#editCategory input[name=image]", function(){
        var this_img = $(this);
        var image = $(this).val();
        var ext = image.split('.').pop().toLowerCase();
        
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $(this).val('');
            $('#editCategory input[name=image]').css('border', '1px solid red');
            $('#editCategory input[name=image]').next().remove();
            $('#editCategory input[name=image]').after('<span class="input-error">Invalid image format!</span>');
        }else{
            var file = $(this)[0].files[0];
            img = new Image();
            img.src = _URL.createObjectURL(file);
              img.onload = function() {
               // imgwidth = this.width;
               // imgheight = this.height;
               imgwidth = 64;
               imgheight = 64;
               if(imgwidth != 64 && imgheight != 64){
                    this_img.val('');
                    $('#editCategory input[name=image]').css('border', '1px solid red');
                    $('#editCategory input[name=image]').next().remove();
                    $('#editCategory input[name=image]').after('<span class="input-error">Image size should be 64px*64px!</span>'); 
               }else{
                    $('#editCategory input[name=image]').css('border', '1px solid #d2d6de');
                    $('#editCategory input[name=image]').next().remove();
               }
            }
        }
    });

    function validateEditCategoryForm(){
        
        var name = $('#editCategory input[name=category_name]').val();
        var description = $('#editCategory textarea[name=category_description]').val();
        var unit = $('#editCategory input[name=unit]').val();
        var error = 0;
        if(name == ''){
            $('#editCategory input[name=category_name]').css('border', '1px solid red');
            $('#editCategory input[name=category_name]').next().remove();
            $('#editCategory input[name=category_name]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#editCategory input[name=category_name]').css('border', '1px solid #d2d6de');
            $('#editCategory input[name=image]').next().remove();
        }

        if(description == ''){
            $('#editCategory textarea[name=category_description]').css('border', '1px solid red');
            $('#editCategory textarea[name=category_description]').next().remove();
            $('#editCategory textarea[name=category_description]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#editCategory textarea[name=category_description]').css('border', '1px solid #d2d6de');
            $('#editCategory textarea[name=category_description]').next().remove();
        }

        if(unit == ''){
            $('#editCategory input[name=unit]').css('border', '1px solid red');
            $('#editCategory input[name=unit]').next().remove();
            $('#editCategory input[name=unit]').after('<span class="input-error">This field is required!</span>');
            error = 1;
        }else{
            $('#editCategory input[name=unit]').css('border', '1px solid #d2d6de');
            $('#editCategory input[name=unit]').next().remove();
        }


        if(error == 1){
            return false;
        }else{
            return true;
        }
    }

    $(document).on("click", ".add-sub-category", function(){
        var parent_id = $(this).attr('data-id');
        $("#saveNewCategory")[0].reset();
        $('#saveNewCategory').find('input[type=hidden][name=parent_category]').val(parent_id);
    });

    $(document).on("click", ".edit-category", function(){
        var cat_id = $(this).attr('data-id');
        var cat_name = $(this).attr('data-name');
        var cat_image = $(this).attr('data-image');
        var cat_description = $(this).attr('data-description');
        var cat_unit = $(this).attr('data-unit');
        $("#editCategory")[0].reset();
        $('#editCategory').find('input[type=hidden][name=category_id]').val(cat_id);
        $('#editCategory').find('input[type=text][name=category_name]').val(cat_name);
        $('#editCategory').find('.img-cat img').attr('src', cat_image);
        $('#editCategory').find('textarea').val(cat_description);
        $('#editCategory').find('input[type=text][name=unit]').val(cat_unit);
    });

    $(document).on("click", ".view-this-category-image", function(){
        var cat_image = $(this).attr('data-img');
        console.log(cat_image);
        $('#view-cat-image-modal .modal-body img').attr('src', cat_image);
    });

    $(document).on("click", ".delete-this-category", function(){
        var id = $(this).attr('data-id');
        var r = confirm("Are you sure you want to delete this category.");
        if (r == true) {
            $.ajax({
                type: "POST",
                url: base_url + '/deleteCategory',
                data: {id: id},
                success: function( response ) {
                    location.reload();
                }
            });
        }        //$('#saveNewCategory').find('input[type=hidden][name=parent_category]').val(parent_id);
    });

    $(document).on("click", ".parentDivChildren", function(){
        if($( this ).parent().find('.parentDiv').length !== 0){
         $( this ).parent().find('.parentDiv').remove();
        }else{
          var child = $( this ).attr('data-child');
          if(child > 0){
            var parent_id = $( this ).attr('data-id');
            var this_div = $(this);
            $.ajax({
                type: "POST",
                url: base_url + '/getChildCategory',
                data: {parent_id: parent_id},
                success: function( response ) {
                    var result = jQuery.parseJSON(response);
                    console.log(result);
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
                                //cat_div = cat_div+'<span style="float: right;cursor: '+cursor+';" class="parentDivChildren" data-child="'+count_child_category+'" data-id="'+result[i].id+'" style=""><i class="fas fa-sort-down"></i></span>';
                            }
                        cat_div = cat_div+
                                //'<span class="add-sub-category" data-toggle="modal" data-target="#sub-cat-modal" title="Add Sub Category" data-id="'+result[i].id+'"><i class="fas fa-plus"></i></span>'+
                                '<span class="edit-category" data-toggle="modal" data-target="#edit-cat-modal" title="Edit Category" data-id="'+result[i].id+'"  data-description="'+result[i].description+'" data-unit="'+result[i].unit+'"   data-name="'+result[i].name+'" data-image="'+result[i].image+'"><i class="fas fa-edit"></i></span>'+
                                '<span class="delete-this-category" title="Delete Category" data-id="'+result[i].id+'"><i class="fas fa-trash-alt"></i></span>'+
                                '<span class="view-this-category-image" data-toggle="modal" data-target="#view-cat-image-modal" title="View Category Image" data-img="'+result[i].image+'"><img src="'+result[i].image+'"></span>'+
                                '</div>';
                        $(this_div).parent().append(cat_div);
                    }
                }
            });
          }
  }
    });
</script>
@endsection



