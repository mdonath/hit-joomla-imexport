<?php defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modeladmin');
jimport('joomla.filesystem.file');
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

/**
 * Import Model.
*/
class KampInfoImExportModelImport extends JModelAdmin {

	public function getForm($data = array(), $loadData = true) {
		$result = self::loadForm(
				'com_kampinfoimexport.import'
				,	'import'
				,	array('control' => 'jform', 'load_data' => $loadData));
		return $result;
	}
	
	/**
	 * @return boolean
	 */
	public function importAlles() {
		
		$app = JFactory::getApplication();

		$jinput = $app->input;

		$file = self::getUploadedFile('import_file');

		if (!$file) {
			$app->enqueueMessage('Geen file geupload?!');
			return false;
		}
		$app->enqueueMessage('File: ' . $file);

		$this->importHit($file);
		
		$msg = "Zogenaamd ok... ;-)";
		$app->enqueueMessage($msg);

		return true;
	}
	
	protected function importHit($file) {
		$hit = json_decode(file_get_contents($file));
		$this->importProjecten($hit);
	}
	
	protected function importProjecten($hit) {
		foreach ($hit->projects as $project) {
			$this->importProject($project);
		}
	}
	
	protected function importProject($project) {
		$table = JTable::getInstance("hitproject", "KampInfoImExportTable");
		
		foreach ($project as $key => $value) {
			$table->$key = $value;
		}
		
		$table->id = null;
		$table->store();
		$project->id = $table->id;
		
		$this->importPlaatsen($project);
	}
	
	protected function importPlaatsen($project) {
		foreach ($project->plaatsen as $plaats) {
			$plaats->hitproject_id = $project->id;
			$this->importPlaats($plaats);
		}
	}
	
	protected function importPlaats($plaats) {
		$table = JTable::getInstance("hitsite", "KampInfoImExportTable");
		
		foreach ($plaats as $key => $value) {
			$table->$key = $value;
		}
		
		$table->id = null;
		$table->asset_id = null;
		$table->store();
		$plaats->id = $table->id;
		
		$this->importKampen($plaats);
	}
	
	protected function importKampen($plaats) {
		foreach ($plaats->kampen as $kamp) {
			$kamp->hitsite_id = $plaats->id;
			$this->importKamp($kamp);
		}
	}
	
	protected function importKamp($kamp) {
		$table = JTable::getInstance("hitcamp", "KampInfoImExportTable");
		
		foreach ($kamp as $key => $value) {
			$table->$key = $value;
		}
		
		$table->id = null;
		$table->asset_id = null;
		$table->store();
		$kamp->id = $table->id;
	}

	protected function getUploadedFile($fieldname) {
		$app = JFactory::getApplication();

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			$app->enqueueMessage(JText::_('file upload staat niet aan in configuratie'));
			return false;
		}

		$jFileInput = new JInput($_FILES);
		$uploadedFile = $jFileInput->get($fieldname, null, 'array');

		// If there is no uploaded file, we have a problem...
		if (!is_array($uploadedFile)) {
			JError::raiseWarning('', 'No file was selected.');
			return false;
		}


		// Build the appropriate paths
		$tmp_path	= JFactory::getConfig()->get('tmp_path');
		$tmp_src	= $uploadedFile['tmp_name'];
		$tmp_dest	= $tmp_path . '/' . $uploadedFile['name'];

		// Move uploaded file
		if (JFile::upload($tmp_src, $tmp_dest) != 1) {
			return false;
		}

		return $tmp_dest;
	}

}
