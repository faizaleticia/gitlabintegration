<?php

/*
 -------------------------------------------------------------------------
GLPI - Gestionnaire Libre de Parc Informatique
Copyright (C) 2003-2011 by the INDEPNET Development Team.

http://indepnet.net/   http://glpi-project.org
-------------------------------------------------------------------------

LICENSE

This file is part of GLPI.

GLPI is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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
 * Example of *_item_form implementation
 * @see http://glpi-developer-documentation.rtfd.io/en/master/plugins/hooks.html#items-display-related
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
      $item = $params['item'];

      $canCreate = self::verifyPermition();

      if ($item::getType() == Ticket::getType() && ($item->getField('id') != 0) && ($canCreate)) {
         $options = $params['options'];

         $firstelt = ($item::getType() == Ticket::getType() ? 'th' : 'td');

         $out = "<tr>";
         $out .= "<td>";
         $out .= "</td>";
         $out .= "</tr>";

         $out .= '<tr><th colspan="' . (isset($options['colspan']) ? $options['colspan'] * 2 : '4') . '">';
         $out .= sprintf(
            __('Integrate with Gitlab'),
            'post_item_form',
            $item::getType()
         );
         $out .= '</th></tr>';

         $out .= "<tr><$firstelt>";
         $out .= '<label>' . __('Create Issue') . '</label>';
         $out .= "</$firstelt><td>";
         $out .= "</td>";
         $out .= '</tr>';

         echo $out;
      } 
   }

   static private function verifyPermition() {
      global $DB;
      $result = $DB->request('glpi_plugin_profiles_users', ['FIELDS' => 'profile_id']);
      // => SELECT `profile_id` FROM `glpi_plugin_profiles_users`

      $canCreate = false;
      foreach ($result as $row) {
         if ($row['profile_id'] == $_SESSION['glpiactiveprofile']['id']) {
            $canCreate = true;
            break;
         }
      }
      return $canCreate;
   }
}
