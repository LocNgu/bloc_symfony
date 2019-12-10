<?php
namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GalleryController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository(Image::class)->findAll();

        return $this->render(
            'gallery/gallery.html.twig',
            array(
                'nav_index' => 1,
                'images' => $images
            )
        );
    }
}
