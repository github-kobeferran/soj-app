

<?php $__env->startSection('content'); ?>

<div class="container">

    <?php echo $__env->make('inc.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-1 ">

        <?php if(!empty(\App\Models\RoomType::first())): ?>
        
            <h3 style="color: rgb(156, 42, 0) !important;" >ROOM TYPES <button data-toggle="modal" data-target="#createroomtypemodal" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room Type</button></h3>

            <div class="modal fade" id="createroomtypemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      
                    <div class="modal-header bg-success text-white">
                      <h5 class="modal-title" id="exampleModalLongTitle">Create a Room Type</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php echo Form::open(['url' => '/roomtypestore', 'files' => true]); ?>


                        <div class="form-group p-2">

                            <label for="">Description</label>

                            <?php echo e(Form::text('desc', '', ['class' => 'form-control', 'placeholder' => 'Room Type Description', 'required' => 'required'])); ?>


                        </div>

                        <div class="form-group p-2">

                            <label for="">Rate</label>

                            <?php echo e(Form::number('rate', '', ['class' => 'form-control', 'placeholder' => 'Rate Value', 'required' => 'required', 'min' => '300' , 'max' => '20000'])); ?>


                        </div>

                        <div class="form-group p-2">

                            <label for="">Features</label>

                            <?php if(!is_null(\App\Models\Feature::first())): ?>

                                <?php $features = \App\Models\Feature::where('standard', 0)->get()->pluck('desc', 'id'); ?>

                                <?php echo e(Form::select('features[]', $features, null, ['data-live-search' => 'true', 'multiple' => 'multiple', 'class' => 'form-control selectpicker', 'title' => 'Select Features'])); ?>


                                <?php if(!is_null(\App\Models\Feature::where('standard', 1)->first())): ?>

                                   <div class="text-left ml-2 border-top">

                                    <h6>Standard Features</h6>

                                        <?php $__currentLoopData = \App\Models\Feature::where('standard', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    
                                            <p class="material-text my-0" style="font-size: 1rem !important;"> <i style="font-size: .5rem !important;" class="fa fa-circle align-middle py-auto" aria-hidden="true"></i> <?php echo e($standard->desc); ?></p>
                                            
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                   </div>
                                    
                                <?php endif; ?>

                            <?php else: ?>

                                No Features yet.. Add one.
                                
                            <?php endif; ?>

                        </div>

                        <div class="form-group p-2">

                            <label for="">Beds</label>

                            <?php if(!is_null(\App\Models\Bed::first())): ?>

                                <?php $beds = \App\Models\Bed::all()->pluck('desc', 'id'); ?>

                                <?php echo e(Form::select('beds[]', $beds, null, ['data-live-search' => 'true', 'multiple' => 'multiple', 'class' => 'form-control selectpicker', 'title' => 'Select Beds', 'required' => 'required'])); ?>


                            <?php else: ?>

                                No Beds yet.. Add one.
                                
                            <?php endif; ?>

                        </div>

                        <div class="form-group p-2">

                            <label for="">Image</label>

                            <?php echo e(Form::file('image',  ['class' => 'form-control', 'required' => 'required'])); ?>


                        </div>
                  
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                  </div>
                </div>
              </div>

            <div class="table-responsive">

                <table id="roomtypes" class="table table-bordered">

                    <caption>Room Type Data</caption>

                    <thead class="bg-success text-white">

                        <tr>

                            <th>Description</th>
                            <th>Rate</th>
                            <th>Images</th>
                            <th style="width: 100px;">Action</th>

                        </tr>

                    </thead>

                    <tbody>                    
                    
                        <?php $__currentLoopData = \App\Models\RoomType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e(ucfirst($room_type->desc)); ?></td>
                            <td> &#8369;<?php echo e(number_format($room_type->rate, 2)); ?></td>
                            <td class="p-2" > <img data-enlargeable style="max-height:100px; max-width:100px; cursor: zoom-in;"  src="<?php echo e(url('storage/images/room_types/' . $room_type->images)); ?>" alt="" class="img-fluid"> </td>
                            <td class="px-2" >

                                <button data-toggle="modal" data-target="#editroomtypemodal-<?php echo e($room_type->id); ?>" class="btn btn-sm btn-info">Edit</button>
                                <button data-toggle="modal" data-target="#deleteroomtypemodal-<?php echo e($room_type->id); ?>" class="btn btn-sm btn-danger">Delete</button>

                                <div class="modal fade" id="editroomtypemodal-<?php echo e($room_type->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Edit Room Type</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span class="text-white" aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <?php echo Form::open(['url' => '/roomtypeupdate', 'files' => true]); ?>

        
                                            <?php echo e(Form::hidden('id', $room_type->id)); ?>

                
                                            <div class="form-group p-2">
                
                                                <label for="">Description</label>
                
                                                <?php echo e(Form::text('desc', $room_type->desc, ['class' => 'form-control', 'placeholder' => 'Room Type Description', 'required' => 'required'])); ?>

                
                                            </div>
                
                                            <div class="form-group p-2">
                
                                                <label for="">Rate</label>
                
                                                <?php echo e(Form::number('rate', $room_type->rate, ['class' => 'form-control', 'placeholder' => 'Rate Value', 'required' => 'required', 'min' => '300' , 'max' => '20000'])); ?>

                
                                            </div>
        
        
                                            <div class="form-group p-2">
        
                                                <label for="">Features</label>
                
                                                <?php if(!is_null(\App\Models\Feature::first())): ?>
                
                                                    <?php $features = \App\Models\Feature::where('standard', 0)->get(); ?>
                                                    <?php 
                                                    
                                                        $defaults = \App\Models\RoomFeatures::where('room_type_id', $room_type->id)->get();
                                                        $default_list = collect();
        
                                                        foreach ($defaults as $default_rel) {
                                                            
                                                            $default_list->push(\App\Models\Feature::find($default_rel->feature_id));
        
                                                        }         
                                                        
                                                    ?>                                                                                                                                        
        
                                                                                            
                                                    <select data-live-search="true" multiple="multiple" class="selectpicker form-control" title="Select Features" name="features[]">                                            
        
                                                        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
                                                            <?php $valid = false; ?>
        
                                                            <?php $__currentLoopData = $default_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
                                                                <?php if($feature->id == $default->id): ?>
        
                                                                    <?php $valid = true; ?>
                                                                                                                           
                                                                <?php endif; ?>
                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
                                                            <option value="<?php echo e($feature->id); ?>" <?php echo e($valid ? 'selected' : ''); ?>><?php echo e($feature->desc); ?> </option>                                                    
                                                                                                                
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
                                                    </select>
                                                    
                                                    
                                                    <?php if(!is_null(\App\Models\Feature::where('standard', 1)->first())): ?>

                                                        <div class="text-left ml-2 border-top">
                    
                                                        <h6>Standard Features</h6>
                    
                                                            <?php $__currentLoopData = \App\Models\Feature::where('standard', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                        
                                                                <p class="material-text my-0" style="font-size: 1rem !important;"> <i style="font-size: .5rem !important;" class="fa fa-circle align-middle py-auto" aria-hidden="true"></i> <?php echo e($standard->desc); ?></p>
                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                                                        </div>
                                                        
                                                    <?php endif; ?>
                
                                                <?php else: ?>
                
                                                    No Features yet.. Add one.
                                                    
                                                <?php endif; ?>
                
                                            </div>

                                            <?php if(!is_null(\App\Models\Bed::first())): ?>

                                                <div class="form-group p-2">

                                                    <?php 
                                                        $beds = \App\Models\Bed::all();

                                                        $room_beds = \App\Models\RoomBeds::where('room_type_id', $room_type->id)->get();
                                                        
                                                        $default_beds = collect();

                                                        foreach ($room_beds as $room_bed) {

                                                            $default_beds->push(\App\Models\Bed::find($room_bed->bed_id));
                                                            
                                                        }
                                                    
                                                    ?>

                                                    <select data-live-search="true" multiple="multiple" class="selectpicker form-control" title="Select Beds" name="beds[]" required>                                            
                                                            
                                                        <?php $__currentLoopData = $beds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <?php $valid = false; ?>

                                                            <?php $__currentLoopData = $default_beds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <?php if($bed->id == $default->id): ?>

                                                                    <?php $valid = true; ?>
                                                                                                                        
                                                                <?php endif; ?>
                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($bed->id); ?>" <?php echo e($valid ? 'selected' : ''); ?>><?php echo e($bed->desc); ?> </option>                                                    
                                                                                                                
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>

                                                </div>
                                                
                                            <?php endif; ?>
                
                                            <div class="form-group p-2">
                
                                                <label for="">Image</label>
        
                                                <img src="<?php echo e(url('storage/images/room_type/' . $room_type->images)); ?>" alt="">
                
                                                <?php echo e(Form::file('image',  ['class' => 'form-control'])); ?>

                
                                            </div>
                                      
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-info">Save Changes</button>
                                        </div>
                
                                        <?php echo Form::close(); ?>

                                      </div>
                                    </div>
                                  </div>
        
                                <div class="modal fade" id="deleteroomtypemodal-<?php echo e($room_type->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
        
                                        <div class="modal-header bg-danger text-white">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo e(ucfirst($room_type->desc)); ?></h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span class="text-white" aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        
                                            <?php echo Form::open(['url' => '/roomtypedelete']); ?>

        
                                                <?php echo e(Form::hidden('id', $room_type->id)); ?>

                        
                                                <b class="my-3">Are you sure you want to delete <?php echo e(ucfirst($room_type->desc)); ?>?</b>
                                        
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                            </div>
                    
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                  </div>

                            </td>                          

                        </tr>
                                                    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            No Room Types yet.. Add one. 

            <button data-toggle="modal" data-target="#createroomtypemodal" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room Type</button>

            <div class="modal fade" id="createroomtypemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      
                    <div class="modal-header bg-success text-white">
                      <h5 class="modal-title" id="exampleModalLongTitle">Create a Room Type</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php echo Form::open(['url' => '/roomtypestore', 'files' => true]); ?>


                        <div class="form-group p-2">

                            <label for="">Description</label>

                            <?php echo e(Form::text('desc', '', ['class' => 'form-control', 'placeholder' => 'Room Type Description', 'required' => 'required'])); ?>


                        </div>

                        <div class="form-group p-2">

                            <label for="">Rate</label>

                            <?php echo e(Form::number('rate', '', ['class' => 'form-control', 'placeholder' => 'Rate Value', 'required' => 'required', 'min' => '300' , 'max' => '20000'])); ?>


                        </div>

                        <div class="form-group p-2">

                            <label for="">Features</label>

                            <?php if(!is_null(\App\Models\Feature::first())): ?>

                                <?php $features = \App\Models\Feature::where('standard', 0)->get()->pluck('desc', 'id'); ?>

                                <?php echo e(Form::select('features[]', $features, null, ['data-live-search' => 'true', 'multiple' => 'multiple', 'class' => 'form-control selectpicker', 'title' => 'Select Features'])); ?>


                                <?php if(!is_null(\App\Models\Feature::where('standard', 1)->first())): ?>

                                   <div class="text-left ml-2 border-top">

                                    <h6>Standard Features</h6>

                                        <?php $__currentLoopData = \App\Models\Feature::where('standard', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    
                                            <p class="material-text my-0" style="font-size: 1rem !important;"> <i style="font-size: .5rem !important;" class="fa fa-circle align-middle py-auto" aria-hidden="true"></i> <?php echo e($standard->desc); ?></p>
                                            
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                   </div>
                                    
                                <?php endif; ?>

                            <?php else: ?>

                                No Features yet.. Add one.
                                
                            <?php endif; ?>

                        </div>

                        <div class="form-group p-2">

                            <label for="">Beds</label>

                            <?php if(!is_null(\App\Models\Bed::first())): ?>

                                <?php $beds = \App\Models\Bed::all()->pluck('desc', 'id'); ?>

                                <?php echo e(Form::select('beds[]', $beds, null, ['data-live-search' => 'true', 'multiple' => 'multiple', 'class' => 'form-control selectpicker', 'title' => 'Select Beds', 'required' => 'required'])); ?>


                            <?php else: ?>

                                No Beds yet.. Add one.
                                
                            <?php endif; ?>

                        </div>

                        <div class="form-group p-2">

                            <label for="">Image</label>

                            <?php echo e(Form::file('image',  ['class' => 'form-control', 'required' => 'required'])); ?>


                        </div>
                  
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                  </div>
                </div>
              </div>
            
        <?php endif; ?>

    </div>

    <hr>

    <div class="row mt-2 ">

        <?php if(!empty(\App\Models\RoomType::first())): ?>          

            <h3>ROOMS <button data-toggle="modal" data-target="#createroommodal" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room</button></h3>

            <div class="modal fade" id="createroommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo Form::open(['url' => '/roomstore']); ?>

                                                    
                    <div class="form-group p-2 text-left">

                        <label for="">Name</label>

                        <?php echo e(Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Room Name', 'required' => 'required'])); ?>


                    </div>

                    <?php $room_types_list = \App\Models\RoomType::all()->pluck('desc', 'id'); ?> 

                    <div class="form-group p-2 text-left">

                        <label for="">Room Type</label>

                        <?php echo e(Form::select('room_type_id', $room_types_list, null, ['data-live-search' => 'true', 'class' => 'selectpicker form-control', 'required' => 'required'])); ?>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
            
            <div class="table-responsive ">

                <table id="rooms" class="table table-bordered table-striped">

                    <caption>Rooms Data</caption>

                    <thead class="bg-info text-white">
                       
                        <tr>
                            <th>Name</th>
                            <th>Room Type</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>

                    </thead>
                    <tbody>                    
                    
                        <?php $__currentLoopData = \App\Models\Room::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e(ucfirst($room->name)); ?></td>
                            <td> <?php echo e(ucfirst($room->room_type->desc)); ?></td>

                            <?php switch($room->status):
                                case (0): ?>
                                    <td class="text-success"> Available </td>        
                                    <?php break; ?>
                                <?php case (1): ?>
                                    <td class="text-danger"> Occupied </td> 
                                    <?php break; ?>
                                <?php case (1): ?>
                                    <td class="text-dark"> Unavailble </td> 
                                    <?php break; ?>
                                <?php default: ?>
                                    
                            <?php endswitch; ?>
                            
                            <td class="px-2" >

                                <button data-toggle="modal" data-target="#editroommodal-<?php echo e($room->id); ?>" class="btn btn-sm btn-info">Edit</button>
                                <button data-toggle="modal" data-target="#deleteroommodal-<?php echo e($room->id); ?>" class="btn btn-sm btn-danger">Delete</button>

                            </td>
                        </tr>

                        <div class="modal fade" id="editroommodal-<?php echo e($room->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Room <?php echo e(ucfirst($room->name)); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php echo Form::open(['url' => '/roomupdate']); ?>

                                                                
                                <div class="form-group p-2 text-left">

                                    <label for="">Name</label>

                                    <?php echo e(Form::text('name', $room->name, ['class' => 'form-control', 'placeholder' => 'Room Name', 'required' => 'required'])); ?>


                                </div>

                                <?php $room_types_list = \App\Models\RoomType::all()->pluck('desc', 'id'); ?> 

                                <div class="form-group p-2 text-left">

                                    <label for="">Room Type</label>

                                    <?php echo e(Form::select('room_type_id', $room_types_list, $room->room_type_id, ['data-live-search' => 'true', 'class' => 'selectpicker form-control', 'required' => 'required'])); ?>


                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Save</button>
                                </div>
            
                                <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="deleteroommodal-<?php echo e($room->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Room <?php echo e(ucfirst($room->name)); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php echo Form::open(['url' => '/roomdelete']); ?>

                                                                
                                <?php echo e(Form::hidden('id', $room->id)); ?>


                                <b class="my-3">You sure you want to delete <?php echo e(ucfirst($room->name)); ?>?</b>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Yes</button>
                                </div>
            
                                <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>

        <?php else: ?>

            No Room yet.. Add one.

            <button data-toggle="modal" data-target="#createroommodal" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room</button>

            <div class="modal fade" id="createroommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo Form::open(['url' => '/roomstore']); ?>

                                                    
                    <div class="form-group p-2 text-left">

                        <label for="">Name</label>

                        <?php echo e(Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Room Name', 'required' => 'required'])); ?>


                    </div>

                    <?php $room_types_list = \App\Models\RoomType::all()->pluck('desc', 'id'); ?> 

                    <div class="form-group p-2 text-left">

                        <label for="">Room Type</label>

                        <?php echo e(Form::select('room_type_id', $room_types_list, null, ['data-live-search' => 'true', 'class' => 'selectpicker form-control', 'required' => 'required'])); ?>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <hr>

    <div class="row my-2">

        <div class="col-md">

            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                </div>
                <button type="button" onclick="togglePanel()" id="showButton" class="btn btn-warning"> SHOW ROOM FEATURES AND BED TYPES </button>            
            </div>            

        </div>

    </div>
    
    <div class="row mb-5 d-none" id="featuresAndBedsPanel">               

        <?php if(!is_null(\App\Models\Feature::first())): ?>

        <hr> 

            <h3>FEATURES <button data-toggle="modal" data-target="#createfeature" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room Feature</button></h3>

            <div class="modal fade" id="createfeature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create a Feature</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo Form::open(['url' => '/featurestore']); ?>                                                                        

                    <div class="form-group px-2">

                        <label for=""><b>Description</b></label>
                        <?php echo e(Form::text('desc', '', ['class' => "form-control", 'placeholder' => 'Feature Description', 'required' => 'required', 'minlength' => '3', 'maxlength' => '50'])); ?>


                    </div>

                    <div class="form-group px-2">

                        <label for=""><b>Type</b></label>
                        <br>

                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light active">
                              <input type="radio" name="standard" id="option1" value="0" autocomplete="off" checked> Special
                            </label>                       
                            <label class="btn btn-light">
                              <input type="radio" name="standard" id="option3" value="1" autocomplete="off"> Standard
                            </label>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

            <div class="table-responsive">

                <table id="features" class="table table-bordered">

                    <thead class="bg-dark text-light">

                        <tr>

                            <th>Description</th>
                            <th>Type</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__currentLoopData = \App\Models\Feature::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td><?php echo e(ucfirst($feature->desc)); ?></td>
                                <td><?php echo e($feature->standard > 0 ? 'Standard' : 'Special'); ?></td>
                                <td class="px-2" >

                                    <button data-toggle="modal" data-target="#editfeature-<?php echo e($feature->id); ?>" class="btn btn-sm btn-info">Edit</button>
                                    <button data-toggle="modal" data-target="#deletefeature-<?php echo e($feature->id); ?>" class="btn btn-sm btn-danger">Delete</button>

                                    <div class="modal fade" id="editfeature-<?php echo e($feature->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Feature <?php echo e(ucfirst($feature->desc)); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span class="text-white" aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <?php echo Form::open(['url' => '/featureupdate']); ?>

        
                                                    <?php echo e(Form::hidden('id', $feature->id)); ?>

                                                                                    
                                                    <div class="form-group px-2">
        
                                                        <label for=""><b>Description</b></label>
                                                        <?php echo e(Form::text('desc', $feature->desc, ['class' => "form-control", 'required' => 'required', 'minlength' => '3', 'maxlength' => '50'])); ?>

                                
                                                    </div>
                                
                                                    <div class="form-group px-2">
                                
                                                        <label for=""><b>Type</b></label>
                                                        <br>
        
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-light active">
                                                              <input type="radio" name="standard" id="option1" value="0" autocomplete="off" <?php echo e($feature->standard > 0 ? '' : 'checked'); ?>> Special
                                                            </label>                       
                                                            <label class="btn btn-light">
                                                              <input type="radio" name="standard" id="option3" value="1" autocomplete="off" <?php echo e($feature->standard > 0 ? 'checked' : ''); ?>> Standard
                                                            </label>
                                                        </div>                                                                     
                                
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-info">Save Changes</button>
                                                    </div>
                                
                                                    <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="modal fade" id="deletefeature-<?php echo e($feature->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Feature <?php echo e(ucfirst($feature->desc)); ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php echo Form::open(['url' => '/featuredelete']); ?>

                                                                                
                                                <?php echo e(Form::hidden('id', $feature->id)); ?>

                
                                                <b class="my-3">You sure you want to delete <?php echo e(ucfirst($feature->desc)); ?>?</b>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                </div>
                            
                                                <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        </div>
    
                                </td>

                               

                            </tr>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>
            
        <?php else: ?>
            
            <div class="text center">

                <h3>No Features yet.. add one.</h3>

                <button data-toggle="modal" data-target="#createfeature" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Room Feature</button>

                <div class="modal fade" id="createfeature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Create a Feature</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo Form::open(['url' => '/featurestore']); ?>                                                                        
    
                        <div class="form-group px-2">
    
                            <label for=""><b>Description</b></label>
                            <?php echo e(Form::text('desc', '', ['class' => "form-control", 'placeholder' => 'Feature Description', 'required' => 'required', 'minlength' => '3', 'maxlength' => '50'])); ?>

    
                        </div>
    
                        <div class="form-group px-2">
    
                            <label for=""><b>Type</b></label>
                            <br>
    
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-light active">
                                  <input type="radio" name="standard" id="option1" value="0" autocomplete="off" checked> Special
                                </label>                       
                                <label class="btn btn-light">
                                  <input type="radio" name="standard" id="option3" value="1" autocomplete="off"> Standard
                                </label>
                            </div>
    
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
    
                        <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>

            </div>

            <hr>
            
        <?php endif; ?>

        <?php if(!is_null(\App\Models\Bed::first())): ?>

        <hr> 

            <h3>BEDS <button data-toggle="modal" data-target="#createbed" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Bed</button></h3>

            <div class="modal fade" id="createbed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Bed</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo Form::open(['url' => '/bedstore']); ?>                                                                        

                    <div class="form-group px-2">

                        <label for=""><b>Description</b></label>
                        <?php echo e(Form::text('desc', '', ['class' => "form-control", 'placeholder' => 'Bed Description', 'required' => 'required', 'minlength' => '3', 'maxlength' => '25'])); ?>


                    </div>

                    <div class="form-group px-2">

                        <label for=""><b>Persons Fit</b></label>
                        
                        <?php echo e(Form::number('persons_fit', 1, ['class' => 'form-control', 'min' => '1', 'max' => '4', 'required' => 'required'])); ?>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

            <div class="table-responsive">

                <table id="beds" class="table table-bordered">

                    <thead class="bg-secondary text-light">

                        <tr>

                            <th>Description</th>
                            <th>Persons Fit</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__currentLoopData = \App\Models\Bed::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td><?php echo e(ucfirst($bed->desc)); ?></td>
                                <td><?php echo e($bed->persons_fit); ?></td>
                                <td class="px-2" >

                                    <button data-toggle="modal" data-target="#editbed-<?php echo e($bed->id); ?>" class="btn btn-sm btn-info">Edit</button>
                                    <button data-toggle="modal" data-target="#deletebed-<?php echo e($bed->id); ?>" class="btn btn-sm btn-danger">Delete</button>

                                    <div class="modal fade" id="editbed-<?php echo e($bed->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Bed <?php echo e(ucfirst($bed->desc)); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span class="text-white" aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <?php echo Form::open(['url' => '/bedupdate']); ?>

        
                                                    <?php echo e(Form::hidden('id', $bed->id)); ?>

                                                                                    
                                                    <div class="form-group px-2">
        
                                                        <label for=""><b>Description</b></label>
                                                        <?php echo e(Form::text('desc', $bed->desc, ['class' => "form-control", 'required' => 'required', 'minlength' => '3', 'maxlength' => '50'])); ?>

                                
                                                    </div>

                                                    <div class="form-group px-2">

                                                        <label for=""><b>Persons Fit</b></label>
                                                        
                                                        <?php echo e(Form::number('persons_fit', $bed->persons_fit, ['class' => 'form-control', 'min' => '1', 'max' => '4', 'required' => 'required'])); ?>

                                
                                                    </div>
                                
                                                 
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-info">Save Changes</button>
                                                    </div>
                                
                                                    <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="modal fade" id="deletebed-<?php echo e($bed->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Bed <?php echo e(ucfirst($bed->desc)); ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php echo Form::open(['url' => '/beddelete']); ?>

                                                                                
                                                <?php echo e(Form::hidden('id', $bed->id)); ?>

                
                                                <b class="my-3">You sure you want to delete <?php echo e(ucfirst($bed->desc)); ?>?</b>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                </div>
                            
                                                <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        </div>
    
                                </td>

                               

                            </tr>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>
            
        <?php else: ?>
            
            <div class="text center">

                <h3>No Beds yet.. add one.</h3>

                
            <button data-toggle="modal" data-target="#createbed" class="btn btn-sm btn-outline-success p-1 ml-2" style="font-size: 1rem;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a Bed</button>

            <div class="modal fade" id="createbed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Bed</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo Form::open(['url' => '/bedstore']); ?>                                                                        

                    <div class="form-group px-2">

                        <label for=""><b>Description</b></label>
                        <?php echo e(Form::text('desc', '', ['class' => "form-control", 'placeholder' => 'Bed Description', 'required' => 'required', 'minlength' => '3', 'maxlength' => '25'])); ?>


                    </div>

                    <div class="form-group px-2">

                        <label for=""><b>Persons Fit</b></label>
                        
                        <?php echo e(Form::number('persons_fit', 1, ['class' => 'form-control', 'min' => '1', 'max' => '4', 'required' => 'required'])); ?>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

            </div>

            <hr>
            
        <?php endif; ?>

    </div>

</div>

<script>

$(document).ready(function() {
    $('#roomtypes').DataTable();      
    $('#rooms').DataTable();      
    $('#features').DataTable();      
    $('#beds').DataTable();      

    $('.selectpicker').selectpicker('refresh');
});

window.onload = (event) => {
    $('.selectpicker').selectpicker('refresh');
};


let showButton = document.getElementById('showButton');
let featuresAndBedsPanel = document.getElementById('featuresAndBedsPanel');

function togglePanel(){

    if(featuresAndBedsPanel.classList.contains('d-none')){        

        featuresAndBedsPanel.classList.remove('d-none');
        showButton.textContent = "HIDE ROOM FEATURES AND BED TYPES";

    } else {

        featuresAndBedsPanel.classList.add('d-none');
        showButton.textContent = "SHOW ROOM FEATURES AND BED TYPES";

    }

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
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/rooms/view.blade.php ENDPATH**/ ?>