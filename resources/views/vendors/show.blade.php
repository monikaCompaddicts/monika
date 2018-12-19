@extends('layouts.app')

@section('css')
<style>
    .form-group {
        margin-bottom: 15px;
        width: 250px;
        display: inline-block;
        vertical-align: top;
    }
    #vendors-ad-table{
        width: 100%;
        border: 1px solid #ddd;
    }
    #vendors-ad-table th, #vendors-ad-table td{
        width: 15%;
    }
    #vendors-ad-table .ad-desc{
        width: 30%;
    }
    #vendors-ad-table .ad-views{
        width: 10%;
    }
    #vendors-ad-table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #d41f00de;
        color: white;
    }
    #vendors-ad-table tr:nth-child(even){
        background-color: #f2f2f2;
    }
    .name-heading{
        margin-left: -10px;
        margin-right: -10px;
        margin-top: -5px;
    }
    .vendor-detail-box .info-box-text{
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 13px;
    }
    .vendor-date-box .info-box-number{
        font-size: 15px;
    }
    .info-box-icon i{
        font-size: 35px;
    }
    #search_vendor_ads{
        padding: 3px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
</style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Vendor
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box vendor-detail-box">
                <!--span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span-->

                <div class="info-box-content" style="margin-left: 0px;">
                  <span class="info-box-text bg-blue-active text-center name-heading">{!! $vendor->name !!}</span>
                  <span class="info-box-text" style="text-transform: none;"><b>Email: </b>{!! $vendor->email !!}</span>
                  <span class="info-box-text" style="text-transform: none;"><b>Contact No.: </b>{!! $vendor->phone !!}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box vendor-date-box">
                <span class="info-box-icon bg-maroon"><i class="fa fa-calendar-plus-o"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Created At</span>
                  <span class="info-box-number">{!! date('d M, Y', strtotime($vendor->created_at)) !!}</span>
                  <!-- <span class="info-box-text">Updated At</span>
                  <span class="info-box-number">{!! date('d M, Y', strtotime($vendor->updated_at)) !!}</span> -->
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Ads</span>
                  <span class="info-box-number">{{ count($vendor_ads) }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fas fa-comment-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Enquiries</span>
                  <span class="info-box-number">{{ $enquiry_count }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px;padding-right: 20px">
                    
                    @if(count($vendor_ads) != 0)
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right">
                        <h4 class="pull-left"><u>Vendor Ads</u></h4>
                        <input type="text" id="search_vendor_ads" class="pull-right" placeholder="Search...">
                    </div>
                    <table class="table table-responsive" id="vendors-ad-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <!-- <th class="ad-desc">Description</th> -->
                                <th>Category</th>
                                <th class="ad-views">Views</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($vendor_ads as $vendorAd)
                            <tr class="vendor-data-rows tr-ad-data">
                                <td>{!! $vendorAd->title !!}</td>
                                <!-- <td class="ad-desc">{!! $vendorAd->description !!}</td> -->
                                <?php $category_detail = DB::table('categories')->where('id', $vendorAd->category_id)->first();
                                if($category_detail->parent_category == 0){ ?>
                                    <td>{!! $category_detail->name !!}</td>
                                <?php }else{ 
                                    $parent_category = DB::table('categories')->where('id', $category_detail->parent_category)->first();
                                ?>
                                    <td>{!! $parent_category->name !!} <i class="fas fa-chevron-right" style="width: 10px;"></i> {!! $category_detail->name !!}</td>
                                <?php } ?>       
                                <td class="ad-views">{!! $vendorAd->views !!}</td>
                                <td>{!! date("d M, Y H:i", strtotime($vendorAd->added_on)) !!}</td>
                                <td>
                                    <a href="{{ url('vendor-ad/'.$vendorAd->id) }}" class='btn btn-xs bg-teal-active'>View Ad Detail</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $vendor_ads->links() }}
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
      $("#search_vendor_ads").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#vendors-ad-table .tr-ad-data").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
@endsection