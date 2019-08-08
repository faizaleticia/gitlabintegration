<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser();

$profileId = (int)$_POST['profileId'];
$userId = (int)$_POST['userId'];

if ($profileId) {
    $result = $DB->request('glpi_plugin_gitlab_profiles_users', ['profile_id' => [$profileId]]);

    if ($result->count() > 0) {
        $erro = "[" . $_SESSION["glpi_currenttime"] . "] glpiphplog.ERROR: PluginGitlabIntegrationProfiles::permissions() in profile.php line 10" . PHP_EOL;
        $erro = $erro . "  ***PHP Notice: The selected profile already has permission: Profile Id: " . $profileId;
        PluginGitlabIntegrationEventLog::ErrorLog($erro);

        Session::addMessageAfterRedirect(__('The selected profile already has permission. Verify logs for more information!'));
    } else {
        $DB->insert(
            'glpi_plugin_gitlab_profiles_users', [
                'profile_id' => $profileId,
                'user_id'    => $userId,
                'created_at' => $_SESSION["glpi_currenttime"]
            ]
        );

        PluginGitlabIntegrationEventLog::Log($profileId, 'profiles', $_SESSION["glpi_currenttime"], 'gitlab', 4, sprintf(__('%2s granted permission for profile ' . $profileId), $_SESSION["glpiname"]));

        Session::addMessageAfterRedirect(__('Permission granted with successfully!'));
    } 
}

