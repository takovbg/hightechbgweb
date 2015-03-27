<?php
namespace Iteration\SagendaBooking\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Iteration\SagendaBooking\Controller\EventsController.
 *
 */
class EventsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Iteration\SagendaBooking\Controller\EventsController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Iteration\\SagendaBooking\\Controller\\EventsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllEventssFromRepositoryAndAssignsThemToView() {

		$allEventss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$eventsRepository = $this->getMock('Iteration\\SagendaBooking\\Domain\\Repository\\EventsRepository', array('findAll'), array(), '', FALSE);
		$eventsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allEventss));
		$this->inject($this->subject, 'eventsRepository', $eventsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('eventss', $allEventss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenEventsToView() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('events', $events);

		$this->subject->showAction($events);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenEventsToView() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newEvents', $events);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($events);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenEventsToEventsRepository() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$eventsRepository = $this->getMock('Iteration\\SagendaBooking\\Domain\\Repository\\EventsRepository', array('add'), array(), '', FALSE);
		$eventsRepository->expects($this->once())->method('add')->with($events);
		$this->inject($this->subject, 'eventsRepository', $eventsRepository);

		$this->subject->createAction($events);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenEventsToView() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('events', $events);

		$this->subject->editAction($events);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenEventsInEventsRepository() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$eventsRepository = $this->getMock('Iteration\\SagendaBooking\\Domain\\Repository\\EventsRepository', array('update'), array(), '', FALSE);
		$eventsRepository->expects($this->once())->method('update')->with($events);
		$this->inject($this->subject, 'eventsRepository', $eventsRepository);

		$this->subject->updateAction($events);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenEventsFromEventsRepository() {
		$events = new \Iteration\SagendaBooking\Domain\Model\Events();

		$eventsRepository = $this->getMock('Iteration\\SagendaBooking\\Domain\\Repository\\EventsRepository', array('remove'), array(), '', FALSE);
		$eventsRepository->expects($this->once())->method('remove')->with($events);
		$this->inject($this->subject, 'eventsRepository', $eventsRepository);

		$this->subject->deleteAction($events);
	}
}
