<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/events", name="events")
     */

    public function eventAction(Request $request)
    {
        $curl = $this -> get('AppBundle\Network\ServiceCurl');
        $events = $this -> getEvents();
        $gpsEvents = [];

        foreach($events as $e){
            $adrese = str_replace('', '+', $e['adresse']);
            $suggestion = json_decode($curl->curl_get($adresse),true);
            $gps = $suggestions['features'][0]['geometry']['coordinates'];
            $e['latitude'] = $gps[1];
            $e['longitude'] =$gps[0];
            $gpsEvents[] = $e;
        }

        return $this->render('App/event/events.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR),
            'events' =>$gpsEvents        
        ]);

    }

    public function getEvents(){
        $events = [
            ['nom'=>'Nouvelle année','date'=>'01/01/2019', 'adresse'=>'Place du Trocadéro 75016 Paris'],
            ['nom'=>'Mon anniversaire','date'=>'15/05/2019', 'adresse'=>'Place de la Bastille 75008'],
            ['nom'=>'Nouvelle année','date'=>'01/01/2019', 'adresse'=>'Place du Trocadéro 75016'],
            ['nom'=>'Nouvelle année','date'=>'01/01/2019', 'adresse'=>'Place du Trocadéro 75016']
        ]


    }






}
