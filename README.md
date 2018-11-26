## Helpers

  ### expression_concat
  
  ### expression_count
  
  ### model_to_array
  
  ### get_model
  
  ### current_route_action
  
  ### array_implode
  ### img_to_base64
  ### delete_tree
  ### str_upperspace
  ### flash_alert
     Almacena un mensaje para ser presentado como alerta flotante en la vista.
     @param string $msg Mensaje a presentar.
     @param string $type Tipo de alerta. Puede ser: info, success, warning o danger.
  ### flash_modal
     * Almacena un mensaje para ser presentado como ventana modal en la vista.
     * @param string $msg Mensaje a presentar.
     * @param string $type Tipo de modal. Puede ser: info, success, warning o danger.
  ### datetime
     * Convierte un Date a String formateado
     * @param string|Date $date Fecha a convertir.
     * @return string Fecha formateada
  ### get_logo
     * Verifica si existe un logo definido por el usuario. Retorna la ruta del logo corporativo.
     * @return string Path
  ### convert_to_date
     * Convierte una cadena de texto a una fecha
     * @param string $fecha_string fecha en formato de texto
     * @return Carbon
  ### number_to_letter
     * Convierte un número a formato basado en reglas de números escritos con palabras
     * !! NumberFormatter requiere habilitar extensión php_intl.dll en php.ini
     * @param  int $num
     * @return string

## Modelos
  ### ModelWithSoftDeletes
  ### RelationshipsTrait
  ### ModelRulesTrait
  ### rules

## Controlador
  ### index
  ### getData
  ### storeModel
  ### updateModel
  ### destroyModel

## View
  ### Widgets
