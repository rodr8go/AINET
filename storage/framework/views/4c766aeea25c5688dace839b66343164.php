<?php $__env->startComponent('telescope-toolbar::item', ['name' => 'config', 'additional_classes' => 'sf-toolbar-block-right']); ?>

    <?php $__env->slot('icon'); ?>

        <?php echo file_get_contents('C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\resources\icons/' . basename('laravel') . '.svg'); ?>

        <span class="sf-toolbar-value"><?php echo e(app()->version()); ?></span>

    <?php $__env->endSlot(); ?>

    <?php $__env->slot("text"); ?>
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>Environment</b>
                <span><?php echo e(app()->environment()); ?></span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Debug</b>
                <span class="sf-toolbar-status sf-toolbar-status-<?php echo e(config('app.debug') ? 'green' : 'red'); ?>"><?php echo e(config('app.debug') ? 'enabled' : 'disabled'); ?></span>
            </div>

            <div class="sf-toolbar-info-group">
                <div class="sf-toolbar-info-piece sf-toolbar-info-php">
                    <b>PHP version</b>
                    <span><?php echo e(phpversion()); ?></span>
                </div>
                <div class="sf-toolbar-info-piece sf-toolbar-info-php">
                    <b>Laravel version</b>
                    <span><?php echo e(app()->version()); ?></span>
                </div>
            </div>
        </div>

    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\src/../resources/views/collectors/config.blade.php ENDPATH**/ ?>