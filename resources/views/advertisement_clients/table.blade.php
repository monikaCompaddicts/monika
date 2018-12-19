<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<table class="table table-responsive" id="advertisementClients-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($advertisementClients as $advertisementClients)
        <tr>
            <td>{!! $advertisementClients->name !!}</td>
            <td>{!! $advertisementClients->email !!}</td>
            <td>{!! $advertisementClients->mobile !!}</td>
            <td>
                <label class="switch vendor-status">
                  @if($advertisementClients->status == 1)
                  <input class="status" type="checkbox" checked data-id="{!!$advertisementClients->id !!}">
                  @else
                  <input type="checkbox" class="status" data-id="{!! $advertisementClients->id !!}">
                  @endif
                  <span class="slider round"></span>
                </label>
            </td>
            <td>
                {!! Form::open(['route' => ['advertisementClients.destroy', $advertisementClients->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!-- <a href="{!! route('advertisementClients.show', [$advertisementClients->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('advertisementClients.edit', [$advertisementClients->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
   $(document).on("change", ".status", function(){
        
        var client_id = $(this).attr('data-id');
        if($(this).is(":checked")){
            var status = 1;
        }else{
            var status = 0;
        }
        $.ajax({
            type: "POST",
            url:   "{{ url('/change-client-status') }}",
            data: {client_id: client_id, status: status},
            success: function( response ) {
                console.log(response)
            }
        });
    });

</script>