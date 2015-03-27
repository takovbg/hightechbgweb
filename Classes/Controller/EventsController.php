<?php
namespace Iteration\SagendaBooking\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * EventsController
 */
class EventsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventsRepository
	 *
	 * @var \Iteration\SagendaBooking\Domain\Repository\EventsRepository
	 * @inject
	 */
	protected $eventsRepository = NULL;

	/**
	 * apiUrl
	 *
	 * @var string
	 */	
	protected $apiUrl = 'http://www.sagenda.net/api/'; //Live Server
	
	
	/**
	 * sagendaToken
	 *
	 * @var string
	 */	
	//protected $authCode = '9279d2b626d84c17be974f14c8f7dd9f'; // Sagenda Token
	protected $authCode = ''; // Sagenda Token
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
	
	    $this->authCode = '9279d2b626d84c17be974f14c8f7dd9f';
	    //$this->authCode = $this->settings['authCode'];
		$this->view->assign('gghhvv', $this->settings['gghhvv']);
	
		$events = $this->eventsRepository->findAll();
		$this->view->assign('events', $events);
		
		//$authCode = '9279d2b626d84c17be974f14c8f7dd9f';
		$apiUrl = 'http://www.sagenda.net/api/';
		
		// Bookable Items - begin
		$json = @file_get_contents($apiUrl . 'Events/GetBookableItemList/' . $this->authCode);
		$this->view->assign('json', $json);
	
		$bookingEvents = json_decode($json, true); // the option "true" makes the $bookingEvents to be an associative array
		$this->view->assign('bookingEvents', $bookingEvents); // $bookingEvents is an associative array
		
		//$this->view->assign('bookingEventsDump', var_dump($bookingEvents));
		
		// Bookable Items - end
		
		
		// Bookable Events (Events List) - begin
		
		$startDate = '12-10-2014';
		$endDate = '12-30-2015';
		$bookableItemId = $bookingEvents[1][Id];
		
		$jsonBookableItems = @file_get_contents($apiUrl . 'Events/GetAvailability/' . $this->authCode . '/' . $startDate . '/' . $endDate . '/?bookableItemId=' . $bookableItemId);
		$bookableItems = json_decode($jsonBookableItems, true);
		$this->view->assign('bookableItems', $bookableItems);
		
		//$this->view->assign('bookingEventsDump', var_dump($bookableItems));
		
		// Bookable Events (Events List) - end
		
		// Validate Account - begin
		$jsonValidate = @file_get_contents($apiUrl . 'ValidateAccount/' . $this->authCode);
		$validateAccount = json_decode($jsonValidate, true);
		$this->view->assign('validateAccount', $validateAccount);
		
		//$this->view->assign('bookingEventsDump', var_dump($validateAccount));
		
		// Validate Account - end
		
		
		// SetBooking - begin
		
		//$Booking = array("ApiToken" => $this->authCode, "EventIdentifier" => $bookableItems[0][EventIdentifier], "BookableItemId" => $bookableItems[0][EventIdentifier][BookableItems][Id], "EventScheduleId" => $bookableItems[0][EventScheduleId], "Courtesy" => "Mr.", "FirstName" => "Ta", "LastName" => "Kov", "PhoneNumber" => "+359888888888", "Email" => "soft_tech@abv.bg", "Description" => "I like this event.");
		$Booking = array("ApiToken" => $this->authCode, "EventIdentifier" => $bookableItems[0][EventIdentifier], "BookableItemId" => $bookableItems[0][EventIdentifier][BookableItems][Id], "EventScheduleId" => $bookableItems[0][EventScheduleId], "Courtesy" => "Mr.", "FirstName" => "Ta", "LastName" => "Kov", "PhoneNumber" => "+359888888888", "Email" => "soft_tech@abv.bg", "Description" => "I like this event.");
        $json_data = json_encode($Booking);
		
        $setEventBookig = @file_get_contents(apiUrl . 'Events/SetBooking', null, stream_context_create(array(
                        'http' => array(
                            'protocol_version' => 1.1,
                            'user_agent' => 'Booking Easy',
                            'method' => 'POST',
                            'header' => "Content-type: application/json\r\n" .
                            "Connection: close\r\n" .
                            "Content-length: " . strlen($json_data) . "\r\n",
                            'content' => $json_data,
                        ),
        )));



					
        $setBookingConfirmation = json_decode($setEventBookig, true);
		//$this->view->assign('bookingEventsDump', var_dump($setBookingConfirmation));
		//$this->view->assign('setBookingStatus', $validateAccount);
		$this->view->assign('setBookingStatus', $setBookingConfirmation);
		

		// SetBooking - end	
		
	}

	/**
	 * action show
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $events
	 * @return void
	 */
	public function showAction(\Iteration\SagendaBooking\Domain\Model\Events $events) {
		$this->view->assign('events', $events);
	}

	/**
	 * action new
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $newEvents
	 * @ignorevalidation $newEvents
	 * @return void
	 */
	public function newAction(\Iteration\SagendaBooking\Domain\Model\Events $newEvents = NULL) {
		$this->view->assign('newEvents', $newEvents);
	}

	/**
	 * action create
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $newEvents
	 * @return void
	 */
	public function createAction(\Iteration\SagendaBooking\Domain\Model\Events $newEvents) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->eventsRepository->add($newEvents);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $events
	 * @ignorevalidation $events
	 * @return void
	 */
	public function editAction(\Iteration\SagendaBooking\Domain\Model\Events $events) {
		$this->view->assign('events', $events);
	}

	/**
	 * action update
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $events
	 * @return void
	 */
	public function updateAction(\Iteration\SagendaBooking\Domain\Model\Events $events) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->eventsRepository->update($events);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Iteration\SagendaBooking\Domain\Model\Events $events
	 * @return void
	 */
	public function deleteAction(\Iteration\SagendaBooking\Domain\Model\Events $events) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->eventsRepository->remove($events);
		$this->redirect('list');
	}

}