<?php

// Init CURL and Authorisation
$ch = curl_init(); 
$authorization = "Authorization: Bearer ".$api_key;
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

// Get Workspaces
curl_setopt($ch, CURLOPT_URL, "https://app.asana.com/api/1.0/workspaces");
$output = curl_exec($ch);
$workspaces_raw = json_decode($output,true);
$workspaces = [];
$workspaces = $workspaces_raw['data'];

// Get User ID
curl_setopt($ch, CURLOPT_URL, "https://app.asana.com/api/1.0/users/me");
$output = curl_exec($ch);
$user = json_decode($output,true);
$user_id = $user['data']['id'];

// Create empty task lists
$inbox = [];
$today = [];
$upcoming = [];
$later = [];

// Create empty project list
$projects = [];

// Loop through all workspaces
foreach ($workspaces as $i => $workspace) {
    // Get Projects
    $query = "https://app.asana.com/api/1.0/workspaces/".$workspace['id']."/projects?opt_fields=name,id,color&archived=false";
    curl_setopt($ch, CURLOPT_URL, $query);
    $output = curl_exec($ch);
    $workspace_projects = json_decode($output,true);

    // Add projects in this workspace to complete project list
    foreach ($workspace_projects['data'] as $project) {
        $projects[] = $project;
    }

    // Get Tasks
    $query = "https://app.asana.com/api/1.0/tasks?workspace=".$workspace['id']."&assignee=".$user_id."&completed_since=now&opt_fields=assignee_status,name,workspace,projects,due_on";
    curl_setopt($ch, CURLOPT_URL, $query);
    $output = curl_exec($ch);
    $tasks = json_decode($output,true);

    // Loop through all the tasks in current workspace and add to Task lists
    foreach ($tasks['data'] as $j => $task) {
        $a = $task['assignee_status'];
        if($a == "today"){
            $today[] = $task;
        }elseif($a == "upcoming"){
            $upcoming[] = $task;
        }elseif($a == "inbox"){
            $inbox[] = $task;
        }elseif($a == "later"){
            $later[] = $task;
        }
    }
}
curl_close($ch);


?>