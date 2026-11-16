#!/usr/bin/env bash
set -uo pipefail
BASE=http://127.0.0.1:8931

# Get a session + CSRF token
rm -f /tmp/cj.txt
TOKEN=$(curl -s -c /tmp/cj.txt -b /tmp/cj.txt "$BASE/en/contact" \
  | grep -oE 'name="csrf-token" content="[^"]+"' | sed 's/.*content="//;s/"//')
if [ -z "$TOKEN" ]; then
  TOKEN=$(curl -s -c /tmp/cj.txt -b /tmp/cj.txt "$BASE/en/contact" \
    | grep -oE '"csrf_token":"[^"]+"' | head -1 | sed 's/.*:"//;s/"//')
fi
echo "TOKEN=${TOKEN:0:12}..."

curl -s -c /tmp/cj.txt -b /tmp/cj.txt -X POST "$BASE/en/contact" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-Requested-With: XMLHttpRequest" \
  -H "X-CSRF-TOKEN: $TOKEN" \
  -d '{
    "name":"Delivery Probe",
    "company":"Probe Ltd",
    "email":"probe.delivery@umistamping.com",
    "phone":"+62 778 111222",
    "inquiry_type":"engineering",
    "message":"Automated SMTP delivery verification. Please disregard this message.",
    "consent":true,
    "elapsed_ms":5000,
    "website":""
  }' -w "\nHTTP=%{http_code}\n"
