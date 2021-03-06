<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePhoneRequest;
use App\Http\Requests\Auth\LocationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Models\API\auth\RegisterResult;
use App\services\FillApiModelService;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


/**
 * Class AuthController
 */

class AuthController extends Controller
{

    /**
     * @OA\Post(path="/student/register",
     *     tags={"Auth Student"},
     *     summary="Register as a new Student",
     *     operationId="authRegister",
     *     @OA\Parameter(
     *         name="Language",
     *         in="header",
     *         description="(en or ar) If left empty it is English",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Registration model",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterModel")
     *     ),
     *     @OA\Response(
     *         response = 200,
     *         description = "RegisterResult response",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResultRegisterResult"),
     *     ),
     * )
     * @param RegisterRequest $request
     * @return string
     */

    public function register(RegisterRequest $request)
    {

        list($res, $data, $msg , $ex) = UserService::apiProfileCreate($request);

        if($res){
            return response()->json($data);
        } else {
            return returnError($msg , $ex);
        }
    }

    /**
     * @OA\Post(path="/student/login",
     *     tags={"Auth Student"},
     *     summary="Login as a Student",
     *     operationId="authLogin",
     *     @OA\Parameter(
     *         name="Language",
     *         in="header",
     *         description="(en or ar) If left empty it is English",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Login model",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginPayload")
     *     ),
     *     @OA\Response(
     *         response = 200,
     *         description = "User Profile response",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResultApi"),
     *     ),
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     */

    public function login(LoginRequest $request)
    {
        list($res, $data, $msg , $ex) = UserService::login($request);

        if($res){
            return response()->json($data);
        } else {
            return returnError($msg , $ex);
        }
    }


    /**
     * @OA\Get(path="/student/profile",
     *     tags={"Auth Student"},
     *     summary="Get profile details",
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *         name="Language",
     *         in="header",
     *         description="(en or ar) If left empty it is English",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response = 200,
     *         description = "ApiResultProfileResult response",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResultProfileAdminResult"),
     *     ),
     * )
     */

    public function profile()
    {
        if(student()=="student")
        {
            $data = FillApiModelService::FillProfileResultModel(user());
            $data = FillApiModelService::FillApiResultProfileAdminResult($data);
            return response()->json($data);
        }
        else
        {
           return returnError('must be authenticated');
        }

    }

    /**
     * @OA\Post(path="/student/update-profile",
     *     tags={"Auth Student"},
     *     summary="Edit profile content",
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *         name="Language",
     *         in="header",
     *         description="(en or ar) If left empty it is English",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *              @OA\Schema(ref="#components/schemas/EditProfileAdminRequest"),
     *        )
     *     ),
     *     @OA\Response(
     *         response = 200,
     *         description = "ApiResultProfileResult response",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResult"),
     *     ),
     * )
     * @param Request $request
     * @return JsonResponse
     */

    public function update_profile(Request $request)
    {
        if(student()=="student") {
            return UserService::ProfileUpdate($request);
        }
        else
            {
                return  returnError('must be authenticated');
            }
    }

    /**
     * @OA\Post(path="/student/logout",
     *     tags={"Auth Student"},
     *     summary="Log out from system",
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *         name="Language",
     *         in="header",
     *         description="(en or ar) If left empty it is English",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response = 200,
     *         description = "Success response",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResult"),
     *     ),
     * )
     * @param $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        return UserService::apiLogOut($request);
    }







}
