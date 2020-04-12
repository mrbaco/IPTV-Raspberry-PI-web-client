#!/bin/sh

pkill omxplayer

omxplayer -p -o hdmi "$1" > /dev/null 2>&1 &

sleep 1
