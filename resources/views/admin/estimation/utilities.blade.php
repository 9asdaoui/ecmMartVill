@section('page_title', __('Utilities Management'))
@extends('admin.layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Utilities Management') }}</h1>
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
                                <h3 class="card-title">{{ __('All Utilities') }}</h3>
                                <button type="button" class="btn btn-primary" onclick="$('#addUtilityModal').modal('show')">
                                    <i class="fas fa-plus"></i> {{ __('Add New Utility') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form action="{{ route('solar-utility.index') }}" method="GET" class="row">
                                    <div class="col-md-3 mb-2">
                                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search utilities...') }}" 
                                            value="{{ request()->get('search') }}">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="state" class="form-control" placeholder="{{ __('State') }}" 
                                            value="{{ request()->get('state') }}">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="country" class="form-control" placeholder="{{ __('Country') }}" 
                                            value="{{ request()->get('country') }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> {{ __('Filter') }}
                                        </button>
                                        <a href="{{ route('solar-utility.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-redo"></i> {{ __('Reset') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Rate Ranges') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Updated') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($utilities as $utility)
                                            <tr>
                                                <td>{{ $utility->id }}</td>
                                                <td><strong>{{ $utility->name }}</strong></td>
                                                <td>
                                                    @if($utility->rateRanges && $utility->rateRanges->count() > 0)
                                                        <small class="text-muted">
                                                            {{ $utility->rateRanges->count() }} {{ __('brackets') }}
                                                            (${{ $utility->rateRanges->min('rate') }} - ${{ $utility->rateRanges->max('rate') }})
                                                        </small>
                                                    @else
                                                        <span class="text-warning">{{ __('No rates defined') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($utility->city || $utility->state || $utility->country)
                                                        {{ implode(', ', array_filter([$utility->city, $utility->state, $utility->country])) }}
                                                    @else
                                                        <span class="text-muted">{{ __('Not specified') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $utility->updated_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info view-utility" 
                                                            data-id="{{ $utility->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary edit-utility" 
                                                            data-id="{{ $utility->id }}"
                                                            data-name="{{ $utility->name }}"
                                                            data-state="{{ $utility->state }}"
                                                            data-city="{{ $utility->city }}"
                                                            data-country="{{ $utility->country }}"
                                                            data-image_url="{{ $utility->image_url }}"
                                                            data-rate-ranges="@json($utility->rateRanges ? $utility->rateRanges->toArray() : [])">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-utility" 
                                                            data-id="{{ $utility->id }}"
                                                            data-name="{{ $utility->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-muted">{{ __('No utilities found.') }}</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($utilities->hasPages())
                            <div class="card-footer clearfix">
                                {{ $utilities->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Utility Modal -->
    <div class="modal fade" id="addUtilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: none;">
                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e5e7eb; border-radius: 16px 16px 0 0; padding: 24px 32px;">
                    <h5 class="modal-title" style="font-weight: 600; color: #1e293b;">{{ __('Add New Utility') }}</h5>
                    <button type="button" class="close" onclick="$('#addUtilityModal').modal('hide')" aria-label="Close" style="font-size: 1.5rem; color: #64748b; background: none; border: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('solar-utility.store') }}" method="POST" style="padding: 24px 32px;">
                    <div class="modal-body" style="padding: 0;">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" style="font-weight: 500; color: #334155;">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required style="border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                            <div class="col-md-6">
                                <label for="image_url" style="font-weight: 500; color: #334155;">{{ __('Image URL') }}</label>
                                <input type="text" class="form-control" id="image_url" name="image_url" placeholder="https://..." style="border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="city" style="font-weight: 500; color: #334155;">{{ __('City') }}</label>
                                <input type="text" class="form-control" id="city" name="city" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                            <div class="col-md-4">
                                <label for="state" style="font-weight: 500; color: #334155;">{{ __('State') }}</label>
                                <input type="text" class="form-control" id="state" name="state" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                            <div class="col-md-4">
                                <label for="country" style="font-weight: 500; color: #334155;">{{ __('Country') }}</label>
                                <input type="text" class="form-control" id="country" name="country" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 18px;">
                            <label style="font-weight: 500; color: #334155;">{{ __('Utility Rate Ranges (kWh Price Brackets)') }}</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" style="background: #f1f5f9; border-radius: 8px;">
                                    <thead>
                                        <tr style="background: #e2e8f0; color: #334155;">
                                            <th>{{ __('Bracket') }}</th>
                                            <th>{{ __('kWh Range') }}</th>
                                            <th>{{ __('Rate per kWh ($)') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>0 - 100 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[0][rate]" placeholder="0.10" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>101 - 200 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[1][rate]" placeholder="0.12" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>201 - 300 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[2][rate]" placeholder="0.14" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>301 - 400 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[3][rate]" placeholder="0.16" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>401 - 500 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[4][rate]" placeholder="0.18" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>501+ kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" name="rate_ranges[5][rate]" placeholder="0.20" style="border-radius: 8px; border: 1px solid #e5e7eb;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">{{ __('Define progressive pricing tiers for electricity consumption') }}</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e5e7eb; border-radius: 0 0 16px 16px; padding: 16px 32px;">
                        <button type="button" class="btn btn-secondary" style="border-radius: 8px; padding: 8px 24px; font-weight: 500;" onclick="$('#addUtilityModal').modal('hide')">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 8px 24px; font-weight: 500;">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Utility Modal -->
    <div class="modal fade" id="editUtilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit Utility') }}</h5>
                    <button type="button" class="close" onclick="$('#editUtilityModal').modal('hide')"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUtilityForm" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_name">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_image_url">{{ __('Image URL') }}</label>
                                <input type="text" class="form-control" id="edit_image_url" name="image_url" placeholder="https://...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="edit_city">{{ __('City') }}</label>
                                <input type="text" class="form-control" id="edit_city" name="city">
                            </div>
                            <div class="col-md-4">
                                <label for="edit_state">{{ __('State') }}</label>
                                <input type="text" class="form-control" id="edit_state" name="state">
                            </div>
                            <div class="col-md-4">
                                <label for="edit_country">{{ __('Country') }}</label>
                                <input type="text" class="form-control" id="edit_country" name="country">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Utility Rate Ranges (kWh Price Brackets)') }}</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr style="background: #e2e8f0; color: #334155;">
                                            <th>{{ __('Bracket') }}</th>
                                            <th>{{ __('kWh Range') }}</th>
                                            <th>{{ __('Rate per kWh ($)') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>0 - 100 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_0" name="rate_ranges[0][rate]" placeholder="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>101 - 200 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_1" name="rate_ranges[1][rate]" placeholder="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>201 - 300 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_2" name="rate_ranges[2][rate]" placeholder="0.14"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>301 - 400 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_3" name="rate_ranges[3][rate]" placeholder="0.16"></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>401 - 500 kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_4" name="rate_ranges[4][rate]" placeholder="0.18"></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>501+ kWh</td>
                                            <td><input type="number" step="0.0001" class="form-control" id="edit_rate_5" name="rate_ranges[5][rate]" placeholder="0.20"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="$('#editUtilityModal').modal('hide')">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Utility Modal -->
    <div class="modal fade" id="viewUtilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUtilityName">{{ __('Utility Details') }}</h5>
                    <button type="button" class="close" onclick="$('#viewUtilityModal').modal('hide')"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>{{ __('Name') }}:</strong> <span id="view_name">-</span></p>
                            <p><strong>{{ __('Location') }}:</strong> <span id="view_location">-</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('Image URL') }}:</strong> <span id="view_image_url">-</span></p>
                            <p><strong>{{ __('Last Updated') }}:</strong> <span id="view_updated">-</span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h6>{{ __('Utility Rate Ranges (kWh Price Brackets)') }}:</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered" id="view_rate_ranges_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Bracket') }}</th>
                                        <th>{{ __('Min kWh') }}</th>
                                        <th>{{ __('Max kWh') }}</th>
                                        <th>{{ __('Rate ($)') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="view_rate_ranges">
                                    <!-- Rate ranges will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="$('#viewUtilityModal').modal('hide')">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUtilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                    <button type="button" class="close" onclick="$('#deleteUtilityModal').modal('hide')"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete the utility:') }}</p>
                    <p><strong id="deleteUtilityName"></strong></p>
                    <p class="text-warning">{{ __('This will also delete all associated rate ranges.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="$('#deleteUtilityModal').modal('hide')">{{ __('Cancel') }}</button>
                    <form id="deleteUtilityForm" method="POST" class="d-inline">
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
            // View utility details
            $('.view-utility').click(function() {
                const id = $(this).data('id');
                
                // Show loading indicator
                $('#viewUtilityName').text('Loading...');
                $('#view_name').text('-');
                $('#view_location').text('-');
                $('#view_image_url').text('-');
                $('#view_updated').text('-');
                $('#view_rate_ranges').empty();
                
                // Fetch utility details via AJAX
                $.ajax({
                    url: `{{ url('admin/solar-utility') }}/${id}`,
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        const utility = response.utility;
                        
                        // Update modal with utility details
                        $('#viewUtilityName').text(utility.name);
                        $('#view_name').text(utility.name);
                        
                        // Format location
                        const location = [utility.city, utility.state, utility.country].filter(Boolean).join(', ');
                        $('#view_location').text(location || 'Not specified');
                        
                        // Format image URL
                        $('#view_image_url').text(utility.image_url || 'Not specified');
                        
                        // Format updated date
                        $('#view_updated').text(utility.updated_at || 'Unknown');
                        
                        // Populate rate ranges
                        if (utility.rate_ranges && utility.rate_ranges.length > 0) {
                            let rateRangesHtml = '';
                            utility.rate_ranges.forEach((range, index) => {
                                rateRangesHtml += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${range.min || 0}</td>
                                        <td>${range.max || 'Unlimited'}</td>
                                        <td>$${parseFloat(range.rate).toFixed(4)}</td>
                                    </tr>
                                `;
                            });
                            $('#view_rate_ranges').html(rateRangesHtml);
                        } else {
                            $('#view_rate_ranges').html('<tr><td colspan="4" class="text-center">No rate ranges defined</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        $('#viewUtilityName').text('Error loading utility details');
                        $('#view_rate_ranges').html('<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>');
                    }
                });
                
                $('#viewUtilityModal').modal('show');
            });
            
            // Edit utility button click
            $('.edit-utility').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const city = $(this).data('city');
                const state = $(this).data('state');
                const country = $(this).data('country');
                const imageUrl = $(this).data('image_url');
                
                // Get rate ranges data
                let rateRanges = [];
                try {
                    const rateRangesData = $(this).data('rate-ranges');
                    console.log("Raw rate ranges data:", rateRangesData);
                    console.log("Type of raw data:", typeof rateRangesData);
                    
                    if (Array.isArray(rateRangesData)) {
                        rateRanges = rateRangesData;
                    } else if (typeof rateRangesData === 'string') {
                        rateRanges = JSON.parse(rateRangesData || '[]');
                    } else {
                        console.warn("Unexpected data type for rate ranges:", typeof rateRangesData);
                        rateRanges = [];
                    }
                    
                    console.log("Parsed rate ranges:", rateRanges);
                    console.log("Number of rate ranges:", rateRanges.length);
                } catch (e) {
                    console.error("Error parsing rate ranges:", e);
                    console.error("Raw data:", $(this).data('rate-ranges'));
                    rateRanges = [];
                }
                
                // Fill the edit form
                $('#edit_name').val(name);
                $('#edit_city').val(city);
                $('#edit_state').val(state);
                $('#edit_country').val(country);
                $('#edit_image_url').val(imageUrl);
                
                // Clear all rate inputs first
                for (let i = 0; i < 6; i++) {
                    $(`#edit_rate_${i}`).val('');
                }
                
                // Enhanced mapping: Map existing rate ranges to the 6-bracket form system
                console.log("Starting rate range mapping for", rateRanges.length, "ranges");
                
                // Define the form's fixed brackets
                const formBrackets = [
                    { min: 0, max: 100, index: 0 },      // Bracket 1: 0-100 kWh
                    { min: 101, max: 200, index: 1 },    // Bracket 2: 101-200 kWh  
                    { min: 201, max: 300, index: 2 },    // Bracket 3: 201-300 kWh
                    { min: 301, max: 400, index: 3 },    // Bracket 4: 301-400 kWh
                    { min: 401, max: 500, index: 4 },    // Bracket 5: 401-500 kWh
                    { min: 501, max: null, index: 5 }    // Bracket 6: 501+ kWh
                ];
                
                // For each existing rate range, find the best matching form bracket
                rateRanges.forEach((range, rangeIndex) => {
                    const rangeMin = parseFloat(range.min);
                    const rangeMax = range.max ? parseFloat(range.max) : null;
                    const rate = parseFloat(range.rate);
                    
                    console.log(`Processing range ${rangeIndex}:`, {
                        min: rangeMin, 
                        max: rangeMax, 
                        rate: rate
                    });
                    
                    // Find the best matching bracket
                    let bestMatch = null;
                    let bestScore = -1;
                    
                    formBrackets.forEach(bracket => {
                        let score = 0;
                        
                        // Calculate overlap score
                        const bracketMax = bracket.max || 999999;
                        const overlapMin = Math.max(rangeMin, bracket.min);
                        const overlapMax = Math.min(rangeMax || 999999, bracketMax);
                        
                        if (overlapMin <= overlapMax) {
                            // There is overlap, calculate score based on overlap size
                            score = overlapMax - overlapMin;
                            
                            if (score > bestScore) {
                                bestScore = score;
                                bestMatch = bracket;
                            }
                        }
                    });
                    
                    // If we found a good match and that bracket isn't already filled
                    if (bestMatch && !$(`#edit_rate_${bestMatch.index}`).val()) {
                        console.log(`Mapping range ${rangeIndex} to bracket ${bestMatch.index}:`, rate.toFixed(4));
                        $(`#edit_rate_${bestMatch.index}`).val(rate.toFixed(4));
                    }
                });
                
                // Fallback: if no smart mapping worked, just fill sequentially
                let filledCount = 0;
                for (let i = 0; i < 6; i++) {
                    if ($(`#edit_rate_${i}`).val()) filledCount++;
                }
                
                if (filledCount === 0 && rateRanges.length > 0) {
                    console.log("Smart mapping failed, using sequential mapping");
                    rateRanges.forEach((range, index) => {
                        if (index < 6 && range.rate) {
                            $(`#edit_rate_${index}`).val(parseFloat(range.rate).toFixed(4));
                        }
                    });
                }
                
                console.log("Rate range mapping completed. Filled", filledCount, "brackets");
                
                // Set the form action URL
                $('#editUtilityForm').attr('action', `{{ url('admin/solar-utility') }}/${id}`);
                
                // Show the modal
                $('#editUtilityModal').modal('show');
            });

            // Delete utility button click
            $('.delete-utility').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                
                $('#deleteUtilityName').text(name);
                $('#deleteUtilityForm').attr('action', `{{ url('admin/solar-utility') }}/${id}`);
                $('#deleteUtilityModal').modal('show');
            });
        });
    </script>
@endsection
