<?php

class Category extends Model
{


    protected $jsonFile = ROOT_PATH . '/data/categories.json';

    public function __construct() {}

    public function getAllCategories() : array
    {
        if (!file_exists($this->jsonFile)) {
            return [];
        }
        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);
        return isset($data['categories']) ? $data['categories'] : [];
    }

    public function addCategory(string $name, string $description, string $color): void
    {
        $categories = $this->getAllCategories();

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

        $this->SaveData(['categories' => $categories]);

    }

    public function deleteCategory(int $id) : void
    {

        $categories = $this->getAllCategories();

        $categories = array_filter($categories, function ($category) use ($id) {
            return $category['id'] !== $id;
        });

        $categories = array_values($categories);

        $this->SaveData(['categories' => $categories]);
    }

    public function searchCategory(int $id) : ?array
    {

        $categories = $this->getAllCategories();

        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                return $category;
            }
        }

        return null;
    }

    public function updateCategory(int $id, string $name, string $description, string $color) : void
    {
        $categories = $this->getAllCategories();

        foreach ($categories as $key => $category) {
            if ($category['id'] === $id) {
                $categories[$key]['name'] = $name;
                $categories[$key]['description'] = $description;
                $categories[$key]['color'] = $color;
                break;
            }
        }

        $this->SaveData(['categories' => $categories]);
    }

    public function filterCategory($searchByName): array
    {
        $categories = $this->getAllCategories();
        $filteredCategories = [];

        foreach ($categories as $category) {
            if (stripos($category['name'], $searchByName) !== false) {
                $filteredCategories[] = $category;
            }
        }

        return $filteredCategories;
    }

    public function SaveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}
