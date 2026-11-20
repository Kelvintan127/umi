/**
 * Extract the six approved manufacturing-process icons from the bundled ZIP.
 * This is intentionally dependency-free and only accepts a fixed filename set.
 * npm's predev/prebuild lifecycle hooks run this before Vite serves public/.
 */
import { existsSync, mkdirSync, readFileSync, writeFileSync } from "node:fs";
import { dirname, join } from "node:path";
import { inflateRawSync } from "node:zlib";
import { fileURLToPath } from "node:url";

const projectRoot = join(dirname(fileURLToPath(import.meta.url)), "..");
const input = join(projectRoot, "resources/assets/UMI_process_icons_no_numbers.zip");
const destination = join(projectRoot, "public/images/process");

const allowed = new Set([
  "UMI_Engineering.png", "UMI_Tooling.png", "UMI_Stamping.png",
  "UMI_Inspection.png", "UMI_Assembly.png", "UMI_Delivery.png",
]);

if (!existsSync(input)) {
  throw new Error("Approved UMI process icon ZIP is missing: " + input);
}
const zip = readFileSync(input);
mkdirSync(destination, { recursive: true });

let offset = 0;
const extracted = new Set();
while (offset + 30 <= zip.length && zip.readUInt32LE(offset) === 0x04034b50) {
  const flags = zip.readUInt16LE(offset + 6);
  const method = zip.readUInt16LE(offset + 8);
  const size = zip.readUInt32LE(offset + 18);
  const unpacked = zip.readUInt32LE(offset + 22);
  const filenameSize = zip.readUInt16LE(offset + 26);
  const extraSize = zip.readUInt16LE(offset + 28);
  const nameStart = offset + 30;
  const name = zip.toString("utf8", nameStart, nameStart + filenameSize);
  const dataStart = nameStart + filenameSize + extraSize;
  const dataEnd = dataStart + size;

  if (flags & 0x08 || (method !== 0 && method !== 8) || dataEnd > zip.length) {
    throw new Error("Unexpected icon ZIP entry: " + name);
  }
  if (!allowed.has(name)) {
    throw new Error("ZIP includes an unexpected filename: " + name);
  }
  const contents = method === 8 ? inflateRawSync(zip.subarray(dataStart, dataEnd)) : zip.subarray(dataStart, dataEnd);
  if (contents.length !== unpacked || contents.readUInt32BE(0) !== 0x89504e47) {
    throw new Error("Invalid PNG entry: " + name);
  }
  writeFileSync(join(destination, name), contents);
  extracted.add(name);
  offset = dataEnd;
}
if (extracted.size !== allowed.size) {
  throw new Error("Expected six approved process icons, got " + extracted.size);
}
console.log("Prepared " + extracted.size + " UMI manufacturing-process icons");
