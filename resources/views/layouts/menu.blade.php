
<style>
	i{width: 30px;}
</style>
<!--li class="{{ Request::is('tests*') ? 'active' : '' }}">
    <a href="{!! route('tests.index') !!}"><i class="fa fa-edit"></i><span>Tests</span></a>
</li-->
<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
    <a href="{{url('/dashboard')}}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
</li>
<li class="{{ Request::is('category*') ? 'active' : '' }}">
    <a href="{{url('/category')}}"><i class="fas fa-fish"></i><span>Category</span></a>
</li>
<li class="{{ Request::is('vendors*') ? 'active' : '' }}">
    <a href="{!! route('vendors.index') !!}"><i class="fas fa-user-friends"></i></i><span>Vendors</span></a>
</li>
<li class="{{ Request::is('customers*') ? 'active' : '' }}">
    <a href="{!! url('/customers') !!}"><i class="fas fa-user-friends"></i></i><span>Customers</span></a>
</li>
<li class="{{ Request::is('locations*') ? 'active' : '' }}">
    <a href="{!! route('locations.index') !!}"><i class="fas fa-map-marker"></i><span>Locations</span></a>
</li>
<li class="{{ Request::is('banners*') ? 'active' : '' }}">
    <a href="{!! url('banners/1/edit') !!}"><i class="fas fa-money-check"></i><span>Setttings</span></a>
</li>
<li class="{{ Request::is('cms*') ? 'active' : '' }}">
    <a href="{!! url('/cms') !!}"><i class="fas fa-sliders-h"></i><span>CMS</span></a>
</li>

<li class="{{ Request::is('ticker*') ? 'active' : '' }}">
    <a href="{!! url('/ticker') !!}"><i class="fab fa-slideshare"></i><span>Ticker</span></a>
</li>










<li class="{{ Request::is('advertisementClients*') ? 'active' : '' }}">
    <a href="{!! route('advertisementClients.index') !!}"><i class="fa fa-edit"></i><span>Advertisement Clients</span></a>
</li>

<li class="{{ Request::is('advertisements*') ? 'active' : '' }}">
    <a href="{!! route('advertisements.index') !!}"><i class="fa fa-edit"></i><span>Advertisements</span></a>
</li>

