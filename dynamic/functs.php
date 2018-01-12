<?php
header('Content-type: text/html; charset=utf-8');
$db = new PDO('sqlite:./database.db') or die('database error');
function html_header($title) {
    print '<!doctype html>';
    print '<html>';
    print '<head>';
    print '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
    print '<title>'.$title.'</title>';
    print '<link rel="stylesheet" href="css/bootstrap.min.css" />';
    print '<link rel="stylesheet" href="css/custom.css" />';
    print '</head>';
    print '<body>';
    print '<div class="jumbotron"><h1 class="display-4"><a href="index.php">'. $title . '</a></h1></div>';
}

function html_footer() {
    print '<script src="js/jquery.js" />';
    print '<script src="js/bootstrap.min.js" />';
    print '</body></html>';
}

function qry($querystring) {
    global $db;
    $query = $db->query($querystring);
    $resultset = $query->fetchAll();
    return $resultset;
}

?>
