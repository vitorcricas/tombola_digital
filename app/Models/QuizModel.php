<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'quiz';
    protected $primaryKey           = 'id_quiz';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = ["q1", "q2", "q3", "q4", "q5"];

    // Dates
    protected $useTimestamps        = false;
    protected $createdField         = '';


    public function saveQuiz($id)
    {
        $this->db->query('update users set hasQuiz=1 where id=' . $id);
    }
}
