@section('page_title', __('Solar Configuration'))
@extends('admin.layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Solar System Configuration') }}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <button type="button" class="btn btn-success" onclick="saveAllConfigs()">
                            <i class="fas fa-save"></i> {{ __('Save All Changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <form id="configForm" action="{{ route('solar-configuration.update-bulk') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Mounting Structure & Hardware Costs -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tools text-primary"></i> {{ __('Mounting Structure & Hardware Costs') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Support Unit Price') }} (MAD)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="support_unit_price" 
                                           value="{{ $configurations->where('key', 'support_unit_price')->first()->value ?? 300 }}">
                                    <small class="form-text text-muted">{{ __('Price per panel support unit') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Rail Unit Price') }} (MAD/meter)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="rail_unit_price" 
                                           value="{{ $configurations->where('key', 'rail_unit_price')->first()->value ?? 120 }}">
                                    <small class="form-text text-muted">{{ __('Price per meter of mounting rail') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Clamp Unit Price') }} (MAD)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="clamp_unit_price" 
                                           value="{{ $configurations->where('key', 'clamp_unit_price')->first()->value ?? 15 }}">
                                    <small class="form-text text-muted">{{ __('Price per clamp (4 clamps per panel)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Unit Price') }} (MAD)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="foundation_unit_price" 
                                           value="{{ $configurations->where('key', 'foundation_unit_price')->first()->value ?? 200 }}">
                                    <small class="form-text text-muted">{{ __('Price per foundation point') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Pricing & Financial -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave text-success"></i> {{ __('System Pricing & Financial') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Electricity Rate') }} (MAD/kWh) <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="electricity_rate" 
                                           value="{{ $configurations->where('key', 'electricity_rate')->first()->value ?? 1.5 }}">
                                    <small class="form-text text-muted">{{ __('Fallback rate when utility provider rates unavailable (system uses actual utility rates)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Installation Cost') }} (%)</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="installation_cost_percent" 
                                           value="{{ $configurations->where('key', 'installation_cost_percent')->first()->value ?? 30 }}">
                                    <small class="form-text text-muted">{{ __('Installation cost as percentage of system cost') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Consultation Fees') }} (%)</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="consultation_fees_percent" 
                                           value="{{ $configurations->where('key', 'consultation_fees_percent')->first()->value ?? 5 }}">
                                    <small class="form-text text-muted">{{ __('Consultation fees as percentage of system cost') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solar System Parameters -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-solar-panel text-warning"></i> {{ __('Solar System Parameters') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Solar Production Factor') }} (kWh/kW/year) <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="solar_production_factor" 
                                           value="{{ $configurations->where('key', 'solar_production_factor')->first()->value ?? 1600 }}">
                                    <small class="form-text text-muted">{{ __('Fallback value when NASA solar irradiance API unavailable (system calculates from API data)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Default Azimuth') }} (degrees)</label>
                                    <input type="number" step="1" class="form-control" 
                                           name="default_azimuth" 
                                           value="{{ $configurations->where('key', 'default_azimuth')->first()->value ?? 180 }}">
                                    <small class="form-text text-muted">{{ __('Default azimuth angle (South facing = 180°)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Optimal Tilt Angle') }} (degrees) <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="1" class="form-control" 
                                           name="optimal_tilt_angle" 
                                           value="{{ $configurations->where('key', 'optimal_tilt_angle')->first()->value ?? 20 }}">
                                    <small class="form-text text-muted">{{ __('Fallback tilt when roof tilt not provided (system uses actual roof data when available)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Default System Losses') }} (%) <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="default_losses_percent" 
                                           value="{{ $configurations->where('key', 'default_losses_percent')->first()->value ?? 14 }}">
                                    <small class="form-text text-muted">{{ __('Fallback value when dynamic loss calculation unavailable (system calculates from actual components)') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Efficiency Factors -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line text-info"></i> {{ __('System Efficiency Factors') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Temperature Efficiency') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control" 
                                           name="eta_temperature" 
                                           value="{{ $configurations->where('key', 'eta_temperature')->first()->value ?? 0.85 }}">
                                    <small class="form-text text-muted">{{ __('Fallback temperature efficiency for dynamic loss calculations (0.0 - 1.0)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Soiling Efficiency') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control" 
                                           name="eta_soiling" 
                                           value="{{ $configurations->where('key', 'eta_soiling')->first()->value ?? 0.95 }}">
                                    <small class="form-text text-muted">{{ __('Fallback soiling (dirt) efficiency for dynamic loss calculations (0.0 - 1.0)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Mismatch Efficiency') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control" 
                                           name="eta_mismatch" 
                                           value="{{ $configurations->where('key', 'eta_mismatch')->first()->value ?? 0.98 }}">
                                    <small class="form-text text-muted">{{ __('Fallback panel mismatch efficiency for dynamic loss calculations (0.0 - 1.0)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Other Losses Efficiency') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control" 
                                           name="eta_other" 
                                           value="{{ $configurations->where('key', 'eta_other')->first()->value ?? 0.95 }}">
                                    <small class="form-text text-muted">{{ __('Fallback other system losses efficiency for dynamic loss calculations (0.0 - 1.0)') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-leaf text-success"></i> {{ __('Environmental Impact Factors') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('CO2 Reduction Factor') }} (kg/kWh)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="co2_reduction_factor" 
                                           value="{{ $configurations->where('key', 'co2_reduction_factor')->first()->value ?? 0.5 }}">
                                    <small class="form-text text-muted">{{ __('CO2 reduction per kWh generated') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tree CO2 Absorption') }} (kg/year)</label>
                                    <input type="number" step="1" class="form-control" 
                                           name="tree_absorption_co2_kg" 
                                           value="{{ $configurations->where('key', 'tree_absorption_co2_kg')->first()->value ?? 20 }}">
                                    <small class="form-text text-muted">{{ __('CO2 absorption per tree per year') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Water Saved') }} (liters/kWh)</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="water_saved_per_kwh" 
                                           value="{{ $configurations->where('key', 'water_saved_per_kwh')->first()->value ?? 5 }}">
                                    <small class="form-text text-muted">{{ __('Water saved per kWh generated') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Gas Savings') }} (liters/kWh)</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="gas_savings_per_kwh" 
                                           value="{{ $configurations->where('key', 'gas_savings_per_kwh')->first()->value ?? 0.1 }}">
                                    <small class="form-text text-muted">{{ __('Gas savings per kWh in liters equivalent') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foundation & Installation Configuration -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-hammer text-warning"></i> {{ __('Foundation & Installation Configuration') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Rooftop Flat') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_rooftop_flat" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_rooftop_flat')->first()->value ?? 0.7 }}">
                                    <small class="form-text text-muted">{{ __('Foundation ratio for flat rooftop installations') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Rooftop Tilted') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_rooftop_tilted" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_rooftop_tilted')->first()->value ?? 0.2 }}">
                                    <small class="form-text text-muted">{{ __('Foundation ratio for tilted rooftop installations') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Ground Mount') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_ground" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_ground')->first()->value ?? 1.2 }}">
                                    <small class="form-text text-muted">{{ __('Foundation ratio for ground mount installations') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Carport') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_carport" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_carport')->first()->value ?? 1.5 }}">
                                    <small class="form-text text-muted">{{ __('Foundation ratio for carport installations') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Floating') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_floating" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_floating')->first()->value ?? 1.0 }}">
                                    <small class="form-text text-muted">{{ __('Foundation ratio for floating installations') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Foundation Ratio - Default') }}</label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="foundation_ratio_default" 
                                           value="{{ $configurations->where('key', 'foundation_ratio_default')->first()->value ?? 1.0 }}">
                                    <small class="form-text text-muted">{{ __('Default foundation ratio for other installation types') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced System Configuration -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cogs text-secondary"></i> {{ __('Advanced System Configuration') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Default Panel') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <select class="form-control" name="panel_id">
                                        @php
                                            $currentPanelId = $configurations->where('key', 'panel_id')->first()->value ?? 21;
                                        @endphp
                                        @if($panels->isEmpty())
                                            <option value="21">{{ __('No panels available - using default ID 21') }}</option>
                                        @else
                                            @foreach($panels as $panel)
                                                <option value="{{ $panel->id }}" 
                                                        {{ $panel->id == $currentPanelId ? 'selected' : '' }}>
                                                    {{ $panel->name }} ({{ $panel->power_output }}W)
                                                    @if($panel->brand) - {{ $panel->brand }}@endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">{{ __('Fallback panel when no panel is specified by user') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Panel Degradation Rate') }} (%/year)</label>
                                    <input type="number" step="0.001" class="form-control" 
                                           name="panel_degradation_rate" 
                                           value="{{ $configurations->where('key', 'panel_degradation_rate')->first()->value ?? 0.005 }}">
                                    <small class="form-text text-muted">{{ __('Annual panel degradation rate (0.5% = 0.005)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Panels per kW') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="number" step="0.1" class="form-control" 
                                           name="panels_per_kw" 
                                           value="{{ $configurations->where('key', 'panels_per_kw')->first()->value ?? 2.5 }}">
                                    <small class="form-text text-muted">{{ __('Fallback value when panel data unavailable (system uses dynamic calculation)') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Default Inverter Type') }} <small class="text-warning">(Fallback Only)</small></label>
                                    <input type="text" class="form-control" 
                                           name="default_inverter_type" 
                                           value="{{ $configurations->where('key', 'default_inverter_type')->first()->value ?? 'String Inverter' }}">
                                    <small class="form-text text-muted">{{ __('Fallback inverter type when system cannot determine optimal inverter') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function saveAllConfigs() {
            // Add loading state to button
            const saveBtn = $('button[onclick="saveAllConfigs()"]');
            const originalText = saveBtn.html();
            saveBtn.html('<i class="fas fa-spinner fa-spin"></i> {{ __("Saving...") }}').prop('disabled', true);
            
            // Submit the form
            $('#configForm').submit();
        }

        $(document).ready(function() {
            // Add change detection to show unsaved changes warning
            let hasChanges = false;
            
            $('input[type="number"], select').on('input change', function() {
                hasChanges = true;
                updateSaveButton();
            });
            
            function updateSaveButton() {
                const saveBtn = $('button[onclick="saveAllConfigs()"]');
                if (hasChanges) {
                    saveBtn.removeClass('btn-success').addClass('btn-warning')
                           .html('<i class="fas fa-exclamation-triangle"></i> {{ __("Save Pending Changes") }}');
                } else {
                    saveBtn.removeClass('btn-warning').addClass('btn-success')
                           .html('<i class="fas fa-save"></i> {{ __("Save All Changes") }}');
                }
            }
            
            // Form submission success handler
            $('#configForm').on('submit', function() {
                hasChanges = false;
                updateSaveButton();
            });
            
            // Add tooltips for better UX
            $('[title]').tooltip();
            
            // Add input validation feedback
            $('input[type="number"]').on('blur', function() {
                const $this = $(this);
                const min = parseFloat($this.attr('min'));
                const max = parseFloat($this.attr('max'));
                const value = parseFloat($this.val());
                
                // Remove existing validation classes
                $this.removeClass('is-valid is-invalid');
                
                if (isNaN(value)) {
                    $this.addClass('is-invalid');
                    return;
                }
                
                if (!isNaN(min) && value < min) {
                    $this.addClass('is-invalid');
                    return;
                }
                
                if (!isNaN(max) && value > max) {
                    $this.addClass('is-invalid');
                    return;
                }
                
                $this.addClass('is-valid');
            });
        });
    </script>
@endsection

