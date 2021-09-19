#!/bin/bash

m3u_src=$IPTV_M3U_URL
today=$(date +%Y%m%d)
m3u_file=/config/iptv-$today.m3u

if [ ! -f "$m3u_file" ]; then
  # Delete files downloaded over seven days ago.
  find /config/iptv-* -mtime +7 -exec rm {} \;

  # Download the m3u files.
  curl -s $m3u_src --output $m3u_file
  #grep group-title $m3u_file | grep -oP "group-title=\"(.*?)\"" | cut -d= -f2 | sort -u > categories-$today.txt
  echo "#EXTM3U" > /config/iptv-filtered.m3u
  while read line; do
    linereg=$(echo $line | sed 's/\\/\\\\/g' | sed 's/|/\\|/g' | sed 's/\./\\\./g' | sed 's/\^/\\\^/g' | sed 's/\$/\\\$/g' | sed 's/\*/\\\*/g' | sed 's/\+/\\\+/g' | sed 's/\-/\\\-/g' | sed 's/\?/\\\?/g' | sed 's/(/\\(/g' | sed 's/)/\\)/g' | sed 's/\[/\\\[/g' | sed 's/\]/\\\]/g' | sed 's/{/\\{/g' | sed 's/}/\\}/g' | sed 's/\—/\\\-/g' | sed 's|\/|\\\/|g')
    grep -E "^#EXTINF.*group\-title=$linereg" -A 1 $m3u_file | sed "/^--$/d" >> /config/iptv-filtered.m3u
  done </config/keep-only.txt 
fi

exit 0