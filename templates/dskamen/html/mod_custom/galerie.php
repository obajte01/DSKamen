<?php
defined('_JEXEC') or die;

JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');
$images = JFolder::files(JPATH_ROOT . '/images/galerie/', '.', false, false, array('.svn', 'CVS','.DS_Store','__MACOSX'), array('^\..*','.*~'));
?>
<div class="row">
    <div class="col-xs-12">
        <hr>
        <h1 id="projekty">Dokončené projekty</h1>
        <div id="realization-photos" class="realization-photos">
            <div class="fotorama" data-nav="thumbs" data-autoplay="true" data-loop="true" data-allowfullscreen="native" data-keyboard="true">
                <?php foreach($images as $image): ?>
                    <img src="<?= JUri::base(true); ?>/images/galerie/<?= htmlspecialchars($image)?>">
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
