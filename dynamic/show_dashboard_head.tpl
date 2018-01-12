<!DOCTYPE html>
<html lang="en">
<head>
    <title>Netdata Multi-Host-Dashboard</title>
    <meta name="application-name" content="netdata" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
</head>
<script>
var netdataTheme = 'slate';
var netdataServer = 'https://frankfurt.my-netdata.io';
</script>
<script type="text/javascript" src="https://frankfurt.my-netdata.io/dashboard.js" />
<script>
    NETDATA.options.current.destroy_on_hide = false;
    NETDATA.options.current.eliminate_zero_dimensions = true;
    NETDATA.options.current.concurrent_refreshes = false;
    NETDATA.options.current.parallel_refresher = true;
</script>
<style type="text/css">
div.line {
 /* default height if it is not set */
 height: 25vh;
}
header {
 padding-left: 5px;
 font-size: 10pt;
 border-bottom: 1px solid #888;
}
header a {
 color: #888;
}
</style>
