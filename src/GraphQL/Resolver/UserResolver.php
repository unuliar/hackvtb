<?php

namespace App\GraphQL\Resolver;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class UserResolver
 * @package App\GraphQL\Resolver
 */
Class UserResolver implements ResolverInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * UserResolver constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ResolveInfo $info
     * @param $value
     * @param Argument $args
     * @return mixed
     */
    public function __invoke(ResolveInfo $info, $value, Argument $args)
    {
        $method = $info->fieldName;
        return $this->$method($value, $args);
    }

    /**
     * @param string $id
     * @return object|null
     */
    public function resolve(string $id)
    {
        return $this->em->find(User::class, $id);
    }

    /**
     * @param User $user
     * @return string
     */
    public function name(User $user) :string
    {
        return $user->getName();
    }
}
