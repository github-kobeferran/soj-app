@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row" style=" border-bottom: 2px solid rgb(102, 99, 99);">

        <div class="col">
            <h2 class="ml-2" style="font-family: 'Poppins', sans-serif !important;">ADMIN DASHBOARD</h2>
        </div>
        <div class="col text-right">

            <a href="/clients" class="btn btn-info border border-primary my-1 mx-2">CLIENTS 
                <span class="badge badge-light">
                    {{\App\Models\User::where('user_type', 0)->count() }}
                </span>
            </a>

            <a href="/rooms#rooms" class="btn btn-success border border-primary  my-1 mx-2">Rooms Available 
                <span class="badge badge-light">
                    {{\App\Models\Room::where('status', 0)->count() }}
                </span>
            </a>

            <a href="/rooms#rooms" class="btn btn-danger border border-primary  my-1 mx-2">Rooms Occupied 
                <span class="badge badge-light">
                    {{\App\Models\Room::where('status', 1)->count() }}
                </span>
            </a>

        </div>

    </div>


    <div class="row my-2">

        <div class="col-8">
            
            <h4 class="" style="color: rgb(156, 42, 0) !important;">CURRENT AND PENDING BOOKINGS</h4>
        </div>

        <div class="col-4">

            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-caret-left" aria-hidden="true"></i></span>
                </div>
                <button id="buttonToggler" type="button" onclick="toggleBookingHistoryPanel()" class="btn btn-sm btn-warning float-right">See Bookings History</button>            
            </div>        
            
            
        </div>  
                     

        <div  id="bookingHistoryPanel" class="table-responsive d-none">

            @if (!is_null(\App\Models\Booking::where('status', 3)->orWhere('status', 4)->first()))

                <table id="bookingrecords" class="table table-bordered">

                    <thead class="bg-secondary text-white">
                        <tr>

                            <th>Booking #</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Client</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Cost</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach (\App\Models\Booking::where('status', 3)->orWhere('status', 4)->get() as $booking)

                        <tr>
                            <th>#{{$booking->booking_id}}</th>
                            <td>{{\Carbon\Carbon::parse($booking->start_date)->isoFormat('Do ddd, MMM Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($booking->end_date)->isoFormat('Do ddd, MMM Y')}}</td>
                            <td><a href="{{url('/profile/'. $booking->client->user->email)}}">{{$booking->client->user->name}}</a></td>
                            <td>{{strtoupper(\App\Models\Room::find($booking->room_id)->name)}}</td>
                            <td>{{$booking->status == 3 ? 'Done' : 'Cancelled'}}</td>
                            <td>&#8369;{{number_format($booking->cost, 2)}}</td>
                        </tr>
                            
                        @endforeach

                    </tbody>

                </table>
                
            @else

            <h3 class="mx-auto">Nothing Done Booking Records so far..</h3>
                
            @endif

        </div>

        
        
    </div>



    @if (!is_null(\App\Models\Booking::where('start_date', '>=', \Carbon\Carbon::now())->orWhere('end_date', '>=', \Carbon\Carbon::now())->where('status', '<', 3)->first()))

        <div class="table-responsive">

            <table id="bookings" class="table table-bordered">

                <thead style="background: rgb(156, 42, 0) !important; color: white !important;">
                    <tr>
                        <th>Booking #</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Client</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Booking::where('start_date', '>=', \Carbon\Carbon::now())
                                                ->orWhere('end_date', '>=', \Carbon\Carbon::now())
                                                ->where('status', '<', 3)
                                                ->orderBy('status', 'desc')
                                                ->get() as $booking)

                            <tr>
                                <th>#{{$booking->booking_id}}</th>
                                <td>{{\Carbon\Carbon::parse($booking->start_date)->isoFormat('Do ddd, MMM Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($booking->end_date)->isoFormat('Do ddd, MMM Y')}}</td>
                                <td><a href="{{url('/profile/'. $booking->client->user->email)}}">{{$booking->client->user->name}}</a></td>
                                <td>{{strtoupper(\App\Models\Room::find($booking->room_id)->name)}}</td>
                                <td>{{$booking->status == 1 ? 'Pending' : 'Checked in'}}</td>
                                <td>&#8369;{{number_format($booking->cost, 2)}}</td>

                                @if ($booking->status == 1)
                                    <td><button type="button" data-toggle="modal" data-target="#checkin" class="btn-warning text-success">CHECK IN</button></td>
                                    <div class="modal fade" id="checkin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
    
                                                <div class="modal-header bg-warning text-dark">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Check In Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!!Form::open(['url' => '/checkin'])!!}
    
                                                {{Form::hidden('id', $booking->id)}}
    
                                                <div class="modal-body text-center">
                                                    Check <b>{{$booking->client->user->name}} </b>in?
                                                </div>
    
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning text-white">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                {!!Form::close()!!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <td><button type="button" data-toggle="modal" data-target="#checkout" class="btn-primary text-white">CHECK OUT</button></td>
                                    <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
    
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Check Out Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!!Form::open(['url' => '/bookdone'])!!}
    
                                                {{Form::hidden('id', $booking->id)}}
    
                                                <div class="modal-body text-center">
                                                    Check <b>{{$booking->client->user->name}} </b>out?
                                                    @if ($booking->client->balance->amount > 0)
                                                        @switch($booking->client->sex)
                                                            @case(0)
                                                                He still has &#8369; <b>{{number_format($booking->client->balance->amount, 2)}}</b> balance.
                                                                @break
                                                            @case(1)
                                                                She still has &#8369; <b>{{number_format($booking->client->balance->amount, 2)}}</b> balance.
                                                                @break
                                                            @default
                                                                
                                                        @endswitch
                                                    @endif

                                                </div>
    
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary text-white">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                {!!Form::close()!!}
                                            </div>
                                        </div>
                                    </div>
                                @endif                                                                

                            </tr>
                        
                    @endforeach
                </tbody>
            </table>

        </div>
        
    @else

    <div class="text-center">

        <hr>

        <h3 id="nobookingtoday" class="mx-auto material-text my-auto">No Bookings Today <i class="fa fa-smile" aria-hidden="true"></i></h3>

    </div>
        
    @endif

</div>

<script>

$(document).ready(function() {
    $('#bookings').DataTable();        
    $('#bookingrecords').DataTable();        

    $('.selectpicker').selectpicker('refresh');
});

let bookingHistoryPanel = document.getElementById('bookingHistoryPanel');
let buttonToggler = document.getElementById('buttonToggler');

function toggleBookingHistoryPanel(){

    if(bookingHistoryPanel.classList.contains('d-none')){          

        bookingHistoryPanel.classList.remove('d-none');        
        buttonToggler.textContent = "Hide Bookings History";

    } else {

        bookingHistoryPanel.classList.add('d-none');
        buttonToggler.textContent = "See Bookings History";

    }

}

</script>
    
@endsection