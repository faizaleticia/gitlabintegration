<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser();

// Modo: 1 = Insert 0 = Delete
$modo = (int)$_POST['modo'];

$profileId = (int)$_POST['profileId'];
$userId = (int)$_POST['userId'];
$id = (int)$_POST['id'];

//INSERT
if ($profileId) {
    if ($modo == 1) {
        $result = $DB->request('glpi_plugin_gitlab_profiles_users', ['profile_id' => [$profileId]]);    
        if ($result->count() > 0) {
            $erro = "[" . $_SESSION["glpi_currenttime"] . "] glpiphplog.ERROR: PluginGitlabIntegrationProfiles::permissions() in profile.php line 10" . PHP_EOL;
            $erro = $erro . "  ***PHP Notice: The selected profile already has permission: Profile Id: " . $profileId;
            PluginGitlabIntegrationEventLog::ErrorLog($erro);
    
            Session::addMessageAfterRedirect(__('The selected profile already has permission. Verify logs for more information!', 'gitlabintegration'));
        } else {
            $DB->insert(
                'glpi_plugin_gitlab_profiles_users', [
                    'profile_id' => $profileId,
                    'user_id'    => $userId,
                    'created_at' => $_SESSION["glpi_currenttime"]
                ]
            );
    
            PluginGitlabIntegrationEventLog::Log($profileId, 'profiles', $_SESSION["glpi_currenttime"], 'gitlab', 4, sprintf(__('%2s granted permission for profile ' . $profileId, 'gitlabintegration'), $_SESSION["glpiname"]));
    
            Session::addMessageAfterRedirect(__('Permission granted with successfully!', 'gitlabintegration'));
        } 
    }
}

//DELETE
if ($id) {
    if ($modo == 0) {
        $result = $DB->request('glpi_plugin_gitlab_profiles_users', ['id' => [$id]]);    
        if ($result->count() > 0) {
            $DB->delete(
                'glpi_plugin_gitlab_profiles_users', [
                    'id' => $id
                ]
            );

            PluginGitlabIntegrationEventLog::Log($id, 'profiles', $_SESSION["glpi_currenttime"], 'gitlab', 4, sprintf(__('%2s removed permission for id ' . $id, 'gitlabintegration'), $_SESSION["glpiname"]));
    
            Session::addMessageAfterRedirect(__('Permission removed with successfully!', 'gitlabintegration'));
        } else {
            $erro = "[" . $_SESSION["glpi_currenttime"] . "] glpiphplog.ERROR: PluginGitlabIntegrationProfiles::permissions() in profile.php line 10" . PHP_EOL;
            $erro = $erro . "  ***PHP Notice: The selected profile can't be deleted: Id: " . $id;
            PluginGitlabIntegrationEventLog::ErrorLog($erro);
    
            Session::addMessageAfterRedirect(__('The selected profile can not be deleted. Verify logs for more information!'));
        } 
    }   
}


