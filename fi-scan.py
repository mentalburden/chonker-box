#!/usr/bin/env python
#mostly stolen from github

import sys
import subprocess
import json
from datetime import datetime

now = datetime.now()
dt_string = now.strftime("%d/%m/%Y %H:%M:%S")
#DANGEROUS!!! SYS ARGS ARE A GATEWAY TO GTFOBINS @_@
lat = sys.argv[1]
lon = sys.argv[2]
jason = {'timestamp':dt_string, 'lat':lat, 'lon':lon, "data":{'essids':[], 'channels':[], 'sectypes':[], 'macaddresses':[]}}
interface = "wlan0"

def get_name(cell):
    this_ssid = matching_line(cell,"ESSID:")[1:-1]
    jason["data"]["essids"].append({'name':this_ssid})
    return this_ssid

def get_quality(cell):
    quality = matching_line(cell,"Quality=").split()[0].split('/')
    cleanstr = str(int(round(float(quality[0]) / float(quality[1]) * 100))).rjust(3) + "%"
#    jason["data"]["qualities"].append({'quality':cleanstr})
    return cleanstr

def get_channel(cell):
    this_chan =  matching_line(cell,"Channel:")
    jason["data"]["channels"].append({'channel':this_chan})
    return this_chan

def get_signal_level(cell):
    return matching_line(cell,"Quality=").split("Signal level=")[1]

def get_encryption(cell):
    enc=""
    if matching_line(cell,"Encryption key:") == "off":
        enc="Open"
    else:
        for line in cell:
            matching = match(line,"IE:")
            if matching!=None:
                wpa=match(matching,"WPA Version ")
                if wpa!=None:
                    enc="WPA v."+wpa
        if enc=="":
            enc="WPA2"
    jason["data"]["sectypes"].append({'sectype':enc})
    return enc

def get_address(cell):
    macaddy =  matching_line(cell,"Address: ")
    jason["data"]["macaddresses"].append({"mac":macaddy})
    return macaddy

rules={"Name":get_name,
       "Quality":get_quality,
       "Channel":get_channel,
       "Encryption":get_encryption,
       "Address":get_address,
       "Signal":get_signal_level
       }

def sort_cells(cells):
    sortby = "Quality"
    reverse = True
    cells.sort(None, lambda el:el[sortby], reverse)

columns=["Name","Address","Quality","Signal", "Channel","Encryption"]

def matching_line(lines, keyword):
    """Returns the first matching line in a list of lines. See match()"""
    for line in lines:
        matching=match(line,keyword)
        if matching!=None:
            return matching
    return None

def match(line,keyword):
    """If the first part of line (modulo blanks) matches keyword,
    returns the end of that line. Otherwise returns None"""
    line=line.lstrip()
    length=len(keyword)
    if line[:length] == keyword:
        return line[length:]
    else:
        return None

def parse_cell(cell):
    """Applies the rules to the bunch of text describing a cell and returns the
    corresponding dictionary"""
    parsed_cell={}
    for key in rules:
        rule=rules[key]
        parsed_cell.update({key:rule(cell)})
    return parsed_cell

def print_table(table):
    widths=map(max,map(lambda l:map(len,l),zip(*table))) #functional magic
    justified_table = []
    for line in table:
        justified_line=[]
        for i,el in enumerate(line):
            justified_line.append(el.ljust(widths[i]+2))
        justified_table.append(justified_line)
    for line in justified_table:
        for el in line:
            print el,
        print

def print_cells(cells):
    table=[columns]
    for cell in cells:
        cell_properties=[]
        for column in columns:
            cell_properties.append(cell[column])
        table.append(cell_properties)
    print_table(table)

def main():
    cells=[[]]
    parsed_cells=[]
    proc = subprocess.Popen(["sudo", "iwlist", interface, "scan"],stdout=subprocess.PIPE, universal_newlines=True)
    out, err = proc.communicate()
    for line in out.split("\n"):
        cell_line = match(line,"Cell ")
        if cell_line != None:
            cells.append([])
            line = cell_line[-27:]
        cells[-1].append(line.rstrip())

    cells=cells[1:]
    for cell in cells:
        parsed_cells.append(parse_cell(cell))
    sort_cells(parsed_cells)
#    print_cells(parsed_cells)

main()


### chonk it out to a json file for now:
with open('jsontemp.json','a+') as outfile:
    json.dump(jason, outfile)

#debug out for now, add in html table with links for wifite trigger later
print(jason['data']['essids'][0]['name'] + "<br>")
print(jason['data']['macaddresses'][0]['mac'] + "<br>")
print(jason['data']['sectypes'][0]['sectype'] + "<br>")
print(jason['data']['channels'][0]['channel'] + "<br>")
