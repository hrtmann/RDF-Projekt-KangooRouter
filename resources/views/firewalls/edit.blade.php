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
            <form action ="{{route('firewallrules.update', $fwrule->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{$fwrule->bezeichnung}}" placeholder="Bezeichnung der Regel" class="form-control">
              </div>
              <div class="form-group">
                <label for="list">Source</label>
                <select id="source" name="source[]" value="" multiple="multiple" class="form-control custom-select">
                  @foreach($definitions as $definition)
                    @if($setobjectssource->where('definition_id', $definition->id)->count() > 0)
                      <option value="d{{$definition->id}}" selected="selected">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                    @else
                      <option value="d{{$definition->id}}">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                    @endif
                  @endforeach
                  @foreach($interfaces as $interface)
                    @if($setobjectssource->where('interface_id', $interface->id)->count() > 0)
                      <option value="i{{$interface->id}}" selected="selected">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                    @else
                      <option value="i{{$interface->id}}">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="port">Port</label>
                @if(empty($fwrule->port_end))
                  <input type="text" id="port" name="port" value="{{$fwrule->port}}" placeholder="Port" class="form-control">
                @else
                  <input type="text" id="port" name="port" value="{{$fwrule->port}}-{{$fwrule->port_end}}" placeholder="Port" class="form-control">
                @endif
              </div>

              <label>Protokoll</label>
                <select class="form-control" name="tcp">
                  @if($fwrule->tcp == 1)
                    <option value="1" selected="selected">TCP</option>
                    <option value="0">UDP</option>
                  @endif
                  @if($fwrule->tcp == 0)
                    <option value="1">TCP</option>
                    <option value="0" selected="selected">UDP</option>
                  @endif
                </select>
              <br>
              <div class="form-group">
                <label for="list">Destination</label>
                <select id="destination" name="destination[]" value="" multiple="multiple" class="form-control custom-select">
                  @foreach($definitions as $definition)
                    @if($setobjectsdest->where('definition_id', $definition->id)->count() > 0)
                      <option value="d{{$definition->id}}" selected="selected">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                    @else
                      <option value="d{{$definition->id}}">DEF. {{$definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}</option>
                    @endif
                  @endforeach
                  @foreach($interfaces as $interface)
                    @if($setobjectsdest->where('interface_id', $interface->id)->count() > 0)
                      <option value="i{{$interface->id}}" selected="selected">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                    @else
                      <option value="i{{$interface->id}}">INT. {{$interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <script>
              var source = $('#source').bootstrapDualListbox();
              var destination = $('#destination').bootstrapDualListbox();
              </script>
              <button type="submit" name="FirewallEdit" class="btn btn-primary">Ändern</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
