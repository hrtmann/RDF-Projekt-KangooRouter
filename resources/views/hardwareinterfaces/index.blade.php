@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
          @foreach($hardwareinterfaces as $hardwareinterface)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$hardwareinterface->bezeichnung}}</strong></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>MAC-Adresse:</strong> {{$hardwareinterface->macaddr}}<br>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          @endforeach
@endsection
