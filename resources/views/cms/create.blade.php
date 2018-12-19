@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            CMS
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::open(['url' => 'updateCMS', 'method' => 'post']) !!}

                        @include('cms.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
<script>
  var base_url = $('#base-url').attr('data-url');
  $(document).on("change", "#select-cms-title", function(){
    var cms_id = $(this).val();
    $.ajax({
          type: "POST",
          url: base_url + '/getCMSContent',
          data: {cms_id: cms_id},
          success: function( response ) {
              if(cms_id == 0){
                $('#cms-content').hide();
              }else{
                if(response == 0){
                  tinymce.get("cms-description").setContent('');
                }else{
                  var result = JSON.parse(response);
                  tinymce.get("cms-description").setContent(result.content);
                }
                $('#cms-content').show();
              }
          }
      });
  });
</script>
@endsection