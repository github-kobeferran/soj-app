@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="ml-2 border-bottom">CLIENTS</h3>

    <div class="row my-2">

       <div class="col">

            @if (\App\Models\User::where('user_type', 0)->count() > 0 )

                <div class="table-responsive">

                    <table id="clients" class="table table-responsive">

                        <thead class="bg-info text-white">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Sex</th>
                                <th >Date Of Birth (age)</th>
                                <th>Nationality</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Last Checked In</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach (\App\Models\Client::all() as $client)

                                @if ($client->user->user_type == 1)

                                    @continue
                                    
                                @endif

                                <tr>                                    
                                    <td><a class="text-dark" href="{{url('/profile/' . $client->user->email)}}"><b>{{$client->user->name}}</b></a></td>
                                    <td>{{$client->user->email}}</td>

                                    @if (!is_null($client->sex))
                                        <td>{{$client->sex == 0 ? 'Male' : 'Female'}}</td>
                                    @else                                    
                                        <td></td>
                                    @endif
                                    
                                    @if (!is_null($client->dob))
                                        <td>{{\Carbon\Carbon::parse($client->dob)->isoFormat('MMM DD, OY') . ' (' . \Carbon\Carbon::parse($client->dob)->age . ' years)'}}</td>
                                    @else                                    
                                        <td></td>
                                    @endif

                                    @if (!is_null($client->nationality))
                                        <td>{{$client->nationality}}</td>
                                    @else                                    
                                        <td></td>
                                    @endif

                                    @if (!is_null($client->address))
                                        <td>{{$client->address}}</td>
                                    @else                                    
                                        <td></td>
                                    @endif

                                    @if (!is_null($client->contact))
                                        <td>{{$client->contact}}</td>   
                                    @else                                    
                                        <td></td>
                                    @endif

                                    @if (!is_null($client->image))
                                        <td><button data-toggle="modal" data-target="#client-image-{{$client->id}}" class="btn btn-light border-0 text-info">View Image</button></td>   

                                        <div class="modal fade" id="client-image-{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">{{ucfirst($client->user->name)}}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>

                                                <img src="{{url('storage/images/client/' . $client->image)}}" alt="" class="img-thumbnail bg-dark mx-auto p-0 ">
                                                
                                              </div>
                                            </div>
                                          </div>
                                    @else                                    
                                        <td></td>
                                    @endif

                                    <td>{{$client->checked_in == 0 ? "Not Checked in" : "Checked in"}}</td>

                                    @if (!is_null($client->image))
                                        <td>{{\Carbon\Carbon::parse($client->last_checked_in)->diffForHumans() }}</td>
                                    @else                                    
                                        <td>Never been</td>
                                    @endif
                                    
                                </tr>
                                
                            @endforeach

                        </tbody>

                    </table>

                </div>
            
            @else
                
                <h6 class="mx-auto">No Clients so far..</h6>
        
            @endif

       </div>

    </div>




</div>

<script>
$(document).ready(function() {
    $('#clients').DataTable();      
});

</script>
    
@endsection