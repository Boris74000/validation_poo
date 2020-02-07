<?php


require_once ("bdd.php");

class Event
{
    /**
     * id de event
     * @var null
     */
    protected $id = null;

    /**
     * id agenda
     * @var null
     */
    protected $idAgenda = null;

    /**
     * titre de event
     * @var null
     */
    protected $title = null;

    /**
     * date de event
     * @var null
     */
    protected $date = null;

    /**
     * durée de event
     * @var null
     */
    protected $duration = null;

    /**
     * article constructor.
     * @param $id
     */

    public function __construct($id=null)
    {

        $dbConnection = BDD::getConnexion();
        $inst = $dbConnection->query('SELECT * FROM event WHERE id='.$id);
        if(!$inst)
            return;

        $result = $inst->fetch(PDO::FETCH_ASSOC);
        if(!$result || empty($result['id']))
            return;
        var_dump($result);

        $this->id = $result['id'];
        $this->idAgenda = $result['idAgenda'];
        $this->title = $result['title'];
        $this->date = $result['date'];
        $this->duration = $result['duration'];


    }

    public static function findAllByDate($filters=[])
    {
        $bdd = BDD::getConnexion();

        $clauses = [];
        foreach ($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }
        $where = '';
        if (!empty($clauses)) {
            $where = 'WHERE '.implode(' AND ', $clauses);
        }
        $query = 'SELECT * FROM event '.$where;
        var_dump($query);

        $res = $bdd->query($query);
        return $res->fetchAll(PDO::FETCH_CLASS, 'Event');
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
        $query = 'SELECT * FROM event '.$where.'LIMIT 0,1';
        var_dump($query);
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, 'Event');
        return $res->fetch();
    }


}
