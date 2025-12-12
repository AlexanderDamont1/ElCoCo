@extends('admin.layouts.app')

@section('title', isset($quoteBlock) ? 'Editar Bloque' : 'Nuevo Bloque')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-{{ isset($quoteBlock) ? 'edit' : 'plus' }} me-2"></i>
                    {{ isset($quoteBlock) ? 'Editar Bloque' : 'Crear Nuevo Bloque' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($quoteBlock) ? route('admin.quote-blocks.update', $quoteBlock) : route('admin.quote-blocks.store') }}" 
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
                                    <h6 class="mb-0">Información básica hooa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label required">Nombre del bloque</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $quoteBlock->name ?? '') }}" 
                                               required
                                               placeholder="Ej: Curso de Ofimática Avanzada">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="3"
                                                  placeholder="Describe brevemente este servicio">{{ old('description', $quoteBlock->description ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="category_id" class="form-label required">Categoría</label>
                                            <select class="form-select select2" 
                                                    id="category_id" 
                                                    name="category_id" 
                                                    required>
                                                <option value="">Seleccionar categoría</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('category_id', $quoteBlock->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label required">Tipo de bloque</label>
                                            <select class="form-select" 
                                                    id="type" 
                                                    name="type" 
                                                    required
                                                    onchange="updateFormFields()">
                                                @foreach($blockTypes as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ old('type', $quoteBlock->type ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="base_price" class="form-label required">Precio base ($ MXN)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="base_price" 
                                                   name="base_price" 
                                                   value="{{ old('base_price', $quoteBlock->base_price ?? 0) }}" 
                                                   required
                                                   min="0"
                                                   step="0.01">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="default_hours" class="form-label required">Horas por defecto</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="default_hours" 
                                                   name="default_hours" 
                                                   value="{{ old('default_hours', $quoteBlock->default_hours ?? 0) }}" 
                                                   required
                                                   min="0">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="order" class="form-label">Orden de aparición</label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="order" 
                                               name="order" 
                                               value="{{ old('order', $quoteBlock->order ?? 0) }}"
                                               min="0">
                                    </div>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $quoteBlock->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Bloque activo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Configuración específica por tipo -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración específica</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Configuración para Cursos -->
                                    <div id="course-config" class="config-section" style="display: none;">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-chalkboard-teacher me-2"></i>
                                            Configuración de cursos
                                        </h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="min_participants" class="form-label">Mínimo de participantes</label>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="min_participants" 
                                                       name="config[min_participants]"
                                                       value="{{ old('config.min_participants', $quoteBlock->config['min_participants'] ?? 10) }}"
                                                       min="1">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="price_per_participant" class="form-label">Precio por participante</label>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="price_per_participant" 
                                                       name="config[price_per_participant]"
                                                       value="{{ old('config.price_per_participant', $quoteBlock->config['price_per_participant'] ?? 500) }}"
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Recargos por modalidad</label>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Modalidad</th>
                                                            <th>Recargo</th>
                                                            <th>Etiqueta</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>En línea</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[modality][online][surcharge]"
                                                                       value="{{ old('config.modality.online.surcharge', $quoteBlock->config['modality']['online']['surcharge'] ?? 0) }}"
                                                                       min="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[modality][online][label]"
                                                                       value="{{ old('config.modality.online.label', $quoteBlock->config['modality']['online']['label'] ?? 'En línea') }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>En instalaciones</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[modality][onsite][surcharge]"
                                                                       value="{{ old('config.modality.onsite.surcharge', $quoteBlock->config['modality']['onsite']['surcharge'] ?? 2000) }}"
                                                                       min="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
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
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-code me-2"></i>
                                            Configuración de desarrollo
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="hourly_rate" class="form-label">Tarifa por hora ($ MXN)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="hourly_rate" 
                                                   name="config[hourly_rate]"
                                                   value="{{ old('config.hourly_rate', $quoteBlock->config['hourly_rate'] ?? 500) }}"
                                                   min="0"
                                                   step="0.01">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="integration_hours" class="form-label">Horas de integración API</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="integration_hours" 
                                                   name="config[integration_hours]"
                                                   value="{{ old('config.integration_hours', $quoteBlock->config['integration_hours'] ?? 20) }}"
                                                   min="0">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Factores de complejidad</label>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Nivel</th>
                                                            <th>Factor</th>
                                                            <th>Etiqueta</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Baja</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[complexity_levels][low][factor]"
                                                                       value="{{ old('config.complexity_levels.low.factor', $quoteBlock->config['complexity_levels']['low']['factor'] ?? 0.8) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[complexity_levels][low][label]"
                                                                       value="{{ old('config.complexity_levels.low.label', $quoteBlock->config['complexity_levels']['low']['label'] ?? 'Baja') }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Media</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[complexity_levels][medium][factor]"
                                                                       value="{{ old('config.complexity_levels.medium.factor', $quoteBlock->config['complexity_levels']['medium']['factor'] ?? 1.0) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[complexity_levels][medium][label]"
                                                                       value="{{ old('config.complexity_levels.medium.label', $quoteBlock->config['complexity_levels']['medium']['label'] ?? 'Media') }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alta</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[complexity_levels][high][factor]"
                                                                       value="{{ old('config.complexity_levels.high.factor', $quoteBlock->config['complexity_levels']['high']['factor'] ?? 1.5) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
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
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-shield-alt me-2"></i>
                                            Configuración de auditorías
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="cost_per_system" class="form-label">Costo por sistema adicional</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="cost_per_system" 
                                                   name="config[cost_per_system]"
                                                   value="{{ old('config.cost_per_system', $quoteBlock->config['cost_per_system'] ?? 1000) }}"
                                                   min="0"
                                                   step="0.01">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Niveles de alcance</label>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Alcance</th>
                                                            <th>Factor</th>
                                                            <th>Etiqueta</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Básica</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[scope_levels][basic][factor]"
                                                                       value="{{ old('config.scope_levels.basic.factor', $quoteBlock->config['scope_levels']['basic']['factor'] ?? 0.7) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[scope_levels][basic][label]"
                                                                       value="{{ old('config.scope_levels.basic.label', $quoteBlock->config['scope_levels']['basic']['label'] ?? 'Básica') }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estándar</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[scope_levels][standard][factor]"
                                                                       value="{{ old('config.scope_levels.standard.factor', $quoteBlock->config['scope_levels']['standard']['factor'] ?? 1.0) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[scope_levels][standard][label]"
                                                                       value="{{ old('config.scope_levels.standard.label', $quoteBlock->config['scope_levels']['standard']['label'] ?? 'Estándar') }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Integral</td>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="config[scope_levels][comprehensive][factor]"
                                                                       value="{{ old('config.scope_levels.comprehensive.factor', $quoteBlock->config['scope_levels']['comprehensive']['factor'] ?? 1.5) }}"
                                                                       min="0"
                                                                       step="0.1">
                                                            </td>
                                                            <td>
                                                                <input type="text" 
                                                                       class="form-control form-control-sm" 
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
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-layer-group me-2"></i>
                                            Configuración de secciones
                                        </h6>
                                        <p class="text-muted">
                                            Las secciones son contenedores para agrupar otros bloques.
                                            No requieren configuración específica adicional.
                                        </p>
                                    </div>
                                    
                                    <!-- Configuración para bloques genéricos -->
                                    <div id="generic-config" class="config-section" style="display: none;">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-cube me-2"></i>
                                            Configuración genérica
                                        </h6>
                                        <p class="text-muted">
                                            Los bloques genéricos usan el precio base directamente.
                                        </p>
                                    </div>
                                    
                                    <!-- Configuración para Mantenimiento -->
                                    <div id="maintenance-config" class="config-section" style="display: none;">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-tools me-2"></i>
                                            Configuración de mantenimiento
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Periodicidad</label>
                                            <select class="form-select" name="config[periodicity]">
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
                                        
                                        <div class="mb-3">
                                            <label for="support_hours" class="form-label">Horas de soporte incluidas</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="support_hours" 
                                                   name="config[support_hours]"
                                                   value="{{ old('config.support_hours', $quoteBlock->config['support_hours'] ?? 10) }}"
                                                   min="0">
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="emergency_support" 
                                                   name="config[emergency_support]"
                                                   value="1"
                                                   {{ old('config.emergency_support', $quoteBlock->config['emergency_support'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="emergency_support">
                                                Incluye soporte de emergencia 24/7
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- Fórmula de cálculo -->
                                    <div class="mt-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-calculator me-2"></i>
                                            Fórmula de cálculo (opcional)
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="formula" class="form-label">
                                                Fórmula personalizada
                                                <small class="text-muted">Usa variables como {base_price}, {quantity}, etc.</small>
                                            </label>
                                            <textarea class="form-control" 
                                                      id="formula" 
                                                      name="formula" 
                                                      rows="3"
                                                      placeholder="Ej: ({base_price} * {quantity}) + ({participants} * 500)">{{ old('formula', $quoteBlock->formula ?? '') }}</textarea>
                                            <div class="form-text">
                                                Variables disponibles: {base_price}, {quantity}, {participants}, {hours}, {systems}, etc.
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Variables predefinidas</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{base_price}')">base_price</span>
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{quantity}')">quantity</span>
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{participants}')">participants</span>
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{hours}')">hours</span>
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{systems}')">systems</span>
                                                <span class="badge bg-info cursor-pointer" onclick="insertVariable('{complexity_factor}')">complexity_factor</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.quote-blocks.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Cancelar
                                </a>
                                
                                <div class="d-flex gap-2">
                                    @if(isset($quoteBlock))
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="confirmDelete()">
                                            <i class="fas fa-trash me-2"></i>
                                            Eliminar
                                        </button>
                                    @endif
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        {{ isset($quoteBlock) ? 'Actualizar Bloque' : 'Crear Bloque' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Formulario para eliminar -->
                @if(isset($quoteBlock))
                    <form id="delete-form" 
                          action="{{ route('admin.quote-blocks.destroy', $quoteBlock) }}" 
                          method="POST" 
                          class="d-none">
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
        
        // Inicializar Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });
</script>
@endpush
@endsection