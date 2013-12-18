<?php
 
 
/**
 * Table tl_attendance
 */
$GLOBALS['TL_DCA']['tl_attendance'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
	),
// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('memberName'),
			'flag'        => 1,
			'panelLayout' => 'filter;sort,search,limit'
		),

'label'             => array
		(
			'fields' => array('memberName'),
			'format' => '%s',
		),
'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
'operations'        => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_attendance']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_attendance']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_attendance']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
		)
	),
// Palettes
	'palettes' => array
	(
		'default'       => '{memberName_legend},memberName,{attendance_legend},attendance'
),
// Fields
	'fields'   => array
	(
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'memberID' => array
		(
			'sql' => "int(10)"
		),
		'memberName'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_attendance']['memberName'],
			'inputType' => 'text',
			'exclude'   => true,
			'sorting'   => true,
			'flag'      => 1,
                        'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => true,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255)"
		),
                'membergroup'    => array
		(
			'sql' => "int(10)"
		),
		'attendance' 	=> array
		(
			'label'         => &$GLOBALS['TL_LANG']['tl_attendance']['attendance'],
			'inputType' => 'text',
			'exclude'     => true,
			'sql'            => "text NULL"
		),
		'date'    => array
		(
			'sql' => "datetime"
		)
       )
);
