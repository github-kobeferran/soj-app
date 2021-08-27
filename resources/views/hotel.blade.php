@extends('layouts.app')

@section('content')

    <div id="hotel" class="container">

        <div class="row my-2">            

            <div class="col-lg">
               
                <h1 style="color:rgb(156, 42, 0) !important; " class="mb-0">HOTEL</h1>   

                
                
                <h1 class="material-text">CHECK ROOM AVAILABILITY <i class="fa fa-search" aria-hidden="true"></i></h1>                


                {!!Form::open(['url' => '/bookroom'])!!}

                <div class="d-flex justify-content-xl-around flex-wrap">

                    <div class="p-2 mx-auto">

                        <div class="form-inline">
                            <span class="mr-2">from </span>
                            {{Form::date('start_date', \Carbon\Carbon::tomorrow(), ['class' => 'form-control', 'id' => 'startDate'])}}
                        </div>
                        
                    </div>

                    <div class="p-2 mx-auto">

                        <div class="form-inline">
                            <span class="mr-2">until</span>
                            {{Form::date('end_date', \Carbon\Carbon::tomorrow()->addDay(), ['class' => 'form-control', 'id' => 'endDate'])}}
                        </div>

                    </div>

                    <?php                     
                        $room_types_list = \App\Models\RoomType::orderBy('desc', 'asc')->pluck('desc', 'id');                    
                    ?>

                    <div class="p-2 mx-auto">
                        {{Form::select('room_type', $room_types_list , null, ['title' => 'Select Room Type', 'class' => 'border border-secondary rounded selectpicker', 'id' => 'selectRoomType', 'data-live-search' => 'true'])}}
                    </div>                    

                    <div id="inputQuantityPanel" class="p-2 mx-auto d-none">
                        <div class="form-inline">                            
                            <span class="mr-2">Room/s </span>
                            {{Form::number('quantity', 1, ['id' => 'inputQuantity', 'placeholder' => 'Input Number of Rooms', 'class' => 'form-control text-center'])}}                        
                            <span class="ml-2 text-danger" id="noOfRoomsAvailableDisplay"></span>
                        </div>                                            
                    </div>          

                    <div id="noAvailableRoomsDisplay" class="p-2 mx-auto d-none">                                            
                        <h1 class="material-text"></h1>
                    </div>                   

                </div>
               
                

                {!!Form::close()!!}                

            </div>

            <div id="spinner" class="spinner-border text-primary p-2 mx-auto d-none" role="status">
                    <span class="sr-only">Loading...</span>
            </div>

        </div>

        <hr>               

        <div class="row d-none" id="book-panel">

            <div class="col-lg">

                <div class="d-flex border border-dark justify-content-center">

                    <h1 id="roomQuantityDisplay" class="material-text py-2 mx-auto">
                        1 
                    </h1>
                    <h1 id="roomTypeDisplay" class="material-text py-2 mx-auto">
                        Deluxe Room
                    </h1>
                    <h1 id="bookCostDisplay" class="material-text py-2 mx-auto">
                        Cost: &#8369; 3223.23 / night
                    </h1>

                </div>

                @guest

                    <a href="{{url('/login')}}" class="btn btn-lg btn-primary btn-block my-2 rounded-0">

                        BOOK NOW   <i class="fa fa-check" aria-hidden="true"></i>

                    </a>

                @else                

                        @if (!auth()->user()->hasVerifiedEmail())

                        <a href="{{url('/email/verify')}}" class="btn btn-lg btn-primary btn-block my-2 rounded-0">

                            BOOK NOW   <i class="fa fa-check" aria-hidden="true"></i>

                        </a>

                        @else

                            @if (is_null(auth()->user()->client->dob) ||
                                is_null(auth()->user()->client->sex) ||
                                is_null(auth()->user()->client->nationality) ||
                                is_null(auth()->user()->client->address) ||
                                is_null(auth()->user()->client->contact))

                                <button type="button" data-toggle="modal" data-target="#updatefirst" class="btn btn-lg btn-primary btn-block my-2 rounded-0">

                                    BOOK NOW   <i class="fa fa-check" aria-hidden="true"></i>

                                </button>

                                <div class="modal fade" id="updatefirst" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Not Valid</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          Update your Personal Information First
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                
                            @else

                            {{-- GOOD TO GO --}}

                            <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-lg btn-primary btn-block my-2 rounded-0">

                                BOOK NOW   <i class="fa fa-check" aria-hidden="true"></i>

                            </button>                            

                           

                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Pay with Paypal</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span class="text-white" aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    
                                    <script src="https://www.paypal.com/sdk/js?client-id=AWBgp7a7-6O-34_L_E-2Xr105AGhWyQFW0vtL8C3xjxo8UxNqXWNMHugnv53bjiiy41VBDXZZo3VLL8S&currency=PHP"></script>                            

                                    <div class="form-group p-2">                                            
                                            <h5 class="text-muted">Policy of 50% and above advanced payment, no cancellation refund</h5>
                                            <h2>Enter Amount to Pay</h2>                                    
                                            {{-- {{Form::hidden('amountToPay', 1, ['id' => 'amountToPay'] )}} --}}
                                        <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">&#8369;</span>
                                                </div>
                                                {{Form::number('amount', '', ['step' => '50','id' => 'inputAmount', 'min' => '1', 'class' => 'form-control', 'required' => 'required'])}}
                                                {{Form::hidden('hidden', '', ['id' => 'hiddenAmount'])}}
                                        </div>
                                    </div>

                                    <div id="paypal-button-container"></div>

                                    <script>                                        

                                        document.getElementById('inputAmount').addEventListener('input', () => {
                                            render(Number(document.getElementById('inputAmount').value).toFixed(2));
                                        });                                        
                                                                                                                                                                                          
                                        function render(num){

                                            

                                            document.getElementById('paypal-button-container').innerHTML = '<div id="paypal-button-container"></div>';

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
                                                                payee : '5MKSZNVBRXX9S'     
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
                                                            window.location.replace('/storebooking/' + details.email_address + '/' + details.purchase_units[0].amount.value + '/' + selectRoomType.value + '/' + startInputDate.value + '/' + endInputDate.value + '/' + inputQuantity.value + '/' + document.getElementById('hiddenAmount').value);
                                                        
                                                        });
                                                    },
                                                    onCancel: function(data){                            
                                                                                                                

                                                    }
                                                }).render('#paypal-button-container');
                                                //This function displays Smart Payment Buttons on your web page.

                                            }

                                    </script>
                                  

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>                                      
                                    </div>
                                  </div>
                                </div>
                              </div>
                                
                            @endif

                           

                        @endif

                @endguest

                <button type="button" onclick="cancelBook()" id="cancelButton" class="btn btn-secondary btn-block rounded-0">Cancel</button>
               
            </div>

        </div>

        <div id="paypal-button-container"></div>

       @if (!is_null(\App\Models\RoomType::first()))

            <div class="text-center">

                <h4 class="material text" style="color:rgb(156, 42, 0) !important; ">ROOM TYPES</h4>

            </div>

            <div class="row d-flex flex-wrap">


                @foreach (\App\Models\RoomType::all() as $room_type)

                    <div class="border text-center mx-auto my-2 p-2" style="background-color: rgba(82, 53, 27, 0.295) !important;">
                        
                        <img data-enlargeable style="max-height: 300px; max-width:300px; cursor: zoom-in;" src="{{url('storage/images/room_types/' . $room_type->images)}}" alt="" class="img-thumbnail border border-secondary">

                        <h2 class="material text" style="color:rgb(153, 153, 153) !important;">{{strtoupper($room_type->desc)}}</h2>
                        <h5 class="material text">&#8369;{{number_format($room_type->rate, 2)}}/night</h5>   
                        
                        @if (!empty($room_type->persons_fit))

                            @foreach ($room_type->beds_attr as $bed)
                                <h6 class="material text" style="font-family: 'Allison', cursive !important; font-size: 2rem !important;">{{ucfirst($bed->desc)}}</h6>   
                            @endforeach   
                            
                            <h6 class="material text">for {{$room_type->persons_fit}} Adults</h6>   
                            
                        @endif

                        @foreach ($room_type->features() as $feature)
                            
                            <div class="text-center">
                                <span class="text-muted"><i class="fa fa-circle text-dark align-middle" style="font-size: .4rem;" aria-hidden="true"></i> {{$feature->desc}}</span>
                            </div>

                        @endforeach
                        

                    </div>                                        
                    
                @endforeach
                         

            </div>
           
       @else

            <h4 class="mx-auto">Nothing to see here..</h4>
           
       @endif

    </div>      
    
<script>

let startInputDate = document.getElementById('startDate');
let endInputDate = document.getElementById('endDate');
let selectRoomType = document.getElementById('selectRoomType');
let inputQuantityPanel = document.getElementById('inputQuantityPanel');
let inputQuantity = document.getElementById('inputQuantity');
let bookPanel = document.getElementById('book-panel');
let noAvailableRoomsDisplay = document.getElementById('noAvailableRoomsDisplay');
let noOfRoomsAvailableDisplay = document.getElementById('noOfRoomsAvailableDisplay');
let spinner = document.getElementById('spinner');

let roomQuantityDisplay = document.getElementById('roomQuantityDisplay');
let roomTypeDisplay = document.getElementById('roomTypeDisplay');
let bookCostDisplay = document.getElementById('bookCostDisplay');
let inputAmount = document.getElementById('inputAmount');
let hiddenAmount = document.getElementById('hiddenAmount');
let cancelButton = document.getElementById('cancelButton');

$("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});

$("[type='number']").on("cut copy paste",function(e) {
      e.preventDefault();
});


selectRoomType.addEventListener('change', () => {
    getAvailableRooms();
   
});

startInputDate.addEventListener('input', () => {
    if(selectRoomType.value == null || selectRoomType.value == '' || selectRoomType.value == 'undefined')
        alert('Select a Room Type first');
    else
        getAvailableRooms();
});

endInputDate.addEventListener('input', () => {
    if(selectRoomType.value == null || selectRoomType.value == '' || selectRoomType.value == 'undefined')
        alert('Select a Room Type first');
    else
        getAvailableRooms();
});

inputQuantity.addEventListener('input', () => {
        changeBookingPanel()
});


function getAvailableRooms(){

    noAvailableRoomsDisplay.classList.add('d-none');
    inputQuantityPanel.classList.add('d-none');

    let xhr = new XMLHttpRequest();

    let startDate = startInputDate.value;
    let endDate = endInputDate.value;
    let roomType = selectRoomType.value;
    

    xhr.open('GET', APP_URL + '/availablerooms/' + startDate + '/' + endDate + '/' + roomType , true);

    spinner.classList.remove('d-none');

    xhr.onload = function() {
        if (this.status == 200) { 

            try {
                let rooms =  JSON.parse(this.responseText);

                spinner.classList.add('d-none');

                if(rooms.length > 0){                    
                    
                    inputQuantityPanel.classList.remove('d-none');
                    inputQuantity.min = 1; 
                    inputQuantity.min = 1; 
                    inputQuantity.max = rooms.length;                               
                    
                    if(rooms.length > 1)
                        noOfRoomsAvailableDisplay.textContent = 'only ' + rooms.length + ' rooms available for ' + rooms[0].room_type.desc;
                    else
                        noOfRoomsAvailableDisplay.textContent = 'only ' + rooms.length + ' room available for ' + rooms[0].room_type.desc;                        
                        
                    changeBookingPanel();

                } else {

                    noAvailableRoomsDisplay.classList.remove('d-none');
                    noAvailableRoomsDisplay.textContent = 'Sorry No Available Rooms for that Room Type and date range';
                    noAvailableRoomsDisplay.style.color = 'red';
                    changeBookingPanel(true);

                }

    
            } catch (error) {
                spinner.classList.add('d-none');

                noAvailableRoomsDisplay.classList.remove('d-none');
                noAvailableRoomsDisplay.textContent = 'Sorry No Available Rooms for that Room Type and date range';
                noAvailableRoomsDisplay.style.color = 'red';
                                

            }                       

        } 
        
    }

    xhr.send(); 

}

function changeBookingPanel(error = false){

    if(error){
        bookPanel.classList.add('d-none');
    } else {
        bookPanel.classList.remove('d-none');

        let xhr = new XMLHttpRequest();

        let startDate = startInputDate.value;
        let endDate = endInputDate.value;
        let roomType = selectRoomType.value;
        let quantity = inputQuantity.value;


        xhr.open('GET', APP_URL + '/computebook/' + quantity + '/' + startDate + '/' + endDate + '/' + roomType , true);

        xhr.onload = function() {
            if (this.status == 200) { 

                try {

                    let details = JSON.parse(this.responseText);

                    var formatter = new Intl.NumberFormat('en-US', 
                    {
                        style: 'currency',
                        currency: 'PHP',                        
                    });

                    cost = Number(details.cost).toFixed(2);                    

                   

                   

                    roomQuantityDisplay.textContent = details.quantity;
                    roomTypeDisplay.textContent = details.room_type_desc;
                    bookCostDisplay.textContent = cost;

                    if (typeof hiddenAmount !== 'undefined') {
                        render(cost);

                        inputAmount.min = cost / 2;
                        inputAmount.value = cost;
                        inputAmount.max = cost;
                        hiddenAmount.value = cost;
                    }

                    

                    let nights = '';

                    if(details.days > 1)
                        nights = 'night';
                    else
                        nights = 'night';

                    bookCostDisplay.textContent = 'Cost: ' + formatter.format(details.cost) + ' / ' + details.days + ' ' + nights;
                                     
                
                } catch (error) {
                    console.log(error);
                    
                }                       

            } 
            
        }

        xhr.send(); 


    }

}

function cancelBook() {

    bookPanel.classList.add('d-none');
    inputQuantityPanel.classList.add('d-none');

    selectRoomType.value = null;    

    var date = new Date();

    
    startInputDate.valueAsDate = date.setDate(date.getDate() + 1);
    endInputDate.valueAsDate = date.setDate(date.getDate() + 2);

}


$('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
    var src = $(this).attr('src');
    var modal;

    function removeModal() {
        modal.remove();
        $('body').off('keyup.modal-close');
    }
    modal = $('<div>').css({
        background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
        backgroundSize: 'contain',
        width: '100%',
        height: '100%',
        position: 'fixed',
        zIndex: '10000',
        top: '0',
        left: '0',
        cursor: 'zoom-out'
    }).click(function() {
        removeModal();
    }).appendTo('body');
    //handling ESC
    $('body').on('keyup.modal-close', function(e) {
        if (e.key === 'Escape') {
        removeModal();
        }
    });
    });


</script>
@endsection