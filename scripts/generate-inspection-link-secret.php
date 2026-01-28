<?php
/**
 * Script para generar un secreto seguro para firmar links de modo-inspección (HMAC).
 *
 * Uso:
 *   php scripts/generate-inspection-link-secret.php
 *
 * Pegar en tu archivo .env:
 *   INSPECTION_LINK_SECRET=<clave-generada>
 */

$keyBytes = random_bytes(32);
$keyHex = bin2hex($keyBytes); // 64 hex chars

echo "═══════════════════════════════════════════════════════════════\n";
echo "  INSPECTION LINK SECRET GENERADO\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "Copia esta línea en tu archivo .env:\n\n";
echo "INSPECTION_LINK_SECRET={$keyHex}\n\n";
echo "Opcional (TTL del link en segundos, default 7 días):\n";
echo "INSPECTION_LINK_TTL_SECONDS=604800\n\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "  ⚠️  IMPORTANTE - GUARDA ESTA CLAVE DE FORMA SEGURA\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "- No commitear .env\n";
echo "- Rotar esta clave invalida links antiguos\n";
echo "- Recomendado: 32 bytes (64 hex)\n\n";
