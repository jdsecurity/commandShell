#!/bin/bash

webProducts85=()
#ldzone ldmobile 87873cn extproduct gamesold
for webProduct in ${webProducts85[*]}
do
echo "rsync -zvRrtopg --delete daemon@60.28.206.85::web$webProduct /var/htmlwww/85web/$webProduct"
        `rsync -zvRrtopg --delete daemon@60.28.206.85::web$webProduct /var/htmlwww/85web/$webProduct >> /var/htmlwww/85web/web$webProduct.txt`
done

webProducts86=(code)
#backzf001 fetions codes mobilegame newzf001 spider
for webProduct in ${webProducts86[*]}
do
echo "rsync -zvRrtopg --delete daemon@60.28.206.86::web$webProduct /var/htmlwww/86web/$webProduct"
        `rsync -zvRrtopg --delete daemon@60.28.206.86::web$webProduct /var/htmlwww/86web/$webProduct >> /var/htmlwww/86web/web$webProduct.txt`
done
