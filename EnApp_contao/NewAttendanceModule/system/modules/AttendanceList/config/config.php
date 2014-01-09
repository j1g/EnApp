<?php
 
/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['AttendanceList'] = array(
	'tables' => array('tl_attendance'),
	'icon'   => 'system/modules/AttendanceList/assets/images/attendance_list.png'
);



$GLOBALS['FE_MOD']['AttendanceList'] = array
(
	'coursegroup_list'     => 'ModuleAttendanceList',
);
