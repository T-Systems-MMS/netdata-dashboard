Netdata Dashboard!
===============================

Description:
========
- this project is related to you if you:
	- have multiple servers with netdata
	- want multiple server graphs in one dashboard
	- want to build a custom netdata dashboard without config writing
- "Netdata – Linux performance monitoring, done right"
- "Looks like another faster horse." 
[Source](https://news.ycombinator.com/item?id=11388196)

Requirements & Installationguide
========
- webserver with git php sqlite php-pdo support
- clone git into webserverfolder and ensure php files can be executed
- Example for redhat/centos 7
```
yum -y install git php httpd sqlite php-pdo
cd /var/www/html
git clone https://github.com/T-Systems-MMS/netdata-dashboard
chcon -t httpd_sys_rw_content_t /var/www/html -R
chown apache: -R /var/www/html/netdata-dashboard
systemctl restart httpd
```
- open browser `http://$YOURIP/netdata-dashboard/dynamic/`
- by default the official netdata examples are loaded

Installation Netdata:
============
- to install netdata on your own machine you have to follow the netdata guide or execute the following short version
```
bash <(curl -Ss https://my-netdata.io/kickstart.sh)
```
- requires internetaccess and/or proxysetup [source](https://github.com/firehol/netdata/wiki/Installation)

Additional:
============
- The need of this feature is already mentioned [here.](https://github.com/firehol/netdata/issues/416)





