<?php
class Input
{
   public $name;
   public $class;
   public $type; 
   public $value = null;
   public $placeholder = null;

        public function __construct($name , $type=null , $classe , $value = null , $placeholder = null)
        {
            $this->name = $name;
            $this->class = $classe;
            $this->type = $type;
            $this->value = $value;
            $this->placeholder = $placeholder;
        }

        public function getName(){
            return $this->name;
        }

        public function CreatInput($label , $divClass){
            echo
                    '<div class="'.$divClass.'">
                    <label style="font-size:20px; color:darkslateblue;" class="section_title text-center">'.$label.' </label>
                    <input type="'.$this->type.'" name="'.$this->name.'" class="'.$this->class.'" value="'.$this->value.'" placeholder="'.$this->placeholder.'">
                    </div>';
        }

        public function CreatSelect($label,$divClass,$idAFF,$nomAFF,$nomAFF2 = null,$fetchable,$titre,$valModif = null){
         
            echo
                '<div class="'.$divClass.'">
                <label style="font-size:20px; color:darkslateblue;" class="section_title text-center">'.$label.'</label>
                <select class="'.$this->class.'" name="'.$this->name.'"; id="">
                <option value = "'.$valModif.'">'.$titre.'</option>';
                while ($cl=$fetchable->fetch()) {
                    echo '<option value = "'.$cl[$idAFF].'"><strong>'.$cl[$nomAFF].'</strong> '.$cl[$nomAFF2].'</option>';
                }
            echo   '</select></div>';
            
               
            }

        public function creatSelectSimple($label,$divClass,array $data,$modif=''){

            echo
            '<div class="'.$divClass.'">
            <label style="font-size:20px; color:darkslateblue;" class="section_title text-center">'.$label.'</label>
            <select class="'.$this->class.'" name="'.$this->name.'"; id="">
            <option value = "'.$modif.'">'.$modif.'</option>';
            foreach($data as $value => $rslt){
                echo
                '<option value = "'.$value.'">'.$rslt.'</option>';
            }
            echo'</select></div>';
        }
           
        public function InputNote()
        {
            echo
            '<div class="form-group border-bottom m-1 p-1 border-info">
                <input  style="width: 1.5cm;font-size: 13px; " type="texte" value="'.$this->value.'" name="'.$this->name.'" placeholder="'.$this->placeholder.'">
            </div>';
        }
        

}
?>
