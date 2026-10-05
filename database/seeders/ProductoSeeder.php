<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Datos de prueba para la tabla PRODUCTO.
     *
     * Genera 8 joyas grabables por categoría (anillo, pendiente, collar y
     * pulsera), repartidas de forma que también haya al menos 8 grabables
     * por material (12 de plata, 12 de oro y 8 de acero), más algunas joyas
     * NO grabables para comprobar que quedan excluidas de "Personaliza tus joyas".
     *
     * Ojo: el seeder inserta sin vaciar la tabla; ejecutarlo dos veces duplica los datos.
     */
    public function run(): void
    {
        // [nombre, marca, descripcion, precio, genero, color, talla, material, peso, stock]
        $grabables = [
            'anillo' => [
                ['Anillo Sello Plata', 'Lotus', 'Anillo sello de plata de primera ley, ideal para grabar iniciales', 45.00, 'unisex', 'plata', '18', 'plata', 5.2, 12],
                ['Anillo Plata Corazón', 'Pandora', 'Anillo de plata con motivo de corazón grabable en el interior', 39.95, 'mujer', 'plata', '16', 'plata', 3.8, 15],
                ['Anillo Plata Media Caña', 'Tous', 'Anillo de plata de media caña pulida con interior grabable', 42.50, 'mujer', 'plata', '17', 'plata', 4.4, 10],
                ['Anillo Oro 18k Clásico', 'Cartier', 'Alianza clásica de oro amarillo de 18 quilates grabable', 320.00, 'unisex', 'dorado', '18', 'oro', 6.1, 5],
                ['Anillo Oro 18k Sello', 'Aristocrazy', 'Anillo sello de oro de 18 quilates para grabado de escudo o iniciales', 289.00, 'hombre', 'dorado', '20', 'oro', 8.3, 4],
                ['Anillo Oro 18k Media Caña', 'Cartier', 'Anillo de oro rosa de 18 quilates con interior grabable', 350.00, 'mujer', 'dorado', '16', 'oro', 5.7, 6],
                ['Anillo Acero Mate', 'Armani', 'Anillo de acero inoxidable negro mate con superficie grabable', 35.00, 'hombre', 'negro', '21', 'acero', 6.8, 20],
                ['Anillo Acero Bicolor', 'Guess', 'Anillo de acero inoxidable bicolor apto para grabado láser', 29.99, 'unisex', 'gris', '19', 'acero', 5.9, 18],
            ],
            'pendiente' => [
                ['Pendientes Placa Plata', 'Tous', 'Pendientes de plata con placa lisa frontal grabable', 32.00, 'mujer', 'plata', null, 'plata', 3.1, 16],
                ['Pendientes Moneda Plata', 'Pandora', 'Pendientes de plata con moneda colgante grabable por ambas caras', 38.50, 'mujer', 'plata', null, 'plata', 4.2, 12],
                ['Pendientes Aro Plata Grabable', 'Lotus', 'Pendientes de aro de plata con placa interior grabable', 35.00, 'mujer', 'plata', null, 'plata', 5.0, 14],
                ['Pendientes Placa Oro 18k', 'Aristocrazy', 'Pendientes de oro de 18 quilates con placa grabable', 210.00, 'mujer', 'dorado', null, 'oro', 3.6, 6],
                ['Pendientes Aro Oro 18k', 'Cartier', 'Pendientes de aro de oro amarillo de 18 quilates grabables', 265.00, 'mujer', 'dorado', null, 'oro', 4.8, 5],
                ['Pendientes Botón Oro 18k', 'Tous', 'Pendientes de botón de oro rosa de 18 quilates con cara grabable', 189.00, 'mujer', 'dorado', null, 'oro', 2.9, 8],
                ['Pendientes Aro Acero', 'Guess', 'Pendientes de aro de acero inoxidable aptos para grabado', 24.95, 'unisex', 'gris', null, 'acero', 4.5, 22],
                ['Pendientes Placa Acero', 'Armani', 'Pendientes de acero inoxidable negro con placa grabable', 27.50, 'hombre', 'negro', null, 'acero', 3.9, 19],
            ],
            'collar' => [
                ['Collar Placa Plata', 'Lotus', 'Collar de plata con placa rectangular grabable', 49.90, 'unisex', 'plata', '45cm', 'plata', 8.6, 11],
                ['Collar Colgante Plata', 'Pandora', 'Collar de plata con colgante circular grabable', 55.00, 'mujer', 'plata', '42cm', 'plata', 7.2, 13],
                ['Collar Cadena Plata Grabable', 'Tous', 'Collar de cadena de plata con medallón grabable', 47.00, 'mujer', 'plata', '50cm', 'plata', 9.8, 9],
                ['Collar Placa Oro 18k', 'Cartier', 'Collar de oro de 18 quilates con placa grabable', 420.00, 'unisex', 'dorado', '45cm', 'oro', 11.5, 4],
                ['Collar Colgante Oro 18k', 'Aristocrazy', 'Collar de oro rosa de 18 quilates con colgante grabable', 385.00, 'mujer', 'dorado', '42cm', 'oro', 9.4, 5],
                ['Collar Cadena Oro 18k', 'Cartier', 'Collar de cadena de oro amarillo de 18 quilates con medallón grabable', 450.00, 'mujer', 'dorado', '50cm', 'oro', 12.7, 3],
                ['Collar Placa Acero', 'Armani', 'Collar de acero inoxidable negro con placa grabable para hombre', 39.00, 'hombre', 'negro', '55cm', 'acero', 18.3, 8],
                ['Collar Cadena Acero', 'Guess', 'Collar de cadena de acero inoxidable con placa grabable', 34.95, 'unisex', 'gris', '50cm', 'acero', 15.6, 14],
            ],
            'pulsera' => [
                ['Pulsera Esclava Plata', 'Tous', 'Pulsera esclava rígida de plata con superficie grabable', 59.00, 'mujer', 'plata', 'M', 'plata', 12.4, 10],
                ['Pulsera Placa Plata', 'Pandora', 'Pulsera de plata con placa central grabable', 52.50, 'unisex', 'plata', 'L', 'plata', 10.1, 12],
                ['Pulsera Cadena Plata Grabable', 'Lotus', 'Pulsera de cadena fina de plata con medallón grabable', 48.00, 'mujer', 'plata', 'S', 'plata', 7.8, 14],
                ['Pulsera Esclava Oro 18k', 'Cartier', 'Pulsera esclava de oro amarillo de 18 quilates grabable', 390.00, 'mujer', 'dorado', 'M', 'oro', 14.2, 4],
                ['Pulsera Placa Oro 18k', 'Aristocrazy', 'Pulsera de oro rosa de 18 quilates con placa grabable', 340.00, 'unisex', 'dorado', 'L', 'oro', 11.8, 5],
                ['Pulsera Cadena Oro 18k', 'Cartier', 'Pulsera de cadena de oro de 18 quilates con medallón grabable', 410.00, 'mujer', 'dorado', 'S', 'oro', 9.6, 6],
                ['Pulsera Esclava Acero', 'Guess', 'Pulsera esclava de acero inoxidable grabable', 32.00, 'unisex', 'gris', 'M', 'acero', 16.5, 17],
                ['Pulsera Placa Acero', 'Armani', 'Pulsera de acero inoxidable negro con placa grabable', 36.50, 'hombre', 'negro', 'L', 'acero', 19.2, 13],
            ],
        ];

        // Joyas de ejemplo NO grabables: no deben aparecer en "Personaliza tus joyas"
        $noGrabables = [
            ['pulsera', 'Pulsera Deportiva Silicona', 'Nike', 'Pulsera ligera de silicona resistente al agua', 15.99, 'unisex', 'azul', 'L', 'silicona', 5.2, 30],
            ['pendiente', 'Pendientes Perlas Cultivadas', 'Majorica', 'Pendientes de perlas cultivadas con cierre de presión', 65.00, 'mujer', 'blanco', null, 'perla', 3.4, 7],
            ['collar', 'Collar Perlas Elegante', 'Majorica', 'Collar clásico de perlas cultivadas', 120.00, 'mujer', 'blanco', '42cm', 'perla', 18.9, 5],
            ['anillo', 'Anillo Fantasía Cristal', 'Swarovski', 'Anillo de fantasía con cristal tallado, no apto para grabado', 45.00, 'mujer', 'blanco', '16', 'cristal', 4.0, 9],
        ];

        $productos = [];

        foreach ($grabables as $categoria => $lista) {
            foreach ($lista as $p) {
                $productos[] = $this->filaProducto($categoria, $p, true);
            }
        }

        foreach ($noGrabables as $p) {
            $productos[] = $this->filaProducto($p[0], array_slice($p, 1), false);
        }

        DB::table('PRODUCTO')->insert($productos);
    }

    /**
     * Construye la fila a insertar en PRODUCTO a partir de los datos resumidos.
     *
     * @param string $categoria Categoría del producto
     * @param array $p [nombre, marca, descripcion, precio, genero, color, talla, material, peso, stock]
     * @param bool $esGrabable Si admite grabado personalizado
     * @return array
     */
    private function filaProducto(string $categoria, array $p, bool $esGrabable): array
    {
        return [
            'categoria' => $categoria,
            'nombre' => $p[0],
            'marca' => $p[1],
            'descripcion' => $p[2],
            'precio' => $p[3],
            'genero' => $p[4],
            'color' => $p[5],
            'talla' => $p[6],
            // La columna es NOT NULL en la BD; se guarda una ruta simbólica
            'ruta_grabado' => 'grabados/' . \Illuminate\Support\Str::slug($p[0]) . '.png',
            'es_grabable' => $esGrabable,
            'material' => $p[7],
            'peso' => $p[8],
            'stock' => $p[9],
            'id_detalles_pedido' => null,
        ];
    }
}
