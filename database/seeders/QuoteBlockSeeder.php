<?php
// database/seeders/QuoteBlockSeeder.php

namespace Database\Seeders;

use App\Models\QuoteBlock;
use App\Models\QuoteBlockCategory;
use Illuminate\Database\Seeder;

class QuoteBlockSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $categories = [
            [
                'name' => 'Cursos Personalizados',
                'description' => 'Capacitación y formación especializada',
                'icon' => 'chalkboard-teacher',
                'color' => '#3b82f6',
                'order' => 1
            ],
            [
                'name' => 'Auditorías y Ciberseguridad',
                'description' => 'Evaluación de seguridad y cumplimiento',
                'icon' => 'shield-alt',
                'color' => '#10b981',
                'order' => 2
            ],
            [
                'name' => 'Mantenimiento',
                'description' => 'Soporte técnico y mantenimiento preventivo',
                'icon' => 'tools',
                'color' => '#f59e0b',
                'order' => 3
            ],
            [
                'name' => 'Desarrollo de Software',
                'description' => 'Soluciones tecnológicas a medida',
                'icon' => 'code',
                'color' => '#8b5cf6',
                'order' => 4
            ],
            [
                'name' => 'Consultoría',
                'description' => 'Asesoría especializada en TI',
                'icon' => 'handshake',
                'color' => '#ec4899',
                'order' => 5
            ]
        ];
        
        foreach ($categories as $categoryData) {
            QuoteBlockCategory::create($categoryData);
        }
        
        // Obtener IDs de categorías
        $coursesCategory = QuoteBlockCategory::where('name', 'Cursos Personalizados')->first();
        $auditCategory = QuoteBlockCategory::where('name', 'Auditorías y Ciberseguridad')->first();
        $maintenanceCategory = QuoteBlockCategory::where('name', 'Mantenimiento')->first();
        $softwareCategory = QuoteBlockCategory::where('name', 'Desarrollo de Software')->first();
        $consultingCategory = QuoteBlockCategory::where('name', 'Consultoría')->first();
        
        // Crear bloques de ejemplo
        $blocks = [
            // Cursos
            [
                'name' => 'Curso de Ofimática Avanzada',
                'description' => 'Capacitación en herramientas Office avanzadas',
                'type' => 'course',
                'category_id' => $coursesCategory->id,
                'base_price' => 5000,
                'default_hours' => 20,
                'config' => [
                    'min_participants' => 10,
                    'price_per_participant' => 500,
                    'modality' => [
                        'online' => ['surcharge' => 0, 'label' => 'En línea'],
                        'onsite' => ['surcharge' => 2000, 'label' => 'En instalaciones']
                    ]
                ],
                'order' => 1
            ],
            
            // Auditorías
            [
                'name' => 'Auditoría de Seguridad Informática',
                'description' => 'Evaluación integral de seguridad de sistemas',
                'type' => 'audit',
                'category_id' => $auditCategory->id,
                'base_price' => 15000,
                'default_hours' => 40,
                'config' => [
                    'scope_levels' => [
                        'basic' => ['factor' => 0.7, 'label' => 'Básica'],
                        'standard' => ['factor' => 1.0, 'label' => 'Estándar'],
                        'comprehensive' => ['factor' => 1.5, 'label' => 'Integral']
                    ],
                    'cost_per_system' => 1000
                ],
                'order' => 1
            ],
            
            // Mantenimiento
            [
                'name' => 'Mantenimiento Preventivo Mensual',
                'description' => 'Soporte técnico y mantenimiento preventivo',
                'type' => 'maintenance',
                'category_id' => $maintenanceCategory->id,
                'base_price' => 3000,
                'default_hours' => 10,
                'config' => [
                    'periodicity' => 'monthly',
                    'support_hours' => 10,
                    'emergency_support' => false
                ],
                'order' => 1
            ],
            
            // Desarrollo de Software
            [
                'name' => 'Módulo de Autenticación',
                'description' => 'Sistema de login y gestión de usuarios',
                'type' => 'software_module',
                'category_id' => $softwareCategory->id,
                'base_price' => 25000,
                'default_hours' => 50,
                'config' => [
                    'hourly_rate' => 500,
                    'integration_hours' => 20,
                    'complexity_levels' => [
                        'low' => ['factor' => 0.8, 'label' => 'Baja'],
                        'medium' => ['factor' => 1.0, 'label' => 'Media'],
                        'high' => ['factor' => 1.5, 'label' => 'Alta']
                    ]
                ],
                'formula' => '({base_price} * {complexity_factor}) + ({integration} * 10000)',
                'order' => 1
            ],
            
            // Consultoría
            [
                'name' => 'Consultoría Estratégica TI',
                'description' => 'Análisis y planificación de tecnología',
                'type' => 'generic',
                'category_id' => $consultingCategory->id,
                'base_price' => 8000,
                'default_hours' => 16,
                'order' => 1
            ]
        ];
        
        foreach ($blocks as $blockData) {
            QuoteBlock::create($blockData);
        }
    }
}