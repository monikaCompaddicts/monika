
<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('logo', 'Logo:') !!}
	    {!! Form::file('logo', ['class' => 'form-control']) !!}
	    @if(isset($banner->logo))
		    <div>
		    	<br>
		    	<img src="{{ url($banner->logo) }}" style="width: 20%">	
		    </div>
	    @endif	    
	</div>
	
	<div class="form-group col-sm-6">
	    {!! Form::label('loader', 'Loader:') !!}
	    {!! Form::file('loader', ['class' => 'form-control']) !!}
	    @if(isset($banner->loader))
		    <div>
		    	<br>
				<img src="{{ url($banner->loader) }}" width="20%">
			</div>
		@endif
	</div>
</div>

<!-- contacts -->
<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('email', 'Email:') !!}
	    {!! Form::text('email', null, ['class' => 'form-control']) !!}
	    
	</div>
	
	<div class="form-group col-sm-6">
	    {!! Form::label('mobile', 'Mobile:') !!}
	    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- page links -->
<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('fb_page_link', 'Facebook link:') !!}
	    {!! Form::text('fb_page_link', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group col-sm-6">
	    {!! Form::label('twitter_page_link', 'Twitter link:') !!}
	    {!! Form::text('twitter_page_link', null, ['class' => 'form-control']) !!}
	</div>
</div>


<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('google_page_lnik', 'Google link:') !!}
	    {!! Form::text('google_page_lnik', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group col-sm-6">
	    {!! Form::label('instragram_page_link', 'Instragram link:') !!}
	    {!! Form::text('instragram_page_link', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- app links -->

<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('android_play_store_link', 'Play store:') !!}
	    {!! Form::text('android_play_store_link', null, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group col-sm-6">
	    {!! Form::label('ios_app_store_link', 'App store:') !!}
	    {!! Form::text('ios_app_store_link', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Banner Heading Field -->
<div class="form-group col-sm-6">
	<div class="form-group col-sm-12">
	    {!! Form::label('banner_heading', 'Banner Heading:') !!}
	    {!! Form::textarea('banner_heading', null, ['class' => 'form-control', 'rows' => '5']) !!}
	    @if($errors->has('banner_heading'))
	    <div class="text-danger">
	    	{{ $errors->first('banner_heading') }}
	    </div>
	    @endif
	</div>


	<!-- Banner Image Field -->
	<div class="form-group col-sm-12">
	    {!! Form::label('banner_image', 'Banner Image:') !!}
	    {!! Form::file('banner_image', ['class' => 'form-control']) !!}
	    @if($errors->has('banner_image'))
	    <div class="text-danger">
	    	{{ $errors->first('banner_image') }}
	    </div>
	    @endif
	</div>
	@if(isset($banner->banner_image))
	<div class="form-group col-sm-12">
		<img src="{{ url($banner->banner_image) }}" width="100%">
	</div>
	@endif
	
</div>

<div class="col-sm-6">
	<!-- Banner Description Field -->
	<div class="form-group col-sm-12 col-lg-12">
	    {!! Form::label('banner_description', 'Banner Description:') !!}
	    {!! Form::textarea('banner_description', null, ['class' => 'form-control', 'rows' => '5']) !!}
	    @if($errors->has('banner_description'))
	    <div class="text-danger">
	    	{{ $errors->first('banner_description') }}
	    </div>
	    @endif
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
