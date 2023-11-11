
<?php

class Tarea {
    protected $nombre;
    protected $completada = false;

    public function __construct($nombre)
    {
        $this->nombre=$nombre;
    }

    public function completar()
    {
        $this->completada=true;
    }

    public function descompletar()
    {
        $this->completada=false;
    }

    public function estaCompletada()
    {
       return $this->completada;
    }
    public function getNombre()
    {
      return  $this->nombre;
    }


}

class TareaImportante extends Tarea {
    private $prioridad;
    
    public function __construct($nombre,$prioridad){
        parent:: __construct($nombre);
        $this->prioridad=$prioridad;

    }
    
 
    
        public function getPrioridad() {
            return $this->prioridad;
        }
    }
    
    

?>