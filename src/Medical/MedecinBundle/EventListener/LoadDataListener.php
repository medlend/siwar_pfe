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

class LoadDataListener
{
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(MyCustomEventt $calendarEvent)
    {

        $startDate = $calendarEvent->getStart();
        $endDate = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        dump($startDate,$endDate,$filters);
        //You may want do a custom query to populate the events

//        $format = 'Y-m-d H:i:s';
        $dateStrat = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-05-28 21:24:38');
        $dateEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-05-28 21:29:38');

        $cust =  new MyCustomEvent('Event Title 1', $dateStrat);
        $cust->setEndDate($dateEnd);
        $cust->setAllDay(false);
        $calendarEvent->addEvent($cust);
//        $calendarEvent->addEvent(new MyCustomEvent('Event Title 2', $dateStrat));
//        $calendarEvent->addEvent(new MyCustomEvent('Event Titlwwe 2', $dateStrat));
    }
}



