#!/usr/bin/python

import os
os.system('cp /etc/rc.local /etc/rc.local.firstboot')
fd=open('/etc/rc.local','r+')
templine='#StartOfPostOsInstall\n'
allLines=fd.readlines()
targetlines=[]
for oneLine in allLines:
        if oneLine == templine:
                break;
        print oneLine
        targetlines.append(oneLine)
fd.seek(0)
fd.truncate()
fd.writelines(targetlines)
fd.close()
