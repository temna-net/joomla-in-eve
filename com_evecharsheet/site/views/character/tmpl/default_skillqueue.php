<?php
/**
 * @version		$Id$
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

?>
<div class="evecharsheet-skillqueue">
	<h3><?php echo JText::_('Skill Queue'); ?></h3>
	<table>
	<?php foreach ($this->queue as $skill): ?>
		<tr>
			<td>
				<?php echo $skill->queuePosition + 1; ?>
			</td>
			<td class="skill-label" title="<?php echo $skill->description; ?>" >
				<?php echo $skill->typeName; ?>
			</td>
			<td class="skill-level">
				<img src="<?php echo JURI::base(); ?>components/com_evecharsheet/assets/level<?php echo $skill->level; ?>.gif" border="0" alt="Level <?php echo $skill->level; ?>" title="<?php echo number_format($skill->endSP); ?>" />
			</td>
			<td>
				<?php echo JHTML::_('date', $skill->startTime, JText::_('DATE_FORMAT_LC2')); ?>
			</td>
			<td>
				<?php echo JHTML::_('date', $skill->endTime, JText::_('DATE_FORMAT_LC2')); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
