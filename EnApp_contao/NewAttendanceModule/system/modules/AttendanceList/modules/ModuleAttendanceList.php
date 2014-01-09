<?php 
namespace Contao;
if (!defined('TL_ROOT')) die('You can not access this file directly!');
class ModuleAttendanceList extends \Module
{
	protected $strTemplate = 'mod_attendance';
	// Generate the module
	protected function compile()
	{
		$groups = $this->Database->execute("SELECT * FROM tl_attendance");
	 	$this->Template->attendancegroups = $groups->fetchAllAssoc();
		
	}
}
?>
