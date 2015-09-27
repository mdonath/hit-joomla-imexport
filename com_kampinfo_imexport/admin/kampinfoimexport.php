<?php defined('_JEXEC') or die('Restricted access');

$controller	= JControllerLegacy::getInstance('KampInfoImExport');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
