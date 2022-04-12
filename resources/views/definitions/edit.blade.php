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
            <form action ="{{route('definitions.update', $definition->id)}}" method="post">
            @csrf
            @method('PATCH')
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{$definition->bezeichnung}}" placeholder="Bezeichnung der Definition" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                @php
                  $ipoutput = $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4;
                @endphp
                <input type="text" id="IP" name="IP" value="{{$ipoutput}}" placeholder="IP-Adresse der Definition" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Subnetzmaske</label>
                  <select id="subnetmask" name="subnetmask" value="{{$definition->subnetmask}}" class="form-control custom-select">
                    @for ($i = 8; $i < 33; $i++)
                      @if ($i != 31)
                        <!-- Ausgewähle CIDR anzeigen-->
                        @if ($i == $definition->subnetmask)
                        <option selected>{{$definition->subnetmask}}</option>
                        @else
                        <option>{{$i}}</option>
                        @endif
                      @endif
                    @endfor
                  </select>
                </div>
              <button type="submit" name="InterfaceEdit" class="btn btn-primary">Ändern</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
