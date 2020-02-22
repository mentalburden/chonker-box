# Chonker-box: backpack mounted wifi destruction

![chonkers](https://i.imgur.com/vc8Qlk8.gif)

Two piece kit, smolbear and lorgbear. All built with pluckNchuck/OTS hardware, all available on Amazan dot calm. Enables GSM WAN access with integrated VPN on the go, wifi pwn platforms, file transfer/exfiltration, and runs off two Anker usb batteries. Easily stored in a backpack, purse, or UPS box. Can run for 9hours off one full charge (and limited C2 activity). 

Also good for:

+ Site survey/heatmapping
+ Snatching parking lot hashes
+ run/jog/burn operations
+ B.S.S.T.  :p
+ Organizational Enumeration , OODA, and initial penetration
+ Being a nice person who does legal things!

Not good for:

+ Illegal, immoral, or violent actions of any type

====

### "smolbear-fi-scan"

- raspi zero with newest kaliarm-lite distro, good battery, backup sd card (butyl tape it together and bag it)
- wifite, zt+ int, socat/netcat C2 revsh, rt8187 driver fix, iwlist python parser, apache2, php7+goodies, strap wireless to C2 mobile hotspot
- get coords of c2 mobile, pass them with php-get to apache on raspi, run iwlist parse, generate json with coords and near wnet data
- push all this info accross c2 mobile hotspot wan to firestore/nosql, run trendanny/visualization after op
- LATER: automate wifite to grab handshakes (skip wps garbage and wordlist crack for time/resource savings)
- LATER: distributed and make C++ version for esp32 and maybe 8266 (hardcoded creds for pyrebase)

Throw index.php and fi-scan.py into the apache working dir. Touch jsontemp.json, or whatever you change the working json file to, it needs write access for www-data.  Ensure ssl is up and visit the static address with your C2 mobile.



### "lorgbear-gourd"

- Raspi3 with arm-debian, mt7628nn mini rtr, E series 4g usb modem, good battery, wetbox, foam/butyl tape together
  - raspi3: wpumpkin, socat public C2 revsh, custom captives (amazan,corncast,tnobel,freshmesh), MITM proxykit (runs really slow though), cred harvester proxy, wifite, hcxdumptools (includes hcxpcap now too), LAMP or VSFTPD (for hash transfer)
  - mediatek: socat public c2 revsh, openvpn tunnel all wan traffic to geographically near VPS (same state/country)
  - usb modem: use clean MVNO provider only (ultra,cricket,ting), no big names due to APN/DNS/MAC monitoring, never enable mms, NO TRACFONE!!!
- NOTE: raspi3 does heavy lifting for proxy/hostapd, minirtr does wan traffic and local C2 network handling        
- Use smolbear for enum and OODA, then use lorgbear for actions and tasks
- lorgbear in quiet mode is good for C2 wan access/tunnels, keep it quiet, keep it safe
- wetbox/case and foam need to be RF transparent, or pop a hole and use a usb extender
- can add a 2W 2.4ghz amp to rt8187 for parabolics and yagis, but rare use case; could use SMA connectors on wetbox for this to keep amp external (hot).
- needs exhaust fan in wet box, also need to print a mount plate for the ots hardware (keep things from rattling, rolled up craft foam sheets work for now).



BOM: <BR>
<BR>
1x - https://www.amazon.com/Vilros-Raspberry-Starter-Power-Premium/dp/B0748MPQT4 <BR>
1x - https://www.amazon.com/Vilros-Raspberry-Clear-Power-Supply/dp/B01D92SSX6 <BR>
3x - https://www.amazon.com/SanDisk-Ultra-microSDXC-Memory-Adapter/ <BR>
1x - https://www.amazon.com/gp/product/B001SH5U0E/ <BR>
2x - https://www.amazon.com/Anker-PowerCore-Portable-Double-Speed-Recharging/dp/B01JIWQPMW/ <BR>
1x - https://www.amazon.com/Unlocked-Huawei-E397u-53-Worldwide-Required/dp/B01M0JY15V/ <BR>
1x - https://www.amazon.com/gp/product/B073TSK26W/ <BR>
1x - https://www.amazon.com/Yunpo-Sealant-Waterproof-Headlamps-Windshield/dp/B07PRXRF9D   (The best stuff ever) <BR>
USB + cat5 + sma connectors + 2.4ghz amp + antenna/parabola/yagi <BR>
<BR><BR>
200'ish bux usd, depending on market prices


<BR><BR>
![open](https://i.imgur.com/ZcWmyR4.jpg)
<BR><BR>
![closed](https://i.imgur.com/l9ohIO9.jpg)
