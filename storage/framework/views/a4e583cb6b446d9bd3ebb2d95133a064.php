<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
<?php $__env->startComponent('telescope-toolbar::item', ['name' => 'models', 'link' => true]); ?>

    <?php $__env->slot('icon'); ?>
        <?php echo file_get_contents('C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\resources\icons/' . basename('models') . '.svg'); ?>

        <span class="sf-toolbar-value"><?php echo e($entries->count()); ?></span>

    <?php $__env->endSlot(); ?>

    <?php $__env->slot('text'); ?>

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">

                <thead>
                <tr>
                    <th>Action</th>
                    <th>Model</th>
                </tr>
                </thead>

                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td>
                            <?php echo e($entry->content['action']); ?>

                        </td>

                        <td>
                            <a href="<?php echo e(route('telescope')); ?>/models/<?php echo e($entry->id); ?>" target="_telescope">
                                <?php echo e($entry->content['model']); ?>

                            </a>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>

            </table>
        </div>

    <?php $__env->endSlot(); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\src/../resources/views/collectors/models.blade.php ENDPATH**/ ?>