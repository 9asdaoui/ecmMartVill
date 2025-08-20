@section('page_title', __('Inverters'))
@extends('admin.layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Inverter Management') }}</h1>
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
                                <h3 class="card-title">{{ __('Inverters') }}</h3>
                                <button type="button" class="btn btn-primary" id="addInverterBtn" onclick="$('#addInverterModal').modal('show')">
                                    <i class="fas fa-plus"></i> {{ __('Add New Inverter') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter and search form -->
                            <form action="{{ route('inverter.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" placeholder="{{ __('Search inverter name...') }}" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="number" name="min_power" class="form-control" placeholder="{{ __('Min Power (kW)') }}" value="{{ request('min_power') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="number" name="max_power" class="form-control" placeholder="{{ __('Max Power (kW)') }}" value="{{ request('max_power') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="brand" class="form-control" placeholder="{{ __('Brand') }}" value="{{ request('brand') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="status" class="form-control">
                                                <option value="">{{ __('All Status') }}</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="deactive" {{ request('status') == 'deactive' ? 'selected' : '' }}>{{ __('Deactive') }}</option>
                                                <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>{{ __('Pending Review') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-info w-100">
                                            <i class="fas fa-search"></i>
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
                                            <th>{{ __('AC Power (kW)') }}</th>
                                            <th>{{ __('Phase Type') }}</th>
                                            <th>{{ __('Max Efficiency') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inverters as $inverter)
                                            <tr>
                                                <td>{{ $inverter->id }}</td>
                                                <td><strong>{{ $inverter->name }}</strong></td>
                                                <td>{{ $inverter->brand ?? '-' }}</td>
                                                <td>{{ $inverter->nominal_ac_power_kw ? number_format($inverter->nominal_ac_power_kw, 1) . ' kW' : '-' }}</td>
                                                <td>{{ $inverter->phase_type ?? '-' }}</td>
                                                <td>{{ $inverter->efficiency_max ? $inverter->efficiency_max . '%' : '-' }}</td>
                                                <td>{{ $inverter->price ? number_format($inverter->price, 2) . ' DH' : '-' }}</td>
                                                <td>
                                                    @switch($inverter->status)
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
                                                            <span class="badge" style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ ucfirst(str_replace('_', ' ', $inverter->status)) }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info view-inverter" 
                                                            data-id="{{ $inverter->id }}" data-toggle="tooltip" title="{{ __('View Details') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary edit-inverter" 
                                                            data-id="{{ $inverter->id }}"
                                                            data-name="{{ $inverter->name }}"
                                                            data-brand="{{ $inverter->brand }}"
                                                            data-price="{{ $inverter->price }}"
                                                            data-warranty="{{ $inverter->warranty }}"
                                                            data-nominal_ac_power_kw="{{ $inverter->nominal_ac_power_kw }}"
                                                            data-max_dc_input_power="{{ $inverter->max_dc_input_power }}"
                                                            data-mppt_min_voltage="{{ $inverter->mppt_min_voltage }}"
                                            data-mppt_max_voltage="{{ $inverter->mppt_max_voltage }}"
                                                            data-max_dc_voltage="{{ $inverter->max_dc_voltage }}"
                                                            data-max_dc_current_mppt="{{ $inverter->max_dc_current_mppt }}"
                                                            data-no_of_mppTs="{{ $inverter->no_of_mppTs }}"
                                                            data-max_strings_mppt="{{ $inverter->max_strings_mppt }}"
                                                            data-efficiency_max="{{ $inverter->efficiency_max }}"
                                                            data-efficiency_euro="{{ $inverter->efficiency_euro }}"
                                                            data-ac_output_voltage="{{ $inverter->ac_output_voltage }}"
                                                            data-phase_type="{{ $inverter->phase_type }}"
                                                            data-spd_included="{{ $inverter->spd_included }}"
                                                            data-ip_rating="{{ $inverter->ip_rating }}"
                                                            data-communication_ports="{{ $inverter->communication_ports }}"
                                                            data-status="{{ $inverter->status }}"
                                                            data-toggle="tooltip" title="{{ __('Edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-inverter" 
                                                            data-id="{{ $inverter->id }}" 
                                                            data-name="{{ $inverter->name }}"
                                                            data-toggle="tooltip" title="{{ __('Delete') }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <p class="text-muted mb-0">{{ __('No inverters found') }}</p>
                                                    <small>{{ request()->has('search') || request()->has('min_power') || request()->has('max_power') || request()->has('brand') || request()->has('status')
                                                        ? __('Try adjusting your search or filter criteria')
                                                        : __('Add your first inverter to get started') }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($inverters->hasPages())
                            <div class="card-footer clearfix">
                                {{ $inverters->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Inverter Modal -->
    <div class="modal fade" id="addInverterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add New Inverter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('inverter.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Inverter Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_id">{{ __('Product ID') }}</label>
                                                <input type="number" class="form-control" id="product_id" name="product_id" min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" min="0">
                                            </div>
                                        </div>                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="brand">{{ __('Brand') }}</label>
                                                <input type="text" class="form-control" id="brand" name="brand">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="warranty">{{ __('Warranty (years)') }}</label>
                                                <input type="number" class="form-control" id="warranty" name="warranty" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="active">{{ __('Active') }}</option>
                                                    <option value="deactive">{{ __('Deactive') }}</option>
                                                    <option value="pending_review">{{ __('Pending Review') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                        <h5 class="mt-4">{{ __('Power Specifications') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nominal_ac_power_kw">{{ __('Nominal AC Power (kW)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="nominal_ac_power_kw" name="nominal_ac_power_kw" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_dc_input_power">{{ __('Max DC Input Power') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="max_dc_input_power" name="max_dc_input_power" min="0">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('MPPT Specifications') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mppt_min_voltage">{{ __('MPPT Min Voltage (V)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="mppt_min_voltage" name="mppt_min_voltage" placeholder="e.g., 125">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mppt_max_voltage">{{ __('MPPT Max Voltage (V)') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="mppt_max_voltage" name="mppt_max_voltage" placeholder="e.g., 550">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_dc_voltage">{{ __('Max DC Voltage') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="max_dc_voltage" name="max_dc_voltage" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="max_dc_current_mppt">{{ __('Max DC Current / MPPT') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="max_dc_current_mppt" name="max_dc_current_mppt" min="0">
                                </div>
                            </div>                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_of_mppt_ports">{{ __('No. of MPPT Ports') }}</label>
                                                <input type="number" class="form-control" id="no_of_mppt_ports" name="no_of_mppt_ports" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="max_strings_per_mppt">{{ __('Max Strings per MPPT') }}</label>
                                                <input type="number" class="form-control" id="max_strings_per_mppt" name="max_strings_per_mppt" min="0">
                                            </div>
                                        </div>
                        </div>                                        <h5 class="mt-4">{{ __('Efficiency & AC Output') }}</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="efficiency_max">{{ __('Max Efficiency (%)') }}</label>
                                                    <input type="number" step="0.01" class="form-control" id="efficiency_max" name="efficiency_max" min="0" max="100">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ac_output_voltage">{{ __('AC Output Voltage') }}</label>
                                                    <input type="text" class="form-control" id="ac_output_voltage" name="ac_output_voltage" placeholder="e.g., 230V/400V">
                                                </div>
                                            </div>
                                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phase_type">{{ __('Phase Type') }}</label>
                                    <select class="form-control" id="phase_type" name="phase_type">
                                        <option value="">{{ __('Select Phase Type') }}</option>
                                        <option value="1P">{{ __('Single Phase (1P)') }}</option>
                                        <option value="3P">{{ __('Three Phase (3P)') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">{{ __('Protection') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="spd_included">{{ __('SPD Included? (DC/AC)') }}</label>
                                    <input type="text" class="form-control" id="spd_included" name="spd_included" placeholder="e.g., DC/AC, DC only, AC only, None">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ip_rating">{{ __('IP Rating') }}</label>
                                    <input type="text" class="form-control" id="ip_rating" name="ip_rating" placeholder="e.g., IP65">
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

    <!-- Edit Inverter Modal -->
    <div class="modal fade" id="editInverterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit Inverter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editInverterForm" method="POST">
                    <div class="modal-body">
                        <!-- Loading Animation -->
                        <div id="editLoadingSpinner" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{{ __('Loading...') }}</span>
                            </div>
                            <p class="mt-2">{{ __('Loading inverter details...') }}</p>
                        </div>

                        <!-- Form Content -->
                        <div id="editFormContent">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_name">{{ __('Inverter Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_brand">{{ __('Brand') }}</label>
                                        <input type="text" class="form-control" id="edit_brand" name="brand">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_price">{{ __('Price') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_warranty">{{ __('Warranty (years)') }}</label>
                                        <input type="number" class="form-control" id="edit_warranty" name="warranty" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_status" name="status" required>
                                            <option value="active">{{ __('Active') }}</option>
                                            <option value="deactive">{{ __('Deactive') }}</option>
                                            <option value="pending_review">{{ __('Pending Review') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Power Specifications') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_nominal_ac_power_kw">{{ __('Nominal AC Power (kW)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_nominal_ac_power_kw" name="nominal_ac_power_kw" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_max_dc_input_power">{{ __('Max DC Input Power') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_max_dc_input_power" name="max_dc_input_power" min="0">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('MPPT Specifications') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_mppt_min_voltage">{{ __('MPPT Min Voltage (V)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_mppt_min_voltage" name="mppt_min_voltage" placeholder="e.g., 125">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_mppt_max_voltage">{{ __('MPPT Max Voltage (V)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_mppt_max_voltage" name="mppt_max_voltage" placeholder="e.g., 550">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_max_dc_voltage">{{ __('Max DC Voltage') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_max_dc_voltage" name="max_dc_voltage" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_max_dc_current_mppt">{{ __('Max DC Current / MPPT') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_max_dc_current_mppt" name="max_dc_current_mppt" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_no_of_mppTs">{{ __('No. of MPPTs') }}</label>
                                        <input type="number" class="form-control" id="edit_no_of_mppTs" name="no_of_mppTs" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edit_max_strings_mppt">{{ __('Max Strings / MPPT') }}</label>
                                        <input type="number" class="form-control" id="edit_max_strings_mppt" name="max_strings_mppt" min="0">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Efficiency & AC Output') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_efficiency_max">{{ __('Max Efficiency (%)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_efficiency_max" name="efficiency_max" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_efficiency_euro">{{ __('Euro Efficiency (%)') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_efficiency_euro" name="efficiency_euro" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_ac_output_voltage">{{ __('AC Output Voltage') }}</label>
                                        <input type="text" class="form-control" id="edit_ac_output_voltage" name="ac_output_voltage" placeholder="e.g., 230V/400V">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_phase_type">{{ __('Phase Type') }}</label>
                                        <select class="form-control" id="edit_phase_type" name="phase_type">
                                            <option value="">{{ __('Select Phase Type') }}</option>
                                            <option value="1P">{{ __('Single Phase (1P)') }}</option>
                                            <option value="3P">{{ __('Three Phase (3P)') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">{{ __('Protection & Communication') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_spd_included">{{ __('SPD Included? (DC/AC)') }}</label>
                                        <input type="text" class="form-control" id="edit_spd_included" name="spd_included" placeholder="e.g., DC/AC, DC only, AC only, None">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_ip_rating">{{ __('IP Rating') }}</label>
                                        <input type="text" class="form-control" id="edit_ip_rating" name="ip_rating" placeholder="e.g., IP65">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_communication_ports">{{ __('Communication Ports') }}</label>
                                        <textarea class="form-control" id="edit_communication_ports" name="communication_ports" rows="3" placeholder="e.g., RS485, WiFi, Ethernet, USB"></textarea>
                                    </div>
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

    <!-- View Inverter Details Modal -->
    <div class="modal fade" id="viewInverterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Inverter Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Loading Animation -->
                    <div id="viewLoadingSpinner" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </div>
                        <p class="mt-2">{{ __('Loading inverter details...') }}</p>
                    </div>

                    <!-- Details Content -->
                    <div id="viewDetailsContent">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('Basic Information') }}</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>{{ __('Name') }}:</strong></td>
                                        <td><span id="view_name"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Brand') }}:</strong></td>
                                        <td><span id="view_brand"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Price') }}:</strong></td>
                                        <td><span id="view_price"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Warranty') }}:</strong></td>
                                        <td><span id="view_warranty"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Status') }}:</strong></td>
                                        <td><span id="view_status_badge"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('Power Specifications') }}</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>{{ __('Nominal AC Power') }}:</strong></td>
                                        <td><span id="view_nominal_ac_power_kw"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Max DC Input Power') }}:</strong></td>
                                        <td><span id="view_max_dc_input_power"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Max Efficiency') }}:</strong></td>
                                        <td><span id="view_efficiency_max"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Euro Efficiency') }}:</strong></td>
                                        <td><span id="view_efficiency_euro"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Phase Type') }}:</strong></td>
                                        <td><span id="view_phase_type"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('MPPT Specifications') }}</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>{{ __('MPPT Voltage Range') }}:</strong></td>
                                        <td><span id="view_mppt_min_voltage"></span> - <span id="view_mppt_max_voltage"></span> V</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Max DC Voltage') }}:</strong></td>
                                        <td><span id="view_max_dc_voltage"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Max DC Current / MPPT') }}:</strong></td>
                                        <td><span id="view_max_dc_current_mppt"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('No. of MPPTs') }}:</strong></td>
                                        <td><span id="view_no_of_mppTs"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Max Strings / MPPT') }}:</strong></td>
                                        <td><span id="view_max_strings_mppt"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">{{ __('AC Output & Protection') }}</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>{{ __('AC Output Voltage') }}:</strong></td>
                                        <td><span id="view_ac_output_voltage"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('SPD Included') }}:</strong></td>
                                        <td><span id="view_spd_included"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('IP Rating') }}:</strong></td>
                                        <td><span id="view_ip_rating"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('Communication Ports') }}:</strong></td>
                                        <td><span id="view_communication_ports"></span></td>
                                    </tr>
                                </table>
                            </div>
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
    <div class="modal fade" id="deleteInverterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this inverter?') }}</p>
                    <p><strong id="deleteInverterName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form id="deleteInverterForm" method="POST" class="d-inline">
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
        
        // View inverter details
        $('.view-inverter').click(function() {
            const id = $(this).data('id');
            
            // Show loading spinner
            $('#viewLoadingSpinner').show();
            $('#viewDetailsContent').hide();
            $('#viewInverterModal').modal('show');
            
            // Fetch inverter details via AJAX
            $.ajax({
                url: `{{ url('admin/inverter') }}/${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const inverter = response.inverter;
                        
                        // Populate modal fields
                        $('#view_name').text(inverter.name || '-');
                        $('#view_brand').text(inverter.brand || '-');
                        $('#view_price').text(inverter.price ? inverter.price + ' DH' : '-');
                        $('#view_warranty').text(inverter.warranty ? inverter.warranty + ' years' : '-');
                        
                        // Status badge
                        let statusBadge = '';
                        switch(inverter.status) {
                            case 'active':
                                statusBadge = '<span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Active</span>';
                                break;
                            case 'deactive':
                                statusBadge = '<span class="badge" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Deactive</span>';
                                break;
                            case 'pending_review':
                                statusBadge = '<span class="badge" style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pending Review</span>';
                                break;
                            default:
                                statusBadge = '<span class="badge" style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">' + (inverter.status || '-') + '</span>';
                        }
                        $('#view_status_badge').html(statusBadge);
                        
                        // Power specifications
                        $('#view_nominal_ac_power_kw').text(inverter.nominal_ac_power_kw ? inverter.nominal_ac_power_kw + ' kW' : '-');
                        $('#view_max_dc_input_power').text(inverter.max_dc_input_power ? inverter.max_dc_input_power + ' W' : '-');
                        $('#view_efficiency_max').text(inverter.efficiency_max ? inverter.efficiency_max + '%' : '-');
                        $('#view_efficiency_euro').text(inverter.efficiency_euro ? inverter.efficiency_euro + '%' : '-');
                        $('#view_phase_type').text(inverter.phase_type || '-');
                        
                        // MPPT specifications
                        $('#view_mppt_min_voltage').text(inverter.mppt_min_voltage || '-');
                        $('#view_mppt_max_voltage').text(inverter.mppt_max_voltage || '-');
                        $('#view_max_dc_voltage').text(inverter.max_dc_voltage ? inverter.max_dc_voltage + ' V' : '-');
                        $('#view_max_dc_current_mppt').text(inverter.max_dc_current_mppt ? inverter.max_dc_current_mppt + ' A' : '-');
                        $('#view_no_of_mppTs').text(inverter.no_of_mppTs || '-');
                        $('#view_max_strings_mppt').text(inverter.max_strings_mppt || '-');
                        
                        // AC Output & Protection
                        $('#view_ac_output_voltage').text(inverter.ac_output_voltage || '-');
                        $('#view_spd_included').text(inverter.spd_included || '-');
                        $('#view_ip_rating').text(inverter.ip_rating || '-');
                        $('#view_communication_ports').text(inverter.communication_ports || '-');
                        
                        // Hide loading and show content with animation
                        $('#viewLoadingSpinner').fadeOut(300, function() {
                            $('#viewDetailsContent').fadeIn(300);
                        });
                    }
                },
                error: function() {
                    $('#viewLoadingSpinner').hide();
                    $('#viewDetailsContent').html('<div class="alert alert-danger text-center">{{ __("Error loading inverter details") }}</div>').show();
                }
            });
        });
        
        // Edit inverter
        $('.edit-inverter').click(function() {
            const button = $(this);
            const id = button.data('id');
            
            // Show loading spinner
            $('#editLoadingSpinner').show();
            $('#editFormContent').hide();
            $('#editInverterModal').modal('show');
            
            // Simulate loading delay for better UX
            setTimeout(function() {
                // Set form values from data attributes
                $('#edit_name').val(button.data('name'));
                $('#edit_brand').val(button.data('brand'));
                $('#edit_price').val(button.data('price'));
                $('#edit_warranty').val(button.data('warranty'));
                $('#edit_status').val(button.data('status'));
                $('#edit_nominal_ac_power_kw').val(button.data('nominal_ac_power_kw'));
                $('#edit_max_dc_input_power').val(button.data('max_dc_input_power'));
                $('#edit_mppt_min_voltage').val(button.data('mppt_min_voltage'));
                $('#edit_mppt_max_voltage').val(button.data('mppt_max_voltage'));
                $('#edit_max_dc_voltage').val(button.data('max_dc_voltage'));
                $('#edit_max_dc_current_mppt').val(button.data('max_dc_current_mppt'));
                $('#edit_no_of_mppTs').val(button.data('no_of_mppTs'));
                $('#edit_max_strings_mppt').val(button.data('max_strings_mppt'));
                $('#edit_efficiency_max').val(button.data('efficiency_max'));
                $('#edit_efficiency_euro').val(button.data('efficiency_euro'));
                $('#edit_ac_output_voltage').val(button.data('ac_output_voltage'));
                $('#edit_phase_type').val(button.data('phase_type'));
                $('#edit_spd_included').val(button.data('spd_included'));
                $('#edit_ip_rating').val(button.data('ip_rating'));
                $('#edit_communication_ports').val(button.data('communication_ports'));
                
                // Set form action URL
                $('#editInverterForm').attr('action', `{{ url('admin/inverter') }}/${id}`);
                
                // Hide loading and show form with animation
                $('#editLoadingSpinner').fadeOut(300, function() {
                    $('#editFormContent').fadeIn(300);
                });
            }, 500); // 500ms delay for loading animation
        });
        
        // Delete inverter
        $('.delete-inverter').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            // Update modal content
            $('#deleteInverterName').text(name);
            $('#deleteInverterForm').attr('action', `{{ url('admin/inverter') }}/${id}`);
            
            // Show modal
            $('#deleteInverterModal').modal('show');
        });
        
        // Handle close button clicks for view modal
        $('#viewInverterModal .close, #viewInverterModal [data-dismiss="modal"]').click(function() {
            $('#viewInverterModal').modal('hide');
        });
        
        // Handle close button clicks for edit modal
        $('#editInverterModal .close, #editInverterModal [data-dismiss="modal"]').click(function() {
            $('#editInverterModal').modal('hide');
        });
        
        // Handle close button clicks for add modal
        $('#addInverterModal .close, #addInverterModal [data-dismiss="modal"]').click(function() {
            $('#addInverterModal').modal('hide');
        });
        
        // Handle close button clicks for delete modal
        $('#deleteInverterModal .close, #deleteInverterModal [data-dismiss="modal"]').click(function() {
            $('#deleteInverterModal').modal('hide');
        });
        
        // Reset modals when closed
        $('#viewInverterModal').on('hidden.bs.modal', function () {
            $('#viewLoadingSpinner').hide();
            $('#viewDetailsContent').show();
            // Clear all view fields
            $('#view_name, #view_brand, #view_price, #view_warranty, #view_nominal_ac_power_kw, #view_max_dc_input_power, #view_efficiency_max, #view_efficiency_euro, #view_phase_type, #view_mppt_voltage_range, #view_max_dc_voltage, #view_max_dc_current_mppt, #view_no_of_mppTs, #view_max_strings_mppt, #view_ac_output_voltage, #view_spd_included, #view_ip_rating, #view_communication_ports').text('-');
            $('#view_status_badge').html('');
        });
        
        $('#editInverterModal').on('hidden.bs.modal', function () {
            $('#editLoadingSpinner').hide();
            $('#editFormContent').show();
            // Reset form
            $('#editInverterForm')[0].reset();
            $('#editInverterForm').attr('action', '');
        });
        
        // Handle modal close buttons explicitly
        $('#viewInverterModal .close, #viewInverterModal [data-dismiss="modal"]').click(function() {
            $('#viewInverterModal').modal('hide');
        });
        
        $('#editInverterModal .close, #editInverterModal [data-dismiss="modal"]').click(function() {
            $('#editInverterModal').modal('hide');
        });
        
        $('#deleteInverterModal .close, #deleteInverterModal [data-dismiss="modal"]').click(function() {
            $('#deleteInverterModal').modal('hide');
        });
        
        $('#addInverterModal .close, #addInverterModal [data-dismiss="modal"]').click(function() {
            $('#addInverterModal').modal('hide');
        });
        
        // Ensure backdrop click closes modal
        $('#viewInverterModal, #editInverterModal, #deleteInverterModal, #addInverterModal').on('click', function(e) {
            if (e.target === this) {
                $(this).modal('hide');
            }
        });
    });
</script>
@endsection
