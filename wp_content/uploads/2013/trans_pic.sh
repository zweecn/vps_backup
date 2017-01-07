#!/bin/bash

for pic in `ls 03`
do
	low=`echo $pic |  tr '[A-Z]' '[a-z]'`
	cmd="mv 03/$pic 03/$low"
	echo $cmd
	$cmd
done
