<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * 會員
     * @var
     */
    public $member;

    public function selectMember($account)
    {
        $this->member = DB::table('users')
        ->select([
            'users.account',
            'users.password',
        ])
        ->where('account', $account)
        ->first();

        return $this->member;
    }

    /**
     * 檢查會員是否重複
     *
     * @param string $account
     * @return bool
     */
    public function isMemberRepeat($account): bool
    {
        $isStatusActive = (data_get($this->member, 'account') == $account);

        return $isStatusActive;
    }

    /**
     * 新增會員
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMember(Request $request)
    {
        $params = $request->all();

        $account = array_get($params, 'Account');

        // 檢查會員是否存在
        $this->selectMember($account);

        // 檢查會員帳號是否重複
        if ($this->isMemberRepeat($account)) {
            return response()->json(
                [
                    "Code" => 1,
                    "Message" => $account. ' 此帳號已重複',
                    "Result" =>
                    [
                        "IsOK" => false,
                    ]
                ],
                400
            );
        }
        try {

            // 新增帳號
            DB::table('users')->insert(
                [
                    'account' => $account,
                    'password' => array_get($params, 'Password')
                ]
            );

            return response()->json(
                [
                    "Code" => 0,
                    "Message" => '帳號建立成功',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],
                200
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    "Code" => 2,
                    "Message" => '帳號建立失敗',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],500
            );
        }

    }

    /**
     * 刪除會員
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteMember(Request $request)
    {
        $params = $request->all();
        $account = array_get($params, 'Account');
        // 檢查會員帳號是否存在
        if (!$this->selectMember($account)) {
            return response()->json(
                [
                    "Code" => 1,
                    "Message" => $account. ' 此帳號不存在',
                    "Result" =>
                    [
                        "IsOK" => false,
                    ]
                ],
                400
            );
        }

        try {
            DB::beginTransaction();

            // 刪除帳號
            DB::table('users')
                ->where('account', $account)
                ->delete();

            DB::commit();
            return response()->json(
                [
                    "Code" => 0,
                    "Message" => '帳號刪除成功',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],
                200
            );
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(
                [
                    "Code" => 2,
                    "Message" => '帳號刪除失敗',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],500
            );
        }

    }

    /**
     * 更改密碼
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */

    public function changePassword(Request $request)
    {
        $params = $request->all();

        $account = array_get($params, 'Account');
        // 檢查會員帳號是否存在
        if (!$this->selectMember($account)) {
            return response()->json(
                [
                    "Code" => 1,
                    "Message" => $account. ' 此帳號不存在',
                    "Result" =>
                    [
                        "IsOK" => false,
                    ]
                ],
                400
            );
        }

        try {
            DB::beginTransaction();

            // 更改密碼
            DB::table('users')
                ->where('account', $account)
                ->update([
                    'password' => array_get($params, 'Password')
                ]
            );

            DB::commit();
            return response()->json(
                [
                    "Code" => 0,
                    "Message" => '更改會員密碼成功',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],
                200
            );
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(
                [
                    "Code" => 2,
                    "Message" => '密碼更新失敗',
                    "Result" =>
                    [
                        "IsOK" => true,
                    ]
                ],500
            );
        }
    }

    /**
     * 驗證帳號密碼
     * @param array $params
     * @return void
     */
    public function login(Request $request)
    {
        $params = $request->all();

        $account = array_get($params, 'Account');
        // 檢查會員帳號是否存在
        if (!$this->selectMember($account)) {
            return response()->json(
                [
                    'Code' => '2',
                    'Message' => 'Login Failed',
                    'Result' => null
                ], 400
            );
        }

        return response()->json(
            [
                "Code" => 0,
                "Message" => '驗證帳號密碼成功',
                "Result" => null
            ],
            200
        );
    }

}
