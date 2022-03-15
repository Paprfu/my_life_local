<?php

$errors = array();
if (!isset($_GET['page'])) {
    include_once('dashboard.php');
    return;
}

switch ($_GET['page']) {
    case 'dashboard':
        include_once('dashboard.php');
        break;
    case 'blogs':
        include_once('blogs.php');
        break;
    case 'projects':
        include_once('projects.php');
        break;
    case 'project':
        include_once('project.php');
        break;
    case 'tasks':
        include_once('tasks.php');
        break;
    case 'task':
        include_once('task.php');
        break;
    case 'schools':
        include_once('schools.php');
        break;
    case 'admin':
        include_once('admin.php');
        break;
    default:
        include_once('dashboard.php');
}