<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * HIT Site Table class
*/
class KampInfoImExportTableHitSite extends JTable {

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct('#__kampinfo_hitsite', 'id', $db);
	}
}