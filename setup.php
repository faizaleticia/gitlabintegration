<?php


function plugin_init_gitlabintegration() {

	global $PLUGIN_HOOKS, $CFG_GLPI;

	include_once (GLPI_ROOT . "/plugins/gitlabintegration/inc/itemform.class.php");
		
	// CSRF compliance : All actions must be done via POST and forms closed by Html::closeForm();
	$PLUGIN_HOOKS['csrf_compliant']['gitlabintegration'] = true;

	if (class_exists('PluginGitlabIntegrationItemForm')) {
		$PLUGIN_HOOKS['pre_item_form']['gitlabintegration']    = ['PluginGitlabIntegrationItemForm', 'preItemForm'];
		$PLUGIN_HOOKS['post_item_form']['gitlabintegration']   = ['PluginGitlabIntegrationItemForm', 'postItemForm'];
	}
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
