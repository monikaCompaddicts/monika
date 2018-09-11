

<!--li class="{{ Request::is('tests*') ? 'active' : '' }}">
    <a href="{!! route('tests.index') !!}"><i class="fa fa-edit"></i><span>Tests</span></a>
</li-->

<li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
    <a href="{{url('/admin/category')}}"><i class="fa fa-edit"></i><span>Category</span></a>
</li>
<li class="{{ Request::is('vendors*') ? 'active' : '' }}">
    <a href="{!! route('vendors.index') !!}"><i class="fa fa-edit"></i><span>Vendors</span></a>
</li>

<li class="{{ Request::is('locations*') ? 'active' : '' }}">
    <a href="{!! route('locations.index') !!}"><i class="fa fa-edit"></i><span>Locations</span></a>
</li>

<li class="{{ Request::is('banners*') ? 'active' : '' }}">
    <a href="{!! url('banners/1/edit') !!}"><i class="fa fa-edit"></i><span>Banners</span></a>
</li>

