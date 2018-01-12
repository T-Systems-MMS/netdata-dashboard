<?php
function add_dashboard($params, $db) {
    if (isset($params['name'])) {
        $add = $db->prepare("INSERT INTO `dashboards` (`name`) VALUES (:name)");
        $add->bindValue(':name', $params['name']);
        $add->execute() or die(print_r($db->errorInfo()));
    }
    else {
        die('missing parameters');
    }
}

function add_host($params, $db) {
    if (isset($params['url'], $params['hostname'])) {
        $url = $params['url'];
        $name = $params['hostname'];
        $add = $db->prepare("INSERT INTO `hosts` (`url`, `name`) VALUES ( :url, :name );");

        $add->bindValue(':url', $url);
        $add->bindValue(':name', $name);
        $add->execute() or die(print_r($db->errorInfo()));
    }
    else {
        die('missing parameters');
    }
}

function add_graph($params, $db) {
    if (isset($params['name'], $params['type'], $params['metric'])) {
        $query = "INSERT INTO `graph` (
                    `graph_name`,
                    `display_type`,
                    `metric_name`,
                    `min`,
                    `max`,
                ) VALUES (
                    :name,
                    :type,
                    :metric,
                    :min,
                    :max
                )";

        $add = $db->prepare($query);
        $add->bindValue(':name', $params['name']);
        $add->bindValue(':type', $params['type']);
        $add->bindValue(':metric', $params['metric']);
        $add->bindValue(':min', $params['min']);
        $add->bindValue(':max', $params['max']);
        $add->execute() or die(print_r($db->errorInfo()));
    }
    else {
        die('missing parameters');
    }
}

function add_line($params, $db) {
    if (isset( $params['dashboard'], $params['lineheight'] )) {
        // check for valid line height setting
        $height = (($params['lineheight'] >= 10 && $params['lineheight'] <= 100) ? true : false );

        $query = 'INSERT INTO `line` (`dashboard_id`, `lineheight`) VALUES (:dashboard_id, :lineheight)';
        $add = $db->prepare($query);
        $add->bindValue(':dashboard_id', $params['dashboard']);
        if ($height)
            $add->bindValue(':lineheight', $params['lineheight']);
        else
            $add->bindValue(':lineheight', null);
        $add->execute() or die(print_r($db->errorInfo()));
    }
    else {
        die('missing parameters');
    }
}

function add_linegraph($params, $db) {
    if (isset($params['line_id'], $params['graph_id'], $params['host_id'], $params['size'])) {
        $query = 'INSERT INTO `linegraph` ( `line_id`, `graph_id`, `host_id`, `size` ) VALUES ( :line_id, :graph_id, :host_id, :size )';
        $add = $db->prepare($query);
        $add->bindValue(':line_id', $params['line_id']);
        $add->bindValue(':graph_id', $params['graph_id']);
        $add->bindValue(':host_id', $params['host_id']);
        $add->bindValue(':size', $params['size']);
        $add->execute() or die(print_r($db->errorInfo()));
    }
    else
        die('missing parameters');
}

try {
    $db = new PDO('sqlite:./database.db') or die('database error');
    $type = $_REQUEST['table'];

    // run different add option based on table parameters
    switch($type) {
        case 'dashboard':
            add_dashboard($_REQUEST, $db);
            break;
        case 'host':
            add_host($_REQUEST, $db);
            break;
        case 'graph':
            add_graph($_REQUEST, $db);
            break;
        case 'line':
            add_line($_REQUEST, $db);
            break;
        case 'linegraph':
            add_linegraph($_REQUEST, $db);
            break;
        default:
            die('missing parameters');
    }
    $db = null;
    $back = $_SERVER['HTTP_REFERER'];
    header("Status: 302 Moved Temporarily");
    header("Location: " . $back);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>
