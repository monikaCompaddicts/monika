@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Admin Profile</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-sm-6">
                    <div class="form-group col-sm-12">
                        <h4>Admin Details</h4>
                    </div>
                {!! Form::open(array('url' => 'updateUserData', 'method' => 'post')) !!}
                    {!! Form::hidden('id', $user->id, ['class' => 'form-control']) !!}

                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('name', 'Name:', ['style' => 'display: block;']) !!}
                        {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                        <!--span style="cursor: pointer;" class="edit-this-text"><i class="fa fa-edit"></i></span-->
                    </div>
                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('email', 'Email:', ['style' => 'display: block;']) !!}
                        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>              
                {!! Form::close() !!}
                </div>

                <div class="col-sm-6" style="border-left: 1px solid #ddd;
">
                    <div class="form-group col-sm-12">
                        <h4>Change Password</h4>
                    </div>
                {!! Form::open(array('url' => 'changeUserPassword', 'method' => 'post')) !!}
                    {!! Form::hidden('id', $user->id, ['class' => 'form-control']) !!}

                    <!-- Registration No Field -->
                    <!--div class="form-group col-sm-12">
                        {!! Form::label('old_password', 'Old Password:', ['style' => 'display: block;']) !!}
                        {!! Form::password('old_password', ['class' => 'form-control']) !!}
                    </div-->
                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('new_password', 'New Password:', ['style' => 'display: block;']) !!}
                        {!! Form::password('new_password', ['class' => 'form-control']) !!}
                        <!--span style="cursor: pointer;" class="edit-this-text"><i class="fa fa-edit"></i></span-->
                    </div>
                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('confirm_password', 'Confirm Password:', ['style' => 'display: block;']) !!}
                        {!! Form::password('confirm_password', ['class' => 'form-control']) !!}
                        <!--span style="cursor: pointer;" class="edit-this-text"><i class="fa fa-edit"></i></span-->
                    </div>
                    <!-- Registration No Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>              
                {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('scripts')
<script>
    
</script>
@endsection


