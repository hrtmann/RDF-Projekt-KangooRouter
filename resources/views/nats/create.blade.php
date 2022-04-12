@extends('layouts.master')


@section('content')
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>

        @endif
        <div class="card card-primary">
            <form action ="{{route('nats.store')}}" method="post">
            @csrf
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{old('bezeichnung')}}" placeholder="Bezeichnung des NAT" class="form-control">
              </div>
              <button type="submit" name="NatSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
