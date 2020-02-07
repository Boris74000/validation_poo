<?php


require_once("bdd.php");

class Agenda
{
    /**
     * id de agenda
     * @var null
     */
    protected $id = null;

    /**
     * name de agenda
     * @var null
     */
    protected $name = null;

    /**
     * color de agenda
     * @var null
     */
    protected $color = null;


    /**
     * article constructor.
     * @param $id
     */

    public function __construct($id = null)
    {

        $dbConnection = BDD::getConnexion();
        $inst = $dbConnection->query('SELECT * FROM agenda WHERE id=' . $id);
        if (!$inst)
            return;

        $result = $inst->fetch(PDO::FETCH_ASSOC);
        if (!$result || empty($result['id']))
            return;
        var_dump($result);

        $this->id = $result['id'];
        $this->name = $result['name'];
        $this->color = $result['color'];

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
        $query = 'SELECT * FROM agenda '.$where.'LIMIT 0,1';
        var_dump($query);
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, 'Agenda');
        return $res->fetch();
    }


}

