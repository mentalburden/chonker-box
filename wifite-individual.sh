#!/bin/bash
###DANGER!!!###
# USES UNSANITIZED ARG FROM INDEX.PHP
# super dangerous and could be coupled with ;{} to break away from wifite and spawn nastyboi shells
# need to santize input for mac addresses only in index.php!!!
###DANGER!!!### @_@

echo "<BR><BR><BR>started individual task for $1 -- <BR><BR><BR>"
sudo /usr/sbin/wifite -i wlan1mon --pmkid --pmkid-timeout 30 --skip-crack -b $1
echo "<BR><BR><BR>ok I ran"
