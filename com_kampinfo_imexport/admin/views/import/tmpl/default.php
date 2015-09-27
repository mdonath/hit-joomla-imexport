<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

?>


<div id="j-main-container" class="span10">

<form	action="<?php echo JRoute::_('index.php?option=com_kampinfoimexport&view=import'); ?>"
		enctype="multipart/form-data" 
		method="post"
		name="adminForm"
		id="adminForm"
>
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Importeer totale json-export'); ?></legend>
			<ul class="adminformlist">
				<li><label>Kies een JSON export</label><input type="file" name="import_file" /></li>
				<li>
					<label></label><input class="button" type="submit" value="<?php echo JText::_('Importeer alles'); ?>" />
				</li>
		</ul>
		</fieldset>
	</div>
	
	<div>
		<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />
		<input type="hidden" name="task" value="import.importAlles" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>
</div>
