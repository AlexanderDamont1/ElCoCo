<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($quoteBlock) ? 'Editar Bloque' : 'Nuevo Bloque' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('bloques.update', $quoteBlock) }}" 
                          method="POST">
                        @csrf
                        @if(isset($quoteBlock))
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 font-semibold">Información básica</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700 required">Nombre del bloque</label>
                                            <input type="text" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $quoteBlock->name ?? '') }}" 
                                                   required
                                                   placeholder="Ej: Curso de Ofimática Avanzada">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                            <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="3"
                                                      placeholder="Describe brevemente este servicio">{{ old('description', $quoteBlock->description ?? '') }}</textarea>
                                        </div>
                                        
                                       
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="base_price" class="block text-sm font-medium text-gray-700 required">Precio base ($ MXN)</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="base_price" 
                                                       name="base_price" 
                                                       value="{{ old('base_price', $quoteBlock->base_price ?? 0) }}" 
                                                       required
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                            
                                            <div>
                                                <label for="default_hours" class="block text-sm font-medium text-gray-700 required">Horas por defecto</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="default_hours" 
                                                       name="default_hours" 
                                                       value="{{ old('default_hours', $quoteBlock->default_hours ?? 0) }}" 
                                                       required
                                                       min="0">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="order" class="block text-sm font-medium text-gray-700">Orden de aparición</label>
                                            <input type="number" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                   id="order" 
                                                   name="order" 
                                                   value="{{ old('order', $quoteBlock->order ?? 0) }}"
                                                   min="0">
                                        </div>
                                        
                                        <div class="flex items-center mb-4">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1"
                                                   {{ old('is_active', $quoteBlock->is_active ?? true) ? 'checked' : '' }}>
                                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                                Bloque activo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Configuración específica por tipo -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 font-semibold">Configuración específica</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Configuración para Cursos -->
                                        <div id="course-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración de cursos
                                            </h6>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="min_participants" class="block text-sm font-medium text-gray-700">Mínimo de participantes</label>
                                                    <input type="number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                           id="min_participants" 
                                                           name="config[min_participants]"
                                                           value="{{ old('config.min_participants', $quoteBlock->config['min_participants'] ?? 10) }}"
                                                           min="1">
                                                </div>
                                                
                                                <div>
                                                    <label for="price_per_participant" class="block text-sm font-medium text-gray-700">Precio por participante</label>
                                                    <input type="number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                           id="price_per_participant" 
                                                           name="config[price_per_participant]"
                                                           value="{{ old('config.price_per_participant', $quoteBlock->config['price_per_participant'] ?? 500) }}"
                                                           min="0"
                                                           step="0.01">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Recargos por modalidad</label>
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modalidad</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recargo</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etiqueta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">En línea</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[modality][online][surcharge]"
                                                                           value="{{ old('config.modality.online.surcharge', $quoteBlock->config['modality']['online']['surcharge'] ?? 0) }}"
                                                                           min="0">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[modality][online][label]"
                                                                           value="{{ old('config.modality.online.label', $quoteBlock->config['modality']['online']['label'] ?? 'En línea') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">En instalaciones</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[modality][onsite][surcharge]"
                                                                           value="{{ old('config.modality.onsite.surcharge', $quoteBlock->config['modality']['onsite']['surcharge'] ?? 2000) }}"
                                                                           min="0">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[modality][onsite][label]"
                                                                           value="{{ old('config.modality.onsite.label', $quoteBlock->config['modality']['onsite']['label'] ?? 'En instalaciones') }}">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Configuración para Módulos de Software -->
                                        <div id="software_module-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración de desarrollo
                                            </h6>
                                            
                                            <div class="mb-4">
                                                <label for="hourly_rate" class="block text-sm font-medium text-gray-700">Tarifa por hora ($ MXN)</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="hourly_rate" 
                                                       name="config[hourly_rate]"
                                                       value="{{ old('config.hourly_rate', $quoteBlock->config['hourly_rate'] ?? 500) }}"
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="integration_hours" class="block text-sm font-medium text-gray-700">Horas de integración API</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="integration_hours" 
                                                       name="config[integration_hours]"
                                                       value="{{ old('config.integration_hours', $quoteBlock->config['integration_hours'] ?? 20) }}"
                                                       min="0">
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Factores de complejidad</label>
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factor</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etiqueta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Baja</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][low][factor]"
                                                                           value="{{ old('config.complexity_levels.low.factor', $quoteBlock->config['complexity_levels']['low']['factor'] ?? 0.8) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][low][label]"
                                                                           value="{{ old('config.complexity_levels.low.label', $quoteBlock->config['complexity_levels']['low']['label'] ?? 'Baja') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Media</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][medium][factor]"
                                                                           value="{{ old('config.complexity_levels.medium.factor', $quoteBlock->config['complexity_levels']['medium']['factor'] ?? 1.0) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][medium][label]"
                                                                           value="{{ old('config.complexity_levels.medium.label', $quoteBlock->config['complexity_levels']['medium']['label'] ?? 'Media') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Alta</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][high][factor]"
                                                                           value="{{ old('config.complexity_levels.high.factor', $quoteBlock->config['complexity_levels']['high']['factor'] ?? 1.5) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[complexity_levels][high][label]"
                                                                           value="{{ old('config.complexity_levels.high.label', $quoteBlock->config['complexity_levels']['high']['label'] ?? 'Alta') }}">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Configuración para Auditorías -->
                                        <div id="audit-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración de auditorías
                                            </h6>
                                            
                                            <div class="mb-4">
                                                <label for="cost_per_system" class="block text-sm font-medium text-gray-700">Costo por sistema adicional</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="cost_per_system" 
                                                       name="config[cost_per_system]"
                                                       value="{{ old('config.cost_per_system', $quoteBlock->config['cost_per_system'] ?? 1000) }}"
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Niveles de alcance</label>
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alcance</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factor</th>
                                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etiqueta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Básica</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][basic][factor]"
                                                                           value="{{ old('config.scope_levels.basic.factor', $quoteBlock->config['scope_levels']['basic']['factor'] ?? 0.7) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][basic][label]"
                                                                           value="{{ old('config.scope_levels.basic.label', $quoteBlock->config['scope_levels']['basic']['label'] ?? 'Básica') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Estándar</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][standard][factor]"
                                                                           value="{{ old('config.scope_levels.standard.factor', $quoteBlock->config['scope_levels']['standard']['factor'] ?? 1.0) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][standard][label]"
                                                                           value="{{ old('config.scope_levels.standard.label', $quoteBlock->config['scope_levels']['standard']['label'] ?? 'Estándar') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">Integral</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="number" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][comprehensive][factor]"
                                                                           value="{{ old('config.scope_levels.comprehensive.factor', $quoteBlock->config['scope_levels']['comprehensive']['factor'] ?? 1.5) }}"
                                                                           min="0"
                                                                           step="0.1">
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    <input type="text" 
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                                           name="config[scope_levels][comprehensive][label]"
                                                                           value="{{ old('config.scope_levels.comprehensive.label', $quoteBlock->config['scope_levels']['comprehensive']['label'] ?? 'Integral') }}">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Configuración para Secciones -->
                                        <div id="section-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración de secciones
                                            </h6>
                                            <p class="text-gray-500 text-sm">
                                                Las secciones son contenedores para agrupar otros bloques.
                                                No requieren configuración específica adicional.
                                            </p>
                                        </div>
                                        
                                        <!-- Configuración para bloques genéricos -->
                                        <div id="generic-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración genérica
                                            </h6>
                                            <p class="text-gray-500 text-sm">
                                                Los bloques genéricos usan el precio base directamente.
                                            </p>
                                        </div>
                                        
                                        <!-- Configuración para Mantenimiento -->
                                        <div id="maintenance-config" class="config-section" style="display: none;">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Configuración de mantenimiento
                                            </h6>
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Periodicidad</label>
                                                <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" name="config[periodicity]" required>
                                                    <option value="monthly" {{ old('config.periodicity', $quoteBlock->config['periodicity'] ?? '') == 'monthly' ? 'selected' : '' }}>
                                                        Mensual
                                                    </option>
                                                    <option value="quarterly" {{ old('config.periodicity', $quoteBlock->config['periodicity'] ?? '') == 'quarterly' ? 'selected' : '' }}>
                                                        Trimestral
                                                    </option>
                                                    <option value="semiannual" {{ old('config.periodicity', $quoteBlock->config['periodicity'] ?? '') == 'semiannual' ? 'selected' : '' }}>
                                                        Semestral
                                                    </option>
                                                    <option value="annual" {{ old('config.periodicity', $quoteBlock->config['periodicity'] ?? '') == 'annual' ? 'selected' : '' }}>
                                                        Anual
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="support_hours" class="block text-sm font-medium text-gray-700">Horas de soporte incluidas</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="support_hours" 
                                                       name="config[support_hours]"
                                                       value="{{ old('config.support_hours', $quoteBlock->config['support_hours'] ?? 10) }}"
                                                       min="0">
                                            </div>
                                            
                                            <div class="flex items-center mb-4">
                                                <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                                       type="checkbox" 
                                                       id="emergency_support" 
                                                       name="config[emergency_support]"
                                                       value="1"
                                                       {{ old('config.emergency_support', $quoteBlock->config['emergency_support'] ?? false) ? 'checked' : '' }}>
                                                <label for="emergency_support" class="ml-2 block text-sm text-gray-700">
                                                    Incluye soporte de emergencia 24/7
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <!-- Fórmula de cálculo -->
                                        <div class="mt-6">
                                            <h6 class="text-blue-600 font-semibold mb-3">
                                                Fórmula de cálculo (opcional)
                                            </h6>
                                            
                                            <div class="mb-4">
                                                <label for="formula" class="block text-sm font-medium text-gray-700">
                                                    Fórmula personalizada
                                                </label>
                                                <p class="text-xs text-gray-500 mb-2">Usa variables como {base_price}, {quantity}, etc.</p>
                                                <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                          id="formula" 
                                                          name="formula" 
                                                          rows="3"
                                                          placeholder="Ej: ({base_price} * {quantity}) + ({participants} * 500)">{{ old('formula', $quoteBlock->formula ?? '') }}</textarea>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Variables disponibles: {base_price}, {quantity}, {participants}, {hours}, {systems}, etc.
                                                </p>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Variables predefinidas</label>
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{base_price}')">base_price</span>
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{quantity}')">quantity</span>
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{participants}')">participants</span>
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{hours}')">hours</span>
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{systems}')">systems</span>
                                                    <span class="cursor-pointer inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200" onclick="insertVariable('{complexity_factor}')">complexity_factor</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('bloques.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            
                            <div class="flex gap-2">
                                @if(isset($quoteBlock))
                                    <button type="button" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                                            onclick="confirmDelete()">
                                        Eliminar
                                    </button>
                                @endif
                                
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ isset($quoteBlock) ? 'Actualizar Bloque' : 'Crear Bloque' }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Formulario para eliminar -->
                    @if(isset($quoteBlock))
                        <form id="delete-form" 
                              action="#" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Mostrar/ocultar configuraciones según el tipo de bloque
        function updateFormFields() {
            const type = document.getElementById('type').value;
            
            // Ocultar todas las configuraciones
            document.querySelectorAll('.config-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Mostrar la configuración correspondiente
            const configSection = document.getElementById(`${type}-config`);
            if (configSection) {
                configSection.style.display = 'block';
            }
        }
        
        // Insertar variable en la fórmula
        function insertVariable(variable) {
            const formulaInput = document.getElementById('formula');
            const start = formulaInput.selectionStart;
            const end = formulaInput.selectionEnd;
            const text = formulaInput.value;
            
            formulaInput.value = text.substring(0, start) + variable + text.substring(end);
            formulaInput.focus();
            formulaInput.setSelectionRange(start + variable.length, start + variable.length);
        }
        
        // Confirmar eliminación
        function confirmDelete() {
            if (confirm('¿Estás seguro de eliminar este bloque? Esta acción no se puede deshacer.')) {
                document.getElementById('delete-form').submit();
            }
        }
        
        // Inicializar al cargar
        document.addEventListener('DOMContentLoaded', function() {
            updateFormFields();
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
        .required:after {
            content: " *";
            color: #dc2626;
        }
        .config-section {
            transition: all 0.3s ease;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    @endpush
</x-app-layout>