

<!--li class="{{ Request::is('tests*') ? 'active' : '' }}">
    <a href="{!! route('tests.index') !!}"><i class="fa fa-edit"></i><span>Tests</span></a>
</li-->

<li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
    <a href="{{url('/admin/category')}}"><i class="fa fa-edit"></i><span>Category</span></a>
</li>
