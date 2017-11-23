<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Test Controller
 *
 * @property \App\Model\Table\TestTable $Test
 */
class ApiController extends AppController
{

	// Contoroller
	public function initialize() {
		parent::initialize();
		$this->loadComponent('RequestHandler'); // これを追加
	}
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	// 今回はJSONのみを返すためViewのレンダーを無効化
    	$this->autoRender = false;
    	// Ajax以外の通信の場合
/*    	if(!$this->request->is('ajax')) {
    		throw new BadRequestException();
    	} */

    	$status = true;
    	$result = array("テスト１","テスト２","テスト３");
    	$error = false;
    	
    	$articles = json_encode(array($status,$result,$error));
    	$comments = "tt";
    	
    	// シリアライズする必要があるビュー変数をセットする
        $this->set(compact('articles', 'comments'));
        // JsonView がシリアライズするべきビュー変数を指定する
    	$this->set('_serialize', ['articles', 'comments']);
    	
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $test = $this->Test->get($id, [
            'contain' => []
        ]);

        $this->set('test', $test);
        $this->set('_serialize', ['test']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $test = $this->Test->newEntity();
        if ($this->request->is('post')) {
            $test = $this->Test->patchEntity($test, $this->request->data);
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
        $this->set('_serialize', ['test']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $test = $this->Test->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Test->patchEntity($test, $this->request->data);
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
        $this->set('_serialize', ['test']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Test->get($id);
        if ($this->Test->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
