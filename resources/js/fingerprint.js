/**
 * fingerprint.js — Generate a simple browser/device fingerprint.
 *
 * Uses canvas + hardware signals. No external library needed.
 * Returns a hex string (SHA-256 hash) that stays stable per browser profile.
 */

let cachedFingerprint = null;

async function generateFingerprint() {
    if (cachedFingerprint) return cachedFingerprint;

    const components = [];

    // 1. User-Agent
    components.push(navigator.userAgent);

    // 2. Screen resolution + color depth
    components.push(`${screen.width}x${screen.height}x${screen.colorDepth}`);

    // 3. Timezone
    components.push(Intl.DateTimeFormat().resolvedOptions().timeZone);

    // 4. Language
    components.push(navigator.language);

    // 5. Platform
    components.push(navigator.platform || '');

    // 6. Hardware concurrency
    components.push(String(navigator.hardwareConcurrency || 0));

    // 7. Device memory (Chrome only)
    components.push(String(navigator.deviceMemory || 0));

    // 8. Canvas fingerprint
    try {
        const canvas = document.createElement('canvas');
        canvas.width = 200;
        canvas.height = 50;
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font = '14px Arial';
        ctx.fillStyle = '#f60';
        ctx.fillRect(10, 1, 62, 20);
        ctx.fillStyle = '#069';
        ctx.fillText('MalangVerse🔑', 2, 15);
        ctx.fillStyle = 'rgba(102, 204, 0, 0.7)';
        ctx.fillText('MalangVerse🔑', 4, 17);
        components.push(canvas.toDataURL());
    } catch {
        components.push('canvas-unavailable');
    }

    // 9. WebGL renderer
    try {
        const canvas2 = document.createElement('canvas');
        const gl = canvas2.getContext('webgl') || canvas2.getContext('experimental-webgl');
        if (gl) {
            const dbg = gl.getExtension('WEBGL_debug_renderer_info');
            if (dbg) {
                components.push(gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL));
                components.push(gl.getParameter(dbg.UNMASKED_VENDOR_WEBGL));
            }
        }
    } catch {
        components.push('webgl-unavailable');
    }

    // Hash everything into a 64-char hex string
    const raw = components.join('|||');
    const buffer = new TextEncoder().encode(raw);
    const hashBuffer = await crypto.subtle.digest('SHA-256', buffer);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    cachedFingerprint = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    return cachedFingerprint;
}

export { generateFingerprint };
