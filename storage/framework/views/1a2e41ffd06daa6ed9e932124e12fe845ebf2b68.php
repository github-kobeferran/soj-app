<nav id="system-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
        <img src="<?php echo e(url('storage/images/system/logo/logo.png')); ?>" style="width: 200px !important; height: auto !important;" alt="" class="img-fluid">
    </a>
  

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
   

    <div class="collapse navbar-collapse justify-content-around" id="navbarsExample08">
       
        <ul class="navbar-nav ">

            <li class="nav-item ">    
                <a class="nav-link" href="<?php echo e(route('home')); ?>"><?php echo e(__('Home,')); ?></a>
            </li>
            <li class="nav-item">    
                <a class="nav-link" href="<?php echo e(route('dishes.clientview')); ?>"><?php echo e(__('Restaurant,')); ?></a>
            </li>
            <li class="nav-item mr-4">    
                <a class="nav-link" href="<?php echo e(route('roomtypes.clientview')); ?>"><?php echo e(__('Hotel.')); ?></a>
            </li>

            

            <?php if(auth()->guard()->guest()): ?>
                <?php if(Route::has('login')): ?>
                    <li class="nav-item">
                        <a class="nav-link ml-2" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                    </li>
                <?php endif; ?>

                <?php if(Route::has('register')): ?>
                    <li class="nav-item">    
                        <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?php echo e(Auth::user()->name); ?>

                    </a>

                    <div class="dropdown-menu dropdown-menu-right" style="font-family: 'Open Sans', sans-serif !important;"  aria-labelledby="navbarDropdown">

                        <?php if(auth()->user()->isAdmin()): ?>

                            <a class="dropdown-item" href="/admin">
                                Admin Dashboard
                            </a>
                            <a class="dropdown-item" href="/clients">
                                Clients
                            </a>
                            <a class="dropdown-item" href="/dishes">
                                Dishes
                            </a>
                            <a class="dropdown-item" href="/rooms">
                                Rooms
                            </a>
                            
                        <?php else: ?>

                            <a class="dropdown-item" href="/profile">
                                My Profile
                            </a>
                            
                        <?php endif; ?>

                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </li>
            <?php endif; ?>                        

        </ul>

        
    </div>
</nav>

<?php /**PATH D:\wamp64\www\soj-app\resources\views/inc/navbar.blade.php ENDPATH**/ ?>