<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
*/
class KampInfoImExportViewExport extends JView
{
	function display($tpl = null) {
		$document = JFactory::getDocument();
		$document->setMimeEncoding('application/json');

		// JResponse::setHeader('Content-Disposition','attachment;filename="export.json"');
		
		$jinput = JFactory::getApplication()->input;
		$jaar = $jinput->get('jaar', null, 'INT');
		
		echo json_encode($this->export($jaar), JSON_PRETTY_PRINT);
	}

	function export($jaar = null) {
		$db = JFactory::getDbo();

		$hit = new stdClass();

		$where = ($jaar == null) ? '1=1' : ('jaar=' . (int) $jaar); 
		$hit->projects = $this->loadData($db, 'hitproject', $where, 'jaar');

		// Haal plaatsen op per project
		foreach ($hit->projects as $project) {
			$project->plaatsen = $this->loadData($db, 'hitsite', 'hitproject_id = '.$project->id, 'naam');
			foreach ($project->plaatsen as $plaats) {
				$plaats->kampen = $this->loadData($db, 'hitcamp', 'hitsite_id ='.$plaats->id, 'naam');
			}
		}
		return $hit;
	}

	function loadData($db, $table, $where, $order) {
		$query = $db
		->getQuery(true)
		->select('*')
		->from($db->quoteName('#__kampinfo_'.$table))
		->where($where)
		->order($order .' ASC')
		;

		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
