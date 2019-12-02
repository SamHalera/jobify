<?php

namespace App\Security\Voter;

use App\Entity\JobOffer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class JobOfferVoter extends Voter
{

    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    //This method is called whenever we use isGranted() method => 
    //$attribute is the string argument passed to isGranted(),
    //$subject is the second argument
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['MANAGE'])
            && $subject instanceof JobOffer;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /**
         * @var JobOffer $subject
         */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'MANAGE':
                if($subject->getAuthor() == $user && $this->security->isGranted("ROLE_RECRUITER")){
                    return true;
                }


            return false;
        }

        return false;
    }
}
