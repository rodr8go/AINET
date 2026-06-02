<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

$dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
$varCloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();

?>

<?php $__env->startComponent('telescope-toolbar::item', ['name' => 'dump', 'link' => false]); ?>

    <?php $__env->slot('icon'); ?>
        <?php echo file_get_contents('C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\resources\icons/' . basename('session') . '.svg'); ?>
        <span class="sf-toolbar-value sf-toolbar-info-piece-additional">Session</span>
    <?php $__env->endSlot(); ?>

    <?php $__env->slot('text'); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($data['session'])): ?>
        <div class="sf-toolbar-info-piece">
            <div class="sf-toolbar-dump">

               <?php echo $dumper->dump($varCloner->cloneVar($data['session'])); ?>


            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    <?php $__env->endSlot(); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\src/../resources/views/collectors/session.blade.php ENDPATH**/ ?>