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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$events = $this->eventsRepository->findAll();
		$this->view->assign('events', $events);
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