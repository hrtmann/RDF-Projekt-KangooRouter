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
          <div class="card-body" style="display: block;">
          <form action ="{{route('dhcp.show', 1)}}" method="post">
              @csrf
                <div class="form-group">
                <label for="interface_id">INTERFACE</label>
               <select id="interface_id" name="interface_id" value="" class="form-control custom-select">
                    @foreach($interfaces as $interface)
                        <option value="{{$interface['id']}}">{{$interface['bezeichnung']}} | IP: {{$interface['ipblock1']}}.{{$interface['ipblock2']}}.{{$interface['ipblock3']}}.{{$interface['ipblock4']}} | CIDR: {{$interface['subnetmask']}}</option>
                      @endforeach
                  </select>
                </div>
                <button type="submit" name="SubmitInterface" class="btn btn-primary">Interface auswählen</button>
            </form>
          </div>
          </div>
@endsection
