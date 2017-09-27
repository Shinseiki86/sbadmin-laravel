<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  {{ Form::open(['route' => 'tipoentidades.store', 'class' => 'form-horizontal']) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar Tipoentidades</h4>
      </div>
      <div class="modal-body">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        

		<!-- Elementos del formulario -->
		@include('tipoentidades.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'tipoentidades'])

	
      </div>
      <div class="modal-footer">        
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>