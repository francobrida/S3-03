<?php

class CategoryJSON extends Model implements CategoryStorageInterface
{

    protected $jsonFile = ROOT_PATH . '/data/categories.json';

    public function __construct() {}

    public function getAll() : array
    {
        return $this->readData();
    }

    public function addCategory(string $name, string $description, string $color): void
    {
        $categories = $this->getAll();

        if (empty($categories)) {
            $newId = 1;
        } else {
            $lastCategory = end($categories);
            $newId = $lastCategory['id'] + 1;
        }

        $categories[] = [
            'id' => $newId,
            'name' => $name,
            'description' => $description,
            'color' => $color
        ];

        $this->saveData(['categories' => $categories]);

    }

    public function deleteData(int $id) : bool
    {

        $categories = $this->getAll();

        $categories = array_filter($categories, function ($category) use ($id) {
            return $category['id'] !== $id;
        });

        $categories = array_values($categories);

        $this->saveData(['categories' => $categories]);
        return true;
    }

    public function searchData(int $id) : ?array
    {

        $categories = $this->getAll();

        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                return $category;
            }
        }

        return null;
    }

    public function updateCategory(int $id, string $name, string $description, string $color) : void
    {
        $categories = $this->getAll();

        foreach ($categories as $key => $category) {
            if ($category['id'] === $id) {
                $categories[$key]['name'] = $name;
                $categories[$key]['description'] = $description;
                $categories[$key]['color'] = $color;
                break;
            }
        }

        $this->saveData(['categories' => $categories]);
    }

    public function filterCategory($searchByName): array
    {
        $categories = $this->getAll();
        $filteredCategories = [];

        foreach ($categories as $category) {
            if (stripos($category['name'], $searchByName) !== false) {
                $filteredCategories[] = $category;
            }
        }

        return $filteredCategories;
    }

    public function readData() : array {
        if (!file_exists($this->jsonFile)) {
            return [];
        }
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);
        return isset($data['categories']) ? $data['categories'] : [];
    }

    public function saveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}