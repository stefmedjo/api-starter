<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface {

  /** @var EntityManagerInterface */
  private $_entityManager;

  /** @var UserPasswordHasherInterface */
  private $_userPasswordHasher;

  public function __construct(
    EntityManagerInterface $entityManagerInterface,
    UserPasswordHasherInterface $userPasswordHasherInterface
  ) {
    $this->_entityManager = $entityManagerInterface;
    $this->_userPasswordHasher = $userPasswordHasherInterface;
  }

  public function supports($data, array $context = []): bool
  {
    return $data instanceof User;  
  }

  /**
   *
   * @param User $data
   */
  public function persist($data, array $context = []) {
    if($data->getPassword()) {
      $plainPassword = $data->getPassword();
      $data->setPassword(
        $this->_userPasswordHasher
            ->hashPassword(
              $data, 
              $plainPassword
            )
      );
      $this->_entityManager->persist($data);
      $this->_entityManager->flush();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function remove($data, array $context = [])
  {
      $this->_entityManager->remove($data);
      $this->_entityManager->flush();
  }

}