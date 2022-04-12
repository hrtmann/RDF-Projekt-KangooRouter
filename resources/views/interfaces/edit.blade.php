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
            <form action ="{{route('interfaces.update', $interface->id)}}" method="post">
            @csrf
            @method('PATCH')
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{$interface->bezeichnung}}" placeholder="Bezeichnung der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                @php
                  $ipoutput = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4;
                @endphp
                <input type="text" id="IP" name="IP" value="{{$ipoutput}}" placeholder="IP-Adresse der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Subnetzmaske</label>
                  <select id="subnetmask" name="subnetmask" value="{{$interface->subnetmask}}" class="form-control custom-select">
                    @for ($i = 8; $i < 33; $i++)
                      @if ($i != 31)
                        @if($i == $interface->subnetmask)
                          <option selected="selected" value="{{$i}}">{{$i}}</option>
                        @else
                          <option value="{{$i}}">{{$i}}</option>
                        @endif
                      @endif
                    @endfor
                  </select>
                </div>
              <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" id="vlan" name="vlan" value="{{$interface->vlan}}" placeholder="VLAN der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="hardwareinterface_id">Hardwareschnittstelle</label>
                  <select id="hardwareinterface_id" name="hardwareinterface_id" class="form-control custom-select">
                    @foreach($hardwareinterfaces as $hardwareinterface)
                      @if($hardwareinterface['id'] == $interface->hardwareinterface_id)
                        <option selected="selected" value="{{$hardwareinterface['id']}}">{{$hardwareinterface['bezeichnung']}}</option>
                      @else
                        <option value="{{$hardwareinterface['id']}}">{{$hardwareinterface['bezeichnung']}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              <button type="submit" name="InterfaceEdit" class="btn btn-primary">Ändern</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
