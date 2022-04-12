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
          <form action ="{{route('dhcp.update', $dhcp->id)}}" method="post">
          @csrf
          @method('PATCH')
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{$dhcp->bezeichnung}}" placeholder="Bezeichnung eintragen" class="form-control">
              </div>
              <div class="form-group">
                <label for="startRange">Startbereich</label>

                <div class="row">
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[0] == $ipexplodeEndRange[0])
          <!--          <fieldset disabled> -->
                      <input type="text" id="ipblock1Start" name="ipblock1Start" value="{{$dhcp->ipblock1Start}}" class="form-control" >
        <!--            </fildset> -->
                    @else
                      <input type="text" id="ipblock1Start" name="ipblock1Start" value="{{$dhcp->ipblock1Start}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[1] == $ipexplodeEndRange[1])
              <!--      <fieldset disabled> -->
                      <input type="text" id="ipblock2Start" name="ipblock2Start" value="{{$dhcp->ipblock2Start}}" placeholder="{{$ipexplodeStartRange['1']}}" class="form-control" >
                <!--    </fieldset> -->
                    @else
                      <input type="text" id="ipblock2Start" name="ipblock2Start" value="{{$dhcp->ipblock2Start}}" placeholder="Startbereich: Minimal {{$ipexplodeStartRange['1']}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[2] == $ipexplodeEndRange[2])
                  <!--  <fieldset disabled> -->
                      <input type="text" id="ipblock3Start" name="ipblock3Start" value="{{$dhcp->ipblock3Start}}" placeholder="{{$ipexplodeStartRange['2']}}" class="form-control" >
                <!--    </fieldset> -->
                    @else
                      <input type="text" id="ipblock3Start" name="ipblock3Start" value="{{$dhcp->ipblock3Start}}" placeholder="Startbereich: Minimal {{$ipexplodeStartRange['2']}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[3] == $ipexplodeEndRange[3])
        <!--            <fieldset disabled> -->
                      <input type="text" id="ipblock4Start" name="ipblock4Start" value="{{$dhcp->ipblock4Start}}" placeholder="{{$ipexplodeStartRange['3']}}" class="form-control" >
          <!--          </fieldset> -->
                    @else
                    <input type="text" id="ipblock4Start" name="ipblock4Start" value="{{$dhcp->ipblock4Start}}" placeholder="Startbereich: Minimal {{$ipexplodeStartRange['3']}}" class="form-control" >
                    @endif
                  </div>
                </div>

              </div>

              <div class="form-group">
                <label for="endRange">Endbereich</label>

                <div class="row">
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[0] == $ipexplodeEndRange[0])
            <!--        <fieldset disabled> -->
                      <input type="text" id="ipblock1End" name="ipblock1End" value="{{$dhcp->ipblock1End}}" class="form-control" >
            <!--        </fildset> -->
                    @else
                      <input type="text" id="ipblock1End" name="ipblock1End" value="{{$dhcp->ipblock1End}}" placeholder="Endbereich: Maximal {{$ipexplodeEndRange['0']}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[1] == $ipexplodeEndRange[1])
          <!--          <fieldset disabled>   -->
                      <input type="text" id="ipblock2End" name="ipblock2End" value="{{$dhcp->ipblock2End}}" placeholder="{{$ipexplodeEndRange['1']}}" class="form-control" >
            <!--        </fieldset> -->
                    @else
                      <input type="text" id="ipblock2End" name="ipblock2End" value="{{$dhcp->ipblock2End}}" placeholder="Endbereich: Maximal {{$ipexplodeEndRange['1']}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[2] == $ipexplodeEndRange[2])
              <!--      <fieldset disabled>   -->
                      <input type="text" id="ipblock3End" name="ipblock3End" value="{{$dhcp->ipblock3End}}" placeholder="{{$ipexplodeEndRange['2']}}" class="form-control" >
              <!--      </fieldset>  -->
                    @else
                      <input type="text" id="ipblock3End" name="ipblock3End" value="{{$dhcp->ipblock3End}}" placeholder="Endbereich: Maximal {{$ipexplodeEndRange['2']}}" class="form-control" >
                    @endif
                  </div>
                  <div class="col-md-3">
                    @if($ipexplodeStartRange[3] == $ipexplodeEndRange[3])
              <!--      <fieldset disabled>  -->
                      <input type="text" id="ipblock4End" name="ipblock4End" value="{{$ipexplodeEndRange['3']}}" placeholder="{{$ipexplodeEndRange['3']}}" class="form-control" >
              <!--      </fieldset>  -->
                    @else
                    <input type="text" id="ipblock4End" name="ipblock4End" value="{{$dhcp->ipblock4End}}" placeholder="Endbereich: Maximal {{$ipexplodeEndRange['3']}}" class="form-control" >
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="dns1">DNS1</label>
                <input type="text" id="dns1" name="dns1" value="{{$dhcp->dns1}}" placeholder="DNS1 eintragen" class="form-control">
              </div>
              <div class="form-group">
                <label for="dns2">DNS2</label>
                <input type="text" id="dns2" name="dns2" value="{{$dhcp->dns2}}" placeholder="DNS2 eintragen" class="form-control">
              </div>
                <div class="form-group">
                  <label for="interface_id">INTERFACE</label>
                  <select id="interface_id" name="interface_id" value="{{$dhcp->interface_id}}" class="form-control custom-select">
                    @foreach($interfaces as $interface)
                      @if($interface['id'] == $dhcp->interface_id)
                        <option selected="selected" value="{{$interface['id']}}">{{$interface['bezeichnung']}} | IP: {{$interface['ipblock1']}}.{{$interface['ipblock2']}}.{{$interface['ipblock3']}}.{{$interface['ipblock4']}} | CIDR: {{$interface['subnetmask']}}</option>
                      @else
                        <option value="{{$interface['id']}}">{{$interface['bezeichnung']}} | IP: {{$interface['ipblock1']}}.{{$interface['ipblock2']}}.{{$interface['ipblock3']}}.{{$interface['ipblock4']}} | CIDR: {{$interface['subnetmask']}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                  <button type="submit" name="DhcpEdit" class="btn btn-primary">Ändern</button>
              </div>

            </form>
          </div>
@endsection
