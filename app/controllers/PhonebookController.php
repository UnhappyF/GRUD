<?php
declare(strict_types=1);
use Phalcon\Mvc\Model\Criteria;

use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class PhonebookController extends ControllerBase
{

    public function indexAction()
    {
	
    }
  
	public function searchAction()
	{

		
		$currentPage = (int) isset($_GET['page']) ? $_GET['page']:1;
	if ($this->request->isPost()) {
		$query = Criteria::fromInput($this->di, "People", $this->request->getPost());
		
		
		
		$people = People::find($query->getParams());
		$this->persistent->searchPeople = $people;

		
		
		
		} 

		
		$paginator = new Paginator(
			array(
				"data" => $this->persistent->searchPeople->toArray(),
				"limit" => 5, // Количество записей на страницу
				"page" => $currentPage // Активная страница
			)
		);

		$page = $paginator->Paginate();
		
		
		
		
		$this->view->page = $page;
	}

	public function newAction()
	{
			//for new contact form
	}

	public function editAction()
	{
			//for edit form
	}

	public function createAction()
	{
			//save from new form
	}

	public function saveAction()
	{
			//save from edit form
	}

	public function deleteAction($id)
	{

	}
}

