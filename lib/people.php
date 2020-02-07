<?php


require_once("bdd.php");

class People
{
    /**
     * id de people
     * @var null
     */
    protected $id = null;

    /**
     * name de people
     * @var null
     */
    protected $name = null;

    /**
     * article constructor.
     * @param $id
     */

    public function __construct($id = null)
    {

        $dbConnection = BDD::getConnexion();
        $inst = $dbConnection->query('SELECT * FROM people WHERE id=' . $id);
        if (!$inst)
            return;

        $result = $inst->fetch(PDO::FETCH_ASSOC);
        if (!$result || empty($result['id']))
            return;
        var_dump($result);

        $this->id = $result['id'];
        $this->name = $result['name'];

    }


    public static function findOne($filters)
    {
        $bdd = BDD::getConnexion();
        $where = '';
        $clauses = [];
        foreach ($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }

        if (!empty($clauses)) {
            $where = 'WHERE '.implode(' AND ', $clauses);
        }
        $query = 'SELECT * FROM people '.$where.'LIMIT 0,1';
        var_dump($query);
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, 'People');
        return $res->fetch();
    }


}

