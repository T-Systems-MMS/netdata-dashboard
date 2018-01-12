<?php
    error_reporting(E_ALL);
    include 'functs.php';

    $dashboard_id = $_REQUEST['id'];
    $lines = $db->prepare('SELECT `id` FROM `line` WHERE `dashboard_id` = :dashboard ORDER BY `id` ASC');
    $lines->bindParam(':dashboard', $dashboard_id);
    $lines->execute();
    $lines_vals = $lines->fetchAll();

    // get a list of all graphs for dropdown in add window
    $graph_dropdown_db = $db->query('SELECT `id`, `graph_name` FROM `graph`');
    $graph_dropdown = $graph_dropdown_db->fetchAll();

    $host_dropdown_db = $db->query('SELECT `id`, `name` FROM `hosts`');
    $host_dropdown = $host_dropdown_db->fetchAll();

    // prepare the queries for graph information display
    $db_items_qry = 'SELECT `id`, `graph_id`, `host_id` FROM `linegraph` WHERE `line_id` = :lineid ORDER BY `id` ASC';
    $db_items = $db->prepare($db_items_qry);

    $db_graphs_qry = 'SELECT `display_type`, `metric_name`, `graph_name`, `min`, `max` FROM `graph` WHERE `id` = :graphid';
    $db_graphs = $db->prepare($db_graphs_qry);

    $db_hosts_qry = 'SELECT `url`, `name` FROM `hosts` WHERE `id` = :hostid';
    $db_hosts = $db->prepare($db_hosts_qry);

    html_header('Dashboard :: Manage Dashboard');
?>
<div class="container">
<div class="row wrapper">
  <div class="col-md-7">
    <form action="add.php" id="add_line">
    <input type="hidden" name="dashboard" value="<?php print $dashboard_id ?>"/>
    <input type="hidden" name="table" value="line"/>
  </div>
    <label class="col-form-label col-md-1" for="lineheight">Zeilenhöhe: </label>
  <div class="col-md-2">
    <input class="form-control" type="number" min="0" max="100" name="lineheight"/>
  </div>
  <div class="col-md-2">
    <input class="btn btn-primary btn-block" type="submit" value="Zeile hinzufügen"/>
    </form>
  </div>
</div>
<?php
foreach( $lines_vals as $line ) {
    print '<div class="line">';
    print '<div class="card wrapper">';
    print '<div class="card-body">';
    $db_items->bindParam(':lineid', $line['id']);
    $db_items->execute();
    $items = $db_items->fetchAll();


    // add item form
    print '<div class="row wrapper">';
    print '<div class="col-md-3">';
        print '<form action="add.php">
            <input type="hidden" name="table" value="linegraph" />
            <input type="hidden" name="line_id" value="' . $line['id'] . '" />';
        print '<select class="form-control" name="host_id">';
        foreach ($host_dropdown as $host)
           print '<option value="'. $host['id'] . '">' . $host['name'] . '</option>';
        print '</select>';
    print '</div>';
    print '<div class="col-md-2">';
        print '<select class="form-control" name="graph_id">';
        foreach ($graph_dropdown as $graph)
            print '<option value="' . $graph['id'] . '">'. $graph['graph_name'] . '</option>';
        print '</select>';
    print '</div>';
        print '<label class="col-form-label col-md-2" for="input">Size&nbsp;(%)</label>';
    print '<div class="col-md-2">';
        print '<input class="form-control" type="number" name="size">';
    print '</div>';
    print '<div class="col-md-3">';
        print '<input class="btn btn-primary btn-block" type="submit" value="Graph hinzufügen"/>
            </form>';
    print '</div>';
    print '</div>';


    print '<div class="row wrapper">';
    // delete item form
    foreach( $items as $item ) {
        // get information from the database
        $db_graphs->bindParam(':graphid', $item['graph_id']);
        $db_graphs->execute();
        $graph_infos = $db_graphs->fetch();

        $db_hosts->bindParam(':hostid', $item['host_id']);
        $db_hosts->execute();
        $host_infos = $db_hosts->fetch();

        print '<div class="col-md-4"><div class="card wrapper"><div class="card-body">';
        print '<div class="row"><div class="col-md-4"><b>Host</b></div><div class="col-md-8">' . $host_infos['name'] . '</div></div>';
        print '<div class="row wrapper"><div class="col-md-4"><b>Graph</b></div><div class="col-md-8">' . $graph_infos['graph_name'] . '</div></div>';
        print '<div class="row"><div class="col-md-6"></div><div class="col-md-6">
            <form action="remove.php">
            <input type="hidden" name="table" value="linegraph" />
            <input type="hidden" name="id" value="' . $item['id'] . '" />
            <input class="btn btn-danger btn-block" type="submit" value="löschen" />
            </form></div>';
        print '</div></div></div></div>';
    }
    print '</div>';
    
    // remove line form
    print '
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <form action="remove.php" class="remove_line">
                    <input type="hidden" name="table" value="line" />
                    <input type="hidden" name="id" value="'. $line['id']. '" />
                    <input class="btn btn-danger btn-block" type="submit" value="Zeile löschen">
                </form>
            </div>
        </div>';
    print '</div>';
    print '</div>';
    print '</div>';
}
?>
</div>
</body>
</html>
