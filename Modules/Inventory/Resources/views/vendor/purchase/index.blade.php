@extends('vendor.layouts.app')
@section('page_title', __('Purchases'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Inventory/Resources/assets/css/datatable.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="purchase-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5> {{ __('Purchase') }} </h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Inventory\Http\Controllers\Vendor\PurchaseController@create', $prms))
                    <x-backend.button.add-new href="{{ route('vendor.purchase.create') }}" />
                    @endif
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-2">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2 filter" name="location">
                        <option value="">{{ __('All Location') }}</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="select2 filter" name="supplier">
                        <option value="">{{ __('All Supplier') }}</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="inventory-module-table inventory-module-table-export-button need-batch-operation" data-namespace="\Modules\Inventory\Entities\Purchase" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')

@endsection
