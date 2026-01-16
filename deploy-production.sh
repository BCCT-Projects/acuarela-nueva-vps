#!/bin/bash
# Deploy Acuarela a Producción
set -e

echo "🚀 Desplegando Acuarela a producción..."

# Detener contenedores actuales
docker compose -f docker-compose.production.yml down 2>/dev/null || true

# Limpiar imágenes antiguas
docker image prune -f

# Construir y levantar
docker compose -f docker-compose.production.yml up -d --build

# Esperar a que esté listo
sleep 5

echo ""
echo "✅ Deploy completado"
echo "🌐 Acceso: http://152.42.152.212"
echo ""
echo "Ver logs: docker compose -f docker-compose.production.yml logs -f"
