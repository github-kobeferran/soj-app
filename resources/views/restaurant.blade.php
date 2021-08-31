@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row my-2">

        <div class="col">
            <h1 style="color:rgb(156, 42, 0) !important; " class="mb-0">RESTAURANT</h1>        
        </div>
        <div class="col text-right">            
            
            @if (\App\Models\Dish::where('status', 0)->count() > 0)

                @guest
                    <a href="/login" class="btn btn-light border border-secondary rounded-0">
                        Reserve a Table tonight
                    </a>    

                @endguest
            
                @auth

                    @if (auth()->user()->client->checked_in == 0)

                        <button data-toggle="modal" data-target="#notcheckedinmodal" class="btn btn-light border border-secondary rounded-0">
                            Reserve a Table tonight
                        </button>

                        <div class="modal fade" id="notcheckedinmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    Can't reserve if you're not checked in! <i class="fa fa-smile"></i>
                                </div>
                                
                                </div>
                            </div>
                        </div>
                
                    @elseif(\App\Models\Table::where('status', 0)->count() < 1 )

                        <button disabled class="btn btn-light border border-secondary rounded-0">
                            Sorry. Tables are full tonight. 
                        </button>

                    @else

                        <button data-toggle="modal" data-target="#reservemodal" class="btn btn-light border border-secondary rounded-0">
                            Reserve a Table tonight
                        </button>

                        <div class="modal fade  rounded-0" id="reservemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered  rounded-0" role="document">
                                <div class="modal-content">
                                <div class="modal-header bg-success text-white rounded-0">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reserve a Table</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    {!!Form::open(['url' => '/reservetable'])!!}
                                </div>

                                <div class="text-center">
                                    
                                   <b> Reserve </b> a Table tonight? <em>{{\Carbon\Carbon::now()->isoFormat('Do, MMM YY\'')}}</em>

                                </div>

                                <div class="modal-footer rounded-0">
                                    <button type="submit" class="btn btn-success rounded-0">
                                        Yes
                                    </button>
                                    <button type="button" class="btn btn-dark rounded-0" data-dismiss="modal">Close</button>                                      
                                </div>
                                {!!Form::close()!!}
                                </div>
                            </div>
                        </div>

                    @endif
                    
                @endauth

                
            @endif


            

        </div>

    </div>

    <div class="row mb-4 border border-secondary p-2 ">

       <div class="col ">

            <div class="text-center mb-2">

                <h3 class="mx-auto" style="font-family: 'Allison', cursive !important; font-size: 3.5em !important;">Menu</h3>

            </div>

            @if (\App\Models\Dish::where('status', 0)->count() > 0)
            
                <div class="table-responsive">

                    <table id="dishes" class="table table-bordered">

                        <thead class="d-none">
                            <tr>
    
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
    
                            </tr>
    
                        </thead>
    
                        <tbody>                    
    
                            @foreach (\App\Models\Dish::where('status', 0)->get() as $dish)
    
                                <tr>
    
                                    <td>{{$dish->name}}</td>
                                    <td>{{$dish->desc}}</td>
                                    <td ><img data-enlargeable style="max-height: 200px; max-width:200px; cursor: zoom-in;" src="{{url('/storage/images/dishes/' . $dish->image)}}" alt=""  class="img-thumbnail"></td>
                                    <td>&#8369; {{number_format($dish->price, 2)}}</td>
    
                                </tr>
                                
                            @endforeach
    
                        </tbody>
    
                    </table>

                </div>

            @else

                <div class="text-center">

                    <hr>

                    <h6>Nothing on the Menu for now <i class="fa fa-smile"></i> </h6>

                </div>
                
            @endif

       </div>

    </div>

</div>

<script>

$(document).ready(function() {
    $('#dishes').DataTable();      
  
});

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