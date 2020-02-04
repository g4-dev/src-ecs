<?php

namespace Admin\Service;

use Admin\Entity\ProductType;
use Symfony\Component\HttpFoundation\Request;

class SiteMapService
{
    public function getSiteMap(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $urls = array();
        $hostname = $request->getSchemeAndHttpHost();

        // add static urls
        #$urls[] = array('loc' => $this->generateUrl('ProductType'));

        // add dynamic urls, like blog posts from your DB
        foreach ($em->getRepository(ProductType::class)->findAll() as $post) {
            $urls[] = array('loc' => $this->generateUrl('ProductType', array('Url_ProductType' => $post->getPostSlug()))
            );
        }

        $response = new Response(
            $this->renderView('Test.html.twig', array( 'urls' => $urls, 'hostname' => $hostname)), 200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $urls;
    }
}