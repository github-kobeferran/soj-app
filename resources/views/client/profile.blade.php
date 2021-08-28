@extends('layouts.app')

@section('content')

    <?php 
                
        $valid = false;

        if(
            !is_null($user_client->client->dob) ||
            !is_null($user_client->client->sex) ||
            !is_null($user_client->client->nationality) ||
            !is_null($user_client->client->address) ||
            !is_null($user_client->client->contact)
        ){
            $valid = true;
        }

    ?>

    <div class="container mt-2 mx-auto">

        @include('inc.messages')
      
        <div class="row">

            <div class="col-sm-5 border border-info rounded mx-2 py-2 px-4">

                <div class="text-center mx-auto">

                    <img src="{{url('storage/images/client/' . (is_null($user_client->client->image) ? 'no-image.png' : $user_client->client->image) )}}" alt="" style="max-height: 200px;" class="img-thumbnail mb-2 h-75">

                <h1 style="font-weight: 1000 !important;" class="material-text">{{$user_client->name}}</h1>                

                @if (!auth()->user()->isAdmin())
                    
                    @if ($valid)

                        <h4 class="text-muted material-text"> {{$user_client->client->address}}</h4>
                        <h4 class="text-muted material-text"> {{$user_client->client->contact}}</h4>
                        <button type="button" data-toggle="modal" data-target="#editProfileModal" class="text-center border-0 text-info"> <u>Click to edit Personal Information</u> </button>
                    @else
                        <button type="button" data-toggle="modal" data-target="#editProfileModal" class="text-center border-0 text-info"> <u>Click to edit Personal Information</u> </button>
                        
                    @endif
                
                

                    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="background-color: rgb(151, 199, 255)">
                              <h5 class="modal-title" id="exampleModalLongTitle" >Edit Profile</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            {!!Form::open(['url' => 'updateprofile', 'files' => true])!!}

                              
                            <div class="text-center mt-2 mx-auto">

                                <img src="{{url('storage/images/client/' . (is_null($user_client->client->image) ? 'no-image.png' : $user_client->client->image) )}}" alt="" style="max-height: 100px;"  class="img-thumbnail h-25">
                                

                            </div>

                            <div class="form-group text-center mx-auto">
                                
                                {{Form::file('image', ['class' => ''])}}

                            </div>

                            <div class="form-group text-left px-2">
                                <label for="">Name</label>
                                {{Form::text('name', $user_client->name, ['class' => 'form-control', 'required' => 'required'])}}
                            </div>

                            <div class="form-group text-left px-2">
                                <label for="">Date of Birth</label>
                                {{Form::date('dob', $user_client->client->dob, ['class' => 'form-control', 'required' => 'required'])}}
                            </div>

                            <div class="form-group text-left px-2">
                                <label for="">Sex</label>
                                {{Form::select('sex', [null => 'Select from options', '0' => 'Male', '1' => 'Female'], $user_client->client->sex, ['class' => 'form-control w-50', 'required' => 'required'])}}
                            </div>
                                                        
                            <div class="form-group text-left px-2">                                
                                <label for="">Nationality</label>
                                {{Form::select('nationality',[], $user_client->client->nationality, ['class' => 'selectpicker', 'id' => 'selectNationality', 'data-live-search' => 'true'])}}
                                <?php $nationality =  $user_client->client->nationality?>
                                <script> var nationality = {!! json_encode($nationality) !!}; </script>                                
                            </div>
                            
                            <div class="form-group text-left px-2">
                                <label for="">Address</label>
                                {{Form::text('address', $user_client->client->address, ['minlength' => '8', 'class' => 'form-control', 'required' => 'required'])}}
                            </div>

                            <div class="form-group text-left px-2">
                                <label for="">Contact</label>
                                {{Form::text('contact', $user_client->client->contact, [ 'minlength' => '8', 'maxlength' => '15', 'class' => 'form-control', 'required' => 'required'])}}
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            {!!Form::close()!!}
                          </div>
                        </div>
                      </div>
                    

                @else
                    
                    @if (!$valid)                        
                        <p>This user has not updated personal information yet.</p>
                    @endif

                @endif

                </div>
            
                
            </div>

            <div class="col-5 mx-1 border-bottom">

                <div>
                    <span class="material-text"><i class="fa fa-caret-left" aria-hidden="true"></i>  Balance: &#8369;{{number_format($user_client->client->balance->amount, 2) }}</span>
                </div>    
                
                @if ($user_client->client->checked_in == 1)

                    <div class="m-auto text-center bg-info p-2">
                        <h4 class="material-text text-white">Checked In</h4>
                    </div>
                    
                @else

                    <div class="m-auto text-center bg-warning p-2">
                        <h4 class="material-text">Not Checked In</h4>
                    </div>
                    
                @endif
               
                <?php 
                    $merchant_id =  config('app.paypalMerchantId', 'paypal-client-id-missing');
                    $num = $user_client->client->balance->amount;
                ?>
                

                @if ($user_client->id == auth()->user()->id)

                    <script src="https://www.paypal.com/sdk/js?client-id={{config('app.paypalClientId', 'paypal-client-id-missing')}}&currency=PHP"></script>                   

                    
                    <div class="text-left border-bottom border-warning p-2">

                        <div class="text-center mt-2">
                            <b class="material-text" style="font-size: 1rem !important;">Pay your balance with </b>
                        </div>

                        <div id="paypal-button-container"></div>

                    </div>

                    <script>

                        var merchant_id = {!! json_encode($merchant_id) !!}
                        var num = {!! json_encode($num) !!}

                                                                    

                        paypal.Buttons({
                                createOrder: function(data, actions) {
                                // This function sets up the details of the transaction, including the amount and line item details.                                                   
                                
                                return actions.order.create({
                                    style: {
                                        size : 'small'
                                    },
                                    purchase_units: [{                                                    
                                        amount: {
                                            value: num,
                                            currency_code: "PHP", 
                                            payee : merchant_id    
                                        }
                                    }]
                                    });

                                },
                                onApprove: function(data, actions) {

                                    // This function captures the funds from the transaction.
                                    return actions.order.capture().then(function(details) {
                                        // This function shows a transaction success message to your buyer.
                                        // alert('Transaction completed by ' + details.payer.name.given_name);
                                        // console.log(details);
                                        window.location.replace('/paybalance');
                                    
                                    });
                                },
                                onCancel: function(data){                            
                                                                                            

                                }
                            }).render('#paypal-button-container');
                            //This function displays Smart Payment Buttons on your web page.


                    </script>
                    
                @endif
                
            </div>
          

        </div>

        <div class="row my-3">

            <div class="col-md">

                <h2 class="material-text text-danger">Bookings History <i class="fa fa-history" aria-hidden="true"></i></h2>

                @if (count($user_client->client->transactions) > 0)

                    <hr>

                    <div class="table-responsive">

                        <table id="bookings" class="table table-bordered table-striped" style="width:100%">
                            <thead class="bg-danger text-white" style="font-family: 'Poppins', sans-serif !important; ">
                                <th>Booking ID</th>
                                <th>Room Type</th>
                                <th>From</th>
                                <th>Until</th>
                                <th>Cost</th>
                                <th>Status</th>                                
                            </thead>

                            <tbody>

                                @foreach ($user_client->client->bookings as $booking)                                
                                    
                                    <tr>

                                    <td>#{{$booking->booking_id}}</td>
                                    <td>{{\App\Models\RoomType::find(\App\Models\Room::find($booking->room_id)->room_type_id)->desc}}</td>
                                    <td>{{\Carbon\Carbon::parse($booking->start_date)->isoFormat('DD, MMM OY') }}</td>
                                    <td>{{\Carbon\Carbon::parse($booking->end_date)->isoFormat('DD, MMM OY') }}</td>
                                    <td>&#8369; {{number_format($booking->cost, 2)}}</td>

                                    @switch($booking->status)
                                        @case(1)
                                            <td>
                                                <button data-toggle="modal" data-target="#cancelModal" class="btn btn-warning">Pending</button>

                                                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModal" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header bg-warning text-dark">
                                                          <h5 class="modal-title" id="exampleModalLongTitle" >CANCEL BOOKING</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        {!!Form::open(['url' => '/cancelbook', 'files' => true])!!}
                            
                                                        {{Form::hidden('id', $booking->id)}}
                                                        <div class="px-2">

                                                            Are you <b>SURE</b> you want to <b>cancel</b> this <b>BOOKING</b>?

                                                        </div>
                            
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-warning">Yes</button>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                                                        </div>
                                                        {!!Form::close()!!}
                                                      </div>
                                                    </div>
                                                  </div>


                                            </td>
                                            @break
                                        @case(2)
                                            <td>Cheked in</td>
                                            @break
                                        @case(3)
                                            <td>Done</td>
                                            @break
                                        @case(4)
                                            <td>Cancelled</td>
                                            @break
                                        @default
                                            
                                    @endswitch

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>                        

                    </div>
                
                @else

                    <h5 class="mt-4 text-center align-middle">No transactions to show</h5>
                    
                    
                @endif

            </div>
            
        </div>

        <hr>

        <div class="row my-3">

            <div class="col-md">

                <h2 class="material-text">Transactions History <i class="fa fa-history" aria-hidden="true"></i></h2>

                @if (count($user_client->client->transactions) > 0)

                    <hr>

                    <div class="table-responsive">

                        <table id="transactions" class="table table-bordered table-striped" style="width:100%">
                            <thead class="bg-info text-white" style="font-family: 'Poppins', sans-serif !important; ">
                                <th>ID</th>
                                <th>Description</th>
                                <th>Amount (if payment)</th>
                                <th>Previous Balance</th>
                                <th>Remaining Balance</th>
                                <th>Done at</th>
                            </thead>

                            <tbody>

                                @foreach ($user_client->client->transactions as $trans)                                
                                    
                                    <tr>
                                        <td>{{$trans->trans_id}}</td>
                                        <td>{{$trans->desc}}</td>
                                        <td>&#8369; {{is_null($trans->amount) ? 'N\A' : number_format($trans->amount, 2)}}</td>
                                        <td>&#8369; {{number_format($trans->prev_bal, 2)}}</td>
                                        <td>&#8369; {{number_format($trans->rem_bal, 2)}}</td>
                                        <td>{{\Carbon\Carbon::parse($trans->created_at)->isoFormat('DD, MMM OY hh:mm A') }}</td>
                                    </tr>
                                    
                                @endforeach

                            </tbody>

                        </table>                        

                    </div>
                
                @else

                    <h5 class="mt-4 text-center align-middle">No transactions to show</h5>
                    
                    
                @endif

            </div>
            
        </div>

    </div>

<script>
    $(document).ready(function() {     
        $('#transactions').DataTable( {
            "order": [[ 5, "desc" ]]
        } );
        $('#bookings').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
        
    } );

    let selectNationality = document.getElementById('selectNationality');

    window.addEventListener('load', (event) => {
        
        let xhr = new XMLHttpRequest();

        xhr.open('GET', 'https://restcountries.eu/rest/v2/all', true);

        
        

        xhr.onload = function() {

            if (this.status == 200) {

                let countries = JSON.parse(this.responseText);                                                

                for(let i in countries){
                    if(nationality == countries[i].demonym){                        
                        selectNationality.options[i] = new Option(countries[i].demonym, countries[i].demonym, true, true);                                                        
                    }else{
                        selectNationality.options[i] = new Option(countries[i].demonym, countries[i].demonym);                                                        
                    }


                    $('.selectpicker').selectpicker('refresh');
                }                                

                
                                
            
            } 
        }    

        xhr.send();                 
        
    });

   
    

    


</script>  
    
@endsection