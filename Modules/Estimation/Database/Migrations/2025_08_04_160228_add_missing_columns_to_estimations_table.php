<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('estimations', function (Blueprint $table) {
            // Add roof_tilt column if it doesn't exist
            if (!Schema::hasColumn('estimations', 'roof_tilt')) {
                $table->decimal('roof_tilt', 5, 2)->nullable()->after('roof_type');
            }
            
            // Add all other missing columns based on the error logs
            $columns = [
                // Usable area detection fields
                'usable_polygon' => ['json', 'nullable'],
                'usable_area' => ['decimal', 8, 2, 'nullable'],
                'usable_area_m2' => ['decimal', 8, 2, 'nullable'],
                'roof_mask_image' => ['string', 'nullable'],
                'overlay_image' => ['string', 'nullable'],
                'sam_masks' => ['json', 'nullable'],
                'roof_mask_index' => ['integer', 'nullable'],
                'facade_reduction_ratio' => ['decimal', 5, 4, 'nullable'],
                'roof_type_detected' => ['string', 'nullable'],
                'facade_filtering_applied' => ['boolean', 'default' => false],
                'meters_per_pixel' => ['decimal', 10, 6, 'nullable'],
                
                // Panel placement API results
                'panel_grid_image' => ['string', 'nullable'],
                'visualization_image' => ['string', 'nullable'],
                'panel_grid' => ['json', 'nullable'],
                'panel_positions' => ['json', 'nullable'],
                
                // Enhanced Solar Calculation Data
                'solar_irradiance_avg' => ['decimal', 8, 2, 'nullable'],
                'performance_ratio' => ['decimal', 5, 4, 'nullable'],
                'solar_production_factor' => ['decimal', 8, 2, 'nullable'],
                
                // Mounting Structure Cost Data
                'mounting_structure_cost' => ['json', 'nullable'],
                'installation_type' => ['string', 'nullable'],
                'panel_orientation' => ['string', 'nullable'],
                
                // Inverter Design Data
                'inverter_design' => ['json', 'nullable'],
                'inverter_combos' => ['json', 'nullable'],
                'stringing_details' => ['json', 'nullable'],
                
                // Wiring Calculation Data
                'wiring_calculation' => ['json', 'nullable'],
                'wiring_specs' => ['json', 'nullable'],
                'wiring_bom' => ['json', 'nullable'],
                'wiring_cost_mad' => ['decimal', 10, 2, 'nullable'],
                
                // Panel Spacing Calculations
                'winter_solstice_angle' => ['decimal', 5, 2, 'nullable'],
                'spacing_portrait' => ['decimal', 8, 2, 'nullable'],
                'spacing_landscape' => ['decimal', 8, 2, 'nullable'],
                
                // Environmental Complexity Data
                'wind_speed' => ['decimal', 8, 2, 'nullable'],
                'elevation' => ['decimal', 8, 2, 'nullable'],
                'wind_complexity' => ['string', 'nullable'],
                'snow_complexity' => ['string', 'nullable'],
                
                // API Success Tracking
                'pvwatts_api_success' => ['boolean', 'default' => false],
                'usable_area_api_success' => ['boolean', 'default' => false],
                'panel_placement_api_success' => ['boolean', 'default' => false],
                'best_fit_panel_found' => ['boolean', 'default' => false],
                'inverter_design_success' => ['boolean', 'default' => false],
                'wiring_calculation_success' => ['boolean', 'default' => false],
                
                // System Loss Calculation Details
                'eta_panel' => ['decimal', 5, 4, 'nullable'],
                'eta_temperature' => ['decimal', 5, 4, 'nullable'],
                'eta_soiling' => ['decimal', 5, 4, 'nullable'],
                'eta_mismatch' => ['decimal', 5, 4, 'nullable'],
                'dc_voltage_drop' => ['decimal', 5, 4, 'nullable'],
                'eta_inverter' => ['decimal', 5, 4, 'nullable'],
                'ac_voltage_drop' => ['decimal', 5, 4, 'nullable'],
                'eta_other' => ['decimal', 5, 4, 'nullable'],
                
                // Best Fit Panel Results
                'best_fit_panel_result' => ['json', 'nullable'],
                'total_capacity_kw' => ['decimal', 8, 2, 'nullable'],
                'total_annual_production_kwh' => ['decimal', 10, 2, 'nullable'],
                
                // Usage Pattern Data Enhancement
                'usage_data_breakdown' => ['json', 'nullable'],
                
                // Error Tracking
                'api_errors' => ['json', 'nullable'],
            ];
            
            foreach ($columns as $columnName => $columnSpec) {
                if (!Schema::hasColumn('estimations', $columnName)) {
                    $column = null;
                    
                    switch ($columnSpec[0]) {
                        case 'json':
                            $column = $table->json($columnName);
                            break;
                        case 'decimal':
                            $column = $table->decimal($columnName, $columnSpec[1], $columnSpec[2]);
                            break;
                        case 'string':
                            $column = $table->string($columnName);
                            break;
                        case 'integer':
                            $column = $table->integer($columnName);
                            break;
                        case 'boolean':
                            $column = $table->boolean($columnName);
                            break;
                    }
                    
                    if ($column && isset($columnSpec[count($columnSpec) - 1]) && $columnSpec[count($columnSpec) - 1] === 'nullable') {
                        $column->nullable();
                    }
                    
                    if ($column && isset($columnSpec['default'])) {
                        $column->default($columnSpec['default']);
                    }
                    
                    // Handle boolean defaults
                    if ($columnSpec[0] === 'boolean' && isset($columnSpec[1]) && str_starts_with($columnSpec[1], 'default')) {
                        $defaultValue = $columnSpec[1] === 'default' ? ($columnSpec[2] ?? false) : false;
                        $column->default($defaultValue);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estimations', function (Blueprint $table) {
            $columns = [
                'roof_tilt', 'usable_polygon', 'usable_area', 'usable_area_m2', 'roof_mask_image', 
                'overlay_image', 'sam_masks', 'roof_mask_index', 'facade_reduction_ratio', 
                'roof_type_detected', 'facade_filtering_applied', 'meters_per_pixel', 
                'panel_grid_image', 'visualization_image', 'panel_grid', 'panel_positions', 
                'solar_irradiance_avg', 'performance_ratio', 'solar_production_factor', 
                'mounting_structure_cost', 'installation_type', 'panel_orientation', 
                'inverter_design', 'inverter_combos', 'stringing_details', 'wiring_calculation', 
                'wiring_specs', 'wiring_bom', 'wiring_cost_mad', 'winter_solstice_angle', 
                'spacing_portrait', 'spacing_landscape', 'wind_speed', 'elevation', 
                'wind_complexity', 'snow_complexity', 'pvwatts_api_success', 
                'usable_area_api_success', 'panel_placement_api_success', 'best_fit_panel_found', 
                'inverter_design_success', 'wiring_calculation_success', 'eta_panel', 
                'eta_temperature', 'eta_soiling', 'eta_mismatch', 'dc_voltage_drop', 
                'eta_inverter', 'ac_voltage_drop', 'eta_other', 'best_fit_panel_result', 
                'total_capacity_kw', 'total_annual_production_kwh', 'usage_data_breakdown', 
                'api_errors'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('estimations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
