<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends DefaultEntityRepository
{
  public function setNameClass()
  {
    self::$nameClass = 'CategoryRepository';
  }

  public function setOrderByAttribute(){
    self::$orderByAttribute = 'CategoryRepository.name';
  }

  public function getAttendantsByCategory($id_category){
    $qb = $this->getEntityManager()->createQueryBuilder();
    $qb
    ->select('a')
    ->from('AppBundle:Attendant','a')
    ->where($qb->expr()->eq('a.deleted',':state'))
    ->andWhere($qb->expr()->eq('a.category', ':$id_category'))
    ->setParameters(array(
      'state'=>false,
      'id_category'=>$id_category
    ));
  }
}
