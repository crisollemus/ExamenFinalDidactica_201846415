<?php

class ListaDeTareas {
    private $tareas =[];

    public function agregarTarea($nombre,$prioridad=null) {
        if ($prioridad !== null){
            $this->tareas[]= new TareaImportante($nombre,$prioridad);
        } else {
            $this->tareas[]=new Tarea($nombre);
        }
    }

    public function obtenerTareas(){
        return  $this->tareas;
    }
    
    public function eliminarTarea($index){
        if (isset ($this->tareas[$index])){
            unset($this->tareas[$index]);
            $this->tareas= array_values($this->tareas);


        }  
    }

}
?>