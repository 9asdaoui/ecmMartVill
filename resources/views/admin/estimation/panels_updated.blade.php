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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPanelModal">
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
                                            <th>{{ __('Efficiency') }}</th>
                                            <th>{{ __('Dimensions (mm)') }}</th>
                                            <th>{{ __('Price') }}</th>
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
                                                <td>{{ $panel->efficiency ? $panel->efficiency . '%' : '-' }}</td>
                                                <td>{{ $panel->width_mm && $panel->height_mm ? number_format($panel->width_mm, 0) . ' × ' . number_format($panel->height_mm, 0) : '-' }}</td>
                                                <td>{{ $panel->price ? number_format($panel->price, 2) . ' DH' : '-' }}</td>
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
                                                            data-efficiency="{{ $panel->efficiency }}"
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
                                                <td colspan="9" class="text-center py-4">
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">{{ __('Brand') }}</label>
                                    <input type="text" class="form-control" id="brand" name="brand">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">{{ __('Price') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" min="0">
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
                                    <label for="power_tolerance">{{ __('Power Tolerance') }}</label>
                                    <input type="text" class="form-control" id="power_tolerance" name="power_tolerance">
                                </div>
                            </div>
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
                                    <label for="operating_temperature">{{ __('Operating Temperature Range') }}</label>
                                    <input type="text" class="form-control" id="operating_temperature" name="operating_temperature" placeholder="e.g., -40°C to +85°C">
                                </div>
                            </div>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="efficiency">{{ __('Overall Efficiency (%)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="efficiency" name="efficiency" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPanelForm" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_panel_rated_power">{{ __('Rated Power (W)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_panel_rated_power" name="panel_rated_power" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_efficiency">{{ __('Efficiency (%)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_efficiency" name="efficiency" min="0" max="100">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_warranty_years">{{ __('Warranty (years)') }}</label>
                                    <input type="number" class="form-control" id="edit_warranty_years" name="warranty_years" min="0">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Dimensions & Weight') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_width_mm">{{ __('Width (mm)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_width_mm" name="width_mm" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_height_mm">{{ __('Height (mm)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_height_mm" name="height_mm" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_weight_kg">{{ __('Weight (kg)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_weight_kg" name="weight_kg" min="0">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Electrical Properties') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_maximum_operating_voltage_vmpp">{{ __('Max Operating Voltage (Vmpp)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_maximum_operating_voltage_vmpp" name="maximum_operating_voltage_vmpp" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_maximum_operating_current_impp">{{ __('Max Operating Current (Impp)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_maximum_operating_current_impp" name="maximum_operating_current_impp" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Panel Details Modal -->
    <div class="modal fade" id="viewPanelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Solar Panel Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>{{ __('Name') }}:</strong> <span id="view_name"></span></p>
                            <p><strong>{{ __('Brand') }}:</strong> <span id="view_brand"></span></p>
                            <p><strong>{{ __('Product ID') }}:</strong> <span id="view_product_id"></span></p>
                            <p><strong>{{ __('Rated Power') }}:</strong> <span id="view_rated_power"></span> W</p>
                            <p><strong>{{ __('Efficiency') }}:</strong> <span id="view_efficiency"></span> %</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('Dimensions') }}:</strong> <span id="view_dimensions"></span> mm</p>
                            <p><strong>{{ __('Weight') }}:</strong> <span id="view_weight_kg"></span> kg</p>
                            <p><strong>{{ __('Warranty') }}:</strong> <span id="view_warranty_years"></span> years</p>
                            <p><strong>{{ __('Price') }}:</strong> <span id="view_price"></span> DH</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this solar panel?') }}</p>
                    <p><strong id="deletePanelName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // View panel details
        $('.view-panel').click(function() {
            const id = $(this).data('id');
            
            // Fetch panel details via AJAX
            $.ajax({
                url: `{{ url('admin/solar-panel') }}/${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const panel = response.panel;
                        
                        // Populate modal fields
                        $('#view_name').text(panel.name || '-');
                        $('#view_brand').text(panel.brand || '-');
                        $('#view_product_id').text(panel.product_id || '-');
                        $('#view_rated_power').text(panel.panel_rated_power || '-');
                        $('#view_efficiency').text(panel.efficiency || '-');
                        $('#view_dimensions').text(panel.width_mm && panel.height_mm ? panel.width_mm + ' × ' + panel.height_mm : '-');
                        $('#view_weight_kg').text(panel.weight_kg || '-');
                        $('#view_warranty_years').text(panel.warranty_years || '-');
                        $('#view_price').text(panel.price || '-');
                        
                        $('#viewPanelModal').modal('show');
                    }
                },
                error: function() {
                    alert('Error fetching panel details');
                }
            });
        });
        
        // Edit panel
        $('.edit-panel').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const product_id = $(this).data('product_id');
            const brand = $(this).data('brand');
            const rated_power = $(this).data('rated_power');
            const efficiency = $(this).data('efficiency');
            const width = $(this).data('width');
            const height = $(this).data('height');
            const weight = $(this).data('weight');
            const warranty = $(this).data('warranty');
            const price = $(this).data('price');
            const max_voltage = $(this).data('max_voltage');
            const max_current = $(this).data('max_current');
            
            // Set form values
            $('#edit_name').val(name);
            $('#edit_product_id').val(product_id);
            $('#edit_brand').val(brand);
            $('#edit_panel_rated_power').val(rated_power);
            $('#edit_efficiency').val(efficiency);
            $('#edit_width_mm').val(width);
            $('#edit_height_mm').val(height);
            $('#edit_weight_kg').val(weight);
            $('#edit_warranty_years').val(warranty);
            $('#edit_price').val(price);
            $('#edit_maximum_operating_voltage_vmpp').val(max_voltage);
            $('#edit_maximum_operating_current_impp').val(max_current);
            
            // Set form action URL
            $('#editPanelForm').attr('action', `{{ url('admin/solar-panel') }}/${id}`);
            
            // Show modal
            $('#editPanelModal').modal('show');
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
    });
</script>
@endsection
