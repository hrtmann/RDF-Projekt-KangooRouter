@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
    @foreach($dhcp as $d)
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>{{$d->bezeichnung}}</strong></h4>
          <div class="card-tools">
            <!--btn-group um Icons nebeneinander zu haben-->
            <div class="btn-group">
              <!--Bearbeiten von Interfaces-->
              <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('dhcp.index') . '/' . $d->id . '/edit'}}'">
                <i class="fas fa-pen-square"></i>
              </button>
              <!-- Löschen von Interfaces-->
              <form action="{{route('dhcp.destroy',$d->id)}}" method="post">
                @csrf
                @method('DELETE')
                <!-- Abfrage ob Löschen gewollt -->
                <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
              </form>
              <!-- Toggle Box -->
                <label class="checkbox checkbox-toggle">
                <input data-id="{{$d->id}}" class="toggle-class test" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" {{$d->status ? 'checked' : ''}}>
              </label>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
          <div class="row">
            <div>
              <strong>Startbereich:</strong> {{$d->ipblock1Start}}.{{$d->ipblock2Start}}.{{$d->ipblock3Start}}.{{$d->ipblock4Start}}<br>
              <strong>Endbereich:</strong> {{$d->ipblock1End}}.{{$d->ipblock2End}}.{{$d->ipblock3End}}.{{$d->ipblock4End}}<br>
              <strong>DNS1:</strong> {{$d->dns1}}<br>
              <strong>DNS2:</strong> {{$d->dns2}}<br>
              <strong>Schnittstelle:</strong>
              @foreach($interfaces as $interface)
                @if($interface['id'] == $d->interface_id)
                  {{$interface['bezeichnung']}}<br>
                  <strong>Schnittstellen IP-Adresse:</strong> {{$interface['ipblock1'] . '.' . $interface['ipblock2']  . '.' . $interface['ipblock3']  . '.' . $interface['ipblock4']  . ' / ' . $interface['subnetmask'] }}<br>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
    @endforeach
    <!-- Script für Toggle -->
    <script>
    //Weitergabe an Route
      $(function() {
        $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var dhcp_id = $(this).data('id');
              $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatusDhcp',
                data: {'status': status, 'dhcp_id': dhcp_id},
                success: function(data){
                  console.log('Success')
                }
              })
        });
    });
    </script>
@endsection
