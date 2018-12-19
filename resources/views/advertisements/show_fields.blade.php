<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $advertisement->id !!}</p>
</div>

<!-- Dimension Field -->
<div class="form-group">
    {!! Form::label('dimension', 'Dimension:') !!}
    <p>{!! $advertisement->dimension !!}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{!! $advertisement->url !!}</p>
</div>

<!-- Start Date Field -->
<div class="form-group">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{!! $advertisement->start_date !!}</p>
</div>

<!-- End Date Field -->
<div class="form-group">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{!! $advertisement->end_date !!}</p>
</div>

<!-- Client Field -->
<div class="form-group">
    {!! Form::label('client', 'Client:') !!}
    <p>{!! $data['client']->client !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $advertisement->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $advertisement->updated_at !!}</p>
</div>

