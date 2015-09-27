<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

function loadData($db, $table, $where, $order) {
	$query = $db
		->getQuery(true)
		->select('*')
		->from($db->quoteName('#__kampinfo_'.$table))
		->where($where)
		->order($order .' ASC')
	;
	
	$db->setQuery($query);
	
	$result = $db->loadObjectList();
	return $result;
}

$db = JFactory::getDbo();

$hit = new stdClass();

$hit->projects = loadData($db, 'hitproject', '1=1', 'jaar');

// Haal plaatsen op per project
foreach ($hit->projects as $project) {
	$project->plaatsen = loadData($db, 'hitsite', 'hitproject_id = '.$project->id, 'naam');
	foreach ($project->plaatsen as $plaats) {
		$plaats->kampen = loadData($db, 'hitcamp', 'hitsite_id ='.$plaats->id, 'naam');
	}
}
?>


<div id="j-main-container" class="span10">

	<table class="adminlist">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Export</th>
				<th>Inhoud</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
			<tr>
				<td>Alles</td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_kampinfoimexport&view=export&format=json'); ?>">Export JSON</a></td>
				<td>&nbsp;</td>
			</tr>
			<?php foreach ($hit->projects as $project) { ?>
				<tr>
					<td><?php echo $project->jaar;?></td>
					<td>
						<a href="<?php echo JRoute::_('index.php?option=com_kampinfoimexport&view=export&format=json&jaar='.$project->jaar); ?>">Export JSON</a>
					</td>
					<td>
						<table>
							<?php foreach ($project->plaatsen as $plaats) { ?>
								<tr>
									<td><?php echo $plaats->naam;?></td>
									<td>Aantal kampen: <?php echo count($plaats->kampen);?></td>
								</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
