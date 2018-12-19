@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{ $total_vendors }}</h3>
                  <p>Total Vendors</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-friends"></i>
                </div>
                <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a-->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{ $total_customers }}</h3>
                  <p>Total Customers</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $total_ads }}</h3>
                  <p>Total Ads</p>
                </div>
                <div class="icon">
                  <i class="fas fa-ad"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{ $total_request }}</h3>
                  <p>Total Request</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-alt"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div> 
            <!-- ./col -->
        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col-md-4">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Recent Messages</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <?php //echo "<pre>";print_r($messages);exit; ?>
                    @foreach($messages as $msg)
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{ $msg['user_name'] }}</span>
                        <span class="direct-chat-timestamp pull-right">{{ $msg['time'] }}</span>
                      </div>
                      <?php $enquiry = (strlen($msg['message']) > 70) ? substr($msg['message'],0,70).'...' : $msg['message']; ?>
                      <div class="direct-chat-text">
                        {{ $enquiry }}
                        <div style="text-align: right;">
                          <a href="{{ url('vendor-ad/'.$msg['ad_id']) }}" class="product-title">
                            <span class="label bg-navy">{{ $msg['cat_name'] }}</span>
                          </a>
                        </div>
                      </div>
                    </div>
                    @endforeach

                  </div>
                  <!--/.direct-chat-messages-->
                </div>
                <!-- /.box-body -->
                <!-- <div class="box-footer" style="">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                      <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                    </div>
                  </form>
                </div> -->
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Vendors</h3>

                  <div class="box-tools pull-right">
                    <!-- <span class="label label-danger">8 New Members</span> -->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding" style="">
                  <ul class="users-list clearfix">
                    <?php $bg_color = array('bg-red-active','bg-yellow-active','bg-aqua-active','bg-blue-active','bg-light-blue-active','bg-green-active','bg-navy-active','bg-teal-active','bg-olive-active','bg-lime-active','bg-orange-active','bg-fuchsia-active','bg-purple-active','bg-maroon-active','bg-black-active');
                    //print_r($bg_color); exit;?>
                    @foreach($latest_vendors as $latest_vendor)
                    <?php $k_color = array_rand($bg_color);
                    $v_color = $bg_color[$k_color];
                    unset($bg_color[$k_color]);?>
                    <li>
                      <!-- <img src="dist/img/user1-128x128.jpg" alt="User Image"> -->
                      <span class="user-letter {{ $v_color }}">{{strtoupper($latest_vendor['name'][0])}}</span>
                      <a class="users-list-name" href="{{ url('/vendors/'.$latest_vendor['id']) }}">{{$latest_vendor['name']}}</a>
                      <span class="users-list-date">{{$latest_vendor['time']}}</span>
                    </li>
                    @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center" style="">
                  <a href="{{url('/vendors')}}" class="uppercase">View All Vendors</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>

            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Recently Posted Ads</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
                    <?php $label_color = array('bg-red-active','bg-yellow-active','bg-blue-active','bg-green-active');
                    //print_r($bg_color); exit;?>
                    @foreach($latest_ads as $latest_ad)
                    <?php $k_color = array_rand($label_color);
                    $v_color = $label_color[$k_color];
                    unset($label_color[$k_color]);?>
                    <li class="item">
                      <!-- <div class="product-img">
                        <img src="dist/img/default-50x50.gif" alt="Product Image">
                      </div> -->
                      <div class="product-info">
                        <a href="{{ url('vendor-ad/'.$latest_ad['id']) }}" class="product-title">{{ $latest_ad['title'] }}
                          <span class="label {{$v_color}} pull-right">{{ $latest_ad['category_name'] }}</span>
                        </a>
                        <span class="product-description">
                          {{ $latest_ad['description'] }}
                        </span>
                      </div>
                    </li>
                    @endforeach
                    <!-- /.item -->
                  </ul>
                </div>
                <!-- /.box-body -->
                <!-- <div class="box-footer text-center">
                  <a href="{{url('/vendors')}}" class="uppercase">View All Vendors</a>
                </div> -->
                <!-- /.box-footer -->
              </div>
            </div>
            <!-- /.col -->
          </div>
        
    </div>
@endsection

@section('scripts')

@endsection


