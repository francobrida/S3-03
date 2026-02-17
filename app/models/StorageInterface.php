<?php

interface StorageInterface {
    public function getAll(): array;
    public function saveData(array $dataToSave) : void;
    public function readData() : array;
    public function deleteData(int $id) : bool;
    public function search(int $id) : ?array;
}

?>