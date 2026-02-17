<?php

interface StorageInterface {
    public function getAll(): array;
    public function saveData() : void;
    public function readData() : array;
    public function deleteData(int $id) : bool;
    public function searchData(int $id) : ?array;
}

?>