<table class="table table-responsive" id="vendors-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($vendors as $vendor)
        <tr>
            <td>{!! $vendor->name !!}</td>
            <td>{!! $vendor->email !!}</td>
            <td>{!! $vendor->phone !!}</td>
            <td>
                <label class="switch vendor-status">
                  @if($vendor->status == 1)
                  <input type="checkbox" checked data-id="{!! $vendor->id !!}">
                  @else
                  <input type="checkbox" data-id="{!! $vendor->id !!}">
                  @endif
                  <span class="slider round"></span>
                </label>
            </td>
            <!--td>{!! $vendor->status !!}</td-->
            <td>
                <!--{!! Form::open(['route' => ['vendors.destroy', $vendor->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('vendors.show', [$vendor->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>-->
                    <a href="{!! route('vendors.edit', [$vendor->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="{{ url('/admin/send-mail/'.$vendor->id) }}" class='btn btn-primary btn-xs send-mail' data-id='{{ $vendor->id }}'>Send Mail</a>
                    <!--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}-->
                </div>
                <!--{!! Form::close() !!}--> 
            </td>
        </tr>
    @endforeach
    </tbody>
</table>