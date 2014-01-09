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
		'onsubmit_callback' => array 
        ( 
            array('tl_content_attendance', 'createFile') 
        )
	),
// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('title'),
			'flag'        => 1,
			'panelLayout' => 'filter;sort,search,limit'
		),

'label'             => array
		(
			'fields' => array('title'),
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
		'default'       => '{memberName_legend},title,file_name,groupp,script'
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
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_attendance']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		
		'file_name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_attendance']['file_name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			
			'eval'                    => array('mandatory'=>true,'rte'=>'tinyMCE', 'maxlength'=>128),
			'sql'                     => "text NULL"
		),
		
		'groupp' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_attendance']['groupp'],
				'exclude'                 => true,
				'inputType'               => 'radio',
				'foreignKey'              => 'tl_member_group.name',
				'eval'                    => array('multiple'=>true, 'mandatory'=>true),
				'sql'                     => "blob NOT NULL"
		   ),
		   
		   'script' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_attendance']['script'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>512, 'mandatory'=>false),
			'save_callback' 	      => array (array('tl_content_attendance', 'editScript')),
			'sql'                     => "text NULL"
		),
       )
);

class tl_content_attendance extends Backend
{
//install this extension (associategroups) to have a table tl_member_to_group

    public function editScript(){
		$objModule = $this->Database->prepare("SELECT * FROM tl_attendance ORDER BY id DESC LIMIT 1")->execute();
		$script = $objModule->script;
		$id = $objModule->id;
		$file = TL_ROOT . "/files/Attendance/Scripts/" . $objModule->file_name . ".php";
		//$file = "/C:/xampp/htdocs/contao2/files/Attendance/Scripts/" . $objModule->file_name . ".php";
		$script = "<form action=\"" . $file . "\" method=\"post\"><input type=\"submit\" value=\"See the attendance list\"></form>";
		$obj2 = $this->Database->prepare("UPDATE tl_attendance SET script = '" . $script . "' WHERE id = " . $id)->execute();
	
	}
	
	public function createFile(DataContainer $dc)
	{
		$file = $dc->activeRecord->file_name;
		
		if (!file_exists(TL_ROOT . "/files/Attendance/")) {		
			  mkdir(TL_ROOT . "/files/Attendance/");
		}
		
		$fileName = TL_ROOT . "/files/Attendance/" . $file . ".csv";
		if (!file_exists($fileName)){
			$ourFileHandle = fopen($fileName, 'w');
			$objModule = $this->Database->prepare("SELECT * FROM tl_member_to_group WHERE group_id=".$dc->activeRecord->groupp)->execute();

			$data = array();
			array_push($data,array("Name"));
			
			while($objModule->next()){
				$result = $this->Database->prepare("SELECT * FROM tl_member WHERE id=".$objModule->member_id)->execute();
				$name = $result->firstname . " " . $result->lastname;
				array_push($data,array($name));
			}
			
			foreach ($data as $fields) {
			        $fields = str_replace('"', '', $fields);
					fputcsv($ourFileHandle, $fields, ',');
			}
			
			fclose($ourFileHandle);
			
			
			//$list = list($first_part, $second_part) = explode('.', $file);
			$filePhp = TL_ROOT . "/files/Attendance/Scripts/" . $file . ".php";
			
			$handlerWrite = fopen($filePhp, 'w');
			$handlerRead = fopen(TL_ROOT . '/files/Attendance/Scripts/attend.php', 'r');
			
			while (($line = fgets($handlerRead)) != false) {

				if (strpos($line, '$file_name = ') !== FALSE) {
				    $newCSVfileName = $fileName;
					$line = '$file_name = "' . $newCSVfileName . '";'; 
				}
				fwrite($handlerWrite, $line);	
			}
			
			fclose($handlerWrite);
			fclose($handlerRead);
			
			//
		}
	
	}
	
}
