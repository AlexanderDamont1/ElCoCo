<?php

namespace Database\Seeders;

use App\Models\QuoteBlock;
use App\Models\QuoteBlockCategory;
use Illuminate\Database\Seeder;

class QuoteBlockSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Desarrollo Web',
                'description' => 'Servicios de desarrollo frontend y backend',
                'order'       => 1,
                'blocks'      => [
                    [
                        'name'          => 'Landing Page',
                        'description'   => 'Página de aterrizaje con diseño responsivo y formulario de contacto',
                        'base_price'    => 8500.00,
                        'default_hours' => 40,
                        'order'         => 1,
                    ],
                    [
                        'name'          => 'Sitio Web Corporativo',
                        'description'   => 'Sitio de hasta 8 páginas con CMS, SEO básico y dominio configurado',
                        'base_price'    => 18000.00,
                        'default_hours' => 80,
                        'order'         => 2,
                    ],
                    [
                        'name'          => 'E-commerce',
                        'description'   => 'Tienda en línea con carrito, pasarela de pago y panel de productos',
                        'base_price'    => 35000.00,
                        'default_hours' => 160,
                        'order'         => 3,
                    ],
                    [
                        'name'          => 'API REST',
                        'description'   => 'Desarrollo de API con autenticación, documentación y pruebas unitarias',
                        'base_price'    => 12000.00,
                        'default_hours' => 60,
                        'order'         => 4,
                    ],
                ],
            ],
            [
                'name'        => 'Diseño',
                'description' => 'Servicios de diseño UI/UX y branding',
                'order'       => 2,
                'blocks'      => [
                    [
                        'name'          => 'Diseño UI/UX',
                        'description'   => 'Diseño de interfaces en Figma con prototipo interactivo y guía de estilos',
                        'base_price'    => 5678.00,
                        'default_hours' => 40,
                        'order'         => 1,
                    ],
                    [
                        'name'          => 'Identidad de Marca',
                        'description'   => 'Logotipo, paleta de color, tipografía y manual de marca básico',
                        'base_price'    => 7500.00,
                        'default_hours' => 30,
                        'order'         => 2,
                    ],
                    [
                        'name'          => 'Rediseño de Interfaz',
                        'description'   => 'Análisis de UX, propuesta de mejora y entrega de mockups en alta fidelidad',
                        'base_price'    => 9200.00,
                        'default_hours' => 50,
                        'order'         => 3,
                    ],
                ],
            ],
            [
                'name'        => 'Cursos y Capacitación',
                'description' => 'Cursos técnicos impartidos en línea o presenciales',
                'order'       => 3,
                'blocks'      => [
                    [
                        'name'          => 'Curso de Excel Avanzado',
                        'description'   => 'Tablas dinámicas, macros VBA y dashboards. Incluye material descargable',
                        'base_price'    => 123.00,
                        'default_hours' => 10,
                        'order'         => 1,
                    ],
                    [
                        'name'          => 'Curso de Laravel',
                        'description'   => 'Fundamentos hasta nivel intermedio: MVC, Eloquent, APIs y autenticación',
                        'base_price'    => 400.00,
                        'default_hours' => 30,
                        'order'         => 2,
                    ],
                    [
                        'name'          => 'Taller de Git y GitHub',
                        'description'   => 'Control de versiones, ramas, pull requests y flujo de trabajo en equipo',
                        'base_price'    => 250.00,
                        'default_hours' => 8,
                        'order'         => 3,
                    ],
                ],
            ],
            [
                'name'        => 'Personalizado',
                'description' => 'Para proyectos con requerimientos fuera de los paquetes estándar',
                'order'       => 4,
                'blocks'      => [
                    [
                        'name'          => 'Proyecto a Medida',
                        'description'   => 'Describe tus requerimientos y te preparamos una propuesta personalizada',
                        'base_price'    => 0.00,
                        'default_hours' => 0,
                        'order'         => 1,
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $blocks = $categoryData['blocks'];
            unset($categoryData['blocks']);

            $category = QuoteBlockCategory::updateOrCreate(
                ['name' => $categoryData['name']],
                array_merge($categoryData, ['is_active' => true])
            );

            foreach ($blocks as $blockData) {
                QuoteBlock::updateOrCreate(
                    [
                        'name'        => $blockData['name'],
                        'category_id' => $category->id,
                    ],
                    array_merge($blockData, [
                        'category_id' => $category->id,
                        'config'      => [],
                        'is_active'   => true,
                    ])
                );
            }

            $this->command->info("✓ Categoría \"{$category->name}\" con " . count($blocks) . " bloques");
        }
    }
}