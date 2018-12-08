<?php
/**
 * Created by PhpStorm.
 * User: imc
 * Date: 19/11/2017
 * Time: 12:21
 */

namespace ClientBundle\Entity;

use doctrine\ORM\entityRepository;
class OffresemploisRepository extends entityRepository
{
    public function findoffreDql(){
        $query=$this->getEntityManager()
            ->createQuery("SELECT v from ClientBundle:Offresemplois v where v.dateExperation>=CURRENT_DATE()");

        return $query->getResult();

    }
    public function findlike($ke){
        $ke="%".$ke."%";
        $query=$this->getEntityManager()
            ->createQuery("SELECT u FROM ClientBundle:Offresemplois u WHERE (u.poste LIKE ?1 OR u.description LIKE ?2 OR u.sal LIKE ?3  OR u.competance LIKE ?4)  AND  u.dateExperation>=CURRENT_DATE()");
        $query->setParameters(array(1=>$ke,2=>$ke,3=>$ke,4=>$ke));
        return $query->getResult();
    }
    public function findoffrearDql(){
        $query=$this->getEntityManager()
            ->createQuery("SELECT v from TmBundle:Offresemplois v where v.dateExperation<=CURRENT_DATE()");

        return $query->getResult();

    }
}