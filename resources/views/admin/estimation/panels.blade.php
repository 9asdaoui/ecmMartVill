@section('page_title', __('Solar Panels'))
@extends('admin.layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Solar Panel Management') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">{{ __('Solar Panels') }}</h3>
                                <button type="button" class="btn btn-primary" id="addPanelBtn" onclick="$('#addPanelModal').modal('show')">
                                    <i class="fas fa-plus"></i> {{ __('Add New Panel') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter and search form -->
                            <form action="{{ route('solar-panel.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" placeholder="{{ __('Search panel name...') }}" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="number" name="min_wattage" class="form-control" placeholder="{{ __('Min Power (W)') }}" value="{{ request('min_wattage') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="number" name="max_wattage" class="form-control" placeholder="{{ __('Max Power (W)') }}" value="{{ request('max_wattage') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="brand" class="form-control" placeholder="{{ __('Brand') }}" value="{{ request('brand') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info w-100">
                                            <i class="fas fa-search"></i> {{ __('Filter') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Brand') }}</th>
                                            <th>{{ __('Product ID') }}</th>
                                            <th>{{ __('Rated Power (W)') }}</th>
                                            <th>{{ __('Module Efficiency') }}</th>
                                            <th>{{ __('Dimensions (mm)') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($panels as $panel)
                                            <tr>
                                                <td>{{ $panel->id }}</td>
                                                <td><strong>{{ $panel->name }}</strong></td>
                                                <td>{{ $panel->brand ?? '-' }}</td>
                                                <td>{{ $panel->product_id }}</td>
                                                <td>{{ $panel->panel_rated_power ? number_format($panel->panel_rated_power, 1) . 'W' : '-' }}</td>
                                                <td>{{ $panel->module_efficiency ? $panel->module_efficiency . '%' : '-' }}</td>
                                                <td>{{ $panel->width_mm && $panel->height_mm ? number_format($panel->width_mm, 0) . ' × ' . number_format($panel->height_mm, 0) : '-' }}</td>
                                                <td>{{ $panel->price ? number_format($panel->price, 2) . ' DH' : '-' }}</td>
                                                <td>
                                                    @switch($panel->status)
                                                        @case('active')
                                                            <span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ __('Active') }}</span>
                                                            @break
                                                        @case('deactive')
                                                            <span class="badge" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ __('Deactive') }}</span>
                                                            @break
                                                        @case('pending_review')
                                                            <span class="badge" style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ __('Pending Review') }}</span>
                                                            @break
                                                        @default
                                                            <span class="badge" style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ ucfirst(str_replace('_', ' ', $panel->status)) }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info view-panel" 
                                                            data-id="{{ $panel->id }}" data-toggle="tooltip" title="{{ __('View Details') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary edit-panel" 
                                                            data-id="{{ $panel->id }}"
                                                            data-name="{{ $panel->name }}"
                                                            data-product_id="{{ $panel->product_id }}"
                                                            data-brand="{{ $panel->brand }}"
                                                            data-rated_power="{{ $panel->panel_rated_power }}"
                                                            data-efficiency="{{ $panel->module_efficiency }}"
                                                            data-width="{{ $panel->width_mm }}"
                                                            data-height="{{ $panel->height_mm }}"
                                                            data-weight="{{ $panel->weight_kg }}"
                                                            data-warranty="{{ $panel->warranty_years }}"
                                                            data-price="{{ $panel->price }}"
                                                            data-max_voltage="{{ $panel->maximum_operating_voltage_vmpp }}"
                                                            data-max_current="{{ $panel->maximum_operating_current_impp }}"
                                                            data-open_circuit_voltage="{{ $panel->open_circuit_voltage }}"
                                                            data-short_circuit_current="{{ $panel->short_circuit_current }}"
                                                            data-toggle="tooltip" title="{{ __('Edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-panel" 
                                                            data-id="{{ $panel->id }}" 
                                                            data-name="{{ $panel->name }}"
                                                            data-toggle="tooltip" title="{{ __('Delete') }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <p class="text-muted mb-0">{{ __('No solar panels found') }}</p>
                                                    <small>{{ request()->has('search') || request()->has('min_wattage') || request()->has('max_wattage') || request()->has('brand')
                                                        ? __('Try adjusting your search or filter criteria')
                                                        : __('Add your first solar panel to get started') }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($panels->hasPages())
                            <div class="card-footer clearfix">
                                {{ $panels->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Panel Modal -->
    <div class="modal fade" id="addPanelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add New Solar Panel') }}</h5>
                    <button type="button" class="close" onclick="$('#addPanelModal').modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('solar-panel.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Panel Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id">{{ __('Product ID') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="product_id" name="product_id" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">{{ __('Brand') }}</label>
                                    <input type="text" class="form-control" id="brand" name="brand">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">{{ __('Type') }}</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="">{{ __('Select Type') }}</option>
                                        <option value="Monocrystalline">{{ __('Monocrystalline') }}</option>
                                        <option value="Polycrystalline">{{ __('Polycrystalline') }}</option>
                                        <option value="Thin Film">{{ __('Thin Film') }}</option>
                                        <option value="Other">{{ __('Other') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">{{ __('Price') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending_review">{{ __('Pending Review') }}</option>
                                        <option value="active">{{ __('Active') }}</option>
                                        <option value="deactive">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Physical Specifications') }}</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="width_mm">{{ __('Width (mm)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="width_mm" name="width_mm" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="height_mm">{{ __('Height (mm)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="height_mm" name="height_mm" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="weight_kg">{{ __('Weight (kg)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="weight_kg" name="weight_kg" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="warranty_years">{{ __('Warranty (years)') }}</label>
                                    <input type="number" class="form-control" id="warranty_years" name="warranty_years" min="0">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Electrical Specifications') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="panel_rated_power">{{ __('Rated Power (W)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="panel_rated_power" name="panel_rated_power" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="maximum_operating_voltage_vmpp">{{ __('Max Operating Voltage (Vmpp)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="maximum_operating_voltage_vmpp" name="maximum_operating_voltage_vmpp" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="maximum_operating_current_impp">{{ __('Max Operating Current (Impp)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="maximum_operating_current_impp" name="maximum_operating_current_impp" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="open_circuit_voltage">{{ __('Open Circuit Voltage (Voc)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="open_circuit_voltage" name="open_circuit_voltage" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="short_circuit_current">{{ __('Short Circuit Current (Isc)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="short_circuit_current" name="short_circuit_current" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="module_efficiency">{{ __('Module Efficiency (%)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="module_efficiency" name="module_efficiency" min="0" max="100">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                         
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="maximum_system_voltage">{{ __('Maximum System Voltage') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="maximum_system_voltage" name="maximum_system_voltage" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="maximum_series_fuse_rating">{{ __('Maximum Series Fuse Rating') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="maximum_series_fuse_rating" name="maximum_series_fuse_rating" min="0">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Additional Specifications') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_of_cells">{{ __('Number of Cells') }}</label>
                                    <input type="number" class="form-control" id="num_of_cells" name="num_of_cells" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wind_load_kg_per_m2">{{ __('Wind Load (kg/m²)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="wind_load_kg_per_m2" name="wind_load_kg_per_m2" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="snow_load_kg_per_m2">{{ __('Snow Load (kg/m²)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="snow_load_kg_per_m2" name="snow_load_kg_per_m2" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="operating_temperature_from">{{ __('Operating Temperature From (°C)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="operating_temperature_from" name="operating_temperature_from" placeholder="e.g., -40">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="operating_temperature_to">{{ __('Operating Temperature To (°C)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="operating_temperature_to" name="operating_temperature_to" placeholder="e.g., 85">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="connector_type">{{ __('Connector Type') }}</label>
                                    <input type="text" class="form-control" id="connector_type" name="connector_type">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Temperature Coefficients') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="temp_coefficient_of_pmax">{{ __('Pmax (%/°C)') }}</label>
                                    <input type="number" step="0.000001" class="form-control" id="temp_coefficient_of_pmax" name="temp_coefficient_of_pmax">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="temp_coefficient_of_voc">{{ __('Voc (%/°C)') }}</label>
                                    <input type="number" step="0.000001" class="form-control" id="temp_coefficient_of_voc" name="temp_coefficient_of_voc">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="temp_coefficient_of_isc">{{ __('Isc (%/°C)') }}</label>
                                    <input type="number" step="0.000001" class="form-control" id="temp_coefficient_of_isc" name="temp_coefficient_of_isc">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom_operating_cell_temp_noct">{{ __('NOCT (°C)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="nom_operating_cell_temp_noct" name="nom_operating_cell_temp_noct">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('#addPanelModal').modal('hide')">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Panel Modal -->
    <div class="modal fade" id="editPanelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit Solar Panel') }}</h5>
                    <button type="button" class="close" onclick="$('#editPanelModal').modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPanelForm" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        
                        <!-- Loading spinner -->
                        <div id="editPanelLoading" class="text-center" style="display: none;">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2">{{ __('Loading panel data...') }}</p>
                        </div>
                        
                        <!-- Edit form content -->
                        <div id="editPanelContent">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_name">{{ __('Panel Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_product_id">{{ __('Product ID') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="edit_product_id" name="product_id" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_brand">{{ __('Brand') }}</label>
                                        <input type="text" class="form-control" id="edit_brand" name="brand">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_price">{{ __('Price') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_type">{{ __('Type') }}</label>
                                        <select class="form-control" id="edit_type" name="type" required>
                                            <option value="">{{ __('Select Type') }}</option>
                                            <option value="Monocrystalline">{{ __('Monocrystalline') }}</option>
                                            <option value="Polycrystalline">{{ __('Polycrystalline') }}</option>
                                            <option value="Thin Film">{{ __('Thin Film') }}</option>
                                            <option value="Other">{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Physical Specifications') }}</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="edit_width_mm">{{ __('Width (mm)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_width_mm" name="width_mm" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="edit_height_mm">{{ __('Height (mm)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_height_mm" name="height_mm" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="edit_weight_kg">{{ __('Weight (kg)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_weight_kg" name="weight_kg" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="edit_warranty_years">{{ __('Warranty (years)') }}</label>
                                        <input type="number" class="form-control" id="edit_warranty_years" name="warranty_years" min="0">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Electrical Specifications') }}</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_panel_rated_power">{{ __('Rated Power (W)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_panel_rated_power" name="panel_rated_power" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_maximum_operating_voltage_vmpp">{{ __('Max Operating Voltage (Vmpp)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_maximum_operating_voltage_vmpp" name="maximum_operating_voltage_vmpp" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_maximum_operating_current_impp">{{ __('Max Operating Current (Impp)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_maximum_operating_current_impp" name="maximum_operating_current_impp" min="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_open_circuit_voltage">{{ __('Open Circuit Voltage (Voc)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_open_circuit_voltage" name="open_circuit_voltage" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_short_circuit_current">{{ __('Short Circuit Current (Isc)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_short_circuit_current" name="short_circuit_current" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_module_efficiency">{{ __('Module Efficiency (%)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_module_efficiency" name="module_efficiency" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_status" name="status" required>
                                            <option value="pending_review">{{ __('Pending Review') }}</option>
                                            <option value="active">{{ __('Active') }}</option>
                                            <option value="deactive">{{ __('Deactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_maximum_system_voltage">{{ __('Maximum System Voltage') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_maximum_system_voltage" name="maximum_system_voltage" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_maximum_series_fuse_rating">{{ __('Maximum Series Fuse Rating') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_maximum_series_fuse_rating" name="maximum_series_fuse_rating" min="0">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Additional Specifications') }}</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_num_of_cells">{{ __('Number of Cells') }}</label>
                                        <input type="number" class="form-control" id="edit_num_of_cells" name="num_of_cells" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_wind_load_kg_per_m2">{{ __('Wind Load (kg/m²)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_wind_load_kg_per_m2" name="wind_load_kg_per_m2" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_snow_load_kg_per_m2">{{ __('Snow Load (kg/m²)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_snow_load_kg_per_m2" name="snow_load_kg_per_m2" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_operating_temperature_from">{{ __('Operating Temperature From (°C)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_operating_temperature_from" name="operating_temperature_from" placeholder="e.g., -40">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_operating_temperature_to">{{ __('Operating Temperature To (°C)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_operating_temperature_to" name="operating_temperature_to" placeholder="e.g., 85">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_connector_type">{{ __('Connector Type') }}</label>
                                        <input type="text" class="form-control" id="edit_connector_type" name="connector_type">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Temperature Coefficients') }}</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_temp_coefficient_of_pmax">{{ __('Pmax (%/°C)') }}</label>
                                        <input type="number" step="0.000001" class="form-control" id="edit_temp_coefficient_of_pmax" name="temp_coefficient_of_pmax">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_temp_coefficient_of_voc">{{ __('Voc (%/°C)') }}</label>
                                        <input type="number" step="0.000001" class="form-control" id="edit_temp_coefficient_of_voc" name="temp_coefficient_of_voc">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_temp_coefficient_of_isc">{{ __('Isc (%/°C)') }}</label>
                                        <input type="number" step="0.000001" class="form-control" id="edit_temp_coefficient_of_isc" name="temp_coefficient_of_isc">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_nom_operating_cell_temp_noct">{{ __('NOCT (°C)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_nom_operating_cell_temp_noct" name="nom_operating_cell_temp_noct">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('#editPanelModal').modal('hide')">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="editPanelSubmitBtn">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Panel Details Modal -->
    <div class="modal fade" id="viewPanelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Solar Panel Details') }}</h5>
                    <button type="button" class="close" onclick="$('#viewPanelModal').modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Loading spinner -->
                    <div id="panelDetailsLoading" class="text-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">{{ __('Loading panel details...') }}</p>
                    </div>
                    
                    <!-- Panel details content -->
                    <div id="panelDetailsContent" style="display: none;">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('Basic Information') }}</h6>
                                <p><strong>{{ __('Name') }}:</strong> <span id="view_name"></span></p>
                                <p><strong>{{ __('Brand') }}:</strong> <span id="view_brand"></span></p>
                                <p><strong>{{ __('Product ID') }}:</strong> <span id="view_product_id"></span></p>
                               <p><strong>{{ __('Type') }}:</strong> <span id="view_type"></span></p>
                                <p><strong>{{ __('Price') }}:</strong> <span id="view_price"></span> DH</p>
                                <p><strong>{{ __('Warranty') }}:</strong> <span id="view_warranty_years"></span> years</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('Physical Specifications') }}</h6>
                                <p><strong>{{ __('Dimensions') }}:</strong> <span id="view_dimensions"></span> mm</p>
                                <p><strong>{{ __('Width') }}:</strong> <span id="view_width_mm"></span> mm</p>
                                <p><strong>{{ __('Height') }}:</strong> <span id="view_height_mm"></span> mm</p>
                                <p><strong>{{ __('Weight') }}:</strong> <span id="view_weight_kg"></span> kg</p>
                                <p><strong>{{ __('Number of Cells') }}:</strong> <span id="view_num_of_cells"></span></p>
                            </div>
                        </div>

                        <hr>

                        <!-- Electrical Specifications -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success">{{ __('Electrical Specifications') }}</h6>
                                <p><strong>{{ __('Rated Power') }}:</strong> <span id="view_rated_power"></span> W</p>
                                <p><strong>{{ __('Overall Efficiency') }}:</strong> <span id="view_efficiency"></span> %</p>
                                <p><strong>{{ __('Module Efficiency') }}:</strong> <span id="view_module_efficiency"></span> %</p>
                                <p><strong>{{ __('Max Operating Voltage (Vmpp)') }}:</strong> <span id="view_max_operating_voltage"></span> V</p>
                                <p><strong>{{ __('Max Operating Current (Impp)') }}:</strong> <span id="view_max_operating_current"></span> A</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-success">{{ __('Circuit Characteristics') }}</h6>
                                <p><strong>{{ __('Open Circuit Voltage (Voc)') }}:</strong> <span id="view_open_circuit_voltage"></span> V</p>
                                <p><strong>{{ __('Short Circuit Current (Isc)') }}:</strong> <span id="view_short_circuit_current"></span> A</p>
                                <p><strong>{{ __('Status') }}:</strong> <span id="view_status"></span></p>
                                <p><strong>{{ __('Maximum System Voltage') }}:</strong> <span id="view_maximum_system_voltage"></span> V</p>
                                <p><strong>{{ __('Maximum Series Fuse Rating') }}:</strong> <span id="view_maximum_series_fuse_rating"></span> A</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Environmental & Temperature -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-warning">{{ __('Environmental Specifications') }}</h6>
                                <p><strong>{{ __('Operating Temperature From') }}:</strong> <span id="view_operating_temperature_from"></span> °C</p>
                                <p><strong>{{ __('Operating Temperature To') }}:</strong> <span id="view_operating_temperature_to"></span> °C</p>
                                <p><strong>{{ __('NOCT') }}:</strong> <span id="view_noct"></span> °C</p>
                                <p><strong>{{ __('Wind Load') }}:</strong> <span id="view_wind_load"></span> kg/m²</p>
                                <p><strong>{{ __('Snow Load') }}:</strong> <span id="view_snow_load"></span> kg/m²</p>
                                <p><strong>{{ __('Connector Type') }}:</strong> <span id="view_connector_type"></span></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-warning">{{ __('Temperature Coefficients') }}</h6>
                                <p><strong>{{ __('Pmax Temperature Coefficient') }}:</strong> <span id="view_temp_coeff_pmax"></span> %/°C</p>
                                <p><strong>{{ __('Voc Temperature Coefficient') }}:</strong> <span id="view_temp_coeff_voc"></span> %/°C</p>
                                <p><strong>{{ __('Isc Temperature Coefficient') }}:</strong> <span id="view_temp_coeff_isc"></span> %/°C</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#viewPanelModal').modal('hide')">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePanelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                    <button type="button" class="close" onclick="$('#deletePanelModal').modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this solar panel?') }}</p>
                    <p><strong id="deletePanelName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#deletePanelModal').modal('hide')">{{ __('Cancel') }}</button>
                    <form id="deletePanelForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Helper function for number formatting
        function number_format(number, decimals = 2) {
            if (number === null || number === undefined || number === '') return '';
            return parseFloat(number).toFixed(decimals);
        }
        
        // Helper function for status badges
        function getStatusBadge(status) {
            switch(status) {
                case 'active':
                    return '<span class="badge badge-success">{{ __("Active") }}</span>';
                case 'deactive':
                    return '<span class="badge badge-secondary">{{ __("Deactive") }}</span>';
                case 'pending_review':
                    return '<span class="badge badge-warning">{{ __("Pending Review") }}</span>';
                default:
                    return '<span class="badge badge-secondary">' + (status ? status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '-') + '</span>';
            }
        }
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Add Panel button click handler (backup)
        $('#addPanelBtn').click(function() {
            $('#addPanelModal').modal('show');
        });
        
        // View panel details
        $('.view-panel').click(function() {
            const id = $(this).data('id');
            
            // Show modal immediately with loading state
            $('#viewPanelModal').modal('show');
            $('#panelDetailsLoading').show();
            $('#panelDetailsContent').hide();
            
            // Fetch panel details via AJAX
            $.ajax({
                url: `{{ url('admin/solar-panel') }}/${id}`,
                type: 'GET',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response.success) {
                        const panel = response.panel;
                        
                        // Populate all modal fields
                        $('#view_name').text(panel.name || '-');
                        $('#view_brand').text(panel.brand || '-');
                        $('#view_product_id').text(panel.product_id || '-');
                        $('#view_price').text(panel.price ? number_format(panel.price, 2) : '-');
                        $('#view_warranty_years').text(panel.warranty_years || '-');
                        
                        // Physical specifications
                        $('#view_dimensions').text(panel.width_mm && panel.height_mm ? panel.width_mm + ' × ' + panel.height_mm : '-');
                        $('#view_width_mm').text(panel.width_mm || '-');
                        $('#view_height_mm').text(panel.height_mm || '-');
                        $('#view_weight_kg').text(panel.weight_kg || '-');
                        $('#view_num_of_cells').text(panel.num_of_cells || '-');
                        
                        // Electrical specifications
                        $('#view_rated_power').text(panel.panel_rated_power || '-');
                        $('#view_efficiency').text(panel.module_efficiency || '-');
                        $('#view_module_efficiency').text(panel.module_efficiency || '-');
                        $('#view_max_operating_voltage').text(panel.maximum_operating_voltage_vmpp || '-');
                        $('#view_max_operating_current').text(panel.maximum_operating_current_impp || '-');
                        
                        // Circuit characteristics
                        $('#view_open_circuit_voltage').text(panel.open_circuit_voltage || '-');
                        $('#view_short_circuit_current').text(panel.short_circuit_current || '-');
                        $('#view_status').html(getStatusBadge(panel.status));
                        $('#view_maximum_system_voltage').text(panel.maximum_system_voltage || '-');
                        $('#view_maximum_series_fuse_rating').text(panel.maximum_series_fuse_rating || '-');
                        
                        // Environmental specifications
                        $('#view_operating_temperature_from').text(panel.operating_temperature_from || '-');
                        $('#view_operating_temperature_to').text(panel.operating_temperature_to || '-');
                        $('#view_noct').text(panel.nom_operating_cell_temp_noct || '-');
                        $('#view_wind_load').text(panel.wind_load_kg_per_m2 || '-');
                        $('#view_snow_load').text(panel.snow_load_kg_per_m2 || '-');
                        $('#view_connector_type').text(panel.connector_type || '-');
                        
                        // Temperature coefficients
                        $('#view_temp_coeff_pmax').text(panel.temp_coefficient_of_pmax || '-');
                        $('#view_temp_coeff_voc').text(panel.temp_coefficient_of_voc || '-');
                        $('#view_temp_coeff_isc').text(panel.temp_coefficient_of_isc || '-');
                        
                        // Hide loading and show content
                        $('#panelDetailsLoading').hide();
                        $('#panelDetailsContent').show();
                    } else {
                        $('#panelDetailsLoading').hide();
                        $('#panelDetailsContent').html('<div class="alert alert-danger">{{ __("Error loading panel details") }}</div>').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#panelDetailsLoading').hide();
                    let errorMessage = '{{ __("Error fetching panel details") }}';
                    if (status === 'timeout') {
                        errorMessage = '{{ __("Request timed out. Please try again.") }}';
                    }
                    $('#panelDetailsContent').html('<div class="alert alert-danger">' + errorMessage + '</div>').show();
                }
            });
        });
        
        // Edit panel
        $('.edit-panel').click(function() {
            const id = $(this).data('id');
            
            // Show modal immediately with loading state
            $('#editPanelLoading').show();
            $('#editPanelContent').hide();
            $('#editPanelModal').modal('show');
            
            // Set form action URL
            $('#editPanelForm').attr('action', `{{ url('admin/solar-panel') }}/${id}`);
            
            // Load panel data via AJAX
            $.ajax({
                url: `{{ url('admin/solar-panel') }}/${id}`,
                method: 'GET',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    const panel = response.panel || response; // Handle both nested and direct response
                    
                    // Populate all form fields
                    $('#edit_name').val(panel.name || '');
                    $('#edit_product_id').val(panel.product_id || '');
                    $('#edit_brand').val(panel.brand || '');
                    $('#edit_price').val(panel.price || '');
                    
                    // Physical specifications
                    $('#edit_width_mm').val(panel.width_mm || '');
                    $('#edit_height_mm').val(panel.height_mm || '');
                    $('#edit_weight_kg').val(panel.weight_kg || '');
                    $('#edit_warranty_years').val(panel.warranty_years || '');
                    
                    // Electrical specifications
                    $('#edit_panel_rated_power').val(panel.panel_rated_power || '');
                    $('#edit_maximum_operating_voltage_vmpp').val(panel.maximum_operating_voltage_vmpp || '');
                    $('#edit_maximum_operating_current_impp').val(panel.maximum_operating_current_impp || '');
                    $('#edit_open_circuit_voltage').val(panel.open_circuit_voltage || '');
                    $('#edit_short_circuit_current').val(panel.short_circuit_current || '');
                    $('#edit_module_efficiency').val(panel.module_efficiency || '');
                    $('#edit_maximum_system_voltage').val(panel.maximum_system_voltage || '');
                    $('#edit_maximum_series_fuse_rating').val(panel.maximum_series_fuse_rating || '');
                    
                    // Additional specifications
                    $('#edit_num_of_cells').val(panel.num_of_cells || '');
                    $('#edit_wind_load_kg_per_m2').val(panel.wind_load_kg_per_m2 || '');
                    $('#edit_snow_load_kg_per_m2').val(panel.snow_load_kg_per_m2 || '');
                    $('#edit_operating_temperature_from').val(panel.operating_temperature_from || '');
                    $('#edit_operating_temperature_to').val(panel.operating_temperature_to || '');
                    $('#edit_connector_type').val(panel.connector_type || '');
                    
                    // Temperature coefficients
                    $('#edit_temp_coefficient_of_pmax').val(panel.temp_coefficient_of_pmax || '');
                    $('#edit_temp_coefficient_of_voc').val(panel.temp_coefficient_of_voc || '');
                    $('#edit_temp_coefficient_of_isc').val(panel.temp_coefficient_of_isc || '');
                    $('#edit_nom_operating_cell_temp_noct').val(panel.nom_operating_cell_temp_noct || '');
                    $('#edit_status').val(panel.status || 'pending_review');
                    
                    // Hide loading and show content
                    $('#editPanelLoading').hide();
                    $('#editPanelContent').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading panel data:', error);
                    $('#editPanelLoading').hide();
                    $('#editPanelContent').show();
                    
                    // Show error message
                    alert('{{ __("Error loading panel data. Please try again.") }}');
                    $('#editPanelModal').modal('hide');
                }
            });
        });
        
        // Handle Edit Panel form submission
        $('#editPanelForm').on('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            $('#editPanelSubmitBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>{{ __("Updating...") }}');
            
            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                timeout: 15000, // 15 second timeout
                success: function(response) {
                    if (response.success) {
                        $('#editPanelModal').modal('hide');
                        location.reload(); // Reload to show updated data
                    } else {
                        alert(response.message || '{{ __("Error updating panel. Please try again.") }}');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating panel:', error);
                    let errorMessage = '{{ __("Error updating panel. Please try again.") }}';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Handle validation errors
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    
                    alert(errorMessage);
                },
                complete: function() {
                    // Reset button state
                    $('#editPanelSubmitBtn').prop('disabled', false).html('{{ __("Update") }}');
                }
            });
        });
        
        // Delete panel
        $('.delete-panel').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            // Update modal content
            $('#deletePanelName').text(name);
            $('#deletePanelForm').attr('action', `{{ url('admin/solar-panel') }}/${id}`);
            
            // Show modal
            $('#deletePanelModal').modal('show');
        });
        
        // Reset modals when closed
        $('#viewPanelModal').on('hidden.bs.modal', function () {
            $('#viewPanelLoading').hide();
            $('#viewPanelContent').show();
            // Clear all view fields
            $('#view_name, #view_brand, #view_price, #view_warranty, #view_nominal_power_watts, #view_efficiency_rating, #view_dimensions, #view_weight, #view_temperature_coefficient, #view_max_system_voltage, #view_max_series_fuse_rating, #view_fire_class, #view_application_class, #view_cell_technology, #view_cell_type, #view_junction_box_ip_rating, #view_cable_length, #view_operating_temperature_min, #view_operating_temperature_max, #view_manufacturer_warranty, #view_product_warranty, #view_origin_country, #view_certification, #view_category, #view_connectivity, #view_installation_type, #view_frame_type, #view_glass_type, #view_backsheet_type, #view_temp_coeff_isc, #view_temp_coeff_voc, #view_temp_coeff_pmp, #view_short_circuit_current, #view_open_circuit_voltage, #view_opt_operating_current, #view_opt_operating_voltage, #view_max_overcurrent_device_rating, #view_max_reverse_current').text('-');
            $('#view_status_badge').html('');
        });
        
        $('#editPanelModal').on('hidden.bs.modal', function () {
            $('#editPanelLoading').hide();
            $('#editPanelContent').show();
            // Reset form
            $('#editPanelForm')[0].reset();
            $('#editPanelForm').attr('action', '');
        });
        
        // Handle modal close buttons explicitly
        $('#viewPanelModal .close, #viewPanelModal [data-dismiss="modal"]').click(function() {
            $('#viewPanelModal').modal('hide');
        });
        
        $('#editPanelModal .close, #editPanelModal [data-dismiss="modal"]').click(function() {
            $('#editPanelModal').modal('hide');
        });
        
        $('#deletePanelModal .close, #deletePanelModal [data-dismiss="modal"]').click(function() {
            $('#deletePanelModal').modal('hide');
        });
        
        $('#addPanelModal .close, #addPanelModal [data-dismiss="modal"]').click(function() {
            $('#addPanelModal').modal('hide');
        });
        
        // Ensure backdrop click closes modal
        $('#viewPanelModal, #editPanelModal, #deletePanelModal, #addPanelModal').on('click', function(e) {
            if (e.target === this) {
                $(this).modal('hide');
            }
        });
    });
</script>
@endsection
