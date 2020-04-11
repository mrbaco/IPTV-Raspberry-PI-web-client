#!/bin/sh

setterm -term xterm -cursor off -clear -blank 0 -powersave off -powerdown 0 >/dev/tty1
setterm -blank 0


pkill omxplayer

omxplayer -p -o hdmi "$1" > /dev/null 2>&1 &

sleep 1
