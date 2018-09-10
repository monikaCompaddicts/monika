<!-- Name Field -->
<div class="form-group col-sm-5" id="all-parent-category">
    {!! Form::label('name', 'Select Parent Category') !!}
    {!! Form::select('parent_category', $parent_categories, 0, ['class' => 'form-control', 'onchange' => 'changeCategory(this);']); !!}
</div>

<div class="form-group col-sm-2" style="text-align: center;">
	{!! Form::label('or', 'OR') !!}
</div>

<div class="form-group col-sm-5">
    {!! Form::label('name', 'Add New Parent Category') !!}
    {!! Form::text('parent_category', '', ['class' => 'form-control']); !!}
</div>

<div id="new-category-div">
	
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tests.index') !!}" class="btn btn-default">Cancel</a>
</div>
