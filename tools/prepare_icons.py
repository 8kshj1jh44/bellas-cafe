"""
Download + sanitize Bella's Cafe icon set from svgrepo.com.

Input: JSON file mapping icon-name -> svgrepo /show/<id>/<slug>.svg URL
       (e.g. {"coffee-cup": "https://www.svgrepo.com/show/102979/coffee-cup-with-steam.svg"})
Output: themes/astra-child/assets/icons/<name>.svg  (sanitized, currentColor, viewBox-only sizing)
        themes/astra-child/assets/icons/README.md    (attribution: source URL per icon)

Usage: python tools/prepare_icons.py tools/icon_sources.json
"""
import json
import re
import subprocess
import sys
import time
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
DEST = ROOT / "themes" / "astra-child" / "assets" / "icons"

ALLOWED_TAGS = {"svg", "path", "circle", "ellipse", "rect", "line", "polyline", "polygon", "g", "defs", "use", "title"}


def fetch(url: str) -> str:
    for attempt in range(4):
        r = subprocess.run(
            ["curl", "-sL", "--max-time", "40", "-A", "Mozilla/5.0 (Windows NT 10.0; Win64; x64)", url],
            capture_output=True, text=True, encoding="utf-8", errors="replace", timeout=45,
        ).stdout
        if r.startswith("<?xml") or r.lstrip().startswith("<svg"):
            return r
        time.sleep(10 * (attempt + 1))  # svgrepo rate limits in bursts; back off
    raise RuntimeError(f"could not fetch {url}")


def sanitize(name: str, raw: str, source: str) -> str:
    svg = re.sub(r"<\?xml[^>]*\?>", "", raw)
    svg = re.sub(r"<!DOCTYPE[^>]*>", "", svg, flags=re.S)
    svg = re.sub(r"<!--.*?-->", "", svg, flags=re.S)
    svg = re.sub(r"<metadata[\s\S]*?</metadata>", "", svg, flags=re.I)
    svg = re.sub(r"<style[\s\S]*?</style>", "", svg, flags=re.I)
    svg = re.sub(r"<text[\s\S]*?</text>", "", svg, flags=re.I)

    root = re.search(r"<svg\b[^>]*>", svg, flags=re.I)
    if not root:
        raise ValueError(f"{name}: no <svg> root found")
    root_tag = root.group(0)

    # Security: drop scripts, event handlers, external references.
    svg = re.sub(r"<script[\s\S]*?</script>", "", svg, flags=re.I)
    svg = re.sub(r"\son\w+=\"[^\"]*\"", "", svg, flags=re.I)
    svg = re.sub(r"\son\w+='[^']*'", "", svg, flags=re.I)
    svg = re.sub(r"\shref=\"(?!#)[^\"]*\"", ' href="#"', svg, flags=re.I)

    vb = re.search(r'viewBox="([^"]+)"', root_tag)
    if not vb:
        w = re.search(r'width="([\d.]+)', root_tag)
        h = re.search(r'height="([\d.]+)', root_tag)
        if not (w and h):
            raise ValueError(f"{name}: no viewBox derivable")
        root_tag = root_tag.replace("<svg", f'<svg viewBox="0 0 {w.group(1)} {h.group(1)}"', 1)

    root_tag = re.sub(r'\s(width|height|class|id|style|fill|xmlns(?::\w+)?)="[^"]*"', "", root_tag)

    # Stroke-based (line-art) icons must not be filled: filling turns them into
    # solid blobs. Detect via a fill="none" root on the source artwork.
    is_stroke_icon = 'fill="none"' in root_tag or "fill='none'" in root_tag
    if is_stroke_icon:
        root_tag = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"' + root_tag[len("<svg"):]
    else:
        root_tag = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"' + root_tag[len("<svg"):]

    svg = svg.replace(root.group(0), root_tag, 1)

    # Drop full-canvas background rects: they render as a solid block behind
    # the artwork (the "cut-off logo" bug).
    svg_vb = re.search(r'viewBox="([\d. -]+)"', root_tag)
    if svg_vb:
        x, y, w, h = [float(v) for v in svg_vb.group(1).split()]
        for rm in list(re.finditer(r'<rect\b[^>]*/?>', svg)):
            rw = re.search(r'width="([\d.]+)"', rm.group(0))
            rh = re.search(r'height="([\d.]+)"', rm.group(0))
            if rw and rh and float(rw.group(1)) >= w * 0.85 and float(rh.group(1)) >= h * 0.85:
                svg = svg.replace(rm.group(0), "")

    # Monocolor normalization: explicit fills and strokes become currentColor,
    # and svgrepo mixer style attrs (e.g. style="fill:#010002") are dropped so
    # nothing overrides currentColor inheritance.
    svg = re.sub(r"\sstyle=\"[^\"]*\"", "", svg)
    svg = re.sub(r"\sstyle='[^']*'", "", svg)
    svg = re.sub(r'fill="(?!none|currentColor)[^"]*"', 'fill="currentColor"', svg)
    svg = re.sub(r'stroke="(?!none|currentColor)[^"]*"', 'stroke="currentColor"', svg)

    # Strip disallowed elements (rare, but svgrepo mixes in foreign markup).
    svg = re.sub(r"<(\w+)[^>]*>.*?</\1>", lambda m: m.group(0) if m.group(1).lower() in ALLOWED_TAGS else "", svg, flags=re.S)
    svg = re.sub(r"</?(?!svg\b|path\b|circle\b|ellipse\b|rect\b|line\b|polyline\b|polygon\b|g\b|defs\b|use\b|title\b)\w+[^>]*/?>", "", svg)

    # svgrepo mixer leftovers: CSS orphaned by <style> removal, stray numeric
    # junk between tags. Neither renders, but they dirty the files.
    svg = re.sub(r">[^<]*\{[^}]*\}[^<]*<", "><", svg)
    svg = re.sub(r">\s*[0-9.][0-9.\s]*<", "><", svg)

    header = f"<!-- Source: {source} | svgrepo.com | see icons README.md for license -->\n"
    return header + re.sub(r"\n\s*\n", "\n", svg).strip() + "\n"


def reclean(path: Path) -> None:
    """Apply the junk-cleanup passes to an already-sanitized local file."""
    svg = path.read_text(encoding="utf-8")
    svg = re.sub(r'(<svg\b[^>]*?)\s+xmlns="http://www\.w3\.org/2000/svg"(?=[^>]*xmlns=)', r"\1", svg, count=1)
    svg = re.sub(r"\sstyle=\"[^\"]*\"", "", svg)
    svg = re.sub(r"\sstyle='[^']*'", "", svg)
    svg = re.sub(r">[^<]*\{[^}]*\}[^<]*<", "><", svg, flags=re.S)
    svg = re.sub(r">\s*[0-9.][0-9.\s]*<", "><", svg)
    svg = re.sub(r"\n\s*\n", "\n", svg)
    path.write_text(svg.strip() + "\n", encoding="utf-8")


def main() -> None:
    sources = json.loads(Path(sys.argv[1]).read_text(encoding="utf-8"))
    DEST.mkdir(parents=True, exist_ok=True)
    readme = ["# Bella's Cafe icon set", "",
              "Icons downloaded from [SVG Repo](https://www.svgrepo.com/) and sanitized for",
              "inline use (currentColor fill, no fixed size). All icons are from CC0 /",
              "public-domain collections unless noted otherwise.", ""]
    failed = []
    for name, url in sources.items():
        try:
            raw = fetch(url)
            (DEST / f"{name}.svg").write_text(sanitize(name, raw, url), encoding="utf-8")
            slug = re.search(r"/show/(\d+)/([a-z0-9-]+)\.svg", url)
            label = re.sub(r"[-_]", " ", slug.group(2)).title() if slug else name
            readme.append(f"- `{name}.svg` — [{label}]({url})")
            print(f"ok   {name}")
        except Exception as e:  # noqa: BLE001 - collect and continue
            failed.append((name, str(e)))
            print(f"FAIL {name}: {e}")
        time.sleep(25)
    (DEST / "README.md").write_text("\n".join(readme) + "\n", encoding="utf-8")
    if failed:
        print("FAILED:", failed)
        sys.exit(1)


if __name__ == "__main__":
    main()
