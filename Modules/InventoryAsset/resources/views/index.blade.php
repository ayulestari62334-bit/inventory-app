@extends('layouts.app')

@section('title', 'Dashboard Asset Inventory')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6 text-right">
            <small class="text-muted">
                Module: {{ config('assetinventory.name') }}
            </small>
        </div>
    </div>

    {{-- INFO BOX --}}
    <div class="row">

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary">
                    <i class="fas fa-box"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Kategori Barang</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="fas fa-warehouse"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Asset</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning">
                    <i class="fas fa-tools"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Asset Aktif</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

    </div>

    {{-- CARD INFORMASI --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Informasi Modul
            </h3>
        </div>
        <div class="card-body">
            <p>
                Modul <strong>{{ config('assetinventory.name') }}</strong> digunakan
                untuk mengelola data kategori barang, asset, dan inventaris
                secara terpusat menggunakan Laravel Modular.
            </p>
        </div>
    </div>

</div>

@endsection
