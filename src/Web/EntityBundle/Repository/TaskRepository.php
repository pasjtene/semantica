<?php

namespace Web\EntityBundle\Repository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{

    public function  getByparam($data, $limit=20, $page=1, $count=false )
    {
        $query = $this->createQueryBuilder('a');
        if($count)
        {
            $query->select('count(a.id)');
            return $query->getQuery()->getSingleScalarResult();
        }

        $query->select(['a','pl','pr','u'])
            ->leftJoin('a.planning','pl')
            ->leftJoin('pl.project','pr')
            ->leftJoin('pr.user','u');


        if($data!=null)
        {
            $parameters['title']='%'.$data['title'].'%';
            $parameters['status']='%'.$data['status'].'%';
            $parameters['libelle']='%'.$data['libelle'].'%';
            $parameters['planning_id']=$data['planning_id'];
            $parameters['user_id']=$data['user_id'];

            $query->Where('pr.title LIKE :title OR pr.title IS NULL');
            $query->andWhere('pr.status LIKE :status OR pr.status IS NULL');
            $query->andWhere('a.libelle LIKE :libelle OR a.libelle IS NULL');
            $query->andWhere('pl.id =:planning_id OR  pl.id IS NULL');
            $query->andWhere('u.id =:user_id OR  u.id IS NULL');
            $query->addOrderBy('a.id','asc');
            $query->setParameters($parameters);

            if($limit)
            {
                $page=$page<1?1:$page;
                $query->setFirstResult(($page-1)*$limit)->setMaxResults($limit);
            }
        }

        return $query->getQuery()->getResult();

    }
}
