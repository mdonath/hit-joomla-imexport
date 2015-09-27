<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');


class KampInfoImExportControllerImport extends JControllerForm {

	public function importAlles() {
		$model = $this->getModel('import');

		$model->importAlles();

		$this->setRedirect(JRoute::_('index.php?option=com_kampinfoimexport&view=import', false));
		return true;
	}

}