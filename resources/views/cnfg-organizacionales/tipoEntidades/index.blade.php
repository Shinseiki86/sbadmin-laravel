@extends('layouts.menu')
@section('title', '/ Tipo Entidades')
@include('datatable')


@section('page_heading')
    <div class="row">
        <div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
            Tipo Entidades
        </div>
        <div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
            <a class='btn btn-primary' role='button' href="{{ route('cnfg-organizacionales.tipoentidades.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('section')

   <div class="row">
        @if($tipoentidades->isEmpty())
            <div class="well text-center">No se encontró ningun Tipoentidades.</div>
        @else
            @include('cnfg-organizacionales.tipoentidades.table')
        @endif
    </div>

    @include('widgets/modal-delete')
@endsection
