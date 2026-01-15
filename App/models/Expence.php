<?php



class Expence{
    private $UserId;
    private $montant;
    private $description;
    private $date;
    private $connect;
    private $category;



    public function __construct($connect){
        $this->connect = $connect;
        
    }
    public function create($UserId,$montant,$description,$date,$category){
        $this->UserId = $UserId;
        $this->montant = $montant;
        $this->description = $description;
        $this->date = $date;
        $this->category = $category;
        $sql = "INSERT INTO expences(UserID,montant,description,date_,category) VALUES (:UserId,:montant,:description,:date,:category)";
        $result = $this->connect->prepare($sql);
        $result->execute([
            ':UserId' => $this->UserId,
            ':montant' => $this->montant,
            ':description' => $this->description,
            ':date' => $this->date,
            ':category' => $this->category
        ]);
        return true;

    }
    public function getAll(){
        $sql = "SELECT * FROM expences";
        $result = $this->connect->query($sql);
        return $result;
    }
    public function getById($id){
        $sql = "select * from expences where id = :id";
        $result = $this->connect->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        return $result;
    }
    public function getByCategory($category){
        $sql = "select * from expences where category = :category";
        $result = $this->connect->prepare($sql);
        $result->execute([
            'category' => $category
        ]);
        return $result->fetchAll();
    }
    public function update($id,$montant,$description,$date){
        $sql = "UPDATE expences SET montant = :montant,description = :description,date = :date WHERE id = :id";
        $this->connect->prepare($sql);
        $this->connect->execute([
            'id' => $id,
            'montant' => $montant,
            'description' => $description,
            'date' => $date
        ]);
        
    }
    public function delete($id){
        $sql = "DELETE FROM expences WHERE id = :id";
        $this->connect->prepare($sql);
        $this->connect->execute([
            'id' => $id
        ]);
    }
}