<?php

/*
 -------------------------------------------------------------------------
GLPI - Gestionnaire Libre de Parc Informatique
Copyright (C) 2003-2019 by the INDEPNET Development Team.

http://indepnet.net/   http://glpi-project.org
-------------------------------------------------------------------------

LICENSE

This file is part of GLPI.

GLPI is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

GLPI is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with GLPI. If not, see <http://www.gnu.org/licenses/>.
--------------------------------------------------------------------------
 */

/**
 * Summary of PluginGitlabIntegrationItemForm
 * */
class PluginGitlabIntegrationItemForm {

   /**
    * Display contents at the begining of item forms.
    *
    * @param array $params Array with "item" and "options" keys
    *
    * @return void
    */
   static public function postItemForm($params) {
      global $CFG_GLPI;
      $item = $params['item'];

      $canCreate = self::verifyPermission();

      if ($item::getType() == Ticket::getType() && ($item->getField('id') != 0) && ($canCreate)) {
         $options = $params['options'];

         $firstelt = ($item::getType() == Ticket::getType() ? 'th' : 'td');

         echo "<tr>";
         echo "<td>";
         echo "</td>";
         echo "</tr>";

         echo "<tr><$firstelt>";
         echo '<label>' . __('Gitlab Project', 'gitlabintegration') . '</label>';
         echo "</$firstelt><td>";

         $dropdown = self::dropdownProject(['value' => 'Project']);
         $selectedProject = self::getSelectedProject($item->getField('id'));

         echo "<script type='text/javascript'>";
         echo "setSelectedProject({$dropdown},{$selectedProject})";
         echo "</script>";

         echo "</td>";
         
         echo "<td style='text-align: left; width: 5px'>";
         
         $message = __('Issue already created for the selected project. Do you want creat it again?', 'gitlabintegration');

         $content = self::getTextWithoutQuotationMarks($item->getField('content'));

         echo "<div class='primary-button' onClick='createIssue(" . $item->getField('id') . " , " . $dropdown . " , " . $selectedProject . " , \"" . $item->getField('name') . "\" , \"" . $content . "\", \"" . $message . "\")'>" . __("Create Issue", "gitlabintegration") . "</div>";

         echo "</td>";
         echo '</tr>';

         echo '<tr style="padding:10px"><td style="padding:10px"></td></tr>';
      } 
   }

   static private function getTextWithoutQuotationMarks($text) {  
     $bodytag = str_replace("'", "\"", $text);
     $bodytag = str_replace("\"", "\\\"", $bodytag);
     return $bodytag;
   }

   /**
    * Display contents at the selected project of item forms.
    *
    * @param $ticketId
    *
    * @return $selectedProject
    */
   static private function getSelectedProject($ticketId) {
      global $DB;

      $result = $DB->request('glpi_plugin_gitlab_integration', ['ticket_id' => [$ticketId]]);
      $selectedProject = 0;

      foreach($result as $row) {
         $selectedProject = $row['gitlab_project_id'];
      }

      return $selectedProject;
   }  
   
   /**
    * Display contents at the profiles have Permission of item forms.
    *
    * @param void
    *
    * @return boolean $canCreate
    */
   static private function verifyPermission() {
      global $DB;
      $result = $DB->request('glpi_plugin_gitlab_profiles_users', ['FIELDS' => 'profile_id']);
      // => SELECT `profile_id` FROM `glpi_plugin_gitlab_profiles_users`

      $canCreate = false;
      foreach ($result as $row) {
         if ($row['profile_id'] == $_SESSION['glpiactiveprofile']['id']) {
            $canCreate = true;
            break;
         }
      }
      return $canCreate;
   }

   /**
    * Display contents at the component of item forms.
    *
    * @param array $options
    *
    * @return Dropdown component
    */
   static function dropdownProject(array $options = []) {
      $p = [
         'name'     => 'project',
         'value'    => 0,
         'showtype' => 'normal',
         'display'  => true,
      ];
   
      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }
   
      $values = []; 

      $result = PluginGitlabIntegrationGitlabIntegration::getProjects();
   
      foreach ($result as $key => $value) {
         $values[$value->id] = $value->name_with_namespace;
      }
   
      return Dropdown::showFromArray($p['name'], $values, $p);
   }
}
