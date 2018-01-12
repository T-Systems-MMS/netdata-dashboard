<?php
// get information from the database
error_reporting(E_ALL);

function show_graph($item) {
    print '<div ' .
        'data-netdata="'. $item['metric_name'] . '" ' .
        'data-host="' . $item['url'] . '" ' .
        'data-title="' . $item['name'] .' - ' . $item['graph_name'] . '" ' .
        'data-chart-library="'. $item['display_type'] . '" ' .
        'data-height="100%" ' .
        'data-after="-300" ';
    if (is_numeric($item['min']) and is_numeric($item['max']))
	    print 'data-dygraph-valuerange="[' . $item['min'] . ', ' . $item['max'] . ']"';
    if (is_numeric($item['size']))
	    print 'data-width="' . $item['size'] . '%" ';
    print '></div>';

}

if (isset($_REQUEST['id'])) {
    $db = new PDO('sqlite:./database.db') or die('database error');

    $dashboard_id = $_REQUEST['id'];

    $db_dashboard_info = $db->prepare('SELECT name FROM dashboards WHERE id = :id');
    $db_dashboard_info->bindParam(':id', $dashboard_id);
    $db_dashboard_info->execute();
    $dashboard_info = $db_dashboard_info->fetch();

    $db_lines = $db->prepare('SELECT `id`, `lineheight` FROM `line` WHERE `dashboard_id` = :dashboard ORDER BY `id` ASC');
    $db_lines->bindParam(':dashboard', $dashboard_id);
    $db_lines->execute();
    $lines = $db_lines->fetchAll();

    $db_items_qry = 'SELECT
            l.id,
            h.name,
            h.url,
            g.display_type,
            g.graph_name,
            g.metric_name,
            g.min,
            g.max,
            l.size
        FROM
            linegraph l
                INNER JOIN graph g
                    ON l.graph_id = g.id
                INNER JOIN hosts h
                    ON l.host_id = h.id
                WHERE
                    l.line_id = :lineid';
    $db_items = $db->prepare($db_items_qry);

    include('show_dashboard_head.tpl');
    print '<header><a href="index.php">Netdata Dashboard :: ' . $dashboard_info['name'] . '</a></header>';
    foreach ($lines as $line) {
        $db_items->bindParam(':lineid', $line['id']) or $db->error_list();
        $db_items->execute();
	$items = $db_items->fetchAll();
	if ( $line['lineheight'] >= 10 and $line['lineheight'] <= 100 ) {
		print '<div class="line" style="height: '.$line['lineheight'].'vh">';
	}
	else {
	        print '<div class="line">';
	}
        foreach ($items as $item) {
            show_graph($item);
        }
        print '</div>';
    }

}
else
    die('missing "id" parameter');
?>
</div>
</body>
</html>
