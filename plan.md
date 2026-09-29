# Plan — Reloj animado en tiempo real (JS vanilla)

## Objetivo
Extraer esfera sin agujas + recrear agujas en SVG + demo funcional con hora real.

## Etapas
1. **Procesado de imagen** (yo, ipython):
   - Cargar `reloj_sin_fondo.png`, localizar centro y radio de la esfera.
   - Máscara de agujas por color (oro rosa vs esfera plateada) protegiendo índices y fecha.
   - Relleno rotacional (copiar píxeles limpios del mismo radio) para textura guilloché perfecta.
   - Salida: `esfera_sin_agujas.png` + coordenadas del centro (%, para el pivot).
2. **Agujas SVG**: 3 agujas (horaria dauphine, minutero dauphine, segundero fino con contrapeso) en oro rosa con gradientes, pivot en (0,0) para rotación trivial. Archivo `agujas.svg`.
3. **Demo web** (HTML único, JS vanilla):
   - Esfera como imagen + SVG superpuesto con las 3 agujas.
   - `requestAnimationFrame` + `Date` → ángulos, `transform: rotate()`.
   - Segundero fluido (sweep) usando milisegundos.
4. **Entrega**: build_version (html) + archivos en /mnt/agents/output.
