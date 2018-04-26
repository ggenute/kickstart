<?php

namespace App\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/review", name="review")
     * @param UserInterface|null $user
     * @return Response
     * @throws AccessDeniedException
     */
    public function review(UserInterface $user = null): Response
    {
        if (!$user) {
            throw new AccessDeniedException('Your user is not authorised');
        }
        if (\in_array('ROLE_MANO_ROLE', $user->getRoles(), true)) {
            return $this->render('admin/review.html.twig');
        }
        if (\in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return $this->render('admin/plan.html.twig');
        }
        // Design system to not reach this line: produce HTTP 500 response
        throw new AccessDeniedException('User not authorised by known roles');
    }
}
