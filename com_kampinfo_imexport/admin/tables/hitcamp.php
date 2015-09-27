<?php defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * HIT Camp Table class.
 */
class KampInfoImExportTableHitCamp extends JTable {

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct('#__kampinfo_hitcamp', 'id', $db);
	}

}