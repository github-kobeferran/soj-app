<?php $__env->startSection('content'); ?>

    <div id="homepage" class="vh-100 ">

        <div class="upper-panel">
            <div class="homepage-img text-center ">
                <img src="<?php echo e(url('storage/images/system/homepage/building.png')); ?>" alt="" class="img-fluid mx-auto" >    
            </div>
    
            <div class="brand-title text-center">
                Song of Joy Resort                
            </div>
            
        </div>
        <p class="text-center mt-2 w-75 mx-auto">
            Is located on sabang beach, Puerto Galera. Experience the wonders of the philippines, which offer relaxed and friendly asian vacation. At SOJ Dive and Beach Resort you will enjoy true Filipino hospitality in a beautiful tropical destination..
        </p>

        <hr>

        <div class="container text-center">

            <div class="row">

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="<?php echo e(url('storage/images/system/homepage/puerto.png')); ?>" alt="" class="learn-more-img">
                        <p class="mx-auto">
                            Puerto Galera
                        </p>
                        <a target="_blank" href="http://www.puertogalera.gov.ph/" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="<?php echo e(url('storage/images/system/homepage/building2.png')); ?>" alt="" class="learn-more-img">
                            <p class="mx-auto">
                                Resort
                            </p>
                            <a href="/hotel" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="<?php echo e(url('storage/images/system/homepage/restau.png')); ?>" alt="" class="learn-more-img">
                            <p class="mx-auto">
                                Restaurant
                            </p>

                            <a href="/restaurant" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

            </div>

        </div> 
        
        <div class="container">

            <footer class="footer">
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <p class="text-muted my-0 py-0">&#169; Capstone 1</p>
                            <p class="text-muted my-0 py-0">Precious Dalisay</p>
                            <p class="text-muted my-0 py-0">Camille Lopez</p>
                        </div>
                        <div class="col">
                            <p class="text-muted my-0 py-0">Song of Joy Resort, Sabang, Puerto Galera, MD 5203, Philippines</p>
                            <p class="text-muted my-0 py-0">Phone: 043-287-3136</p>
                        </div>
                    </div>
                </div>
              </footer>

        </div>

                
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/home.blade.php ENDPATH**/ ?>