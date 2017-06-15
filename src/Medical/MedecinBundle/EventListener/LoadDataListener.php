<?php
/**
 * Created by PhpStorm.
 * User: medlend
 * Date: 27/05/17
 * Time: 22:14
 */

namespace Medical\MedecinBundle\EventListener;


use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent as MyCustomEventt;
//use Medical\MedecinBundle\Entity\CalendarEvent as MyCustomEvent;
use AncaRebeca\FullCalendarBundle\Model\Event as MyCustomEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadDataListener
{

    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(MyCustomEventt $calendarEvent)
    {
       $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $eventt = $this->container->get('doctrine.orm.entity_manager')->getRepository('MedecinBundle:CalendarEvent')
            ->findBy(array('idDocteur' =>$user->getId()));

//        dump($eventt);die;
//        $hopitales = $this->em
//            ->getRepository('MedecinBundle:CalendarEvent')
//            ->createQueryBuilder('e')
//            ->join('e.user', 'r')
//            ->where('r.enabled = 1')
//            ->getQuery()
//            ->getResult();

        if(empty($eventt)) return ;
        $userManager = $this->container->get('fos_user.user_manager');



        foreach ($eventt as $event){
//        $format = 'Y-m-d H:i:s';
        $heureRendezVous = \DateTime::createFromFormat('Y-m-d', $event->getStartDate());
        $dateRendezVous = \DateTime::createFromFormat('Y-m-d H:i:s', $event->getEndDate());

            $dateRendezVous = new \DateTime($event->getEndDate());
            $user = $userManager->findUserByEmail($event->getIdUser());

//            dump($date);die('aaa');
        $cust =  new MyCustomEvent($event->getStartDate().' '.$user->getUsername(), $dateRendezVous);
        $calendarEvent->addEvent($cust);
        }

    }
}



