
#!/bin/bash

echo "<BR><BR><BR>started -- <BR><BR><BR>"
sudo /usr/sbin/wifite --clients-only --pmkid-timeout 13 -i wlan1mon --pmkid --skip-crack --pow 50 -p 13
echo "<BR><BR><BR>ok I ran"

#Below is the fix for wifite to stop throwing idiotic tty column check errors in the webui.
#Going to work on a rebuild of wifite that doesnt use the color bullcrap, its a 
#waste of resources and makes the output disgusting. rawr, angery about dum codez @_@
#
#"/usr/lib/python3/dist-packages/wifite/util/color.py"
#
#
#    @staticmethod
#    def clear_entire_line():
#        import os
#        (rows, columns) = os.popen('stty size', 'r').read().split()
#        Color.p('\r\n')
