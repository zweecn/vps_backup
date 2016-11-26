#!/bin/sh
#---------------------------------------------------------------- 
# Shell Name：install
# Description：Plug-in install script
# Author：Starry
# E-mail: starry@misstar.com
# Time：2016-11-06 02:30 CST
# Copyright © 2016 Misstar Tools. All rights reserved.
#----------------------------------------------------------------*/
clear
echo "欢迎使用小米路由Misstar Tools工具箱"
echo "当前版本：1.16.11.06"
echo "问题反馈&技术交流QQ群：523723125"

## Check The Router Hardware Model 
mode=$(cat /proc/xiaoqiang/model)

if [ "$mode" = "R2D" -o "$mode" = "R1D" ];then
	Hardware_model="arm"
elif [ "$mode" = "R3" ];then
	Hardware_model="mips"
else
	echo "对不起，本工具不支持小米Mini路由器。"
	exit
fi 

echo "是否继续安装："
echo -n "[按任意键继续，按Ctrl+C 退出安装]:"

read continue

echo "开始下载安装包..."

url="http://www.misstar.com/tools/lastversion"

wget ${url}/misstar.tar.gz -O /tmp/misstar.tar.gz

if [ $? -eq 0 ];then
    echo "安装包下载完成！"
else 
    echo "下载安装包失败，正在退出..."
    exit
fi


mount -o remount,rw /

if [ $? -eq 0 ];then
    echo "挂载文件系统成功。"
else 
    echo "挂载文件系统失败，正在退出..."
    exit
fi

mkdir /etc/misstar

unzip -o -P Misstar_Tools@2016 /tmp/misstar.tar.gz -d /

if [ $? -eq 0 ];then
    echo "压缩包解压完成，开始安装："
else 
    echo "压缩包解压失败，正在退出..."
    exit
fi




mkdir /etc/misstar/bin
mv /etc/misstar/$Hardware_model/* /etc/misstar/bin/

chmod +x /etc/misstar/bin/*
chmod +x /etc/misstar/bin/adm/adm
chmod +x /etc/misstar/scripts/*

rm -rf /etc/misstar/arm
rm -rf /etc/misstar/mips

cd /etc/misstar/scripts


cp -rf /etc/misstar/.config/misstar /etc/config/misstar


chmod 777 /etc/firewall.user


if [ $(cat /etc/firewall.user | grep 'file_check.sh' | wc -l) == '0' ]; then
	echo "/etc/misstar/scripts/file_check" >> /etc/firewall.user 
fi

if [ $? -eq 0 ];then
    echo -e "安装完成，请刷新网页。"
else 
    echo "安装失败。"
    exit
fi

/etc/misstar/scripts/file_check


reboot