<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

$selectedProject = (int)$_POST['selectedProject'];
$ticketId = (int)$_POST['ticketId'];

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