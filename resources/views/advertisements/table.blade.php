<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<table class="table table-responsive" id="advertisements-table">
    <thead>
        <tr>
            <th style="width: 20%">Image</th>
            <th>Position & Dimension</th>
            <th>Url</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Client</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($advertisements as $advertisement)
        <tr>
            <td>
                @if(isset($advertisement->image))
                <img src="{{ url($advertisement->image) }}" style="width: 40%">
                @endif
            </td>
            <?php
                $dim_position = DB::table('ad_dimensions')->where('id', $advertisement->dimension)->first();
            ?>
            <td>{!! $dim_position->position_name !!} ({!! $dim_position->dimension !!})</td>
            <td>{!! $advertisement->url !!}</td>
            <td>{!! $advertisement->start_date !!}</td>
            <td>{!! $advertisement->end_date !!}</td>
            <?php
                $name = DB::table('advertisement_clients')->where('id', $advertisement->client)->first();
            ?>
            <td>
                @if(isset($name))
                {!! $name->name !!}
                @endif
            </td>

             <td>
                <label class="switch vendor-status">
                  @if($advertisement->status == 1)
                  <input class="status" type="checkbox" checked data-id="{!! $advertisement->id !!}">
                  @else
                  <input type="checkbox" class="status" data-id="{!! $advertisement->id !!}">
                  @endif
                  <span class="slider round"></span>
                </label>
            </td>

            <td>
                {!! Form::open(['route' => ['advertisements.destroy', $advertisement->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!-- <a href="{!! route('advertisements.show', [$advertisement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('advertisements.edit', [$advertisement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
    
<script>
   $(document).on("change", ".status", function(){
        
        var adv_id = $(this).attr('data-id');
        if($(this).is(":checked")){
            var status = 1;
        }else{
            var status = 0;
        }
        $.ajax({
            type: "POST",
            url:   "{{ url('/change-advertismente-status') }}",
            data: {advertisement_id: adv_id, status: status},
            success: function( response ) {
                console.log(response)
            }
        });
    });

</script>
</table>