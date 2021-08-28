

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="row" style=" border-bottom: 2px solid rgb(102, 99, 99);">

        <div class="col">
            <h2 class="ml-2" style="font-family: 'Poppins', sans-serif !important;">ADMIN DASHBOARD</h2>
        </div>
        <div class="col text-right">

            <a href="/clients" class="btn btn-info border border-primary my-1 mx-2">CLIENTS 
                <span class="badge badge-light">
                    <?php echo e(\App\Models\User::where('user_type', 0)->count()); ?>

                </span>
            </a>

            <a href="/rooms#rooms" class="btn btn-success border border-primary  my-1 mx-2">Rooms Available 
                <span class="badge badge-light">
                    <?php echo e(\App\Models\Room::where('status', 0)->count()); ?>

                </span>
            </a>

            <a href="/rooms#rooms" class="btn btn-danger border border-primary  my-1 mx-2">Rooms Occupied 
                <span class="badge badge-light">
                    <?php echo e(\App\Models\Room::where('status', 1)->count()); ?>

                </span>
            </a>

            <a href="/admin#tables" class="btn btn-warning border border-primary  my-1 mx-2">Tables 
                <span class="badge badge-light">
                    <?php echo e(\App\Models\Table::count()); ?>

                </span>
            </a>

        </div>

    </div>


    <div class="row my-2">

        <div class="col-8">
            
            <h4 class="" style="color: rgb(156, 42, 0) !important;">CURRENT AND PENDING BOOKINGS</h4>
        </div>

        <div class="col-4">

            <div class="input-group input-group-lg mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-caret-left" aria-hidden="true"></i></span>
                </div>
                <button id="buttonToggler" type="button" onclick="toggleBookingHistoryPanel()" class="btn btn-sm btn-warning float-right">See Bookings History</button>            
            </div>        
            
            
        </div>  
                     

        <div  id="bookingHistoryPanel" class="table-responsive d-none">

            <?php if(!is_null(\App\Models\Booking::where('status', 3)->orWhere('status', 4)->first())): ?>

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

                        <?php $__currentLoopData = \App\Models\Booking::where('status', 3)->orWhere('status', 4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <th>#<?php echo e($booking->booking_id); ?></th>
                            <td><?php echo e(\Carbon\Carbon::parse($booking->start_date)->isoFormat('Do ddd, MMM Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($booking->end_date)->isoFormat('Do ddd, MMM Y')); ?></td>
                            <td><a href="<?php echo e(url('/profile/'. $booking->client->user->email)); ?>"><?php echo e($booking->client->user->name); ?></a></td>
                            <td><?php echo e(strtoupper(\App\Models\Room::find($booking->room_id)->name)); ?></td>
                            <td><?php echo e($booking->status == 3 ? 'Done' : 'Cancelled'); ?></td>
                            <td>&#8369;<?php echo e(number_format($booking->cost, 2)); ?></td>
                        </tr>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>
                
            <?php else: ?>

            <h3 class="mx-auto">Nothing Done Booking Records so far..</h3>
                
            <?php endif; ?>

        </div>

        
        
    </div>



    <?php if(!is_null(\App\Models\Booking::where('start_date', '>=', \Carbon\Carbon::now())->orWhere('end_date', '>=', \Carbon\Carbon::now())->where('status', '<', 3)->first())): ?>

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
                    <?php $__currentLoopData = App\Models\Booking::where('start_date', '>=', \Carbon\Carbon::now())
                                                ->orWhere('end_date', '>=', \Carbon\Carbon::now())
                                                ->where('status', '<', 3)
                                                ->orderBy('status', 'desc')
                                                ->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <th>#<?php echo e($booking->booking_id); ?></th>
                                <td><?php echo e(\Carbon\Carbon::parse($booking->start_date)->isoFormat('Do ddd, MMM Y')); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($booking->end_date)->isoFormat('Do ddd, MMM Y')); ?></td>
                                <td><a href="<?php echo e(url('/profile/'. $booking->client->user->email)); ?>"><?php echo e($booking->client->user->name); ?></a></td>
                                <td><?php echo e(strtoupper(\App\Models\Room::find($booking->room_id)->name)); ?></td>
                                <td><?php echo e($booking->status == 1 ? 'Pending' : 'Checked in'); ?></td>
                                <td>&#8369;<?php echo e(number_format($booking->cost, 2)); ?></td>

                                <?php if($booking->status == 1): ?>
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
                                                <?php echo Form::open(['url' => '/checkin']); ?>

    
                                                <?php echo e(Form::hidden('id', $booking->id)); ?>

    
                                                <div class="modal-body text-center">
                                                    Check <b><?php echo e($booking->client->user->name); ?> </b>in?
                                                </div>
    
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning text-white">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
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
                                                <?php echo Form::open(['url' => '/bookdone']); ?>

    
                                                <?php echo e(Form::hidden('id', $booking->id)); ?>

    
                                                <div class="modal-body text-center">
                                                    Check <b><?php echo e($booking->client->user->name); ?> </b>out?
                                                    <?php if($booking->client->balance->amount > 0): ?>
                                                        <?php switch($booking->client->sex):
                                                            case (0): ?>
                                                                He still has &#8369; <b><?php echo e(number_format($booking->client->balance->amount, 2)); ?></b> balance.
                                                                <?php break; ?>
                                                            <?php case (1): ?>
                                                                She still has &#8369; <b><?php echo e(number_format($booking->client->balance->amount, 2)); ?></b> balance.
                                                                <?php break; ?>
                                                            <?php default: ?>
                                                                
                                                        <?php endswitch; ?>
                                                    <?php endif; ?>

                                                </div>
    
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary text-white">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>                                                                

                            </tr>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
        
    <?php else: ?>

    <div class="text-center">

        <hr>

        <h3 id="nobookingtoday" class="mx-auto material-text my-auto">No Bookings Today <i class="fa fa-smile" aria-hidden="true"></i></h3>

    </div>
        
    <?php endif; ?>

    <div class="mt-1">
        <?php echo $__env->make('inc.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <div class="row my-2 border border-secondary py-2">

        <div class="col  ">
            
            <h5>Number of Tables : <?php echo e(\App\Models\Table::count()); ?></h5>

        </div>
        <div class="col  ">
            
            <?php echo Form::open([ 'url' => '/tablestore']); ?>


                <button type="submit" class="btn btn-sm btn-success">Add a Table</button>

            <?php echo Form::close(); ?>


        </div>
        <div class="col  ">
            
            <?php echo Form::open([ 'url' => '/tabledelete']); ?>


                <button type="submit" class="btn btn-sm btn-secondary">Delete a Table</button>

            <?php echo Form::close(); ?>



        </div>
        <div class="col  ">
            
            <h5>Reserved Tables : <?php echo e(\App\Models\Table::where('status', 1)->count()); ?></h5>

        </div>

    </div>

    <?php if(!is_null(\App\Models\Reservation::first())): ?>

        <div class="row">
            <div class="col text-right">

                <div class="input-group input-group-lg mb-2 ">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-caret-left" aria-hidden="true"></i></span>
                    </div>
                    <button id="toggleReservations" type="button" onclick="toggleReservationsPanel()" class="btn btn-sm btn-warning float-right">See Reservations <span class="badge badge-light"><?php echo e(\App\Models\Reservation::whereBetween('created_at',  [\Carbon\Carbon::now()->startOfDay(), \Carbon\Carbon::now()->endOfDay()] )->count()); ?></span></button>            
                </div>  
                    
            </div>
        </div>

        <div id="reservationpanel" class="row d-none">

            <div class="col">

                <div class="table-responsive">

                    <table id="reservations" class="table table-bordered">

                        <thead class="bg-success text-white">
                            <tr>
                                <th>Client</th>
                                <th>Date and Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = \App\Models\Reservation::orderBy('created_at', 'desc')->get();; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <tr>
                                    <td><a href="<?php echo e(url('/profile/'. $reservation->client->user->email)); ?>"><?php echo e($reservation->client->user->name); ?></a></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($reservation->created_at)->isoFormat('DD, MMM OY hh:mm A')); ?></td>
                                </tr>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>

            </div>
            
        </div>
        
    <?php endif; ?>

</div>

<script>

$(document).ready(function() {  
    $('#bookings').DataTable( {
        "order": [[ 0, "desc" ]]
    } ); 
   
    $('#bookingrecords').DataTable( {
        "order": [[ 0, "desc" ]]
    } ); 

    $('#reservations').DataTable( {
        "order": [[ 1, "desc" ]]
    } ); 

    $('.selectpicker').selectpicker('refresh');
});

let bookingHistoryPanel = document.getElementById('bookingHistoryPanel');
let buttonToggler = document.getElementById('buttonToggler');
let reservationpanel = document.getElementById('reservationpanel');
let toggleReservations = document.getElementById('toggleReservations');

function toggleReservationsPanel(){

    if(reservationpanel.classList.contains('d-none')){          

        reservationpanel.classList.remove('d-none');        
        toggleReservations.textContent = "Hide Reservations";

    } else {

        reservationpanel.classList.add('d-none');
        toggleReservations.textContent = "See Reservations";

    }


}

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
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>