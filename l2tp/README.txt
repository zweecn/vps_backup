主要是这里的一键安装脚本：https://teddysun.com/448.html
它说centos6通过编译安装，centos7通过yum安装，其实都是yum安装比较好。
即是说安装 libreswan

-----------------------------------------------------------------

如果提示lib event xxx什么的话，先remove掉老的libevent，再装新的libevent2

yum remove libevent-devel-1.4.13-4.el6.x86_64
yum install libevent2-devel

整个l2tp就是安装2个东西：
ipsec
xl2tp
再配置iptables

-----------------------------------------------------------------

[root@MyCloudServer ~]# vi /etc/sysconfig/iptables
[root@MyCloudServer ~]# vi /etc/xl2tpd/xl2tpd.conf 
[root@MyCloudServer ~]# !vi
vi /etc/xl2tpd/xl2tpd.conf 
[root@MyCloudServer ~]# vi /etc/sysconfig/iptables
[root@MyCloudServer ~]# /etc/init.d/iptables restart
iptables：将链设置为政策 ACCEPT：nat filter mangle raw     [确定]
iptables：清除防火墙规则：                                 [确定]
iptables：正在卸载模块：                                   [确定]
iptables：应用防火墙规则：                                 [确定]
[root@MyCloudServer ~]# vi /etc/ip
iproute2/      ipsec.conf     ipsec.d/       ipsec.secrets  
[root@MyCloudServer ~]# vi /etc/ipsec.d/ipsec.conf 
[root@MyCloudServer ~]# vi /etc/xl2tpd/
l2tp-secrets  xl2tpd.conf   
[root@MyCloudServer ~]# vi /etc/xl2tpd/xl2tpd.conf 
[root@MyCloudServer ~]# vi /etc/sysconfig/iptables
[root@MyCloudServer ~]# /etc/init.d/xl2tpd restart
Stopping xl2tpd:                                           [确定]
Starting xl2tpd:                                           [确定]
[root@MyCloudServer ~]# /etc/init.d/ipsec restart
Shutting down pluto IKE daemon
002 shutting down

Starting pluto IKE daemon for IPsec: .                     [确定]
[root@MyCloudServer ~]# /etc/init.d/iptables restart
iptables：将链设置为政策 ACCEPT：nat filter mangle raw     [确定]
iptables：清除防火墙规则：                                 [确定]
iptables：正在卸载模块：                                   [确定]
iptables：应用防火墙规则：                                 [确定]

-----------------------------------------------------------------

iptables的配置如下：

[root@MyCloudServer ~]# cat /etc/sysconfig/iptables
# Generated by iptables-save v1.4.7 on Sun Nov 27 19:05:13 2016
*raw
:PREROUTING ACCEPT [25486:10805121]
:OUTPUT ACCEPT [14270:1418385]
COMMIT
# Completed on Sun Nov 27 19:05:13 2016
# Generated by iptables-save v1.4.7 on Sun Nov 27 19:05:13 2016
*mangle
:PREROUTING ACCEPT [25486:10805121]
:INPUT ACCEPT [25291:10788846]
:FORWARD ACCEPT [91:9906]
:OUTPUT ACCEPT [14270:1418385]
:POSTROUTING ACCEPT [14361:1428291]
COMMIT
# Completed on Sun Nov 27 19:05:13 2016
# Generated by iptables-save v1.4.7 on Sun Nov 27 19:05:13 2016
*filter
:INPUT ACCEPT [0:0]
:FORWARD ACCEPT [0:0]
:OUTPUT ACCEPT [1:156]
-A INPUT -p udp -m multiport --dports 500,4500,1701 -j ACCEPT 
-A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT 
-A INPUT -p icmp -j ACCEPT 
-A INPUT -i lo -j ACCEPT 
-A INPUT -p tcp -m state --state NEW -m tcp --dport 22 -j ACCEPT 
-A INPUT -p tcp -m state --state NEW -m tcp --dport 80 -j ACCEPT 
-A INPUT -p tcp -m state --state NEW -m tcp --dport 53 -j ACCEPT 
-A INPUT -p udp -m state --state NEW -m udp --dport 53 -j ACCEPT 
-A INPUT -p tcp -m state --state NEW -m tcp --dport 1194 -j ACCEPT 
-A INPUT -p udp -m state --state NEW -m udp --dport 1701 -j ACCEPT 
-A INPUT -p udp -m state --state NEW -m udp --dport 500 -j ACCEPT 
-A INPUT -p udp -m state --state NEW -m udp --dport 4500 -j ACCEPT 
-A INPUT -j REJECT --reject-with icmp-host-prohibited 
-A FORWARD -s 192.168.18.0/24 -j ACCEPT 
-A FORWARD -m state --state RELATED,ESTABLISHED -j ACCEPT 
# -A FORWARD -d 192.168.11.0/24 -j ACCEPT 
# -A FORWARD -s 192.168.11.0/24 -j ACCEPT 
-A FORWARD -j REJECT --reject-with icmp-host-prohibited 
COMMIT
# Completed on Sun Nov 27 19:05:13 2016
# Generated by iptables-save v1.4.7 on Sun Nov 27 19:05:13 2016
*nat
:PREROUTING ACCEPT [0:0]
:POSTROUTING ACCEPT [0:0]
:OUTPUT ACCEPT [0:0]
# -A POSTROUTING -s 192.168.11.0/24 -o eth0 -j MASQUERADE 
# -A POSTROUTING -s 192.168.11.0/24 -j SNAT --to-source 45.125.17.10 
-A POSTROUTING -s 192.168.18.0/24 -j SNAT --to-source 45.125.17.10 
COMMIT
# Completed on Sun Nov 27 19:05:13 2016

