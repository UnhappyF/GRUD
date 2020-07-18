<?php
declare(strict_types=1);
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

class PhonebookController extends ControllerBase
{

    public function indexAction()
    {
	
    }
  
	public function searchAction()
	{

		
		$currentPage = (int) isset($_GET['page']) ? $_GET['page']:1;
		
	
		
		
		
		/*
		$query = Criteria::fromInput($this->di, "Phonenumber", $this->request->getPost());
		$query->join("People", "People.id = Phonenumber.idPeople", "r");
		$this->view->tmp = Phonenumber::find($query->getParams());
		
		$Phonenumber = Phonenumber::find($query->getParams());
		$this->persistent->searchPeople = $Phonenumber;

		*/
		
		$ppls = $this->modelsManager->createBuilder();
		$ppls->from('Phonenumber');
		$ppls->join('People');
		$ppls->orderBy('People.name');
		$ppls->getQuery();
		
	
		/*$tmpAr = $this->persistent->searchPeople->toArray();
		$i=0;
		foreach($tmpAr as $phone){
			$j=0;
			foreach($this->persistent->searchPeople as $ppl){
			
				if($i==$j)
					$phone += $ppl->getPeople()->toArray();
				
				$j++;
			
			
			}
			
			$aa[$i] = $phone;
			$i++;
			
		}
		*/

		
		$paginator = new Paginator(
			array(
				"builder" => $ppls,
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

