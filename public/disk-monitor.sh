#!/bin/bash

URL="http://smarthub-dashboard.test/webhook/disk"

#echo "$1"
#echo $URL
servername="$1"

python_script=$(cat <<'EOF'
import sys, json

data = {'diskarray': []}
for line in sys.stdin.readlines():
    mount, total, used_by = line.rstrip(';').split()
    data['diskarray'].append(dict(mount=mount, spacetotal=total, used=used_by))
sys.stdout.write(json.dumps(data))
EOF
)

DISK="$(df -h | awk '/^\// { print $1" "$2" "$3";" }' | python -c "$python_script")"
echo "${DISK}"

generate_post_data()
{
cat <<EOF
{"dh":${DISK},"servername":"$servername"}
EOF
}

echo "$(generate_post_data)"

curl \
-H "Content-Type:application/json" \
-X POST --data "$(generate_post_data)" $URL