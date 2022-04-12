@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
          @foreach($fwrules as $fwrule)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$fwrule->bezeichnung}}</strong></h4>
                <div class="card-tools">
                  <!--Status-->
                  @if($fwrule->end_status == 0)
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-check"></i>
                    </button>
                  @elseif($fwrule->end_status == -1)
                  <button type="button" class="btn" title="Status">
                    <i class="fas fa-question"></i>
                  </button>
                  @elseif($fwrule->end_status != 0)
                  <button type="button" class="btn" title="Status">
                    <i class="fas fa-exclamation"></i>
                  </button>
                  @endif
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('firewallrules.index') . '/' . $fwrule->id . '/edit'}}'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="{{route('firewallrules.destroy',$fwrule->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="{{$fwrule->id}}" class="toggle-class loading-page" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" {{$fwrule->status ? 'checked' : ''}}>
                    </label>
                  </div>
                </div>
              </div>

                <div class="card-body">
                  <div class="row">
                  <div style="width: 40%;">
                    <div >
                        <strong>Port: </strong> {{$fwrule->port}};
                        <strong> PortEnd: </strong> {{$fwrule->port_end}}<br>
                        <strong>Protokoll: </strong>@if($fwrule->tcp == 1) TCP @else UDP @endif
                        <br>
                        <strong>Source: </strong>
                        <br>
                        <strong class="col-sm-6 col-sm-offset-3">Definitions: </strong><br>
                      <ul>
                        @foreach($setobjectssource->where('firewallrule_id', $fwrule->id)->whereNull('interface_id') as $source)
                        <li>{{$definitions->where('id', $source->definition_id)->first()->bezeichnung}}</li>
                        @endforeach
                      </ul>

                        <strong class="col-sm-6 col-sm-offset-3">Interfaces: </strong><br>
                      <ul>
                        @foreach($setobjectssource->where('firewallrule_id', $fwrule->id)->whereNull('definition_id') as $interface)
                        <li>{{$interfaces->where('id', $interface->interface_id)->first()->bezeichnung}}</li>
                        @endforeach
                      </ul>
                  </div>
                </div>

                <div style="width: 40%;">
                  <div >
                      <br><br>
                      <strong>Destination: </strong>
                      <br>
                      <strong class="col-sm-6 col-sm-offset-3">Definitions: </strong><br>
                      <ul>
                      @foreach($setobjectsdest->where('firewallrule_id', $fwrule->id)->whereNull('interface_id') as $source)
                      <li>{{$definitions->where('id', $source->definition_id)->first()->bezeichnung}}</li>
                      @endforeach
                    </ul>

                      <strong class="col-sm-6 col-sm-offset-3">Interfaces: </strong><br>
                    <ul>
                      @foreach($setobjectsdest->where('firewallrule_id', $fwrule->id)->whereNull('definition_id') as $interface)
                      <li>{{$interfaces->where('id', $interface->interface_id)->first()->bezeichnung}}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

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
                  var trigger = 1;
                  var status = $(this).prop('checked') == true ? 1 : 0;
                  var firewall_id = $(this).data('id');
                      $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '/changeStatusFirewall',
                        data: {'status': status, 'firewall_id': firewall_id},
                        async: true,
                        cache: false,
                        success: function(data){
                          console.log('Success');
                        }
                      })
                });
            });
            </script>
          @endforeach
@endsection
