const crypto = require('crypto');

// Generar 32 bytes aleatorios (256 bits para AES-256)
const key = crypto.randomBytes(32).toString('hex');

console.log('═══════════════════════════════════════════════════════════════');
console.log('  CLAVE DE CIFRADO GENERADA');
console.log('═══════════════════════════════════════════════════════════════\n');
console.log('Copia esta línea en tu archivo .env:\n');
console.log(`DATA_ENCRYPTION_KEY=${key}\n`);
console.log('═══════════════════════════════════════════════════════════════');
console.log('  ⚠️  IMPORTANTE - GUARDA ESTA CLAVE DE FORMA SEGURA');
console.log('═══════════════════════════════════════════════════════════════\n');
console.log('1. Agrega la línea al archivo .env en la raíz del proyecto');
console.log('2. NUNCA guardes esta clave en el repositorio Git');
console.log('3. Haz backup de esta clave en un lugar seguro');
console.log('4. Si pierdes esta clave, NO podrás descifrar los datos\n');
console.log(`Longitud: ${key.length} caracteres hexadecimales`);
console.log('Bits: 256 bits');
console.log('Algoritmo: AES-256-CBC\n');
