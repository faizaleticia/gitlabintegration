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
 * Summary of PluginGitlabIntegrationParameters
 * */
class PluginGitlabIntegrationParameters {

    /**
    * Display contents at the begining of parameters.
    *
    * @param void
    *
    * @return array of $url and $token gitlab
    */
    static public function getParameters() {
        global $DB;
        $result = $DB->request('glpi_plugin_gitlab_parameters', ['name' => ['gitlab_url','gitlab_token']]);
        // SELECT * FROM glpi_plugin_gitlab_parameters WHERE NAME IN ('gitlab_url', 'gitlab_token');

        foreach ($result as $row) {
            if ($row['name'] == 'gitlab_url') {
                $url = $row['value'];
            } else if ($row['name'] == 'gitlab_token') {
                $token = $row['value'];
            }
        }

        return [
            'url'   => $url,
            'token' => $token
        ];
    }
}