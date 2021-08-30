

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="row my-2">

        <div class="col">
            <h1 style="color:rgb(156, 42, 0) !important; " class="mb-0">RESTAURANT</h1>        
        </div>
        <div class="col text-right">            
            
            <?php if(\App\Models\Dish::where('status', 0)->count() > 0): ?>

                <?php if(auth()->guard()->guest()): ?>
                    <a href="/login" class="btn btn-light border border-secondary rounded-0">
                        Reserve a Table tonight
                    </a>    

                <?php endif; ?>
            
                <?php if(auth()->guard()->check()): ?>

                    <?php if(auth()->user()->client->checked_in == 0): ?>

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
                
                    <?php elseif(\App\Models\Table::where('status', 0)->count() < 1 ): ?>

                        <button disabled class="btn btn-light border border-secondary rounded-0">
                            Sorry. Tables are full tonight. 
                        </button>

                    <?php else: ?>

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
                                    <?php echo Form::open(['url' => '/reservetable']); ?>

                                </div>

                                <div class="text-center">
                                    
                                   <b> Reserve </b> a Table tonight? <em><?php echo e(\Carbon\Carbon::now()->isoFormat('Do, MMM YY\'')); ?></em>

                                </div>

                                <div class="modal-footer rounded-0">
                                    <button type="submit" class="btn btn-success rounded-0">
                                        Yes
                                    </button>
                                    <button type="button" class="btn btn-dark rounded-0" data-dismiss="modal">Close</button>                                      
                                </div>
                                <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                    
                <?php endif; ?>

                
            <?php endif; ?>


            

        </div>

    </div>

    <div class="row mb-4 border border-secondary p-2 vh-100">

       <div class="col ">

            <div class="text-center mb-2">

                <h3 class="mx-auto" style="font-family: 'Allison', cursive !important; font-size: 3.5em !important;">Menu</h3>

            </div>

            <?php if(\App\Models\Dish::where('status', 0)->count() > 0): ?>
            
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
    
                            <?php $__currentLoopData = \App\Models\Dish::where('status', 0)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
                                <tr>
    
                                    <td><?php echo e($dish->name); ?></td>
                                    <td><?php echo e($dish->desc); ?></td>
                                    <td ><img data-enlargeable style="max-height: 200px; max-width:200px; cursor: zoom-in;" src="<?php echo e(url('/storage/images/dishes/' . $dish->image)); ?>" alt=""  class="img-thumbnail"></td>
                                    <td>&#8369; <?php echo e(number_format($dish->price, 2)); ?></td>
    
                                </tr>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                        </tbody>
    
                    </table>

                </div>

            <?php else: ?>

                <div class="text-center">

                    <hr>

                    <h6>Nothing on the Menu for now <i class="fa fa-smile"></i> </h6>

                </div>
                
            <?php endif; ?>

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
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/restaurant.blade.php ENDPATH**/ ?>