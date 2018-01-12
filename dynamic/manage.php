<?php
include 'functs.php';
// get data
$all_dashboards = qry("SELECT id, name FROM dashboards;");
$all_hosts = qry("SELECT id, name, url FROM hosts;");
$all_graphs = qry("SELECT id, graph_name FROM graph;");

html_header("Dashboard :: Manage Configuration");
?>

<div class="container">
  <div class="row wrapper">
    <div class="col">
      <div class="card">
        <div class="card-header">Manage Dashboard</div>
        <div class="card-body">
          <form action="manage_dashboard.php" method="get">
            <div class="row">
              <label class="col-form-label col-sm-2" for="id">Dashboard-Name</label>
              <div class="col-md-6">
                <select class="form-control" name="id">
                <?php foreach( $all_dashboards as $row )
                    print '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                ?>
                </select>
              </div>
              <div class="col-md-4">
                <input class="btn btn-primary btn-block" type="submit" value="Dashboard bearbeiten"/>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row wrapper">
    <div class="col">
      <div class="card">
        <div class="card-header">Manage Dashboards</div>
          <div class="card-body">
            <form action="add.php">
              <div class="row wrapper">
                <div class="col-md-8">
                  <input name="table" type="hidden" value="dashboard"/>
                  <input class="form-control" placeholder="Dashboard" type="text" name="name" />
                </div>
                <div class="col-md-4">
                  <input class="btn btn-primary btn-block" type="submit" value="Dashboard hinzufügen" />
                </div>
              </div>
            </div>
            <div class="card-body">
              </form>
              <form action="remove.php">
                <div class="row">
                  <div class="col-md-8">
                    <input type="hidden" name="table" value="dashboard" />
                    <select class="form-control" name="id">
                      <?php foreach ( $all_dashboards as $row )
                          print '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                      ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input class="btn btn-danger btn-block" type="submit" value="Dashboard löschen" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  <div class="row wrapper">
    <div class="col">
      <div class="card">
        <div class="card-header">
          Manage Hosts
        </div>
        <div class="card-body">
          <form action="add.php">
            <div class="row wrapper">
              <div class="col-md-8">
                <input name="table" type="hidden" value="host" />
                <input placeholder="Hostname" class="form-control" type="text" name="hostname" />
              </div>
            </div>
            <div class="row wrapper">
              <div class="col-md-8">
                <input placeholder="Netdata URL des Hosts" class="form-control" type="text" name="url" />
              </div>
              <div class="col-md-4">
                <input class="btn btn-primary btn-block" type="submit" value="Host hinzufügen">
              </div>
            </div>
          </form>
          </div>
          <div class="card-body">
          <form action="remove.php">
            <div class="row wrapper">
              <div class="col-md-8">
                <input name="table" type="hidden" value="host" />
                <select class="form-control" name="id">
                  <?php foreach ( $all_hosts as $row )
                    print '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <input class="btn btn-danger btn-block" type="submit" value="Host löschen">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<div class="row wrapper">
  <div class="col">
    <div class="card">
      <div class="card-header">
        Manage Graphs
      </div>
      <div class="card-body">
        <form action="add.php">
          <div class="row wrapper">
            <input name="table" type="hidden" value="graph" />
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-md-6">
              <input class="form-control" type="text" name="name" />
            </div>
          </div>
          <div class="row wrapper">
            <label for="type" class="col-sm-2 col-form-label">Graph-Typ</label>
            <div class="col-sm-6">
              <select class="form-control" name="type">
                <option>gauge</option>
                <option>dygraph</option>
              </select>
            </div>
          </div>
          <div class="row wrapper">
            <label class="col-sm-2 col-form-label" for="metric">Metrik</label>
            <div class="col-sm-6">
              <input class="form-control" type="text" name="metric" />
            </div>
          </div>
          <div class="row wrapper">
            <label class="col-sm-2 col-form-label" for="min">Minimalwert</label>
            <div class="col-sm-2">
              <input class="form-control" type="number" name="min" />
            </div>
            <label class="col-sm-2 col-form-label" for="max">Maximalwert</label>
            <div class="col-sm-2">
              <input class="form-control" type="number" name="max" />
            </div>
          </div>
          <div class="row wrapper">
            <label for="size" class="col-sm-2 col-form-label">Anzeigegröße (in %)</label>
            <div class="col-sm-6">
              <input class="form-control" type="number" name="size" />
            </div>
            <div class="col-sm-4">
              <input class="btn btn-primary btn-block" type="submit" value="Graph hinzufügen"/>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body">
        <form action="remove.php">
          <div class="row">
            <input name="table" type="hidden" value="graph" />
            <label for="id" class="col-form-label col-sm-2">Graph</label>
            <div class="col-sm-6">
              <select class="form-control" name="id">
              <?php foreach ( $all_graphs as $row )
                print '<option value="' . $row['id'] . '">' . $row['graph_name'] . '</option>';
              ?>
              </select>
            </div>
            <div class="col-sm-4">
              <input class="btn btn-danger btn-block" type="submit" value="Graph löschen"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
<?php html_footer(); ?>
