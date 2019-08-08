<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser();

Html::header(PluginGitlabIntegrationProfiles::getTypeName(), $_SERVER['PHP_SELF'],
             "admin", "plugingitlabintegrationmenu", "profiles");

PluginGitlabIntegrationProfiles::showForm();

Html::footer();