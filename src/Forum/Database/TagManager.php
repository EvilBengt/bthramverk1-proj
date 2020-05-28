<?php

namespace EVB\Forum\Database;

use Anax\Database\Database;
use EVB\Forum\Models\Tag;

class TagManager
{
    /**
     * Database connection
     *
     * @var Database
     */
    private $db;


    public function __construct(Database $db) {
        $this->db = $db;
    }


    public function all() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT id, name
              FROM tags
            ;
        ");

        foreach ($data as $key => $tag) {
            $data[$key] = $this->fromDbData($tag);
        }

        return $data;
    }

    public function byQuestionID(int $id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT t.id AS id,
                   t.name AS name
              FROM questions_has_tags AS qt
              JOIN tags AS t
                ON t.id = qt.tag
             WHERE qt.question = ?
        ", [$id]);

        foreach ($data as $key => $tag) {
            $data[$key] = $this->fromDbData($tag);
        }

        return $data;
    }


    private function fromDbData(array $data) : Tag
    {
        return new Tag(
            $data["id"],
            $data["name"]
        );
    }
}
