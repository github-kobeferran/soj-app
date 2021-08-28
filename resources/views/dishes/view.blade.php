@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row my-2">

        <div class="col ">

            <h3 class="border-bottom">DISHES</h3> 

        </div>

        <div class="col text-right">

            <button data-toggle="modal" data-target="#createdish" class="btn btn-sm rounded-0 btn-outline-success"><i class="fa fa-plus"></i> Add a Dish</button>

            <div class="text-left">

                <div class="modal fade" id="createdish" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
    
                        <div class="modal-header bg-success text-white">
                          <h5 class="modal-title" id="exampleModalLongTitle">Create a Dish</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        
                        {!! Form::open(['url' => '/dishstore' , 'files' => true]) !!}
    
                            <div class="form-group p-2">
                                <b><label for="">Name</label></b>
                                {{Form::text('name', '', ['placeholder' => 'Dish Name', 'class' => 'form-control', 'maxlength' => '50','minlength' => '2', 'required' => 'required'])}}
                            </div>
    
                            <div class="form-group p-2">
                                <b><label for="">Description</label></b>
                                {{Form::textarea('desc', '', ['placeholder' => 'Dish Description','class' => 'form-control', 'maxlength' => '255', 'minlength' => '2', 'required' => 'required'])}}
                            </div>
    
                            <div class="form-group p-2">
                                <b><label for="">Image</label></b>
                                {{Form::file('image', ['class' => 'form-control border-0'])}}
                            </div>
    
                            <div class="form-group p-2">
                                <b><label for="">Price</label></b>
                                {{Form::number('price', '', ['placeholder' => 'Dish Price','class' => 'form-control', 'min' => '50', 'max' => '10000', 'required' => 'required', 'step' => '.01'])}}
                            </div>
        
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success border">Save</button>
                        </div>
    
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>

    <div>

        @include('inc.messages')

    </div>

    @if (!is_null(\App\Models\Dish::first()))

        <div class="row">

            <div class="col">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach (\App\Models\Dish::all() as $dish)

                                <tr>                                    
                                    <td>{{$dish->name}}</td>
                                    <td>{{$dish->desc}}</td>
                                    <td><img style="max-height: 200px !important; max-width: 200px !important; cursor: zoom-in;" src="{{url('/storage/images/dishes/' . $dish->image)}}" alt="" class="img-thumbnail"></td>
                                    <td>{{number_format($dish->price, 2)}}</td>

                                    @switch($dish->status)
                                        @case(0)
                                            <td>
                                                <button data-toggle="modal" data-target="#makeunavail-{{$dish->id}}" class="btn btn-light border">
                                                    Available
                                                </button>

                                                <div class="modal fade" id="makeunavail-{{$dish->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                        
                                                        <div class="modal-header bg-danger text-white">
                                                          <h5 class="modal-title" id="exampleModalLongTitle">{{$dish->name}}</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span class="text-white" aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        
                                                            {!! Form::open(['url' => '/dishunavailable']) !!}
                        
                                                                {{Form::hidden('id', $dish->id)}}
                                        
                                                                <div class="text-center">
                                                                    <b class="my-3">Make  {{$dish->name}} unavailable?</b>

                                                                </div>
                                                        
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-light border">Yes</button>
                                                            </div>
                                    
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>                                        
                                            @break
                                        @case(1)                                        
                                        <td>
                                            <button data-toggle="modal" data-target="#makeavail-{{$dish->id}}" class="btn btn-secondary border">
                                                Unavailable
                                            </button>

                                            <div class="modal fade" id="makeavail-{{$dish->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                    
                                                    <div class="modal-header bg-info text-white">
                                                      <h5 class="modal-title" id="exampleModalLongTitle">{{$dish->name}}</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span class="text-white" aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    
                                                        {!! Form::open(['url' => '/dishavailable']) !!}
                    
                                                            {{Form::hidden('id', $dish->id)}}
                                    
                                                            <div class="text-center">

                                                                <b class="my-3">Make  {{$dish->name}} available?</b>

                                                            </div>
                                                    
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-info border">Yes</button>
                                                        </div>
                                
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>  
                                            @break
                                        @default
                                            
                                    @endswitch

                                    <td>
                                        <button data-toggle="modal" data-target="#editdish-{{$dish->id}}" class="btn btn-info border">
                                            Edit
                                        </button>
                                        <button data-toggle="modal" data-target="#deletedish-{{$dish->id}}" class="btn btn-danger border">
                                            Delete
                                        </button>


                                        <div class="modal fade" id="editdish-{{$dish->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                            
                                                <div class="modal-header bg-info text-white">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Dish {{$dish->name}}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                
                                                {!! Form::open(['url' => '/dishupdate' , 'files' => true]) !!}
                                                
                                                {{Form::hidden('id', $dish->id)}}

                                                    <div class="form-group p-2">
                                                        <b><label for="">Name</label></b>
                                                        {{Form::text('name', $dish->name, ['placeholder' => 'Dish Name', 'class' => 'form-control', 'maxlength' => '50','minlength' => '2', 'required' => 'required'])}}
                                                    </div>
                            
                                                    <div class="form-group p-2">
                                                        <b><label for="">Description</label></b>
                                                        {{Form::textarea('desc', $dish->desc, ['placeholder' => 'Dish Description','class' => 'form-control', 'maxlength' => '255', 'minlength' => '2', 'required' => 'required'])}}
                                                    </div>


                            
                                                    <div class="form-group p-2">
                                                        <img style="max-height: 100px !important; max-width: 100px !important;" src="{{url('storage/images/dishes/' . $dish->image)}}" alt="" class="img-thumbnail">
                                                        {{Form::file('image', ['class' => 'form-control border-0'])}}
                                                    </div>
                            
                                                    <div class="form-group p-2">
                                                        <b><label for="">Price</label></b>
                                                        {{Form::number('price', $dish->price, ['placeholder' => 'Dish Price','class' => 'form-control', 'min' => '50', 'max' => '10000', 'required' => 'required', 'step' => '.01'])}}
                                                    </div>
                                
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info border">Save</button>
                                                </div>
                            
                                                {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="deletedish-{{$dish->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                            
                                                <div class="modal-header bg-danger text-white">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">Delete Dish {{$dish->name}}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                
                                                {!! Form::open(['url' => '/dishdelete']) !!}     
                                                
                                                {{Form::hidden('id', $dish->id)}}
                                
                                                <div class="text-center">

                                                    Delete dish <b>{{$dish->name}}</b> ?

                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger border">Yes</button>
                                                </div>
                            
                                                {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    
                                </tr>
                                
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
        
    @endif

</div>

<script>


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