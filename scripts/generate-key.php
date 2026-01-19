<?php
/**
 * Script para generar una clave de cifrado segura
 * 
 * Uso:
 *   php generate-key.php
 * 
 * La clave generada debe guardarse en el archivo .env:
 *   DATA_ENCRYPTION_KEY=<clave-generada>
 */

// Generar 32 bytes aleatorios (256 bits para AES-256)
$keyBytes = random_bytes(32);

// Convertir a hexadecimal para facilitar almacenamiento
$keyHex = bin2hex($keyBytes);

echo "═══════════════════════════════════════════════════════════════\n";
echo "  CLAVE DE CIFRADO GENERADA\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "Copia esta línea en tu archivo .env:\n\n";
echo "DATA_ENCRYPTION_KEY={$keyHex}\n\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "  ⚠️  IMPORTANTE - GUARDA ESTA CLAVE DE FORMA SEGURA\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "1. Agrega la línea al archivo .env en la raíz del proyecto\n";
echo "2. NUNCA guardes esta clave en el repositorio Git\n";
echo "3. Haz backup de esta clave en un lugar seguro\n";
echo "4. Si pierdes esta clave, NO podrás descifrar los datos\n\n";
echo "Longitud: " . strlen($keyHex) . " caracteres hexadecimales\n";
echo "Bits: 256 bits\n";
echo "Algoritmo: AES-256-CBC\n\n";
