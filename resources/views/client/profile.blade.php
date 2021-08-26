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
                        <h4 class="material-text">Checked In</h4>
                    </div>
                    
                @else

                    <div class="m-auto text-center bg-warning p-2">
                        <h4 class="material-text">Not Checked In</h4>
                    </div>
                    
                @endif
       
                            

            </div>
          

        </div>

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
                                    
                                    <td>{{$trans->id}}</td>
                                    <td>{{$trans->desc}}</td>
                                    <td>&#8369; {{is_null($trans->amount) ? 'N\A' : number_format($trans->amount, 2)}}</td>
                                    <td>&#8369; {{number_format($trans->prev_bal, 2)}}</td>
                                    <td>&#8369; {{number_format($trans->rem_bal, 2)}}</td>
                                    <td>{{\Carbon\Carbon::parse($trans->created_at)->isoFormat('DD, MMM OY hh:mm A') }}</td>
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
        $('#transactions').DataTable();
      
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