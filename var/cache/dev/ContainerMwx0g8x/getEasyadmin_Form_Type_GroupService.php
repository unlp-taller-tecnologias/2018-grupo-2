<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'easyadmin.form.type.group' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/FormTypeInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/AbstractType.php';
include_once $this->targetDirs[3].'/vendor/easycorp/easyadmin-bundle/src/Form/Type/EasyAdminGroupType.php';

return $this->services['easyadmin.form.type.group'] = new \EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminGroupType();
