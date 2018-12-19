@extends('layouts.app')

@section('css')
<style>
    .form-group {
        margin-bottom: 15px;
        width: 250px;
        display: inline-block;
        vertical-align: top;
    }
    #ad-enquiry-table{
        width: 100%;
        border: 1px solid #ddd;
    }
    #ad-enquiry-table th, #ad-enquiry-table td{
        width: 20%;
    }
    #ad-enquiry-table .ad-desc{
        width: 30%;
    }
    #ad-enquiry-table .ad-posted-on{
        width: 15%;
    }
    #ad-enquiry-table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #d41f00de;
        color: white;
    }
    #ad-enquiry-table tr:nth-child(even){
        background-color: #f2f2f2;
    }
    .ad-images-ul{
        list-style: none;
        padding-left: 0;
    }
    .ad-images-ul li{
        width: 180px;
        height: 180px;
        display: inline-block;
        vertical-align: top;
        margin-right: 20px;
        border: 1px solid #ddd;
    }
    .ad-images-ul li img{
        width: 100%;
        height: 100%;
        object-fit:cover;
    }
    #search_ad_enquiry{
        padding: 3px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
</style>
@endsection

@section('content')
    <!--section class="content-header">
        <h1>
            {{$ad->title}}
        </h1>
    </section-->
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px;padding-right: 20px">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left" style="margin-bottom: 10px;">
                        <h3 style="margin-top: 0px;margin-bottom: 0px;float:left;"><b>{{$ad->title}}</b></h3>
                        <span style="float: right;"><span>Active / Inactive Ad</span>
                        <label class="switch ad-status" style="margin-bottom: 0;">
                          @if($ad->status == 1)
                          <input type="checkbox" checked data-id="{!! $ad->id !!}">
                          @else
                          <input type="checkbox" data-id="{!! $ad->id !!}">
                          @endif
                          <span class="slider round"></span>
                        </label>
                        </span>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left">
                        <p>({!! $ad->description !!})</p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left">
                        <h4><u>Ad Images</u></h4>
                        <ul class="ad-images-ul">
                            @foreach($ad_images as $ad_image)
                            <li><img src="{{$ad_image->image}}"></li>
                            @endforeach
                        </ul>

                    </div>
                    @if(count($ad_enquiries) != 0)
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left">
                        <h4 class="pull-left"><u>Ad Enquiries</u></h4>
                        <input type="text" id="search_ad_enquiry" class="pull-right" placeholder="Search...">
                    </div>
                    <table class="table table-responsive" id="ad-enquiry-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="ad-posted-on">Mobile No.</th>
                                <th class="ad-desc">Message</th>
                                <th class="ad-posted-on">Posted On</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ad_enquiries as $adEnquiry)
                            <?php $user_id = $adEnquiry->user_id; $user_type = $adEnquiry->user_type;
                                if($user_type == 1){
                                    $user_data = DB::table('vendors')->where('id', $user_id)->first();
                                }else{
                                    $user_data = DB::table('customers')->where('id', $user_id)->first();
                                }
                            ?>
                            <tr class="tr-ad-data">
                                <td>{{ $user_data->name }}</td>
                                <td>{{ $user_data->email }}</td>
                                <td class="ad-posted-on">{{ $user_data->phone }}</td>
                                <td class="ad-desc">{{ $adEnquiry->message }}</td>
                                <td class="ad-posted-on">{{ date("d M, Y H:i", strtotime($adEnquiry->created_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $ad_enquiries->links() }}
                    @endif
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left">
                        <a href="{!! $_SERVER['HTTP_REFERER'] !!}" class="btn btn-default">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $("#search_ad_enquiry").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#ad-enquiry-table .tr-ad-data").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    var base_url = $('#base-url').attr('data-url');
    $(document).on("change", ".ad-status input[type=checkbox]", function(){
        var ad_id = $(this).attr('data-id');
        if($(this).is(":checked")){
            var status = 1;
        }else{
            var status = 0;
        }
        $.ajax({
            type: "POST",
            url: base_url + '/changeAdStatus',
            data: {ad_id: ad_id, status: status},
            success: function( response ) {
                //location.reload();
            }
        });
    });
</script>
@endsection