@extends('layouts.app')

@section('css')
<style>
  .add-more-ticker i, .delete-more-ticker i{
    font-size: 25px;
    padding-top: 30px;
  }
  .append-more-rows a{
    text-align: center;
  }
</style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Ticker Content
        </h1>
   </section>
   <div class="content" style="padding-top: 0px;">
       @include('adminlte-templates::common.errors')
       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                    {!! Form::open(array('url' => 'saveTicker', 'method' => 'post', 'id' => 'save-ticker-form')) !!}
                    <input type="hidden" name="deleted_ids">
                      <div id="ticker-form">
                        @if(count($ticker) == 0)
                          <input type="hidden" name="count_ticker" value="1">
                          <div class="col-md-12 append-more-rows">
                            <div class="form-group col-sm-5">
                                {!! Form::label('name_1', 'Product Name:', ['class' => 'label-product-name']) !!}
                                {!! Form::text('name_1', null, ['class' => 'form-control product-name']) !!}
                                {!! Form::hidden('id_1', null, ['class' => 'form-control product-id']) !!}
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-5">
                                {!! Form::label('price_1', 'Price:', ['class' => 'label-product-price']) !!}
                                {!! Form::text('price_1', null, ['class' => 'form-control product-price']) !!}
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-1">
                                <a href="javascript:void(0);" class="add-more-ticker"><i class="fas fa-plus-circle"></i></a>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-1">
                                <!-- <a href="javascript:void(0);" class="delete-more-ticker"><i class="fas fa-minus-circle"></i></a> -->
                            </div>
                          </div>
                        @else
                          <input type="hidden" name="count_ticker" value="{{ count($ticker) }}">
                          @for($i=1;$i<=count($ticker);$i++) 
                          <?php $j = $i-1;?>
                          <div class="col-md-12 append-more-rows">
                            <div class="form-group col-sm-5">
                                {!! Form::label('name_'.$i, 'Product Name:', ['class' => 'label-product-name']) !!}
                                {!! Form::text('name_'.$i, $ticker[$j]->product_name, ['class' => 'form-control product-name']) !!}
                                {!! Form::hidden('id_'.$i, $ticker[$j]->id, ['class' => 'form-control product-id']) !!}
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-5">
                                {!! Form::label('price_'.$i, 'Price:', ['class' => 'label-product-price']) !!}
                                {!! Form::text('price_'.$i, $ticker[$j]->product_price, ['class' => 'form-control product-price']) !!}
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-1">
                                <a href="javascript:void(0);" class="add-more-ticker"><i class="fas fa-plus-circle"></i></a>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-sm-1">
                              @if($i!=1)
                                <a href="javascript:void(0);" class="delete-more-ticker" data-id="{{ $ticker[$j]->id }}"><i class="fas fa-minus-circle"></i></a>
                              @endif
                            </div>
                          </div>
                          @endfor
                        @endif
                        

                      </div>
                      <div class="col-md-12">
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary', 'onclick' => 'return validateTrickerForm();']) !!}
                            <!-- <a href="{!! route('vendors.index') !!}" class="btn btn-default">Cancel</a> -->
                        </div>
                      </div>

                    {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
<script>
  var deleted_ids = '';
  var comma = '';
  $(document).on('click', '.add-more-ticker', function(){
    var count = parseInt($('#save-ticker-form input[name=count_ticker]').val())+1;
    $('#save-ticker-form input[name=count_ticker]').val(count);

    var ticker_div = '<div class="col-md-12 append-more-rows">'+
                '<div class="form-group col-sm-5">'+
                  '<label for="name_'+count+'" class="label-product-name">Product Name:</label>'+
                  '<input class="form-control product-name" name="name_'+count+'" type="text">'+
                  '<input class="form-control product-id" name="id_'+count+'" type="hidden">'+
                '</div>'+
                '<div class="form-group col-sm-5">'+
                  '<label for="price_'+count+'" class="label-product-price">Product Price:</label>'+
                  '<input class="form-control product-price" name="price_'+count+'" type="text">'+
                '</div>'+
                '<div class="form-group col-sm-1">'+
                  '<a href="javascript:void(0);" class="add-more-ticker"><i class="fas fa-plus-circle"></i></a>'+
                '</div>'+
                '<div class="form-group col-sm-1">'+
                  '<a href="javascript:void(0);" class="delete-more-ticker" data-id=""><i class="fas fa-minus-circle"></i></a>'+
                '</div>'+
              '</div>';

    $('#ticker-form').append(ticker_div);
     
  });

  $(document).on('click', '.delete-more-ticker', function(){
    var count = parseInt($('#save-ticker-form input[name=count_ticker]').val())-1;
    $('#save-ticker-form input[name=count_ticker]').val(count);

    if($(this).attr('data-id') != ''){
      var id = $(this).attr('data-id');
      deleted_ids = deleted_ids+''+comma+''+id;
      comma = ',';
      console.log(deleted_ids);
    }

    $(this).parent().parent().remove();

    //var i = 1;
    $('.append-more-rows').each(function(i, obj) {
      i++;

      $(this).find('.label-product-name').attr('for', 'name_'+i);
      $(this).find('.product-name').attr('name', 'name_'+i);
      $(this).find('.product-id').attr('name', 'id_'+i);
      $(this).find('.label-product-price').attr('for', 'price_'+i);
      $(this).find('.product-price').attr('name', 'price_'+i);
    });

    $('#save-ticker-form input[name=deleted_ids]').val(deleted_ids);
  });

  function validateTrickerForm(){
    var error = 0;
    $('#save-ticker-form input[type=text]').each(function(i, obj) {
      if($(this).val() == ''){
        error = 1;
        $(this).css('border', '1px solid red');
      }else{
        if($(this).hasClass("product-price")){
          var price_val = $(this).val();
          if(/^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(price_val)){
            $(this).css('border', '1px solid #d2d6de');
          }else{
            error = 1;
            $(this).css('border', '1px solid red');
          }
        }else{
          $(this).css('border', '1px solid #d2d6de');
        }
      }

    });

    if(error == 0)
      return true;
    else
      return false;
  }
</script>
@endsection