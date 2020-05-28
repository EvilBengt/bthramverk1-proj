<?php

namespace EVB\Forum\Database;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;

use EVB\Forum\Models\User;
use EVB\Forum\Models\Comment;

use EVB\Forum\Database\UserManager;

class CommentManager
{
    /**
     * Database connection
     *
     * @var Database
     */
    private $db;

    /**
     * User manager
     *
     * @var UserManager
     */
    private $userManager;


    public function __construct(Database $db, UserManager $userManager) {
        $this->db = $db;
        $this->userManager = $userManager;
    }


    public function byContainerID(int $id) : array
    {
        $comments = $this->db->connect()->executeFetchAll("
            SELECT id, comment_container, author, body
              FROM comments
             WHERE comment_container = ?
            ;
        ", [$id]);

        foreach ($comments as $key => $c) {
            $comments[$key] = $this->fromDbData($c);
        }

        return $comments;
    }

    public function byID(int $id) : Question
    {
        $question = $this->db->connect()->executeFetch("
            SELECT id, title, body, comment_container, author
              FROM questions
             WHERE id = ?
        ", [$id]);

        return $this->fromDbData($question);
    }


    private function fromDbData(array $data) : Comment
    {
        return new Comment(
            $data["id"],
            $data["comment_container"],
            $this->userManager->byID($data["author"]),
            $data["body"]
        );
    }
}
