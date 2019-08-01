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
    $parameters = PluginGitlabIntegrationParameters::getParameters();

    $url = $parameters['url'] . 'api/v4/projects/' . $selectedProject . '/issues';

    $headers = array(
        'PRIVATE-TOKEN: ' . $parameters['token']
    );

    try {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  
        $result = curl_exec($curl);
  
        $result = json_decode($result);
  
        if ($result) {
            $iid = $result[0]->iid + 1;
        } else {
            $iid = 1;
        }
  
        curl_close($curl);
    } catch (Exception $e) {
        PluginGitlabIntegrationParameters::ErrorLog($e->getMessage());
    }

    $title = $ticketId . ' - ' . $ticketName;
    $description = str_replace('&lt;p&gt;', '', str_replace('&lt;/p&gt;', '', $ticketContent));;

    $query = array(
        'id'          => $selectedProject, 
        'iid'         => $iid,
        'title'       => $title,
        'description' => $description,
    );

    try {
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_POST, 1);

       curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

       curl_setopt($curl, CURLOPT_POSTFIELDS, $query);

       $result = curl_exec($curl);

       curl_close($curl);
    } catch (Exception $e) {
        PluginGitlabIntegrationParameters::ErrorLog($e->getMessage());
    }

    $logIssue = "[ISSUE CREATED: IID: " . $iid . " PROJECT ID: " . $selectedProject . " TITLE: \"" . $title . "\" DESCRIPTION: \"" . $description . "\"]";

    PluginGitlabIntegrationEventLog::Log($ticketId, 'ticket', $_SESSION["glpi_currenttime"], 'issue', 4, sprintf(__('%2s created Issue'), $_SESSION["glpiname"]));
    PluginGitlabIntegrationEventLog::CreatedIssueLog($logIssue);

    Session::addMessageAfterRedirect(__('Issue created successfully!'));
} else {
    Session::addMessageAfterRedirect(__('Problem to create issue. Verify logs for more information!'));

    $erro = "[" . $_SESSION["glpi_currenttime"] . "] glpiphplog.ERROR: PluginGitlabIntegrationParameters::create() in issue.php line 34" . PHP_EOL;
    $erro = $erro . "  ***PHP Notice: Class PluginGitlabIntegrationParameters not created";
    PluginGitlabIntegrationEventLog::ErrorLog($erro);
}

