<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Helpers\ApiFormatter;
use App\Models\ProvinceModel;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $province = ProvinceModel::orderby('province_id', 'ASC')->get();
        $response = ApiFormatter::createJson(200, 'Get Data Success', $province);
        return response()->json($response);
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();

            $validator = Validator::make(
                $params,
                [
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'code.required' => 'Province Code is required',
                    'code.max'      => 'Province Code must not exceed 10 characters',
                    'name.required' => 'Province Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $province = [
                'province_code' => $params['code'],
                'province_name' => $params['name'],
            ];

            $data = ProvinceModel::create($province);
            $createdProvince = ProvinceModel::find($data->province_id);

            $response = ApiFormatter::createJson(200, 'Create province success', $createdProvince);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function detail($id)
    {
        try {
            $province = ProvinceModel::find($id);

            if (is_null($province)) {
                return ApiFormatter::createJson(404, 'province not found');
            }

            $response = ApiFormatter::createJson(200, 'Get detail province sucess', $province);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(400, $e->getMessage());
            return response()->json($response);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();

            $preProvince = ProvinceModel::find($id);
            if (is_null($preProvince)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $validator = Validator::make(
                $params,
                [
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'code.required' => 'Province Code is required',
                    'code.max'      => 'Province Code must not exceed 10 characters',
                    'name.required' => 'Province Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $province = [
                'province_code' => $params['code'],
                'province_name' => $params['name'],
            ];

            $preProvince->update($province);
            $updatedProvince = $preProvince->fresh();

            $response = ApiFormatter::createJson(200, 'Update province success', $updatedProvince);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function patch(Request $request, $id)
    {
        try {
            $params = $request->all();

            $preProvince = ProvinceModel::find($id);
            if (is_null($preProvince)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            if (isset($params['code'])) {
                $validator = Validator::make(
                    $params,
                    [
                        'code' => 'required|max:10',
                    ],
                    [
                        'code.required' => 'Province Code is required',
                        'code.max' => 'Province Code must not exceed 10 characters',
                    ]
                );

                if ($validator->fails()) {
                    $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                    return response()->json($response);
                }

                $province['province_code'] = $params['code'];
            }

            if (isset($params['name'])) {
                $validator = Validator::make(
                    $params,
                    [
                        'name' => 'required',
                    ],
                    [
                        'name.required' => 'Province Name is required',
                    ]
                );

                if ($validator->fails()) {
                    $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                    return response()->json($response);
                }

                $province['province_name'] = $params['name'];
            }

            $preProvince->update($province);
            $updatedProvince = $preProvince->fresh();

            $response = ApiFormatter::createJson(200, 'Update province success', $updatedProvince);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function delete($id)
    {
        try {
            $province = ProvinceModel::find($id);

            if (is_null($province)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $province->delete();

            $response = ApiFormatter::createJson(200, 'Delete province success');
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }
}
