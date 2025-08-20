@extends('admin.layouts.app')
@section('page_title', __('Solar Project Details'))

@push('styles')
    <style>
        .details-card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .details-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin-bottom: 1.5rem;
        }

        .metric-card {
            border-left: 4px solid #10b981;
            transition: all 0.3s ease;
        }

        .metric-card:hover {
            transform: scale(1.02);
        }

        .environmental-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: #10b981;
        }

        .download-btn {
            position: relative;
            overflow: hidden;
        }

        .download-btn:after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.3s;
        }

        .download-btn:hover:after {
            left: 100%;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12pt;
            }

            .container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Header with Project Details -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <h1 class="h3 mb-1">{{ __('Solar Energy Project Details') }}</h1>
                        <p class="text-muted">{{ __('Project ID') }}: #{{ $estimation->id }}</p>
                        <p class="text-muted">{{ __('Created on') }}: {{ $estimation->created_at->format('F j, Y') }}</p>
                    </div>
                    <div class="d-flex no-print">
                        <a href="{{ route('admin.estimation.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Projects') }}
                        </a>
                        <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editEstimationModal">
                            <i class="fas fa-edit"></i> {{ __('Edit Estimation') }}
                        </button>
                        <button onclick="window.print()" class="btn btn-info me-2">
                            <i class="fas fa-print"></i> {{ __('Print') }}
                        </button>
                        <button id="downloadPdf" class="btn btn-success download-btn">
                            <i class="fas fa-file-pdf"></i> {{ __('Download PDF') }}
                        </button>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('Please fix the following errors:') }}
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Summary Information Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Customer Information') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Customer Name') }}:</span>
                                    {{ $customerName }}
                                </div>
                                @if($customerEmail)
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Email') }}:</span>
                                    {{ $customerEmail }}
                                </div>
                                @endif
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Project ID') }}:</span>
                                    #{{ $estimation->id }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Created') }}:</span>
                                    {{ $estimation->created_at->format('M j, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('System Overview') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('System Size') }}:</span>
                                    {{ number_format($estimation->system_capacity, 2) }} kW
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Panel Count') }}:</span>
                                    {{ $estimation->panel_count }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Tilt') }}:</span>
                                    {{ $estimation->tilt }}°
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Azimuth') }}:</span>
                                    {{ $estimation->azimuth }}°
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Losses') }}:</span>
                                    {{ $estimation->total_losses_percent }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Energy Production') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Annual Energy') }}:</span>
                                    {{ number_format($estimation->energy_annual, 0) }} kWh/year
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Capacity Factor') }}:</span>
                                    {{ number_format($estimation->capacity_factor, 1) }}%
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Annual Usage') }}:</span>
                                    {{ number_format($estimation->annual_usage_kwh, 0) }} kWh
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Solar Coverage') }}:</span>
                                    {{ number_format(($estimation->energy_annual / $estimation->annual_usage_kwh) * 100, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Location Details') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Address') }}:</span>
                                    {{ $estimation->street }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('City') }}:</span>
                                    {{ $estimation->city }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('State') }}:</span>
                                    {{ $estimation->state }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Zip Code') }}:</span>
                                    {{ $estimation->zip_code }}
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ __('Coordinates') }}:</span>
                                    {{ $estimation->latitude }}, {{ $estimation->longitude }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Production Chart -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="card-title h4 mb-0">{{ __('Monthly Energy Production') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyProductionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Financial Analysis -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <!-- Cost Breakdown -->
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Cost Breakdown') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Electricity Rate') }}:</span>
                                    ${{ number_format($electricityRate, 2) }}/kWh
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('System Cost') }}:</span>
                                    ${{ number_format($systemCost, 2) }}
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Installation Cost') }}:</span>
                                    ${{ number_format($installationCost, 2) }}
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Permits & Fees') }}:</span>
                                    ${{ number_format($permitsFees, 2) }}
                                </div>
                                <div class="mt-4 pt-3 border-top">
                                    <span class="fw-bold fs-5">{{ __('Total Investment') }}:</span>
                                    <span class="fs-5 text-success">${{ number_format($totalInvestment, 2) }}</span>
                                </div>
                                <div class="chart-container mt-4">
                                    <canvas id="costBreakdownChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- ROI Analysis -->
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('ROI Analysis') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Annual Savings') }}:</span>
                                    ${{ number_format($annualSavings, 2) }}/year
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Payback Period') }}:</span>
                                    {{ number_format($paybackPeriod, 1) }} years
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('Lifetime Savings') }}:</span>
                                    ${{ number_format($lifetimeSavings, 2) }}
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ __('ROI') }}:</span>
                                    {{ number_format((($lifetimeSavings - $totalInvestment) / $totalInvestment) * 100, 1) }}%
                                </div>
                                <div class="chart-container mt-4">
                                    <canvas id="roiChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="card-title h4 mb-0">{{ __('Environmental Impact') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card metric-card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-cloud-sun environmental-icon"></i>
                                        <h3 class="h5 mb-2">{{ __('CO2 Reduction') }}</h3>
                                        <div class="h4 text-success">
                                            {{ number_format($estimation->energy_annual * 0.5, 1) }} kg</div>
                                        <p class="text-muted small">{{ __('per year') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card metric-card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tree environmental-icon"></i>
                                        <h3 class="h5 mb-2">{{ __('Equivalent Trees') }}</h3>
                                        <div class="h4 text-success">{{ number_format($treesEquivalent, 1) }}</div>
                                        <p class="text-muted small">{{ __('planted per year') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card metric-card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-gas-pump environmental-icon"></i>
                                        <h3 class="h5 mb-2">{{ __('Gas Savings') }}</h3>
                                        <div class="h4 text-success">{{ number_format($gasSavings, 1) }} gal</div>
                                        <p class="text-muted small">{{ __('equivalent per year') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card metric-card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tint environmental-icon"></i>
                                        <h3 class="h5 mb-2">{{ __('Water Saved') }}</h3>
                                        <div class="h4 text-success">{{ number_format($waterSaved, 1) }} gal</div>
                                        <p class="text-muted small">{{ __('per year') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Details and Technical Specifications -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('System Configuration') }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="fw-bold w-50">{{ __('System Size (DC)') }}</td>
                                        <td>{{ number_format($estimation->system_capacity, 2) }} kW</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Panel Count') }}</td>
                                        <td>{{ $estimation->panel_count }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Roof Type') }}</td>
                                        <td>{{ $roofType }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tilt') }}</td>
                                        <td>{{ $estimation->tilt }}°</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Azimuth') }}</td>
                                        <td>{{ $estimation->azimuth }}°</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Losses') }}</td>
                                        <td>{{ $estimation->total_losses_percent }}%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Performance Metrics') }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="fw-bold w-50">{{ __('Annual Energy Production') }}</td>
                                        <td>{{ number_format($estimation->energy_annual) }} kWh</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Capacity Factor') }}</td>
                                        <td>{{ number_format($estimation->capacity_factor, 1) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Annual Solar Radiation') }}</td>
                                        <td>{{ number_format($estimation->solrad_annual, 1) }} kWh/m²</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Optimum Tilt') }}</td>
                                        <td>{{ number_format($estimation->optimum_tilt, 1) }}°</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Optimum Azimuth') }}</td>
                                        <td>{{ number_format($estimation->optimum_azimuth, 1) }}°</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Annual Degradation Rate') }}</td>
                                        <td>{{ number_format($panelDegradationRate * 100, 1) }}%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison and Lifetime Performance -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Monthly Energy Comparison') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="energyComparisonChart"></canvas>
                                </div>
                                <p class="text-muted small mt-3">
                                    {{ __('This chart compares your monthly energy production with your estimated consumption.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card details-card h-100">
                            <div class="card-header bg-light">
                                <h3 class="card-title h5 mb-0">{{ __('Lifetime Performance') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="lifetimePerformanceChart"></canvas>
                                </div>
                                <p class="text-muted small mt-3">
                                    {{ __('Projected system performance over 25 years with annual degradation rate of') }}
                                    {{ number_format($panelDegradationRate * 100, 1) }}%.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes and Disclaimers -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="alert-heading">{{ __('Notes') }}</h5>
                            <p>{{ __('These estimations are based on historical weather data and system specifications. Actual production may vary depending on weather conditions, shading, and system maintenance.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart color configuration
            const chartColors = {
                primary: '#10b981',
                secondary: '#3b82f6',
                tertiary: '#f59e0b',
                quaternary: '#ef4444',
                gray: '#9ca3af',
                light: '#e5e7eb',
                dark: '#4b5563',
                gradientFrom: 'rgba(16, 185, 129, 0.8)',
                gradientTo: 'rgba(16, 185, 129, 0.1)'
            };

            // Monthly data from PHP (provided via controller)
            const monthlyData = @json($monthlyData);
            const months = monthlyData.map(data => data.month);
            const acValues = monthlyData.map(data => parseFloat(data.ac_output));
            const dcValues = monthlyData.map(data => parseFloat(data.dc_output));

            // Create monthly production chart
            const monthlyCtx = document.getElementById('monthlyProductionChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'AC Output (kWh)',
                        data: acValues,
                        backgroundColor: chartColors.primary,
                        borderColor: chartColors.primary,
                        borderWidth: 1
                    }, {
                        label: 'DC Output (kWh)',
                        data: dcValues,
                        backgroundColor: chartColors.secondary,
                        borderColor: chartColors.secondary,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Energy (kWh)'
                            }
                        }
                    }
                }
            });

            // Cost Breakdown Chart
            const costBreakdownCtx = document.getElementById('costBreakdownChart').getContext('2d');
            new Chart(costBreakdownCtx, {
                type: 'pie',
                data: {
                    labels: [
                        'System Equipment',
                        'Installation',
                        'Permits & Fees'
                    ],
                    datasets: [{
                        data: [
                            {{ $systemCost }},
                            {{ $installationCost }},
                            {{ $permitsFees }}
                        ],
                        backgroundColor: [
                            chartColors.primary,
                            chartColors.secondary,
                            chartColors.tertiary
                        ],
                        borderColor: chartColors.light,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((acc, val) => acc + val,
                                        0);
                                    const percentage = (value * 100 / total).toFixed(1);
                                    return `$${value.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // ROI Chart - Cumulative savings over 25 years
            const years = Array.from({
                length: 26
            }, (_, i) => i);
            const cumulativeSavings = years.map(year => {
                if (year === 0) return -{{ $totalInvestment }};
                return -{{ $totalInvestment }} + (year * {{ $annualSavings }});
            });

            const roiCtx = document.getElementById('roiChart').getContext('2d');
            new Chart(roiCtx, {
                type: 'line',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Cumulative Savings ($)',
                        data: cumulativeSavings,
                        fill: {
                            target: 'origin',
                            above: chartColors.gradientFrom,
                            below: chartColors.gradientTo
                        },
                        backgroundColor: chartColors.gradientFrom,
                        borderColor: chartColors.primary,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: chartColors.primary
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `$${context.raw.toLocaleString()}`;
                                },
                                title: function(context) {
                                    return `Year ${context[0].label}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: 'Cumulative Savings ($)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Years'
                            }
                        }
                    }
                }
            });

            // Energy Comparison Chart (Solar vs. Consumption)
            const solarProduction = monthlyData.map(data => parseFloat(data.ac_output));
            const estimatedUsage = @json($monthlyConsumption ?? []);
            const netEnergy = solarProduction.map((value, index) => value - estimatedUsage[index]);

            const energyComparisonCtx = document.getElementById('energyComparisonChart').getContext('2d');
            new Chart(energyComparisonCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Solar Production (kWh)',
                        data: solarProduction,
                        backgroundColor: chartColors.primary,
                        stack: 'Stack 0'
                    }, {
                        label: 'Energy Consumption (kWh)',
                        data: estimatedUsage,
                        backgroundColor: chartColors.secondary,
                        stack: 'Stack 1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Energy (kWh)'
                            }
                        }
                    }
                }
            });

            // Lifetime Performance Chart
            const lifetimeYears = Array.from({
                length: 26
            }, (_, i) => i);
            const annualProduction = {{ $estimation->energy_annual }};
            const degradationRate = {{ $panelDegradationRate }}; // 0.5% per year

            const lifetimeProduction = lifetimeYears.map(year => {
                if (year === 0) return 0;
                return annualProduction * (1 - (degradationRate * (year - 1)));
            });

            const lifetimeEfficiency = lifetimeYears.map(year => {
                if (year === 0) return 100;
                return 100 * (1 - (degradationRate * year));
            });

            const lifetimeCtx = document.getElementById('lifetimePerformanceChart').getContext('2d');
            new Chart(lifetimeCtx, {
                type: 'line',
                data: {
                    labels: lifetimeYears,
                    datasets: [{
                        label: 'Annual Energy Production (kWh)',
                        data: lifetimeProduction,
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: chartColors.primary,
                        borderWidth: 2,
                        yAxisID: 'y'
                    }, {
                        label: 'Panel Efficiency (%)',
                        data: lifetimeEfficiency,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: chartColors.secondary,
                        borderWidth: 2,
                        borderDash: [5, 5],
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Energy (kWh)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Efficiency (%)'
                            },
                            min: 80,
                            max: 100,
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Years'
                            }
                        }
                    }
                }
            });

            // PDF Download functionality
            document.getElementById('downloadPdf').addEventListener('click', function() {
                const element = document.querySelector('.card-body');
                const opt = {
                    margin: 10,
                    filename: 'solar_project_details_{{ $estimation->id }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                // Hide elements we don't want in the PDF
                const noPrintElements = document.querySelectorAll('.no-print');
                noPrintElements.forEach(el => el.style.display = 'none');

                // Generate PDF
                html2pdf().from(element).set(opt).save().then(() => {
                    noPrintElements.forEach(el => el.style.display = '');
                });
            });
        });
    </script>
@endpush

<!-- Edit Estimation Modal -->
<div class="modal fade" id="editEstimationModal" tabindex="-1" aria-labelledby="editEstimationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.estimation.update', $estimation->id) }}">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editEstimationModalLabel">{{ __('Edit Estimation') }} #{{ $estimation->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <!-- System Configuration -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('System Configuration') }}</h6>
                            
                            <div class="mb-3">
                                <label for="system_capacity" class="form-label">{{ __('System Capacity (kW)') }}</label>
                                <input type="number" step="0.01" class="form-control" id="system_capacity" name="system_capacity" 
                                       value="{{ old('system_capacity', $estimation->system_capacity) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tilt" class="form-label">{{ __('Tilt (degrees)') }}</label>
                                <input type="number" step="0.1" min="0" max="90" class="form-control" id="tilt" name="tilt" 
                                       value="{{ old('tilt', $estimation->tilt) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="azimuth" class="form-label">{{ __('Azimuth (degrees)') }}</label>
                                <input type="number" step="0.1" min="0" max="360" class="form-control" id="azimuth" name="azimuth" 
                                       value="{{ old('azimuth', $estimation->azimuth) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="losses" class="form-label">{{ __('System Losses (%)') }}</label>
                                <input type="number" step="0.1" min="0" max="50" class="form-control" id="losses" name="losses" 
                                       value="{{ old('losses', $estimation->total_losses_percent) }}" required>
                            </div>
                        </div>
                        
                        <!-- Energy & Coverage -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('Energy & Coverage') }}</h6>
                            
                            <div class="mb-3">
                                <label for="annual_usage_kwh" class="form-label">{{ __('Annual Usage (kWh)') }}</label>
                                <input type="number" step="1" min="1" class="form-control" id="annual_usage_kwh" name="annual_usage_kwh" 
                                       value="{{ old('annual_usage_kwh', $estimation->annual_usage_kwh) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="coverage_percentage" class="form-label">{{ __('Coverage Percentage (%)') }}</label>
                                <input type="number" step="1" min="1" max="100" class="form-control" id="coverage_percentage" name="coverage_percentage" 
                                       value="{{ old('coverage_percentage', $estimation->coverage_percentage) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="utility_company" class="form-label">{{ __('Utility Company') }}</label>
                                <input type="text" class="form-control" id="utility_company" name="utility_company" 
                                       value="{{ old('utility_company', $estimation->utility_company) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft" {{ old('status', $estimation->status) == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                    <option value="pending" {{ old('status', $estimation->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="completed" {{ old('status', $estimation->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="failed" {{ old('status', $estimation->status) == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location Information -->
                    <hr>
                    <h6 class="text-primary mb-3">{{ __('Location Information') }}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="street" class="form-label">{{ __('Street Address') }}</label>
                                <input type="text" class="form-control" id="street" name="street" 
                                       value="{{ old('street', $estimation->street) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="city" class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control" id="city" name="city" 
                                       value="{{ old('city', $estimation->city) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="state" class="form-label">{{ __('State') }}</label>
                                <input type="text" class="form-control" id="state" name="state" 
                                       value="{{ old('state', $estimation->state) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="zip_code" class="form-label">{{ __('Zip Code') }}</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" 
                                       value="{{ old('zip_code', $estimation->zip_code) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="country" class="form-label">{{ __('Country') }}</label>
                                <input type="text" class="form-control" id="country" name="country" 
                                       value="{{ old('country', $estimation->country) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        {{ __('Note: Changing system capacity, tilt, or azimuth will trigger a recalculation of solar production data using the PVWatts API.') }}
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
