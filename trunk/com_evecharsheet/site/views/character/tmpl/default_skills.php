<?php
/**
 * @version		$Id$
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>

<div class="evecharsheet-skills">
<h3><?php echo JText::_('Skills'); ?></h3>

<a class="expand-all-skills" href="#" title="<?php echo JText::_('Expand all skills'); ?>">
	<?php echo JText::_('Expand all skills'); ?>
</a> 
| 
<a class="collapse-all-skills" href="#" title="<?php echo JText::_('Collapse all skills'); ?>">
	<?php echo JText::_('Collapse all skills'); ?>
</a>


<?php foreach ($this->groups as $group): ?>
	<h4><?php echo $this->escape($group->groupName); ?></h4>
	<?php if ($group->skills): ?>
		<table class="skill-group">
		<?php foreach ($group->skills as $skill): ?>
			<tr>
				<td class="skill-label" title="<?php echo $skill->description; ?>" >
					<?php echo $skill->typeName; ?>
				</td>
				<td class="skill-level">
					<img src="<?php echo JURI::base(); ?>media/com_evecharsheet/images/level<?php echo $skill->level; ?>.gif" border="0" alt="Level <?php echo $skill->level; ?>" title="<?php echo number_format($skill->skillpoints); ?>" />
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<div>
			<?php echo JText::sprintf('%s skills trained for total of %s skillpoints', $group->skillCount, number_format($group->skillpoints)); ?><br />
			<?php echo JText::sprintf('Skill Cost %s', number_format($group->skillPrice)); ?>
		</div>
	<?php else: ?>
		<div class="skill-group">
		</div>
		<div>
			<?php echo JText::_('No skills in this category'); ?>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>