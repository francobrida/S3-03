<?php

interface StorageInterface {
    public function getAll(): array;
    public function saveData() : void;
    public function readData() : array;
    public function delete(int $id) : bool;
    public function search(int $id) : ?array;
}

?>