<?php
/**
 * Test básico del CryptoService
 */

require_once __DIR__ . '/../miembros/includes/CryptoService.php';

echo "═══════════════════════════════════════════════════════════════\n";
echo "  TEST CRYPTOSERVICE\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// 1. Generar una clave de prueba
echo "1. Generando clave de prueba...\n";
$testKey = bin2hex(random_bytes(32));
echo "   Clave generada: " . substr($testKey, 0, 20) . "...\n\n";

// 2. Crear instancia de CryptoService
echo "2. Creando instancia de CryptoService...\n";
try {
    $crypto = new CryptoService($testKey);
    echo "   ✓ CryptoService creado exitosamente\n\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// 3. Test de cifrado
echo "3. Test de cifrado:\n";
$testData = [
    "Juan Pérez",
    "2020-05-15",
    "+1-555-0123",
    "juan.perez@email.com"
];

foreach ($testData as $plaintext) {
    try {
        $encrypted = $crypto->encrypt($plaintext);
        echo "   Original:  $plaintext\n";
        echo "   Cifrado:   " . substr($encrypted, 0, 30) . "...\n";
        echo "   Longitud:  " . strlen($encrypted) . " caracteres\n\n";
    } catch (Exception $e) {
        echo "   ✗ Error cifrando '$plaintext': " . $e->getMessage() . "\n";
    }
}

// 4. Test de descifrado
echo "4. Test de descifrado (cifrar y descifrar):\n";
$original = "Sofía Rodríguez";
try {
    $encrypted = $crypto->encrypt($original);
    $decrypted = $crypto->decrypt($encrypted);

    echo "   Original:   $original\n";
    echo "   Cifrado:    " . substr($encrypted, 0, 30) . "...\n";
    echo "   Descifrado: $decrypted\n";

    if ($original === $decrypted) {
        echo "   ✓ Descifrado correcto!\n\n";
    } else {
        echo "   ✗ Error: descifrado no coincide\n\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 5. Test de isEncrypted
echo "5. Test de detección de cifrado:\n";
$plainText = "Texto plano";
$encryptedText = $crypto->encrypt("Texto cifrado");

echo "   Texto plano: \"$plainText\"\n";
echo "   isEncrypted(): " . ($crypto->isEncrypted($plainText) ? "true" : "false") . "\n";
echo "   Esperado: false\n\n";

echo "   Texto cifrado: \"" . substr($encryptedText, 0, 30) . "...\"\n";
echo "   isEncrypted(): " . ($crypto->isEncrypted($encryptedText) ? "true" : "false") . "\n";
echo "   Esperado: true\n\n";

if (!$crypto->isEncrypted($plainText) && $crypto->isEncrypted($encryptedText)) {
    echo "   ✓ Detección funciona correctamente!\n\n";
} else {
    echo "   ✗ Error en detección\n\n";
}

// 6. Test de arrays
echo "6. Test de cifrado de arrays:\n";
$arrayData = ["Polen", "Maní", "Lactosa"];
try {
    $encryptedArray = $crypto->encryptArray($arrayData);
    $decryptedArray = $crypto->decryptArray($encryptedArray);

    echo "   Original:   " . json_encode($arrayData) . "\n";
    echo "   Cifrado:    " . substr($encryptedArray, 0, 30) . "...\n";
    echo "   Descifrado: " . json_encode($decryptedArray) . "\n";

    if ($arrayData === $decryptedArray) {
        echo "   ✓ Arrays funcionan correctamente!\n\n";
    } else {
        echo "   ✗ Error: array descifrado no coincide\n\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 7. Test de compatibilidad con datos viejos
echo "7. Test de compatibilidad con datos mixtos:\n";
$oldData = "Datos sin cifrar";  // Simula dato viejo
$newData = $crypto->encrypt("Datos nuevos cifrados");

echo "   Dato viejo (texto plano): \"$oldData\"\n";
if (!$crypto->isEncrypted($oldData)) {
    echo "   ✓ Detecta correctamente como NO cifrado\n";
    echo "   ✓ Se puede usar directamente sin descifrar\n\n";
}

echo "   Dato nuevo (cifrado): \"" . substr($newData, 0, 30) . "...\"\n";
if ($crypto->isEncrypted($newData)) {
    $decrypted = $crypto->decrypt($newData);
    echo "   ✓ Detecta correctamente como cifrado\n";
    echo "   ✓ Descifrado: \"$decrypted\"\n\n";
}

echo "═══════════════════════════════════════════════════════════════\n";
echo "  TODOS LOS TESTS COMPLETADOS\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Próximo paso: Integrar CryptoService en sdk.php\n\n";
