<?php
declare(strict_types=1);
use Phalcon\Mvc\Model\Criteria;

use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;


class PhonebookController extends ControllerBase
{

    public function indexAction()
    {
		$types = Typephonenumber::find();
		$this->view->types = $types;
		
		$groups = Group::find();
		$this->view->groups = $groups;
    }
  
	public function searchAction()
	{

		
		$currentPage = (int) isset($_GET['page']) ? $_GET['page']:1;

		if($this->request->isPost()){
			$this->persistent->searchParams = $this->request->getPost();
		}
		
		
		$ppls = $this->modelsManager->createBuilder();
		$ppls->from('Phonenumber');
		$ppls->where('People.name LIKE \''.$this->persistent->searchParams['name'].'%\'');
		$ppls->andWhere('Phonenumber.phoneNumber LIKE \''.$this->persistent->searchParams['phone'].'%\'');
		$ppls->andWhere('People.secondName LIKE \''.$this->persistent->searchParams['lastName'].'%\'');
		$ppls->andWhere('People.patronomic LIKE \''.$this->persistent->searchParams['fatherName'].'%\'');
		$ppls->andWhere('People.mail LIKE \''.$this->persistent->searchParams['email'].'%\'');
		$ppls->andWhere('People.organizationName LIKE \''.$this->persistent->searchParams['orgName'].'%\'');
		$ppls->andWhere('People.city LIKE \''.$this->persistent->searchParams['city'].'%\'');
		$ppls->andWhere('People.street LIKE \''.$this->persistent->searchParams['street'].'%\'');
		$ppls->andWhere('People.house LIKE \''.$this->persistent->searchParams['house'].'%\'');
		$ppls->andWhere('People.apNumber LIKE \''.$this->persistent->searchParams['ap'].'%\'');
		$ppls->andWhere('People.chosen LIKE \''.$this->persistent->searchParams['important'].'%\'');
		$ppls->andWhere('Phonenumber.idTypePhoneNumber LIKE \''.$this->persistent->searchParams['typeNumber'].'%\'');
		$ppls->andWhere('People.birth LIKE \''.$this->persistent->searchParams['birth'].'%\'');
		#$ppls->andWhere('People.note LIKE \''.$this->request->getPost()['note'].'%\'');
		$ppls->join('People');
		$ppls->join('Group');
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
		
		$types = Typephonenumber::find();
		$this->view->types = $types;
		
		$groups = Group::find();
		$this->view->groups = $groups;
	}

	public function newAction()
	{
		$types = Typephonenumber::find();
		$this->view->types = $types;
		
		$groups = Group::find();
		$this->view->groups = $groups;
	}

	public function editAction($number)
	{
			
			$phonenumber = Phonenumber::findFirst('phoneNumber = \''.$number.'\'');
			
			$people = People::findFirst('id = \''.$phonenumber->idPeople.'\'');
			
			$people->name = $this->request->getPost()['name'];
			
			$people->secondName = $this->request->getPost()['secondName'];
			
			$people->patronomic = $this->request->getPost()['fatherName'];
			$people->mail = $this->request->getPost()['mail'];
			
			$people->organizationName = $this->request->getPost()['orgName'];
			$people->city = $this->request->getPost()['city'];
			$people->street = $this->request->getPost()['street'];
			
			$people->house = $this->request->getPost()['house'];
			$people->apNumber = $this->request->getPost()['ap'];
			$people->birth = empty($this->request->getPost()['birth']) ? NULL:$this->request->getPost()['birth'];
			
			
			$people->peoplegroup->delete();
			$success = $people->save();
			if(isset($this->request->getPost()['groups'])){
			
			
		
			$group = new Group();
			$group->name = 'Test';
			$groups = Group::find([
				'id IN ({letter:array})',
				'bind' => [
				'letter' => $this->request->getPost()['groups']
				]
			]);
			
			$modules = [];
			foreach ($groups as $gr)
				array_push($modules,$gr);
			$people->groups = $modules;
		
		}
			$success = $people->save();
		
		
		
		
		
			
				
		
			
			$phonenumber->phoneNumber = $this->request->getPost()['phone'];
			$phonenumber->idTypePhoneNumber = $this->request->getPost()['typeNumber'];
			
			$success = $phonenumber->save();
			if ($success) {
				echo "Контакт обновлён!";
				echo $this->tag->linkTo("phonebook/search", "Перейти к справочнику");
				
			}else {
				echo "Ошибка: <br/>";
				foreach ($phonenumber->getMessages() as $message) {
					echo $message->getMessage(), "<br/>";
				}
			}
	}

	public function createAction()
	{
			
	$people = new people();
		
		$people->name = $this->request->getPost()['name'];
		$people->email = $this->request->getPost()['email'];
		$people->secondName = $this->request->getPost()['lastName'];
		
		$people->patronomic = $this->request->getPost()['fatherName'];
		$people->mail = $this->request->getPost()['email'];
		$people->note = $this->request->getPost()['note'];
	
		$people->chosen = isset($this->request->getPost()['important'])       ? $this->request->getPost()['important'] : '0';
		
		
		
		$people->organizationName = $this->request->getPost()['orgName'];
		$people->city = $this->request->getPost()['city'];
		$people->street = $this->request->getPost()['street'];
		
		$people->house = $this->request->getPost()['house'];
		$people->apNumber = $this->request->getPost()['ap'];
		
		$people->birth = empty($this->request->getPost()['birth']) ? NULL:$this->request->getPost()['birth'];
		
		
		if(isset($this->request->getPost()['groups'])){
		$people->peoplegroup = $this->request->getPost()['groups'];
		
	
		
		
		
		
			$group = new Group();
			$group->name = 'Test';
			$groups = Group::find([
				'id IN ({letter:array})',
				'bind' => [
				'letter' => $this->request->getPost()['groups']
				]
			]);
			
			$modules = [];
			foreach ($groups as $gr)
				array_push($modules,$gr);
			$people->groups = $modules;
		
		}
		
		$success = $people->save();
		
		
		
		
		
		
		
		if ($success) {
			
			$phonenumber = new phonenumber();
	
			$phonenumber->phoneNumber = $this->request->getPost()['phone'];
			$phonenumber->idTypePhoneNumber = $this->request->getPost()['typeNumber'];
			$phonenumber->idPeople = $people->id;
			$phonenumber->idOperator = 1;
			$success2 = $phonenumber->save();
			if ($success2) {
				echo "Контакт добавлен!";
				echo $this->tag->linkTo("phonebook/search", "Перейти к справочнику");
				echo $this->tag->linkTo("phonebook/new", "Добавить еще контакт");
			}else {
				echo "Ошибка: <br/>";
				foreach ($phonenumber->getMessages() as $message) {
					echo $message->getMessage(), "<br/>";
				}
			}
		} else {
			echo "Ошибка: <br/>";
			foreach ($people->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}
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
				echo $this->tag->linkTo("phonebook/search", "Перейти к справочнику");
				echo 'Телефон был успешно удален!';
			}
		}
	}
}

