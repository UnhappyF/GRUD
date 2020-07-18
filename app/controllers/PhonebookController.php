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

		
	
		
		
		$ppls = $this->modelsManager->createBuilder();
		$ppls->from('Phonenumber');
		$ppls->where('People.name LIKE \''.$this->request->getPost()['name'].'%\'');
		$ppls->andWhere('Phonenumber.phoneNumber LIKE \''.$this->request->getPost()['phone'].'%\'');
		$ppls->andWhere('People.secondName LIKE \''.$this->request->getPost()['lastName'].'%\'');
		$ppls->andWhere('People.patronomic LIKE \''.$this->request->getPost()['fatherName'].'%\'');
		$ppls->andWhere('People.mail LIKE \''.$this->request->getPost()['email'].'%\'');
		$ppls->andWhere('People.organizationName LIKE \''.$this->request->getPost()['orgName'].'%\'');
		$ppls->andWhere('People.city LIKE \''.$this->request->getPost()['city'].'%\'');
		$ppls->andWhere('People.street LIKE \''.$this->request->getPost()['street'].'%\'');
		$ppls->andWhere('People.house LIKE \''.$this->request->getPost()['house'].'%\'');
		$ppls->andWhere('People.apNumber LIKE \''.$this->request->getPost()['ap'].'%\'');
		#$ppls->andWhere('People.note LIKE \''.$this->request->getPost()['note'].'%\'');
		$ppls->join('People');
		$ppls->getQuery();
		
	


		
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

	public function deleteAction($number)
	{
		$Phone = Phonenumber::find('phoneNumber = \''.$number.'\'');

		if ($Phone !== false) {
			if ($Phone->delete() === false) {
				echo "К сожалению, мы не можем удалить телефон прямо сейчас: \n";

				$messages = $Phone->getMessages();

				foreach ($messages as $message) {
					echo $message, "\n";
				}
			} else {
				echo 'Телефон был успешно удален!';
			}
		}
	}
}

