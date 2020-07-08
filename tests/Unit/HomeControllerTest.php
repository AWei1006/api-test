<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\User;
use Exception;

class HomeControllerTest extends TestCase
{

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     *  會員使用者
     *
     * @var
     */
    protected $account;

    /**
     *  會員使用者密碼
     *
     * @var
     */
    protected $password;

    /**
     * @var string
     */
    protected $submitUrl = '';

    /**
     * @var
     */
    protected $HomeController;

    /**
     * 建立會員測試
     *
     * @return void
     */
    public function testCreateMember()
    {
        try {
            // Arrange
            $this->client = new GuzzleClient();
            $this->submitUrl = 'http://localhost';

            // 創建使用者
            $this->user = new User();

            $this->user->account = 'a1111b222';
            $this->user->password = 'c3333d444';

            // 建立controller
            $this->HomeController = new HomeController();

            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'Account' =>  $this->user->account,
                'Password' => $this->user->password,
            ]);

            // Act
            $response = $this->HomeController->createMember($request);
            $arrayData = json_decode($response->getContent(), true);
            // Assert
            $this->assertEquals(0, array_get($arrayData, 'Code'));
        } catch (Exception $exception) {
            // 帳號已重複
            $this->assertEquals(1, array_get($arrayData, 'Code'));
        }
    }
    /**
     * 刪除會員
     *
     * @return void
     */
    public function testDeleteMember()
    {
        try {
            // Arrange
            $this->client = new GuzzleClient();
            $this->submitUrl = 'http://localhost';

            // 創建使用者
            $this->user = new User();

            $this->user->account = 'a1111b222';
            $this->user->password = 'c3333d444';

            // 建立controller
            $this->HomeController = new HomeController();

            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'Account' =>  $this->user->account,
                'Password' => $this->user->password,
            ]);

            // Act
            $response = $this->HomeController->deleteMember($request);
            $arrayData = json_decode($response->getContent(), true);
            // Assert
            $this->assertEquals(0, array_get($arrayData, 'Code'));
        } catch (Exception $exception) {
            // 帳號不存在
            $this->assertEquals(1, array_get($arrayData, 'Code'));
        }
    }
    /**
     * 會員更改密碼
     *
     * @return void
     */
    public function testChangePassword()
    {
        try {
            // Arrange
            $this->client = new GuzzleClient();
            $this->submitUrl = 'http://localhost';

            // 創建使用者
            $this->user = new User();

            $this->user->account = 'a1111b222';
            $this->user->password = 'c3333d444';

            // 建立controller
            $this->HomeController = new HomeController();

            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'Account' =>  $this->user->account,
                'Password' => $this->user->password,
            ]);

            // Act
            $response = $this->HomeController->changePassword($request);
            $arrayData = json_decode($response->getContent(), true);
            // Assert
            $this->assertEquals(0, array_get($arrayData, 'Code'));
        } catch (Exception $exception) {
            // 帳號不存在
            $this->assertEquals(1, array_get($arrayData, 'Code'));
        }
    }
    /**
     * 驗證帳號密碼
     *
     * @return void
     */
    public function testLogin()
    {
        try {
            // Arrange
            $this->client = new GuzzleClient();
            $this->submitUrl = 'http://localhost';

            // 創建使用者
            $this->user = new User();

            $this->user->account = 'a1111b222';
            $this->user->password = 'c3333d444';

            // 建立controller
            $this->HomeController = new HomeController();

            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'Account' =>  $this->user->account,
                'Password' => $this->user->password,
            ]);

            // Act
            $response = $this->HomeController->createMember($request);
            $arrayData = json_decode($response->getContent(), true);
            // Assert
            $this->assertEquals(0, array_get($arrayData, 'Code'));
        } catch (Exception $exception) {
            // 會員帳號不存在
            $this->assertEquals(1, array_get($arrayData, 'Code'));
        }
    }
}
