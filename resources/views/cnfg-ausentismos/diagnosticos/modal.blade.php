<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  {{ Form::open(['route' => 'cnfg-ausentismos.diagnosticos.store', 'class' => 'form-horizontal']) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar Diagnosticos</h4>
      </div>
      <div class="modal-body">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.diagnosticos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos.diagnosticos'])

	
      </div>
      <div class="modal-footer">        
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>