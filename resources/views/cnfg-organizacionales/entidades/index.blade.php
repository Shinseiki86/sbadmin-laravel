@extends('layouts.menu')
@section('title', '/Entidades')
@include('datatable')


@section('page_heading')
    <div class="row">
        <div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
            Entidades
        </div>
        <div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
            <a class='btn btn-primary' role='button' href="{{ route('cnfg-organizacionales.entidades.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('section')

   <div class="row">
        @if($entidades->isEmpty())
            <div class="well text-center">No se encontró ningun entidades.</div>
        @else
            @include('cnfg-organizacionales.entidades.table')
        @endif
    </div>

    @include('widgets/modal-delete')
@endsection
