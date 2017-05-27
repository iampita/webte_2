<?php

include_once 'dbcontroller.php';

class Projects
{
    private $db;

    function __construct()
    {
        $this->db = new DBController();
        $this->db->connectDB();
    }

    function getAllProjectTypes() {
        $query = "SELECT projectType, COUNT(projectType) as count
                  FROM   projects
                  GROUP BY projectType;";
        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

    function getProject($projectType) {
        $query = "SELECT id, number, titleSK, titleEN, duration, coordinator
                  FROM  projects
                  WHERE projectType LIKE '{$projectType}';";
        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

    function getDetail($id) {
        $query = "SELECT *
                  FROM  projects
                  WHERE id = {$id};";
        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

}