<?php
/**
 * CryptoService - Servicio de cifrado/descifrado para datos sensibles
 * 
 * Implementa cifrado AES-256-CBC para proteger información personal
 * de menores y familias en cumplimiento con SOC 2, ISO 27001, COPPA.
 * 
 * @author Acuarela Security Team
 * @version 1.0
 */

class CryptoService
{
    /**
     * Clave de cifrado (debe ser de 32 bytes para AES-256)
     */
    private $encryptionKey;

    /**
     * Algoritmo de cifrado
     */
    private $cipher = 'AES-256-CBC';

    /**
     * Constructor
     * 
     * @param string $key Clave de cifrado hexadecimal
     * @throws Exception Si la clave no es válida
     */
    public function __construct($key)
    {
        if (empty($key)) {
            throw new Exception('Encryption key cannot be empty');
        }

        // Convertir clave hexadecimal a binario
        $this->encryptionKey = hex2bin($key);

        if (strlen($this->encryptionKey) !== 32) {
            throw new Exception('Encryption key must be 32 bytes (64 hex characters)');
        }
    }

    /**
     * Cifra un valor usando AES-256-CBC
     * 
     * @param string $plaintext Texto plano a cifrar
     * @return string Texto cifrado en base64 (incluye IV)
     */
    public function encrypt($plaintext)
    {
        // No cifrar valores vacíos
        if (empty($plaintext)) {
            return $plaintext;
        }

        try {
            // Generar IV único para esta operación
            $ivLength = openssl_cipher_iv_length($this->cipher);
            $iv = openssl_random_pseudo_bytes($ivLength);

            // Cifrar datos
            $encrypted = openssl_encrypt(
                $plaintext,
                $this->cipher,
                $this->encryptionKey,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($encrypted === false) {
                throw new Exception('Encryption failed');
            }

            // Combinar IV + datos cifrados y codificar en base64
            // Formato: base64(IV + ciphertext)
            return base64_encode($iv . $encrypted);

        } catch (Exception $e) {
            // Log error (sin exponer datos sensibles)
            error_log('CryptoService encrypt error: ' . $e->getMessage());
            throw new Exception('Failed to encrypt data');
        }
    }

    /**
     * Descifra un valor cifrado con AES-256-CBC
     * 
     * @param string $ciphertext Texto cifrado en base64
     * @return string Texto plano descifrado
     */
    public function decrypt($ciphertext)
    {
        // No descifrar valores vacíos
        if (empty($ciphertext)) {
            return $ciphertext;
        }

        try {
            // Decodificar base64
            $data = base64_decode($ciphertext, true);

            if ($data === false) {
                throw new Exception('Invalid base64 data');
            }

            // Extraer IV y datos cifrados
            $ivLength = openssl_cipher_iv_length($this->cipher);

            if (strlen($data) < $ivLength) {
                throw new Exception('Invalid ciphertext length');
            }

            $iv = substr($data, 0, $ivLength);
            $encrypted = substr($data, $ivLength);

            // Descifrar
            $decrypted = openssl_decrypt(
                $encrypted,
                $this->cipher,
                $this->encryptionKey,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($decrypted === false) {
                throw new Exception('Decryption failed');
            }

            return $decrypted;

        } catch (Exception $e) {
            // Log error (sin exponer datos sensibles)
            error_log('CryptoService decrypt error: ' . $e->getMessage());
            throw new Exception('Failed to decrypt data');
        }
    }

    /**
     * Verifica si un valor está cifrado
     * 
     * Usa heurística para detectar si un valor es texto cifrado base64
     * vs texto plano. Esto permite compatibilidad con datos viejos.
     * 
     * @param string $value Valor a verificar
     * @return bool True si el valor parece estar cifrado
     */
    public function isEncrypted($value)
    {
        // Valores vacíos no están cifrados
        if (empty($value)) {
            return false;
        }

        // Un valor cifrado debe tener longitud mínima
        // IV (16 bytes) + mínimo 1 bloque cifrado (16 bytes) = 32 bytes raw
        // En base64: ~44 caracteres mínimo
        if (strlen($value) < 44) {
            return false;
        }

        // Verificar que sea base64 válido
        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            return false;
        }

        // Verificar que el base64 decode/encode sea idéntico
        if (base64_encode($decoded) !== $value) {
            return false;
        }

        // Verificar que tenga longitud suficiente para IV + datos
        $ivLength = openssl_cipher_iv_length($this->cipher);
        if (strlen($decoded) < $ivLength + 1) {
            return false;
        }

        return true;
    }

    /**
     * Cifra un array convirtiéndolo a JSON primero
     * 
     * @param array $data Array a cifrar
     * @return string JSON cifrado en base64
     */
    public function encryptArray($data)
    {
        if (empty($data)) {
            return json_encode([]);
        }

        $json = json_encode($data);
        return $this->encrypt($json);
    }

    /**
     * Descifra un JSON cifrado y lo convierte a array
     * 
     * @param string $ciphertext JSON cifrado
     * @return array Array descifrado
     */
    public function decryptArray($ciphertext)
    {
        if (empty($ciphertext)) {
            return [];
        }

        // Si no está cifrado, intentar decodificar directamente
        if (!$this->isEncrypted($ciphertext)) {
            $decoded = json_decode($ciphertext, true);
            return $decoded !== null ? $decoded : [];
        }

        $json = $this->decrypt($ciphertext);
        $decoded = json_decode($json, true);

        return $decoded !== null ? $decoded : [];
    }
}
