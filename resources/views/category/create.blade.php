@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add Category
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open([]) !!}

                        @include('category.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var base_url = $('#base-url').attr('data-url');
    function changeCategory(elm){
        var parent_id = $(elm).val();
        console.log($(elm).parent().nextAll());
        if($(elm).parent().nextAll().find('.new-row').length > 0){
            $(elm).parent().nextAll().find('.new-row').remove();
        }else{
            if($(elm).parent().parent().nextAll().hasClass("new-row")){
                $(elm).parent().parent().nextAll().remove();
            }
        }
        $.ajax({
            type: "POST",
            url: base_url + '/admin/getChildCategory',
            data: {parent_id: parent_id},
            success: function( response ) {
                var result = jQuery.parseJSON(response);
                if(result.length == 0){
                    var new_div = '<div class="new-row"><div class="form-group col-sm-5">'+
                                        '<label>Add New Sub Category</label>'+
                                        '<input type="text" name="sub_category" class="form-control">'+
                                    '</div></div>';
                }else{
                    var new_div = '<div class="new-row"><div class="form-group col-sm-5">'+
                                        '<label>Add Sub Category</label>'+
                                        '<select name="sub_category" class="form-control" onchange="changeCategory(this);">'+
                                        '<option value="0">Select</option>';
                                        for (var i = 0; i < result.length; i++) {
                                            new_div = new_div+'<option value="'+result[i].id+'">'+result[i].name+'</option>';
                                        }
                                    new_div = new_div+'</select>'+
                                    '</div>'+
                                    '<div class="form-group col-sm-2" style="text-align: center;"><label>OR</label></div>'+
                                    '<div class="form-group col-sm-5">'+
                                        '<label>Add New Sub Category</label>'+
                                        '<input type="text" name="sub_category" class="form-control">'+
                                    '</div></div>';
                }
                $('#new-category-div').append(new_div);
            }
        });   
    }
</script>
@endsection