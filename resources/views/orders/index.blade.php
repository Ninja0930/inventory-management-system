@extends('layouts.tabler')

@pushonce('page-styles')
    {{--- ---}}
@endpushonce

@section('content')
<div class="page-body">
    @if($orders->isEmpty())
    <div class="container-xl d-flex flex-column justify-content-center">
        <div class="empty">
            <div class="empty-img">
                <img src="{{ asset('static/illustrations/undraw_bug_fixing_oc7a.svg') }}" height="128" alt="">
            </div>
            <p class="empty-title">No results found</p>
            <p class="empty-subtitle text-secondary">
                Try adjusting your search or filter to find what you're looking for.
            </p>
            <div class="empty-action">
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Add your first Order
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        {{ __('Orders') }}
                    </h3>
                </div>

                <div class="card-actions">
                    <a href="{{ route('orders.create') }}" class="btn btn-icon btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                {{ __('No.') }}
                            </th>
                            <th scope="col">
                                {{ __('Invoice') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Customer') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Date') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Payment') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Total') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="text-center">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $order->invoice_no }}
                            </td>
                            <td class="text-center">
                                {{ $order->customer->name }}
                            </td>
                            <td class="text-center">
                                {{ $order->order_date }}
                            </td>
                            <td class="text-center">
                                {{ $order->payment_type }}
                            </td>
                            <td class="text-center">
                                {{ number_format($order->total, 2) }}
                            </td>
                            <td class="text-center">
                                <span class="btn btn-success btn-sm text-uppercase">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-icon btn-outline-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </a>
                                <a href="{{ route('order.downloadInvoice', $order) }}" class="btn btn-icon btn-outline-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@pushonce('page-scripts')
    {{--    --}}
@endpushonce
