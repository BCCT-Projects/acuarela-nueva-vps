#!/bin/bash
# Deploy Acuarela a Producción - Optimizado con Build Condicional
set -e

COMPOSE_FILE="docker-compose.production.yml"
DEPLOY_STATE_FILE=".deploy_state"
BUILD_MODE="full"  # full, cache, none

echo "🚀 Desplegando Acuarela a producción..."

# Obtener commit actual
CURRENT_COMMIT=""
if [ -n "$GITHUB_SHA" ]; then
    CURRENT_COMMIT="$GITHUB_SHA"
elif [ -d ".git" ]; then
    CURRENT_COMMIT=$(git rev-parse HEAD 2>/dev/null || echo "")
fi

# Leer último commit desplegado
LAST_COMMIT=""
if [ -f "$DEPLOY_STATE_FILE" ]; then
    LAST_COMMIT=$(cat "$DEPLOY_STATE_FILE" 2>/dev/null | head -1 | tr -d '[:space:]' || echo "")
fi

# Determinar modo de build
if [ -z "$CURRENT_COMMIT" ] || [ -z "$LAST_COMMIT" ] || [ "$CURRENT_COMMIT" != "$LAST_COMMIT" ]; then
    if [ -d ".git" ] && [ -n "$LAST_COMMIT" ] && [ "$LAST_COMMIT" != "" ]; then
        # Verificar qué archivos cambiaron
        CHANGED_FILES=$(git diff --name-only "$LAST_COMMIT" HEAD 2>/dev/null || echo "")
        
        if [ -n "$CHANGED_FILES" ]; then
            # Verificar si cambió composer.json o Dockerfile (requiere rebuild completo)
            if echo "$CHANGED_FILES" | grep -qE "(Dockerfile|docker-compose|composer\.json|composer\.lock)"; then
                BUILD_MODE="full"
                echo "📦 Cambios en archivos críticos (Dockerfile/composer.json) - rebuild completo"
            # Si solo cambian archivos de código (PHP, JS, HTML, CSS)
            elif echo "$CHANGED_FILES" | grep -qE "(\.php$|\.js$|\.html$|\.css$|\.scss$)"; then
                BUILD_MODE="cache"
                echo "📝 Solo cambios en código (PHP/JS/CSS) - rebuild con cache (rápido)"
            else
                # Cambios en otros archivos (docs, configs, etc)
                BUILD_MODE="cache"
                echo "📄 Cambios menores detectados - rebuild con cache"
            fi
        else
            BUILD_MODE="full"
            echo "📦 Commit diferente pero sin cambios detectados - rebuild completo por seguridad"
        fi
    else
        BUILD_MODE="full"
        echo "📦 Primera vez o sin git - rebuild completo"
    fi
else
    BUILD_MODE="none"
    echo "✅ Sin cambios desde último deploy (commit: $CURRENT_COMMIT)"
fi

# Detener contenedores actuales
echo "🛑 Deteniendo contenedores actuales..."
docker compose -f "$COMPOSE_FILE" down 2>/dev/null || true

# Limpiar imágenes huérfanas (no las que están en uso)
echo "🧹 Limpiando imágenes huérfanas..."
docker image prune -f 2>/dev/null || true

# Ejecutar según el modo
case "$BUILD_MODE" in
    "full")
        echo "🔨 Reconstruyendo imagen completa (esto puede tomar 2-3 minutos)..."
        docker compose -f "$COMPOSE_FILE" build --no-cache=false
        docker compose -f "$COMPOSE_FILE" up -d
        ;;
    "cache")
        echo "⚡ Reconstruyendo con cache (rápido, reutiliza composer)..."
        docker compose -f "$COMPOSE_FILE" build --no-cache=false
        docker compose -f "$COMPOSE_FILE" up -d
        ;;
    "none")
        echo "🚀 Levantando contenedores sin rebuild (muy rápido)..."
        docker compose -f "$COMPOSE_FILE" up -d
        ;;
esac

# Guardar commit actual después de deploy exitoso
if [ -n "$CURRENT_COMMIT" ]; then
    echo "$CURRENT_COMMIT" > "$DEPLOY_STATE_FILE" 2>/dev/null || true
    echo "💾 Estado guardado: commit $CURRENT_COMMIT"
fi

# Esperar a que esté listo
echo "⏳ Esperando a que el contenedor esté listo..."
sleep 5

# Verificar que el contenedor está corriendo
if docker compose -f "$COMPOSE_FILE" ps | grep -q "Up"; then
    echo ""
    echo "✅ Deploy completado exitosamente"
    echo "🌐 Acceso: http://152.42.152.212"
    echo ""
    echo "📊 Estado del contenedor:"
    docker compose -f "$COMPOSE_FILE" ps
    echo ""
    echo "📋 Ver logs: docker compose -f $COMPOSE_FILE logs -f"
else
    echo "❌ Error: El contenedor no está corriendo"
    echo "📋 Ver logs: docker compose -f $COMPOSE_FILE logs"
    exit 1
fi
