@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Advertisement Clients
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($advertisementClients, ['route' => ['advertisementClients.update', $advertisementClients->id], 'method' => 'patch']) !!}

                        @include('advertisement_clients.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection