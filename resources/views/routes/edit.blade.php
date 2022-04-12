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
            <form action ="{{route('routes.update', $route->id)}}" method="post">
            @csrf
            @method('PATCH')
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{$route->bezeichnung}}" placeholder="Bezeichnung der Route" class="form-control">
              </div>
              <div class="form-group">
                <label for="next_hop">Next-Hop</label>
                  <select class="form-control js-states"  id="next_hop" name="next_hop">
                    @foreach ($definitions as $definition)
                        @if($definition['id'] == $route->next_hop)
                        <option selected="selected" value="{{$definition['id']}}">{{$definition['bezeichnung']}}</option>
                        @else
                        <option value="{{$definition['id']}}">{{$definition['bezeichnung']}}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="definition_id">Ziel-Netzwerk</label>
                    <select class="form-control js-states"  id="target" name="target">
                      @foreach ($definitions as $definition)
                          @if($definition['id'] == $route->target)
                          <option selected="selected" value="{{$definition['id']}}">{{$definition['bezeichnung']}}</option>
                          @else
                          <option value="{{$definition['id']}}">{{$definition['bezeichnung']}}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>

                <!--Script für Dropdown mit Suche-->
                <script>
                      $(document).ready(function() { $("#definition_id").select2(); });
                </script>
                  <button type="submit" name="InterfaceEdit" class="btn btn-primary">Ändern</button>
              </div>
            </form>
          </div>
@endsection
