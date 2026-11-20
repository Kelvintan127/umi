# RFQ attachments — implementation notes

- Allowed formats: PDF, DWG, DXF, STEP/STP, IGES/IGS.
- Files are processed through Laravel's multipart Inertia form handling with a maximum of 3 files and maximum **25 MiB total**. Each file is also individually capped at 25 MiB.
- The server verifies basic file signatures, limits extensions, validates sizes and stores using UUID filenames on the private \`local\` disk at \`storage/app/private/inquiries/{id}/\`.
- The existing \`Inquiry\` row stores only the original display name, server path, detected MIME and size in a nullable JSON array. Storage occurs before mail delivery. Failed mail does not lose the inquiry or its files.
- The private files are attached only to the internal sales office email. They are never sent in the customer acknowledgement.
- The uploads are not exposed by a new public URL. Existing \`storage:link\` serves only \`storage/app/public\`, not private files.
- This is **signature validation, not malware scanning**. For production, add AV scanning, access-control and retention controls, monitor mail size limits and test customer files against real CAD samples.
- Ensure \`upload_max_filesize >= 26M\`, \`post_max_size >= 30M\` and \`client_max_body_size >= 30M\` (or the equivalent upstream body limit). Do not add file uploads to a production environment with smaller request limits.
- In short-lived or horizontally scaled deployments, ensure private storage persists and is available to mail workers; local ephemeral containers are insufficient.
- Run \`php artisan migrate --force\` before enabling the updated contact form.

