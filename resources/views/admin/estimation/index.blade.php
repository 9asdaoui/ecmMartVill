@extends('admin.layouts.app')
@section('page_title', __('Solar Estimations'))
@section('css')
<style>
    .badge-system-size {
        background-color: #17a2b8;
        color: white;
    }
    .badge-energy {
        background-color: #28a745;
        color: white;
    }
</style>
@endsection

@section('content')
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Solar Estimations') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="projects-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Location') }}</th>
                                        <th>{{ __('System Details') }}</th>
                                        <th>{{ __('Created Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>
                                                <strong>{{ $project->customer_name }}</strong><br>
                                                @if($project->email)
                                                    <small>{{ $project->email }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($project->city)
                                                    {{ $project->city }}@if($project->state), {{ $project->state }}@endif<br>
                                                @endif
                                                <small>
                                                    {{ $project->latitude }}, {{ $project->longitude }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge badge-system-size">{{ number_format($project->system_capacity, 2) }} kW</span>
                                                <span class="badge badge-energy">{{ number_format($project->energy_annual, 0) }} kWh/yr</span><br>
                                                <small>Tilt: {{ $project->tilt }}° | Azimuth: {{ $project->azimuth }}°</small>
                                            </td>
                                            <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'draft' => 'badge-secondary',
                                                        'pending' => 'badge-warning',
                                                        'completed' => 'badge-success',
                                                        'failed' => 'badge-danger'
                                                    ][$project->status] ?? 'badge-light';
                                                @endphp
                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.estimation.show', $project->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> {{ __('Details') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No estimations found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if(method_exists($projects, 'links'))
                            <div class="mt-4">
                                {{ $projects->links() }}
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@section('js')
<script>
    $(function() {
        $('#projects-table').DataTable({
            "paging": {{ method_exists($projects, 'links') ? 'false' : 'true' }},
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection
