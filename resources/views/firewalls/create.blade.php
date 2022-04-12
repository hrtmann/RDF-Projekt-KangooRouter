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
            <form action ="{{route('firewallrules.store')}}" method="post">
            @csrf
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{old('bezeichnung')}}" placeholder="Bezeichnung der Regel" class="form-control">
              </div>

              <div class="form-group">
                <label for="list">Source</label>
                <select id="source" name="source[]" value="" multiple="multiple" class="form-control custom-select">
                  @foreach($definitions as $definition)
                      <option value="d{{$definition->id}}">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                  @endforeach
                  @foreach($interfaces as $interface)
                      <option value="i{{$interface->id}}">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                  @endforeach
                </select>
                <br>
              </div>
              <div class="form-group">
                <label for="port">Port</label>
                <input type="text" id="port" name="port" value="{{old('port')}}" placeholder="Port" class="form-control">
              </div>
              <label>Protokoll</label>
                <select class="form-control" name="tcp">
                    <option value="1" selected="selected">TCP</option>
                    <option value="0">UDP</option>
                </select>
              <br>
              <div class="form-group">
                <label for="list">Destination</label>
                <select id="destination" name="destination[]" value="" multiple="multiple" class="form-control custom-select">
                  @foreach($definitions as $definition)
                      <option value="d{{$definition->id}}">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                  @endforeach
                  @foreach($interfaces as $interface)
                      <option value="i{{$interface->id}}">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                  @endforeach
                </select>
              </div>
              <script>
              var source = $('#source').bootstrapDualListbox();
              var destination = $('#destination').bootstrapDualListbox();
              </script>

              <button type="submit" name="FirewallSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
