<!-- Banner Heading Field -->
<div class="form-group col-sm-12">
	<div class="form-group col-sm-6">
	    {!! Form::label('banner_heading', 'CMS Title:') !!}
	    {!! Form::select('cms_title', $cms_titles, null, ['class' => 'form-control', 'id' => 'select-cms-title']) !!}
	</div>

</div>

<div class="form-group col-sm-12" id="cms-content" style="display: none;">
	<div class="form-group col-sm-12 col-lg-12">
	    {!! Form::label('cms_description', 'CMS Description:') !!}
	    {!! Form::textarea('cms_description', null, ['class' => 'form-control', 'rows' => '9', 'id' => 'cms-description']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
	<div class="form-group col-sm-12">
    	{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    	<a href="{!! route('banners.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>
