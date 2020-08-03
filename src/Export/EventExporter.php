<?php

namespace GabrielDeTassigny\Puc\Export;

use DateTime;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use GabrielDeTassigny\Puc\Entity\Utility;

class EventExporter
{
    public function generateEvent(DateTime $eventTime, Utility $utility): string
    {
        $calendar = new Calendar('payg-utility-calculator');

        $event = new Event();
        $event->setDtStart($eventTime)
            ->setDtEnd($eventTime)
            ->setNoTime(true)
            ->setSummary($utility->getName() . ' expiration');

        $calendar->addComponent($event);

        $filename = '/tmp/puc-event-' . time() . '.ics';
        file_put_contents($filename, $calendar->render());

        return $filename;
    }
}