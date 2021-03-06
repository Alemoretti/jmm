<?php
/**
 * @package		JMM
 * @link		http://adidac.github.com/jmm/index.html
 * @license		GNU/GPL
 * @copyright	Biswarup Adhikari
*/
defined('_JEXEC') or die('Restricted access');
$listOrder=$this->escape($this->state->get('list.ordering'));
$orderDirn=$this->escape($this->state->get('list.direction'));
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="index.php?option=com_jmm&amp;view=sitetables" method="post" id="adminForm" name="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
<div id="filter-bar" class="btn-toolbar">
	<div class="btn-group pull-left">
	<div class="btn-wrapper input-append">
			<input type="text" name="filter_search" id="filter_search" 
			value="<?php echo $this->escape($this->state->get('filter.search'));?>" title="Search" />
			<input type="submit" class="btn" value="Search">
			<input type="button" class="btn search_clear_btn" onclick="document.getElementById('filter_search').value='';this.form.submit();" value="Clear">
		</div>
	</div>
	<div class="btn-group pull-right">
			<!--Filter Transactions By Recipients Starts-->
			<select name="filter_database" class="inputbox" onchange="this.form.submit()">
				<option value="">Select DataBase</option>
				<?php echo JHtml::_('select.options', $this -> databases, 'value', 'text', $this -> state -> get('filter.database'), true); ?>
			</select>
	</div>
</div>
<div class="clearfix"> </div>
<table class="table table-bordered table-hover sortTable">
		<thead>
			<tr>
				
				<th>
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)"/>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort','ID','st.id',$orderDirn,$listOrder);?>
				</th>
    			<th>
					<?php echo JHtml::_('grid.sort','Title','st.title',$orderDirn,$listOrder);?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort','DataBase','st.dbname',$orderDirn,$listOrder);?>
				</th>
    			<th>
					<?php echo JHtml::_('grid.sort','Query','st.query',$orderDirn,$listOrder);?>
				</th>				
    			<th>
					<?php echo JHtml::_('grid.sort','Access Level','vl.title',$orderDirn,$listOrder);?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort','Date Time','st.datetime',$orderDirn,$listOrder);?>
				</th>	
				<th>
					<?php echo JHtml::_('grid.sort','Status','st.published',$orderDirn,$listOrder);?>
				</th>
				<th>
					Export
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->items as $i => $item): ?>	
				
				<tr class="row<?php echo $i % 2?>" id="id<?php echo $i;?>">					
					<td class="center">
						<?php echo JHtml::_('grid.id',$i,$item->id);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->id);?>
					</td>
    				<td>
						<?php echo $item->title;?>
					</td>
					<td>
						<?php echo $this->escape($item->dbname);?>
					</td>
    				<td>
						<?php echo $this->escape($item->query);?>
					</td>
    				<td>
						<?php echo $item->access_level;?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->datetime);?>
					</td>
					<td class="center">
						<?php 
						echo JHtml::_('jgrid.published',$item->published,'sitetable',true,'cb');
						?>
					</td>
					<td class="center">
							<input type="button" class="btn btn-success" id="export_as_csv" value="Export as CSV">
					</td>
				</tr>
				
			<?php endforeach?>
		</tbody>
			<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter();?>
				</td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token');?>
</div>
</form>