<?php

function plugin_gitlabintegration_install(){
	
	global $DB;

	$config = new Config();
   	$config->setConfigurationValues('plugin:Gitlab Integration', ['configuration' => false]);

   	ProfileRight::addProfileRights(['gitlabintegration:read']);
	
	//instanciate migration with version
	$migration = new Migration(100);

	//Create table glpi_plugin_gitlab_integration only if it does not exists yet!
	if (!$DB->tableExists('glpi_plugin_gitlab_integration')) {
	    $query = "CREATE TABLE `glpi_plugin_gitlab_integration` (
				   `id` INT(11) NOT NULL AUTO_INCREMENT,
				   `ticket_id` INT(11) NOT NULL,
				   `gitlab_project_id` INT(11) NOT NULL,
				   PRIMARY KEY  (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	    $DB->queryOrDie($query, $DB->error());

	    $query = "ALTER TABLE `glpi_plugin_gitlab_integration` 
	                ADD CONSTRAINT `fk_gitlab_ticket` 
					FOREIGN KEY (`ticket_id`) REFERENCES `glpi_tickets` (`id`)";
	    $DB->queryOrDie($query, $DB->error());
	}
	// To be called for each task the plugin manage
   	// task in class
   	CronTask::Register('PluginExampleExample', 'Sample', DAY_TIMESTAMP, ['param' => 50]);
 
	return true;
}


function plugin_gitlabintegration_uninstall(){

	global $DB;
	
	$config = new Config();
	$config->deleteConfigurationValues('plugin:Gitlab Integration', ['configuration' => false]);

	ProfileRight::deleteProfileRights(['gitlabintegration:read']);

	$notif = new Notification();
	$options = ['itemtype' => 'Ticket',
				'event'    => 'plugin_gitlabintegration',
				'FIELDS'   => 'id'];
	foreach ($DB->request('glpi_notifications', $options) as $data) {
		$notif->delete($data);
	}

	$drop_count = "DROP TABLE glpi_plugin_gitlab_integration";
	$DB->query($drop_count); 	
	
	return true;
}


?>
