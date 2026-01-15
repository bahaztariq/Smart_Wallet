<?php




class Category{
    private $category;
    private $categoryLimit;
    private $connect;

    public function __construct($connect){
        $this->connect =$connect;
    }

    public function create($category,$categoryLimit){
        $this->category = $category;
        $this->categoryLimit = $categoryLimit;
        $sql = "INSERT INTO categories (category,Limit) VALUES (':category',':categoryLimit')";
        $this->connect->prepare($sql);
        $this->connect->execute([
            'category' => $this->category,
            'categoryLimit' => $this->categoryLimit
        ]);
        return true;
    }
    public function getAll(){
        $sql = "SELECT * FROM categories";
        $result = $this->connect->query($sql);
        return $result;
    }
    public function getById($id){
        $sql = "select * from categories where id = '$id'";
        $result = $this->connect->query($sql);
        return $result;
    }
    public function getByName($category){
        $sql = "select * from categories where category = '$category'";
        $result = $this->connect->query($sql);
        return $result;
    }

    public function update($id,$category,$Limit){
        $sql = "UPDATE categories SET category = '$category',Limit = '$Limit' WHERE id = '$id'";
        $this->connect->query($sql);
        
    }
    public function delete($id){
        $sql = "DELETE FROM categories WHERE id = '$id'";
        $this->connect->query($sql);
    }
}