<?php
if(file_exists('database.db')) {
    include 'functs.php';
    html_header('Dashboard :: Index');
    $dashboards = qry("SELECT `id`, `name` FROM `dashboards`;");
    print '
        <div class="container">
        <div class="row">
            <div class="col-md-9">';
                foreach($dashboards as $dashboard) {
                    print '<div class="card wrapper"><div class="card-body"><div class="row">';
                    print '<div class="col-md-8"><h4>' . $dashboard['name'] . '</h4></div>';
                    print '<div class="col-md-2"><a class="btn btn-block btn-primary" href="show_dashboard.php?id=' . $dashboard['id'] . '">Show</a></div>';
                    print '<div class="col-md-2"><a class="btn btn-block btn-danger" href="manage_dashboard.php?id='. $dashboard['id'].'">Edit</a></div>';
                    print '</div></div></div>';
                }
    print '</div>
        <div class="col-md-3">';
    print '
        <div class="card wrapper">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="manage.php">Manage Assets</a>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col">
                        <small class="form-text text-muted">add and remove Hosts, Graph Types, Dashboards etc</small>
                    </div>
                </div>
            </div>
        </div>
';
    print '</div></div>';
    html_footer();
}
else {
    // if the database isn't setup, run the installation script
    header("Status: 302 Moved Temporarily");
    header("Location: install.php");
}

?>
