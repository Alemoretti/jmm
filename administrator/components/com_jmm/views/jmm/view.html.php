<?php
/**
 * @package		JMM
 * @link		http://adidac.github.com/jmm/index.html
 * @license		GNU/GPL
 * @copyright	Biswarup Adhikari
*/
defined('_JEXEC') or die('Restricted access');
class JMMViewJMM extends JViewLegacy
{

	
	function display($tmpl=null) 
	{
                
        JFactory::getApplication()->redirect('index.php?option=com_jmm&view=tables');
		parent::display($tmpl);
	}
	
}
