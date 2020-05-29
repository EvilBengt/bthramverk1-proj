<?php

namespace EVB\Forum\Database;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;

use EVB\Forum\Models\Answer;
use EVB\Forum\Models\Question;
use EVB\Forum\Models\User;
use EVB\Forum\Models\CommentContainer;

use EVB\Forum\Database\UserManager;
use EVB\Forum\Database\CommentManager;

class AnswerManager
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
     * Comment manager
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Text filter
     *
     * @var TextFilter
     */
    private $textFilter;


    public function __construct(Database $db, UserManager $userManager, CommentManager $commentManager, TextFilter $textFilter) {
        $this->db = $db;
        $this->userManager = $userManager;
        $this->commentManager = $commentManager;
        $this->textFilter = $textFilter;
    }


    public function byQuestionID(int $id) : array
    {
        $answers = $this->db->connect()->executeFetchAll("
            SELECT id, question, body, comment_container, author
              FROM answers
             WHERE question = ?
            ;
        ", [$id]);

        foreach ($answers as $key => $a) {
            $answers[$key] = $this->fromDbData($a);
        }

        return $answers;
    }

    public function byID(int $id) : Answer
    {
        $answer = $this->db->connect()->executeFetch("
            SELECT id, question, body, comment_container, author
              FROM answers
             WHERE id = ?
        ", [$id]);

        return $this->fromDbData($answer);
    }

    public function byUserID(int $id) : array
    {
        $answers = $this->db->connect()->executeFetchAll("
            SELECT id, question, body, comment_container, author
              FROM answers
             WHERE author = ?
        ", [$id]);

        foreach ($answers as $key => $a) {
            $answers[$key] = $this->fromDbData($a);
        }

        return $answers;
    }

    public function create(int $questionID, string $body, int $author) : int
    {
        $this->db->connect()->execute("
            INSERT INTO comment_containers()
            VALUES ()
            ;
        ");

        $commentContainer = $this->db->lastInsertId();

        $this->db->connect()->execute("
            INSERT INTO answers(question, body, comment_container, author)
            VALUES (?, ?, ?, ?)
            ;
        ", [
            $questionID,
            $body,
            $commentContainer,
            $author
        ]);

        return $this->db->lastInsertId();
    }


    private function fromDbData(array $data) : Answer
    {
        return new Answer(
            $data["id"],
            $data["question"],
            $this->textFilter->markdown($data["body"]),
            $this->commentManager->byContainerID($data["comment_container"]),
            $data["comment_container"],
            $this->userManager->byID($data["author"])
        );
    }
}
