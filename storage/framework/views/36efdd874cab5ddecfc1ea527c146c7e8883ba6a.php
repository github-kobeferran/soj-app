

<?php $__env->startSection('content'); ?>

<div class="container">

    <h3 class="ml-2 border-bottom">CLIENTS</h3>

    <div class="row my-2">

       <div class="col">

            <?php if(\App\Models\User::where('user_type', 0)->count() > 1 ): ?>

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

                            <?php $__currentLoopData = \App\Models\Client::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if($client->user->user_type == 1): ?>

                                    <?php continue; ?>
                                    
                                <?php endif; ?>

                                <tr>                                    
                                    <td><a class="text-dark" href="<?php echo e(url('/profile/' . $client->user->email)); ?>"><b><?php echo e($client->user->name); ?></b></a></td>
                                    <td><?php echo e($client->user->email); ?></td>

                                    <?php if(!is_null($client->sex)): ?>
                                        <td><?php echo e($client->sex == 0 ? 'Male' : 'Female'); ?></td>
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>
                                    
                                    <?php if(!is_null($client->dob)): ?>
                                        <td><?php echo e(\Carbon\Carbon::parse($client->dob)->isoFormat('MMM DD, OY') . ' (' . \Carbon\Carbon::parse($client->dob)->age . ' years)'); ?></td>
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>

                                    <?php if(!is_null($client->nationality)): ?>
                                        <td><?php echo e($client->nationality); ?></td>
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>

                                    <?php if(!is_null($client->address)): ?>
                                        <td><?php echo e($client->address); ?></td>
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>

                                    <?php if(!is_null($client->contact)): ?>
                                        <td><?php echo e($client->contact); ?></td>   
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>

                                    <?php if(!is_null($client->image)): ?>
                                        <td><button data-toggle="modal" data-target="#client-image-<?php echo e($client->id); ?>" class="btn btn-light border-0 text-info">View Image</button></td>   

                                        <div class="modal fade" id="client-image-<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                  <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(ucfirst($client->user->name)); ?></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>

                                                <img src="<?php echo e(url('storage/images/client/' . $client->image)); ?>" alt="" class="img-thumbnail bg-dark mx-auto p-0 ">
                                                
                                              </div>
                                            </div>
                                          </div>
                                    <?php else: ?>                                    
                                        <td></td>
                                    <?php endif; ?>

                                    <td><?php echo e($client->checked_in == 0 ? "Not Checked in" : "Checked in"); ?></td>

                                    <?php if(!is_null($client->image)): ?>
                                        <td><?php echo e(\Carbon\Carbon::parse($client->last_checked_in)->diffForHumans()); ?></td>
                                    <?php else: ?>                                    
                                        <td>Never been</td>
                                    <?php endif; ?>
                                    
                                </tr>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>
            
            <?php else: ?>
                
                <h6 class="mx-auto">No Clients so far..</h6>
        
            <?php endif; ?>

       </div>

    </div>




</div>

<script>
$(document).ready(function() {
    $('#clients').DataTable();      
});

</script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/client/view.blade.php ENDPATH**/ ?>