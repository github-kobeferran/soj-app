<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="row justify-content-left ml-3 py-2">

        <div class="col">

            <h1 class="heading">REGISTER</h1>

        </div>

    </div>

    <hr>

    <div class="row ml-2 justify-content-left">

        <div class="col ">

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>
    
                <div class="form-group row">
                    <label for="name" class="material-text col-md-4 col-form-label text-md-left"><?php echo e(__('Name')); ?></label>
    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control material-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>
    
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="email" class="material-text col-md-4 col-form-label text-md-left"><?php echo e(__('E-Mail Address')); ?></label>
    
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control material-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
    
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="password" class="material-text col-md-4 col-form-label text-md-left"><?php echo e(__('Password')); ?></label>
    
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control material-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password">
    
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="password-confirm" class="material-text col-md-4 col-form-label text-md-left"><?php echo e(__('Confirm Password')); ?></label>
    
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control material-input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
    
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-block material-input border-primary">
                            <?php echo e(__('Register')); ?>

                        </button>
                    </div>
                </div>
            </form>

        </div>

    </div>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\soj-app\resources\views/auth/register.blade.php ENDPATH**/ ?>