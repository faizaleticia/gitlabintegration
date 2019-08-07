<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser();

// if ($_SESSION["glpiactiveprofile"]["interface"] == "central") {
//     Html::header(__("Permitions Gitlab", "gitlabintegration"), "", "admin", "plugingitlabintegrationprofiles", "");
//  } else {
//     Html::helpHeader(__("Permitions Gitlab", "gitlabintegration"), $_SERVER['PHP_SELF']);
//  }
Html::header(PluginGitlabIntegrationProfiles::getTypeName(), $_SERVER['PHP_SELF'],
             "admin", "plugingitlabintegrationmenu", "profiles");

PluginGitlabIntegrationProfiles::title();
Search::show('PluginGitlabIntegrationProfiles');
PluginGitlabIntegrationProfiles::configPage();

Html::footer();