#!/bin/bash

echo "<BR><BR><BR>started individual task for $1 -- <BR><BR><BR>"
sudo /usr/sbin/wifite -i wlan1mon --pmkid --pmkid-timeout 30 --skip-crack -b $1
echo "<BR><BR><BR>ok I ran"
