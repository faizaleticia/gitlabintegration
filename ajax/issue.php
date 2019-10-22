<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser();

$selectedProject = (int)$_POST['selectedProject'];
$ticketId = (int)$_POST['ticketId'];
$ticketName = $_POST['ticketName'];
$ticketContent = $_POST['ticketContent'];

$result = $DB->request('glpi_plugin_gitlab_integration', ['ticket_id' => [$ticketId]]);

if ($result->count() > 0) {
    $DB->update(
        'glpi_plugin_gitlab_integration', [
           'gitlab_project_id'  => $selectedProject
        ], [
           'ticket_id' => $ticketId
        ]
    );

} else {
    $DB->insert(
        'glpi_plugin_gitlab_integration', [
            'ticket_id'         => $ticketId,
            'gitlab_project_id' => $selectedProject
        ]
    );
} 

if (class_exists('PluginGitlabIntegrationParameters')) {
    $title = $ticketId . ' - ' . $ticketName;
    $description = str_replace('&lt;p&gt;', '', str_replace('&lt;/p&gt;', '', $ticketContent));
    $description = str_replace('&lt;br&gt;', '<br>', $description);
    $description = str_replace('&lt;p style=\"padding-left: 40px;\"&gt;', '<p style="padding-left: 40px;">', $description);
    $description = str_replace('&lt;', '<', $description);
    $description = str_replace('&gt;', '>', $description);

    PluginGitlabIntegrationGitlabIntegration::CreateIssue($selectedProject, $title, $description);

    PluginGitlabIntegrationEventLog::Log($ticketId, 'ticket', $_SESSION["glpi_currenttime"], 'issue', 4, sprintf(__('%2s created Issue', 'gitlabintegration'), $_SESSION["glpiname"]));

    Session::addMessageAfterRedirect(__('Issue created successfully!', 'gitlabintegration'));
} else {
    Session::addMessageAfterRedirect(__('Problem to create issue. Verify logs for more information!', 'gitlabintegration'));

    $erro = "[" . $_SESSION["glpi_currenttime"] . "] glpiphplog.ERROR: PluginGitlabIntegrationParameters::create() in issue.php line 34" . PHP_EOL;
    $erro = $erro . "  ***PHP Notice: Class PluginGitlabIntegrationParameters not created";
    PluginGitlabIntegrationEventLog::ErrorLog($erro);
}

