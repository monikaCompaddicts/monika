<table class="table table-responsive" id="settings-table">
    <thead>
        <tr>
            <th>Banner Heading</th>
        <th>Banner Description</th>
        <th>Banner Image</th>
        <th>Ad-Banner</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($settings as $settings)
        <tr>
            <td>{!! $settings->banner_heading !!}</td>
            <td>{!! $settings->banner_description !!}</td>
            <td>{!! $settings->banner_image !!}</td>
            <td>{!! $settings->ad_banner !!}</td>
            <td>
                {!! Form::open(['route' => ['settings.destroy', $settings->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('settings.show', [$settings->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('settings.edit', [$settings->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>