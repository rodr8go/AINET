<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

$memory = $data['memory'] ?? null;
if (!$memory) {
    return;
}

$statusColor = null;
if ($memory > 50) {
    $statusColor = 'yellow';
} elseif ($memory > 10) {
    $memory = round($memory);
}
?>

<?php $__env->startComponent('telescope-toolbar::item', ['name' => 'memory', 'link' => true]); ?>

    <?php $__env->slot('icon'); ?>

        <?php echo file_get_contents('C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\resources\icons/' . basename('memory') . '.svg'); ?>

        <span class="sf-toolbar-value"><?php echo e($memory); ?></span>
        <span class="sf-toolbar-label">MB</span>
    <?php $__env->endSlot(); ?>

    <?php $__env->slot('text'); ?>

        <div class="sf-toolbar-info-piece">
            <b>Peak memory usage</b>
            <span><?php echo e($data['memory']); ?> MB</span>
        </div>

    <?php $__env->endSlot(); ?>


<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\src/../resources/views/collectors/memory.blade.php ENDPATH**/ ?>