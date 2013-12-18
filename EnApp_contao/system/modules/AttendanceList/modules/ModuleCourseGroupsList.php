<?php 
namespace attendance;
if (!defined('TL_ROOT')) die('You can not access this file directly!');
class ModuleCourseGroupsList extends \Module
{
	protected $strTemplate = 'mod_group_list';
	protected function compile()
	{
		$groups = $this->Database->execute("SELECT * FROM tl_member_group");
	 	$this->Template->attendancegroups = $groups->fetchAllAssoc();

	}
}
?>
