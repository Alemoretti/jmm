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
$this -> state -> set('filter.database',JRequest::getVar('dbname'));
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
?>
<form action="index.php?option=com_jmm&amp;view=templates" method="post" id="adminForm" name="adminForm">
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
</div>
<div class="clearfix"> </div>
<table class="table table-bordered table-hover">
		<thead>
			<tr>
				
				<th>
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)"/>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort','ID','id',$orderDirn,$listOrder);?>
				</th>
    			<th>
					<?php echo JHtml::_('grid.sort','Title','title',$orderDirn,$listOrder);?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort','Date Time','datetime',$orderDirn,$listOrder);?>
				</th>	
				<th>
					<?php echo JHtml::_('grid.sort','Status','published',$orderDirn,$listOrder);?>
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
					<td class="center">
						<?php echo $this->escape($item->datetime);?>
					</td>
					<td class="center">
						<?php 
						echo JHtml::_('jgrid.published',$item->published,'sitetable',true,'cb');
						?>
					</td>
				</tr>
				
			<?php endforeach?>
		</tbody>
			<tfoot>
			<tr>
				<td colspan="5">
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