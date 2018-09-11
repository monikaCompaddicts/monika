<!-- Banner Heading Field -->
<div class="form-group col-sm-6">
	<div class="form-group col-sm-12">
	    {!! Form::label('banner_heading', 'Banner Heading:') !!}
	    {!! Form::text('banner_heading', null, ['class' => 'form-control']) !!}
	</div>


	<!-- Banner Image Field -->
	<div class="form-group col-sm-12">
	    {!! Form::label('banner_image', 'Banner Image:') !!}
	    {!! Form::file('banner_image', ['class' => 'form-control']) !!}
	</div>

	<div class="form-group col-sm-12">
		<img src="{{ $banner->banner_image }}" width="100%">
	</div>
</div>

<div class="col-sm-6">
	<!-- Banner Description Field -->
	<div class="form-group col-sm-12 col-lg-12">
	    {!! Form::label('banner_description', 'Banner Description:') !!}
	    {!! Form::textarea('banner_description', null, ['class' => 'form-control', 'rows' => '5']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('banners.index') !!}" class="btn btn-default">Cancel</a>
</div>
