<?php
if(file_exists('./database.db')) {
	die('already installed. please remove database file for reinstallation.');
} else {
    $db = new PDO('sqlite:./database.db') or die('database error');

    // create database file containing templates
    $create_tables = array( 
            "CREATE TABLE IF NOT EXISTS `dashboards` ( 
                `id` INTEGER PRIMARY KEY AUTOINCREMENT, 
                `name` TEXT NOT NULL 
            );",
            "CREATE TABLE IF NOT EXISTS `hosts` ( 
                `id` INTEGER PRIMARY KEY AUTOINCREMENT, 
                `name` TEXT NOT NULL, 
                `url` TEXT NOT NULL 
            );",
            "CREATE TABLE IF NOT EXISTS `line` ( 
                `id` INTEGER PRIMARY KEY AUTOINCREMENT,
		`dashboard_id` INTEGER NOT NULL,
		`lineheight` INTEGER,
                FOREIGN KEY(dashboard_id) REFERENCES dashboards(id)
            );",
            "CREATE TABLE IF NOT EXISTS `graph` ( 
                `id` INTEGER PRIMARY KEY AUTOINCREMENT, 
                `display_type` TEXT NOT NULL, 
                `metric_name` TEXT NOT NULL, 
                `graph_name` TEXT NOT NULL, 
                `min` INTEGER, 
                `max` INTEGER
            );",
            "CREATE TABLE IF NOT EXISTS `linegraph` ( 
                `id` INTEGER PRIMARY KEY AUTOINCREMENT, 
                `size` INTEGER,
                `line_id` INTEGER NOT NULL,
                `graph_id` INTEGER NOT NULL,
                `host_id` INTEGER NOT NULL,
                FOREIGN KEY(line_id) REFERENCES line(id),
                FOREIGN KEY(graph_id) REFERENCES graph(id),
                FOREIGN KEY(host_id) REFERENCES host(id)
            );",
            "INSERT INTO `dashboards` VALUES(1,'exampledashboard');",
            "INSERT INTO `hosts` VALUES(1,'frankfurt','https://frankfurt.my-netdata.io');",
            "INSERT INTO `hosts` VALUES(2,'newyork','https://newyork.my-netdata.io');",
            "INSERT INTO `hosts` VALUES(3,'singapore','https://singapore.my-netdata.io');",
            "INSERT INTO `hosts` VALUES(4,'bangalore','https://bangalore.my-netdata.io');",
            "INSERT INTO `line` VALUES(1,1,45);",
            "INSERT INTO `line` VALUES(2,1,45);",
            "INSERT INTO `linegraph` VALUES(1,50,1,9,1);",
            "INSERT INTO `linegraph` VALUES(2,50,1,9,2);",
            "INSERT INTO `linegraph` VALUES(3,50,2,9,3);",
            "INSERT INTO `linegraph` VALUES(4,50,2,9,4);"
    );

    foreach ($create_tables as $table)
        $db -> query($table) or die(print_r($db->errorInfo()));


    $db_graphs_query="INSERT INTO graph (display_type, metric_name, graph_name) VALUES (:display_type, :metric_name, :graph_name)";
    $db_graphs=$db->prepare($db_graphs_query);

    $initial_graphs=array(
          array('dygraph', 'system.cpu', 'CPU Usage'),
          array('dygraph', 'system.load', 'System Load'),
          array('dygraph', 'system.io', 'Disk IO (total)'),
          array('dygraph', 'system.ram', 'RAM Usage'),
          array('dygraph', 'system.net', 'Total Traffic'),
          array('dygraph', 'ipv4.sockstat_tcp_sockets', 'IPv4 TCP Sockets'),
          array('dygraph', 'ipv4.tcpsock', 'IPv4 Active Connections'),
          array('dygraph', 'apps.mem', 'RAM Usage by Apps'),
          array('dygraph', 'apps.cpu', 'CPU Usage by Apps'),
          array('dygraph', 'web_log_apache.response_codes', 'Apache Response Codes'),
          array('dygraph', 'netfilter.conntrack_sockets', 'Active Connections')
      );

    foreach ( $initial_graphs as $db_graph ) {
        $db_graphs->bindValue(':display_type', $db_graph[0]);
        $db_graphs->bindValue(':metric_name', $db_graph[1]);
        $db_graphs->bindValue(':graph_name', $db_graph[2]);
        $db_graphs->execute() or die(print_r($db->errorInfo()));
    }

    header("Status: 302 Moved Temporarily");
    header("Location: index.php");
}
?>
