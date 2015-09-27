<?php defined('_JEXEC') or die('Restricted access');

/**
 * General Controller of KampInfo component.
 */
class KampInfoImExportController extends JControllerLegacy {

	/**
	 * 
	 * @param string $cachable
	 * @param string $urlparams
	 * @return boolean|KampInfoController
	 */
	function display($cachable = false, $urlparams = false) {
		$submenu = JRequest::getCmd('view', 'info');
		
		JSubMenuHelper::addEntry("Info", 'index.php?option=com_kampinfoimexport&view=info', $submenu == 'info');
		JSubMenuHelper::addEntry("Export", 'index.php?option=com_kampinfoimexport&view=export', $submenu == 'export');
		JSubMenuHelper::addEntry("Import", 'index.php?option=com_kampinfoimexport&view=import', $submenu == 'import');
		
		$input = JFactory::getApplication()->input;
		$input->set('view', $submenu);
		
		// call parent behavior
		parent::display($cachable);

		return $this;
	}
}
