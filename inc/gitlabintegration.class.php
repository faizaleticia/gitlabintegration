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
 * Summary of PluginGitlabIntegrationGitlabIntegration
 * */
class PluginGitlabIntegrationGitlabIntegration {

    /**
    * Display contents at create issue of gitlab selected project.
    *
    * @param void
    *
    * @return void
    */
    static public function CreateIssue($selectedProject, $title, $description) {
        $parameters = PluginGitlabIntegrationParameters::getParameters();

        $url = $parameters['url'] . 'api/v4/projects/' . $selectedProject . '/issues';

        $headers = array(
            'PRIVATE-TOKEN: ' . $parameters['token']
        );

        $iid = self::getIidIssue($selectedProject, $parameters, $headers);

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
        PluginGitlabIntegrationEventLog::CreatedIssueLog($logIssue);
    }

    /**
    * Display contents at create issue of gitlab.
    *
    * @param void
    *
    * @return void
    */
    static public function getProjects() {
        $parameters = PluginGitlabIntegrationParameters::getParameters();

        $url = $parameters['url'] . 'api/v4/projects?per_page=100&order_by=name';
    
        $headers = array(
            'PRIVATE-TOKEN: ' . $parameters['token']
        );
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($curl);
    
        $result = json_decode($result);

        curl_close($curl);

        return $result;
    }

    /**
    * Display contents at get iid issue of gitlab selected project.
    *
    * @param $selectedProject, $parameters, $headers
    *
    * @return $iid
    */
    static private function getIidIssue($selectedProject, $parameters, $headers) {
        $url = $parameters['url'] . 'api/v4/projects/' . $selectedProject . '/issues';

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

        return $iid;
    }
}