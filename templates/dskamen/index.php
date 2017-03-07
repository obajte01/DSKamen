<?php
defined('_JEXEC') or die;

// include config
include_once(dirname(__FILE__) . '/config.php');

$headerdata = JFactory::getDocument()->getHeadData();



?>
<!DOCTYPE html>
<html lang="<?= $this->language ?>">
<head>
    <jdoc:include type="head"/>
    <link rel="shortcut icon" href="<?= $this->baseurl ?>/templates/dskamen/images/icons/favicon.ico"/>
    <link rel="icon" type="image/png" href="<?= $this->baseurl ?>/templates/dskamen/images/icons/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?= JUri::base(true); ?>/media/jui/js/html5.js"></script>
    <![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($params->get('google-site-verification')): ?>
        <meta name="google-site-verification"
              content="<?= htmlspecialchars($params->get('google-site-verification'), ENT_QUOTES); ?>"/>
    <?php endif; ?>
</head>
<body class="site <?php
echo $option
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($pageclass ? $pageclass : '')
    . ($bodyClass ? ' ' . $bodyClass : '')
?>">
<header>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a href="index.php" class="logo"><img src="<?= $this->baseurl ?>/templates/dskamen/images/logo/logo.png"></a>
            </div>
            <?php if ($this->countModules('menu')) : ?>
                <div class="col-xs-12 col-sm-8">
                    <nav>
                        <jdoc:include type="modules" name="menu" style="xhtml"/>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="triangle hidden-xs"></div>
</header>
<main>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php if ($this->countModules('slider')) : ?>
                <div class="col-xs-12 box-shadow">
                    <jdoc:include type="modules" name="slider" style="xhtml"/>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php if ($this->countModules('content')) : ?>
                <jdoc:include type="modules" name="content" style="xhtml"/>
            <?php endif; ?>
            <?php if ($this->countModules('sluzby')) : ?>
                <jdoc:include type="modules" name="sluzby" style="xhtml"/>
            <?php endif; ?>
            <?php if ($this->countModules('galerie')) : ?>
                <jdoc:include type="modules" name="galerie" style="xhtml"/>
            <?php endif; ?>
        </div>
    </div>
</main>
<footer id="kontakty">
    <div class="triangle-footer"></div>
    <div class="footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="footer-adress">
                        <span class="footer-adress-icon">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                        </span>
                        <span class="footer-adress-text">
                            <h3>Sídlo firmy</h3>
                            <h4>Kolbenova 762/6</h4>
                            <h4>Praha 9, Vysočany</h4>
                            <h4>190 00</h4>
                        </span>
                    </div>

                    <div class="footer-adress">
                        <span class="footer-adress-icon">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                        <span class="footer-adress-text">
                            <h3>Kontakty</h3>
                            <h4>Ivo Dundáček, DiS.</h4>
                            <h5>dundacek@dskamen.cz</h5>
                            <h5>+420 722 906 070</h5>
                            <h4>Oldřich Sobotka</h4>
                            <h5>sobotka@dskamen.cz</h5>
                            <h5>+420 721 292 329</h5>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="contact-form">
                        <h3>Napište nám</h3>
                       <!-- <form method="post" action="index.php">
                            <input type="text" class="" id="email" placeholder="Jméno">
                            <input type="email" class="" id="email" placeholder="*Email" required>
                            <input type="tel" class="" id="telephone" placeholder="Telefon">
                            <textarea rows="5" placeholder="*Zpráva" id="message" name="message" required></textarea>
                            <button type="submit" class="btn btn-default col-xs-12 col-sm-6 col-sm-offset-3">Odeslat
                            </button>
                        </form> -->

                        <?php if ($this->countModules('kontakt')) : ?>
                            <jdoc:include type="modules" name="kontakt" style="xhtml"/>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="copyright">
                <div class="row">
                    <div class="col-xs-8"><span>&copy 2017 DSKamen</span></div>
                    <div class="col-xs-4">
                        <div class="text-right">
                            <a href="https://www.facebook.com/DSKAMEN" target="_blank"><i class="fa fa-facebook-square"></i></a>
                            <a href="https://www.instagram.com/ds.kamen/" target="_blank"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>