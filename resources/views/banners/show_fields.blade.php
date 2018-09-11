<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $banner->id !!}</p>
</div>

<!-- Banner Heading Field -->
<div class="form-group">
    {!! Form::label('banner_heading', 'Banner Heading:') !!}
    <p>{!! $banner->banner_heading !!}</p>
</div>

<!-- Banner Description Field -->
<div class="form-group">
    {!! Form::label('banner_description', 'Banner Description:') !!}
    <p>{!! $banner->banner_description !!}</p>
</div>

<!-- Banner Image Field -->
<div class="form-group">
    {!! Form::label('banner_image', 'Banner Image:') !!}
    <p>{!! $banner->banner_image !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $banner->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $banner->updated_at !!}</p>
</div>

