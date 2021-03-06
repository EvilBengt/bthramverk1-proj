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

    /**
     * Text filter
     *
     * @var TextFilter
     */
    private $textFilter;


    public function __construct(Database $db, UserManager $userManager, TextFilter $textFilter) {
        $this->db = $db;
        $this->userManager = $userManager;
        $this->textFilter = $textFilter;
    }


    public function byContainerID(int $id) : array
    {
        $comments = $this->db->connect()->executeFetchAll("
            SELECT id,
                   comment_container,
                   author,
                   body,
                   rating
              FROM comments
             WHERE comment_container = ?
            ;
        ", [$id]);

        foreach ($comments as $key => $c) {
            $comments[$key] = $this->fromDbData($c);
        }

        return $comments;
    }

    public function byID(int $id) : Comment
    {
        $comment = $this->db->connect()->executeFetch("
            SELECT id,
                   comment_container,
                   author,
                   body,
                   rating
              FROM comments
             WHERE id = ?
            ;
        ", [$id]);

        return $this->fromDbData($comment);
    }

    public function byUserID(int $id) : array
    {
        $comments = $this->db->connect()->executeFetchAll("
            SELECT id,
                   comment_container,
                   author,
                   body,
                   rating
              FROM comments
             WHERE author = ?
            ;
        ", [$id]);

        foreach ($comments as $key => $c) {
            $comments[$key] = $this->fromDbData($c);
        }

        return $comments;
    }

    public function getQuestionID(int $id) : int
    {
        $comment = $this->byID($id);

        $question = $this->db->connect()->executeFetch("
            SELECT id
              FROM questions
             WHERE comment_container = ?
            ;
        ", [$comment->getCommentContainer()]);

        if ($question != null) {
            return $question["id"];
        }

        $answer = $this->db->connect()->executeFetch("
            SELECT id
                   question
              FROM answers
             WHERE comment_container = ?
            ;
        ", [$comment->getCommentContainer()]);

        return $answer["question"];
    }

    public function create(int $containerID, string $body, int $author) : int
    {
        $this->db->connect()->execute("
            INSERT INTO comments(comment_container, author, body)
            VALUES (?, ?, ?)
            ;
        ", [
            $containerID,
            $author,
            $body
        ]);

        $this->db->connect()->execute("
            UPDATE users
               SET reputation = reputation + 3
             WHERE id = ?
        ", [$author]);

        return $this->db->lastInsertId();
    }

    public function voteUp($id)
    {
        $this->db->connect()->execute("
            UPDATE comments
               SET rating = rating + 1
             WHERE id = ?
        ", [$id]);

        $authorID = $this->byID($id)->getAuthor()->getID();

        $this->db->connect()->execute("
            UPDATE users
               SET reputation = reputation + 1
             WHERE id = ?
        ", [$authorID]);
    }

    public function voteDown($id)
    {
        $this->db->connect()->execute("
            UPDATE comments
               SET rating = rating - 1
             WHERE id = ?
        ", [$id]);

        $authorID = $this->byID($id)->getAuthor()->getID();

        $this->db->connect()->execute("
            UPDATE users
               SET reputation = reputation - 1
             WHERE id = ?
        ", [$authorID]);
    }


    private function fromDbData(array $data) : Comment
    {
        return new Comment(
            $data["id"],
            $data["comment_container"],
            $this->userManager->byID($data["author"]),
            $this->textFilter->markdown($data["body"]),
            $data["rating"]
        );
    }
}
