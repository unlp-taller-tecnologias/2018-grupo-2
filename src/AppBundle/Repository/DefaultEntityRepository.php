<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * DefaultEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DefaultEntityRepository extends \Doctrine\ORM\EntityRepository
{
  protected static $nameClass;
  protected static $orderByAttribute;

  public function findByPage($page = 1, $max = 10,$arrayParams = NULL)
  {
      $this->setNameClass();
      $this->setOrderByAttribute();

      $query = $this->setQuery($arrayParams);
      $format= ((!is_null($arrayParams)) && (isset($arrayParams['format'])))? $arrayParams['format']:"html";
      if ($format != "html") {
        return $query->getResult();
      }
      $firstResult = ($page - 1) * $max;
      $query->setFirstResult($firstResult);
      $query->setMaxResults($max);
      $paginator = new Paginator($query);
      if(($paginator->count() <=  $firstResult) && $page != 1) {
        throw new NotFoundHttpException('Page not found');
      }
      return $paginator;
  }

  protected function setNameClass(){
    self::$nameClass = '';
  }

  protected function setOrderByAttribute(){
    self::$orderByAttribute = '';
  }

  protected function setQuery($arrayParams){
    if (is_null($arrayParams)) {
      $qb = $this->createQueryBuilder(self::$nameClass)
                  ->andWhere(self::$nameClass.'.deleted = :deleted')
                  ->setParameter('deleted', false)
                  ->orderBy(self::$orderByAttribute, 'ASC')
                  ->getQuery();
      return $qb;
    }
  }
}
