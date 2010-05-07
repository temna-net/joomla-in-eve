<?php
/**
 * @version		$Id$
 * @author		Pavol Kovalik
 * @package		Joomla! in EVE
 * @subpackage	Asset List
 * @copyright	Copyright (C) 2008 Pavol Kovalik. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/licenses/gpl.html
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class EveassetlistViewEveassetlist extends JView {
	function display($tmpl = null) {
		JHTML::stylesheet('assetlist.css', 'administrator/components/com_eveassetlist/assets/');
		
		$title = JText::_('Com_Eveassetlist_Eve_Asset_List_Title');
		JToolBarHelper::title($title, 'assets');
		//JToolBarHelper::preferences('com_eveassetlist', 480, 640);

		parent::display($tmpl);
	}
}
