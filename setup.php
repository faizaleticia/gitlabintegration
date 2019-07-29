<?php


function plugin_init_gitlabintegration() {

	global $PLUGIN_HOOKS,$CFG_GLPI;

	// CSRF compliance : All actions must be done via POST and forms closed by Html::closeForm();
	$PLUGIN_HOOKS['csrf_compliant']['gitlabintegration'] = true;

 
	$PLUGIN_HOOKS['pre_item_form']['gitlabintegration']    = ['PluginExampleItemForm', 'preItemForm'];
	$PLUGIN_HOOKS['post_item_form']['gitlabintegration']   = ['PluginExampleItemForm', 'postItemForm'];
 
	// declare this plugin as an import plugin for Computer itemtype
	$PLUGIN_HOOKS['import_item']['gitlabintegration'] = ['Computer' => ['Plugin']];
 
	// add additional informations on Computer::showForm
	$PLUGIN_HOOKS['autoinventory_information']['gitlabintegration'] =  [
	   'Computer' =>  ['PluginExampleComputer', 'showInfo']
	];
}


function plugin_version_gitlabintegration(){
	global $DB, $LANG;

	return array('name'			  => __('Gitlab Integration','gitlabintegration'),
			     'version' 		  => '0.0.1',
				 'author'		  => 'Fáiza Letícia Schoeninger',
				 'license'		  => 'GPLv3+',
				 'homepage'		  => 'https://stwautomacao.com.br',
				 'minGlpiVersion' => '9.4'
	);
}


function plugin_gitlabintegration_check_prerequisites(){
     if (GLPI_VERSION >= 9.4){
         return true;
     } else {
         echo "GLPI version NOT compatible. Requires GLPI >= 9.4";
     }
}


function plugin_gitlabintegration_check_config($verbose=false){
	if ($verbose) {
		echo 'Installed / not configured';
	}
	return true;
}


?>
