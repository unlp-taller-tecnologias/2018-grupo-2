<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * FASpecieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FASpecieRepository extends DefaultEntityRepository
{
  public function setNameClass()
  {
    self::$nameClass = 'FASpecieRepository';
  }

  protected function setOrderByAttribute(){
    self::$orderByAttribute = 'FASpecieRepository.name';
  }
}
