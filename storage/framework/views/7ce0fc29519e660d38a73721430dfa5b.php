<div class="sf-toolbar-block sf-toolbar-block-<?php echo e($name); ?> sf-toolbar-status-<?php echo e($status ?? 'normal'); ?> <?php echo e($additional_classes ?? ''); ?>" <?php echo $block_attrs ?? ''; ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($link) && $link): ?>
        <?php
            $ttLink = route('telescope-toolbar.show', ['token' => $token, 'tab' => $name]);
            if ($link === true) {
                $link = $ttLink;
            } elseif (\Illuminate\Support\Str::startsWith($link, '#')) {
                $link = $ttLink . $link;
            }
        ?>
        <a href="<?php echo e($link); ?>" <?php echo e(config('telescope-toolbar.new_tab') ? 'target="_blank"' : ''); ?>>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="sf-toolbar-icon"><?php echo e($icon ?? ''); ?></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($link) && $link): ?></a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="sf-toolbar-info"><?php echo e($text ?? ''); ?></div>
</div>
<?php /**PATH C:\laragon\www\ainet-main\vendor\fruitcake\laravel-telescope-toolbar\src/../resources/views/item.blade.php ENDPATH**/ ?>