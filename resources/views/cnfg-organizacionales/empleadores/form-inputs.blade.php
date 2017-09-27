{{--@include('datepicker')--}}
@include('chosen')
<div class='col-md-8 col-md-offset-2'>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'EMPL_NIT', 'label'=>'NIT', 'options'=>['size' => '999999999999999' ] ])
		@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'EMPL_RAZONSOCIAL', 'label'=>'Razón Social', 'options'=>['maxlength' => '100'] ])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'EMPL_DIRECCION', 'label'=>'Dirección', 'options'=>['maxlength' => '100'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'CIUD_DOMICILIO', 'label'=>'Ciudad', 'data'=>$arrCiudades])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'text', 'name'=>'EMPL_NOMBRECOMERCIAL', 'label'=>'Nombre Comercial', 'options'=>['maxlength' => '100'] ])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'EMPL_NOMBREREPRESENTANTE', 'label'=>'Nombre Representante Legal', 'options'=>['maxlength' => '100'] ])
		@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'EMPL_CEDULAREPRESENTANTE', 'label'=>'Cedula Representante', 'options'=>['size' => '999999999999999' ] ])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'email', 'column'=>8, 'name'=>'EMPL_CORREO', 'label'=>'Correo electrónico responsable G.H'])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'CIUD_CEDULA', 'label'=>'Ciudad de Expedición', 'data'=>$arrCiudades])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'PROS_ID', 'label'=>'Responsable de Gestión Humana', 'data'=>$arrProspectos])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'GERE_ids', 'label'=>'Gerencias', 'data'=>$arrGerencias, 'multiple'=>true])
	</div>
	<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'TURN_ids', 'label'=>'Turnos', 'data'=>$arrTurnos, 'multiple'=>true])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'GRUP_ids', 'label'=>'Grupos', 'data'=>$arrGrupos, 'multiple'=>true])
	</div>
	<div class="row">
		@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'EMPL_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
	</div>

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/empleadores'])
</div>