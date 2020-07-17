<?php
declare(strict_types=1);
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PhonebookController extends ControllerBase
{

    public function indexAction()
    {
	
    }
  
	public function searchAction()
	{

		$query = Criteria::fromInput($this->di, "People", $this->request->getPost());
		
		
		$people = People::find($query->getParams());
if (count($people) == 0) {
$this->flash->notice("Поиск не нашел никаких продуктов");
return $this->forward("phonebook/index");
}

		
		$paginator = new Paginator(
array(
"data" => $people, // Данные для пагинации
"limit" => 5, // Количество записей на страницу
"page" => 1 // Активная страница
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

