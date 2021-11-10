<?php

class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=simple_note', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getNotes()
    {

        $num1 = $_SESSION['id'];
        $statement = $this->pdo->prepare("SELECT * FROM notes where user_id = $num1 ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
        $statement = $this->pdo->prepare("INSERT INTO notes (user_id, title, description, create_date)
                                    VALUES (:user_id, :title, :description, :date)");
        $statement->bindValue('user_id', $note['user_id']);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('date', date('Y-m-d H:i:s'));
        return $statement->execute();
    }

    public function updateNote($note_id, $note)
    {
        $statement = $this->pdo->prepare("UPDATE notes SET title = :title, description = :description WHERE note_id = :note_id");
        $statement->bindValue('note_id', $note_id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        return $statement->execute();
    }

    public function removeNote($note_id)
    {
        $statement = $this->pdo->prepare("DELETE FROM notes WHERE note_id = :note_id");
        $statement->bindValue('note_id', $note_id);
        return $statement->execute();
    }

    public function getNoteById($note_id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE note_id = :note_id");
        $statement->bindValue('note_id', $note_id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

return new Connection();
