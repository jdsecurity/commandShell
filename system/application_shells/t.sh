#!/bin/bash

webProducts85=(87873cn extproduct gamesold ldmobile ldzone)
for webProduct in ${webProducts85[*]}
do
echo "rsync -zvRrtopg --delete daemon@60.28.206.85::web$webProduct /var/htmlwww/85web/$webProduct >> /var/htmlwww/85web/web$webProduct.txt"
        `rsync -zvRrtopg --delete daemon@60.28.206.85::web$webProduct /var/htmlwww/85web/$webProduct >> /var/htmlwww/85web/web$webProduct.txt`
done
