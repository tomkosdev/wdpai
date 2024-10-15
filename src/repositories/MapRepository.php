<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Map.php';

class MapRepository extends Repository
{

    public function getMap(int $id): ?Map
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.maps WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $map = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($map == false) {
            return null;
        }

    
        return new Map(
            $map['name'],
            $map['date'],
            $map['description'],
            $map['image'],
            $map['pk3file'],
            $map['likes'],
            $map['id'],
            $map['uploader']
        );
    }

    public function addMap(Map $map): void
    {
        $currentDate = date('Y-m-d');

        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.maps(
                name, description, date, image, pk3file, uploader
            ) VALUES (?, ?, ?, ?, ?, ?);
        ');
    
        $stmt->execute([
            $map->getTitle(),
            $map->getDescription(),
            $currentDate,  
            $map->getImage(),
            $map->getPk3file(),
            $_SESSION['nickname']
        ]);
    }

    public function removeMap(string $id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT image FROM public.maps WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $imagePath = $stmt->fetchColumn();
        $imagePath = 'public/uploads/' . $imagePath;


        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath); 
        }

        $stmt = $this->database->connect()->prepare('
        DELETE FROM public.maps WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function likeMap(string $id_map, string $id_user)
    {
        $stmt = $this->database->connect()->prepare('CALL like_map(:id_map, :id_user)');

        $stmt->bindParam(':id_map', $id_map, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeLike(string $id_map, string $id_user)
    {
        $stmt = $this->database->connect()->prepare('CALL dislike_map(:id_map, :id_user)');

        $stmt->bindParam(':id_map', $id_map, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getMaps(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.maps ORDER BY id;');

        $stmt->execute();
        $maps = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($maps as $map) {
            
            $result[] = new Map(
                $map['name'],
                $map['date'],
                $map['description'],
                $map['image'],
                $map['getPk3file'],
                $map['likes'],
                $map['id'],
                $map['uploader']
            );
        }

        return $result;
    }

    public function getFavourite(string $email): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT id_map FROM public.user_map_likes a 
            INNER JOIN public.users u ON a.id_user = u.id 
            INNER JOIN public.user_credentials d ON u.credential = d.id
            WHERE d.email = :email');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $map_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($map_ids)) {
            return $result;
        }

        foreach ($map_ids as $id) {
            $result[] = $this->getMap($id['id_map']);
        }

        return $result;
    }

    public function isFavourite(string $id_map)
    {
        // tomek
        $stmt = $this->database->connect()->prepare('
        SELECT is_map_liked(:id_map, :id_user);');

        $stmt->bindParam(':id_map', $id_map, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $_SESSION['id'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMapByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.maps WHERE LOWER(name) LIKE :search OR LOWER(description) LIKE :search ORDER BY id');

        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}