@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error_kr'))
    <div class="alert alert-danger">
      <h6>Folgender Fehler ist aufgetreten:</h6>
      <ul>
      @foreach(session('error_kr') as $error)
        <li>
        {{$error}}
        </li>
      @endforeach
      </ul>
    </div>
    {{session()->forget('error_kr')}}
@endif
          @foreach($interfaces as $interface)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$interface->bezeichnung}}</strong></h4>
                <div class="card-tools">
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Status-->
                    @if($interface->end_status == 0)
                      <button type="button" class="btn" title="Status">
                        <i class="fas fa-check"></i>
                      </button>
                    @elseif($interface->end_status == -1)
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-question"></i>
                    </button>
                    @elseif($interface->end_status != 0)
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-exclamation"></i>
                    </button>
                    @endif
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('interfaces.index') . '/' . $interface->id . '/edit'}}'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="{{route('interfaces.destroy',$interface->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="{{$interface->id}}" class="toggle-class test" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" {{$interface->status ? 'checked' : ''}}>
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>Hardware-Schnitstelle:</strong> {{$hardwareinterfaces[$interface->id]['bezeichnung']}}<br>
                    <strong>IP-Adresse:</strong> {{$interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}<br>
                    <!--<strong>MAC-Adresse:</strong> {{$interface->macaddr}}<br>-->
                    <strong>VLAN-ID:</strong> {{$interface->vlan}}
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          @endforeach
          <!-- Script für Toggle -->
          <script>
          $(document).ajaxSend(function(event, jqxhr, settings){
              $.LoadingOverlay("show");
          });
          $(document).ajaxComplete(function(event, jqxhr, settings){
              //$.LoadingOverlay("hide");
              location.reload();
          });
          //Weitergabe an Route
            $(function() {
              $('.toggle-class').change(function() {
                $.LoadingOverlay("show");
                var status = $(this).prop('checked') == true ? 1 : 0;
                var interface_id = $(this).data('id');
                    $.ajax({
                      type: "GET",
                      dataType: "json",
                      url: '/changeStatusInterface',
                      data: {'status': status, 'interface_id': interface_id},
                      async: true,
                      cache: false,
                      success: function(data){
                        console.log('Success');
                      }
                    })
              });
          });
          </script>
@endsection
