<?php
defined('_JEXEC') or die;
JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');
$images = JFolder::files(JPATH_ROOT . '/images/slider/', '.', false, false, array('.svn', 'CVS','.DS_Store','__MACOSX'), array('^\..*','.*~'));
?>

<div id="owl-demo" class="owl-carousel owl-theme">
    <?php foreach($images as $image): ?>
        <div class="item"><img src="<?= JUri::base(true); ?>/images/slider/<?= htmlspecialchars($image)?>"></div>
    <?php endforeach ?>
</div>