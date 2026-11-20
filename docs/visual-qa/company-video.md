# Authentic UMI profile video — delivery plan

Authoritative source: Drive file ID 1TG8YE0MxVe2aQjj5IaukehXx_JJzdBDw; name Company Profile Video; MIME video/quicktime; size 1,017,676,520 bytes.

**Access limitation:** Connected Drive download rejected the original with HTTP 413: 1,017,676,520 bytes exceeds the connector limit of 268,435,456 bytes. Actual codecs, duration, orientation and audio cannot be verified or transcoded from this connection. This is NOT a verified playable MP4.

1. Download the original MOV onto a trusted workstation using Drive outside the connector limit.
2. Run the supplied script: bash scripts/optimize-company-video.sh /path/to/Company_Profile.mov /external/media/company-profile.mp4
3. Review audio/video, metadata, rotation, seeking and the generated company-profile-poster.jpg.
4. Upload MP4 and poster to durable media storage with byte range requests. Do not use a Drive preview URL as a production video endpoint.
5. Set VITE_UMI_COMPANY_PROFILE_URL to the verified media CDN URL in the Vite build environment, rebuild, and verify playback across desktop/mobile browsers.

The About video is loaded only after the user clicks Play. The player displays a clear error state for unavailable media. The original 1 GB MOV must never be committed to Git.
