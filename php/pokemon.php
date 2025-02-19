<?php

namespace Pokemon;

use DB\DBLink;
use PDO;

class PokemonView
{
    public function addType($name, $image, &$errorMessage)
    {
        global $db;

        try {
            $query = $db->prepare("INSERT INTO pokemonTypes (name, image) VALUES (:name, :image)");
            $query->bindParam(":name", $name, PDO::PARAM_STR);
            $query->bindParam(":image", $image, PDO::PARAM_STR);

            if (!$query->execute()) {
                die("Erreur lors de l'insertion dans la base de données.");
            }
        } catch (PDOException $e) {
            $errorMessage .= "Erreur : " . $e->getMessage() . '<br>';
            exit;
        }
    }

    public function updateType($newName, $newImage, &$errorMessage)
    {
        global $db;

        try {
            $query = $db->prepare("UPDATE pokemonTypes SET name = :name, image = :image WHERE id = :id");
            $query->bindParam(":name", $newName, PDO::PARAM_STR);
            $query->bindParam(":image", $newImage, PDO::PARAM_STR);
            $query->bindParam(":id", $id, PDO::PARAM_INT);

            if (!$query->execute()) {
                die("Error while updating.");
            }

        } catch (PDOException $e) {
            $errorMessage .= "Erreur : " . $e->getMessage() . '<br>';
            exit;
        }
    }
}

?>