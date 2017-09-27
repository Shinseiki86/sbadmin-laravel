@extends('layouts.menu')
@section('title', '/ Ciudades')
@include('datatable')


@section('page_heading')
    <div class="row">
        <div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
            ProrrogaAusentismos
        </div>
        <div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
            <a class='btn btn-primary' role='button' href="{{ route('cnfg-ausentismos.prorrogaausentismos.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('section')

   <div class="row">
        @if($prorrogaAusentismos->isEmpty())
            <div class="well text-center">No se encontró ningun ProrrogaAusentismos.</div>
        @else
            @include('cnfg-ausentismos.prorrogaausentismos.table')
        @endif
    </div>

    @include('widgets/modal-delete')
@endsection
