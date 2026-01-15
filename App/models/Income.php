<?php


class Income{
    private $UserId;
    private $montant;
    private $description;
    private $date;
    private $connect;


    public function __construct($connect){
        $this->connect = $connect;
    }
    public function create($UserId,$montant,$description,$date){
        $this->UserId = $UserId;
        $this->montant = $montant;
        $this->description = $description;
        $this->date = $date;
        $sql = "INSERT INTO incomes(UserID,montant,description,date_) VALUES (:UserId,:montant,:description,:date)";
        $this->connect->prepare($sql);
        $this->connect->execute([
            ':UserId' => $this->UserId,
            ':montant' => $this->montant,
            ':description' => $this->description,
            ':date' => $this->date
        ]);
        return true;

    }
    public function getAll(){
        
        $sql = "SELECT * FROM incomes";
        $result = $this->connect->query($sql);
        return $result;
    }
    public function getById($id){
        $sql = "SELECT * FROM incomes WHERE id = :id";
        $result = $this->connect->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        return $result;
    }
    public function getByCategory($category){
        $sql = "SELECT * FROM incomes WHERE category = :category";
        $result = $this->connect->prepare($sql);
        $result->execute([
            'category' => $category
        ]);
        return $result->fetchAll();
    }
    public function update($id,$montant,$description,$date){
        $sql = "UPDATE incomes SET montant = :montant,description = :description,date = :date WHERE id = :id";
        $this->connect->prepare($sql);
        $this->connect->execute([
            'id' => $id,
            'montant' => $montant,
            'description' => $description,
            'date' => $date
        ]);
        
    }
    public function delete($id){
        $sql = "DELETE FROM incomes WHERE id = :id";
        $this->connect->prepare($sql);
        $this->connect->execute([
            'id' => $id
        ]);
    }
}
?>