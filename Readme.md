Netdata Dashboard!
===============================

Description:
========
- "Netdata – Linux performance monitoring, done right"
- "Looks like another faster horse." 
[Source](https://news.ycombinator.com/item?id=11388196)

Requirements & Installationguide
========
- webserver with git php sqlite php-pdo support
- clone git into webserverfolder and ensure php files can be executed
- Example for redhat/centos 7

```
yum install git php httpd sqlite php-pdo
cd /var/www/html
git clone https://github.com/T-Systems-MMS/netdata-dashboard
# SELINUX write permissions
chcon -t httpd_sys_rw_content_t /var/www/html -R
```

- open browser `http://$YOURIP/dynamic/`
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




