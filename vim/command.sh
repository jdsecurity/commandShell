args ./**/*.php
argdo %s/source/target/ge | update
%s/\n\+\%$//
%s/\s*$//

vimgrep
