<?php
defined('_JEXEC') or die;

header('X-UA-Compatible: IE=edge');

// Getting params from template
$pageclass  = '';
$app        = JFactory::getApplication();
$params     = $app->getTemplate(true)->params;
$doc        = JFactory::getDocument();
$seoHeader  = $params->get('seo_header');

$this->language = $doc->language;
$menu           = $app->getMenu()->getActive();

if ($menu):
    $pageclass = $menu->params->get('pageclass_sfx');
endif;

// Detecting Active Variables
$option             = $app->input->getCmd('option', '');
$view               = $app->input->getCmd('view', '');
$layout             = $app->input->getCmd('layout', '');
$task               = $app->input->getCmd('task', '');
$itemid             = $app->input->getCmd('Itemid', '');
$sitename           = JFactory::getConfig()->get('sitename', '');
$bodyClass          = $this->params->get('body_class');
$fluidMainContainer = $this->params->get('boxed_main_container', 0) ? null : '-fluid';
$contact_email      = $this->params->get('contact_email');

// Logo file or site title param
if ($this->params->get('logoFile')):
    $logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
else:
    $logo = '<span title="' . $sitename . '">' . $sitename . '</span>';
endif;

$showMessage = true;

// layout
$fluidContainer = $this->params->get('fluidContainer') ? '-fluid' : null;

// external
$doc->addStyleSheet('//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css');
$doc->addScript('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');

// styles & scripts
$doc->addStyleSheet(JUri::base(true) . '/templates/' . $this->template . '/css/index.css');
$doc->addStyleSheet(JUri::base(true) . '/templates/' . $this->template . '/css/flexbin.css');
$doc->addStyleSheet(JUri::base(true) . '/templates/' . $this->template . '/css/fotorama.css');
$doc->addScript(JUri::base(true) . '/templates/' . $this->template . '/js/owl.carousel.min.js');
$doc->addScript(JUri::base(true) . '/templates/' . $this->template . '/js/fotorama.js');
$doc->addScript(JUri::base(true) . '/templates/' . $this->template . '/js/basic.js');
