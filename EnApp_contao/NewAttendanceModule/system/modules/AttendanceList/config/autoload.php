<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\ModuleAttendanceList'   => 'system/modules/AttendanceList/modules/ModuleAttendanceList.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_attendance'   => 'system/modules/AttendanceList/templates',
));
