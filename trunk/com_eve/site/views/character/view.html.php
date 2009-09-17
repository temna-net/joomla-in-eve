<?php

/**
 * @version		$Id$
 * @author		Pavol Kovalik
 * @package		Joomla! in EVE
 * @subpackage	Community Builder - Character Sheet
 * @copyright	Copyright (C) 2009 Pavol Kovalik. All rights reserved.
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

class EveViewCharacter extends JView 
{
	public function display($tpl = null)
	{
		$model = $this->getModel();
		$params = $this->get('Params');
		$character = $this->get('Character');
		
		$this->assignRef('character', $character);
		$this->assignRef('params', $params);
		
		parent::display();
		$this->_setPathway();
	}
	
	protected function _setPathway()
	{
		$app = JFactory::getApplication();
		$pathway = $app->getPathway();
		if (JRequest::getInt('allianceID') > 0) {
			$pathway->setItemName(0, $this->character->allianceName);
			$pathway->addItem($this->character->corporationName, 
				JRoute::_('index.php?option=com_eve&view=corporation&corporationID='.$this->character->corporationID.':'.$this->character->corporationName));
			$pathway->addItem($this->character->name);
		} elseif (JRequest::getInt('characterID') > 0) {
			$pathway->setItemName(0, $this->character->corporationName);
			$pathway->addItem($this->character->name);
		} else {
			$pathway->setItemName(0, $this->character->ame);
		}
		//JPathwaySite::addItem()
	}
}