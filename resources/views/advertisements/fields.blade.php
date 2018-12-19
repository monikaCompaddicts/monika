<!-- Dimension Field -->


<div class="form-group col-sm-6">
    {!! Form::label('dimension', 'Position & Dimension:') !!}
    <select name="dimension" id="dimension" class="form-control">
        <option value="">Select Position</option>
        @foreach($data['dimension'] as $dim)
            @if( isset($advertisement) && ($dim->id == $advertisement->dimension)))            
            <option value="{{ $dim->id }}" selected data-dim={{$dim->dimension}}>{{ $dim->position_name }} ({{ $dim->dimension }})</option>
            @else 
                <option data-dim={{$dim->dimension}} value="{{ $dim->id }}" {{ old('dimension') == $dim->id ? 'selected' : '' }}>{{ $dim->position_name }} ({{ $dim->dimension }})</option>
            @endif
        @endforeach        
    </select>
    
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <input type="file" name="image" class="form-control" id="image">
    @if(isset($advertisement->image))
    <img src="{{url($advertisement->image)}}" style="width: 100%; margin-top: 20px">
    @endif
</div>

<!-- Client Field -->

<div class="form-group col-sm-6">
    {!! Form::label('client', 'Client:') !!}

    <select name="client" class="form-control">
        <option value="">Select Client</option>>
        @foreach($data['clients'] as $client)

            @if( isset($advertisement) && ($client->id == $advertisement->client)))

            <option value="{{ $client->id }}" selected>{{ $client->name }} ({{ $client->mobile }})</option>>
            @else
            <option value="{{ $client->id }}" {{ old('client') == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->mobile }})</option>> 
            @endif 
                    
        @endforeach
    </select>
</div>




<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'onclick' => 'return validateImage();']) !!}
    <a href="{!! route('advertisements.index') !!}" class="btn btn-default">Cancel</a>
</div>


<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
var imgHeight = null;
var imghWidth = null;
$(document).ready(function(){
    var _URL = window.URL || window.webkitURL;
    
    $("#image").change(function (e) {
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                //alert(this.width + " " + this.height);
                imgHeight = this.height;
                imghWidth = this.width;
            };
            img.src = _URL.createObjectURL(file);
        }
    });

});

function validateImage() {     
        // if(!document.getElementById('image').value) {
        //     alert('Please select image');
        //     return false;
        // }
        if(imghWidth == null && imgHeight == null) {
            return true;
        }

        var e = document.getElementById("dimension");
        var option = e.options[e.selectedIndex];
        var dimension = option.getAttribute('data-dim');

        //var dimension = document.getElementById('dimension').options[selectedIndex];
        

        var imgDim    = (imghWidth.toString()) + 'X' + (imgHeight.toString())
        //console.log(dimension); return false;
        if(dimension != imgDim) {
            alert('Image dimension not matched');
            return false;
        } 

    }
</script>
