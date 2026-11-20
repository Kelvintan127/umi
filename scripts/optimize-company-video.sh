#!/usr/bin/env bash
# Transcode the AUTHENTIC UMI Company Profile Video, externally supplied as a
# QuickTime MOV. Neither source nor MP4 belongs in this Git repository.
set -euo pipefail
if [[ $# -ne 2 ]]; then
  echo "Usage: $0 original.mov output.mp4" >&2
  exit 2
fi
input="$1"; output="$2"
[[ -r "$input" ]] || { echo "Missing original media: $input" >&2; exit 1; }
[[ "$output" != "$input" ]] || { echo "Input and output must differ" >&2; exit 1; }
mkdir -p "$(dirname "$output")"
ffprobe -v error -show_entries format=duration,size,format_name:stream=index,codec_type,codec_name,width,height -of json "$input"
ffmpeg -hide_banner -nostdin -y -i "$input" \
  -map 0:v:0 -map 0:a? -map_metadata 0 \
  -vf "scale=w='min(1920,iw)':h=-2" \
  -c:v libx264 -preset medium -crf 23 -pix_fmt yuv420p \
  -c:a aac -b:a 160k -movflags +faststart -sn -dn "$output"
ffmpeg -hide_banner -loglevel error -y -ss 1 -i "$output" \
  -frames:v 1 -q:v 3 "$(dirname "$output")/company-profile-poster.jpg"
ffprobe -v error -show_entries format=duration,size,format_name:stream=index,codec_type,codec_name,width,height -of json "$output"
echo "Upload output and poster to persistent media storage/CDN. Do not commit to Git."
