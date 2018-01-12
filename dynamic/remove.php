<?php
try {
    $db = new PDO('sqlite:./database.db') or die('database error');

    function remove($tablename, $id, $db) {
        if($tablename == 'line') {
            $delete_items_qry = 'DELETE FROM linegraph WHERE line_id = :id';
            $delete_items = $db->prepare($delete_items_qry);
            $delete_items->bindParam(':id', $id);
            $delete_items->execute();
        }
        $query = 'DELETE FROM ' . $tablename . ' WHERE `id` = :id';
        $delete = $db->prepare($query);
        $delete->bindParam(':id', $id);
        $delete->execute();
    }
    // run different remove option based on table parameters
    $type = $_REQUEST['table'];
    switch($type) {
        case 'dashboard':
            remove('dashboards',$_REQUEST['id'], $db);
            break;
        case 'host':
            remove('hosts',$_REQUEST['id'], $db);
            break;
        case 'graph':
            remove('graph',$_REQUEST['id'], $db);
            break;
        case 'line':
            remove('line',$_REQUEST['id'], $db);
            break;
        case 'linegraph':
            remove('linegraph', $_REQUEST['id'], $db);
            break;
        default:
            die('missing parameters');
    }
    $db = null;
    $back = $_SERVER['HTTP_REFERER'];
    header("Status: 302 Moved Temporarily");
    header("Location: " . $back);
}
catch(PDOExceptions $e) {
    print $e->getMessage();
}
?>
