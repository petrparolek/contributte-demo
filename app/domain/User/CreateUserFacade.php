<?php declare(strict_types = 1);

namespace App\Domain\User;

use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use Nette\Security\Passwords;

class CreateUserFacade
{

	/** @var EntityManager */
	private $em;

	/** @var Passwords */
	private $passwords;

	public function __construct(
		EntityManager $em,
		Passwords $passwords
	)
	{
		$this->em = $em;
		$this->passwords = $passwords;
	}

	/**
	 * @param mixed[] $data
	 */
	public function createUser(array $data): User
	{
		// Create User
		$user = new User(
			$data['name'],
			$data['surname'],
			$data['email'],
			$data['username'],
			$this->passwords->hash($data['password'])
		);

		// Set role
		if (isset($data['role'])) {
			$user->setRole($data['role']);
		}

		// Save user
		$this->em->persist($user);
		$this->em->flush();

		return $user;
	}

}
