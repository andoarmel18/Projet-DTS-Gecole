<?php
class Database
{
    private $dbsname;
    private $dbsuser;
    private $mdps;
    private $host;
    private $pdo;

        public function __construct($dbsname='gestionecl',$dbsuser = 'root',$mdp='',$host='localhost')
        {
            $this->dbsname = $dbsname;
            $this->dbsuser = $dbsuser;
            $this->mdps = $mdp;
            $this->host = $host;
        }

        

        private function connect()
        {
            if($this->pdo === null){
                $pdo = new PDO("mysql:host=localhost;dbname=gestionecl",$this->dbsuser,$this->mdps,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                $this->pdo = $pdo;  
            }
        return $this->pdo;
        }

        

        public function getAllData(string $requette)
        {
            try{
                $req = $this->connect()->query($requette);
                $data = $req->fetch();
                return $data;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
        }
        

        public function requette(string $requette)
        {
            try{
                return  $this->connect()->query($requette);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
         
  
        }

        public function ReqSecure($requette , array $attribut)
        {
            try{
                return $this->connect()->prepare($requette)->execute($attribut);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
             
        }

        public  function  Chearch($requette) 
        {
            try{
                $data = $this->connect()->query($requette);
                $datas = $data->fetch();
                if(!empty($datas)){
                return true;
            }
                return false;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
           
             
        }

        public function ReqSecureData($requette , array $attribut)
        {
            try{
                $statment =  $this->connect()->prepare($requette)->execute($attribut);
                $data = $statment->fetch();
                return $data;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
         
            
        }

       
        
}

