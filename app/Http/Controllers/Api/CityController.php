<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Helpers\ApiFormatter;
use App\Models\CityModel;


class CityController extends Controller
{
    public function index(Request $request)
    {
        $province = CityModel::orderby('city_id', 'ASC')->get();
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
                    'province' => 'required',
                    'type' => 'required',
                    'name' => 'required',
                ],
                [
                    'province.required' => 'Province id is required',
                    'type.required' => 'City Type is required',
                    'name.required' => 'City Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $city = [
                'province_id' => $params['province'],
                'city_type' => $params['type'],
                'city_name' => $params['name'],
            ];

            $data = CityModel::create($city);
            $createdCity = CityModel::find($data->city_id);

            $response = ApiFormatter::createJson(200, 'Create city success', $createdCity);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function detail($id)
    {
        try {
            $city = CityModel::find($id);

            if (is_null($city)) {
                return ApiFormatter::createJson(404, 'city not found');
            }

            $response = ApiFormatter::createJson(200, 'Get detail city sucess', $city);
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

            $preCity = CityModel::find($id);
            if (is_null($preCity)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $validator = Validator::make(
                $params,
                [
                    'province' => 'required',
                    'type' => 'required',
                    'name' => 'required',
                ],
                [
                    'province.required' => 'Province id is required',
                    'type.required' => 'City Type is required',
                    'name.required' => 'City Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $city = [
                'province_id' => $params['province'],
                'city_type' => $params['type'],
                'city_name' => $params['name'],
            ];

            $preCity->update($city);
            $updatedCity = $preCity->fresh();

            $response = ApiFormatter::createJson(200, 'Update city success', $updatedCity);
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

            $preCity = CityModel::find($id);
            if (is_null($preCity)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            if (isset($params['province'])) {
                $validator = Validator::make(
                    $params,
                    [
                        'province' => 'required',
                    ],
                    [
                        'province.required' => 'Province id is required',
                    ]
                );

                if ($validator->fails()) {
                    $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                    return response()->json($response);
                }

                $city['province_id'] = $params['province'];
            }

            if (isset($params['type'])) {
                $validator = Validator::make(
                    $params,
                    [
                        'type' => 'required',
                    ],
                    [
                        'type.required' => 'City Type is required',
                    ]
                );

                if ($validator->fails()) {
                    $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                    return response()->json($response);
                }

                $city['city_type'] = $params['type'];
            }

            if (isset($params['name'])) {
                $validator = Validator::make(
                    $params,
                    [
                        'name' => 'required',
                    ],
                    [
                        'name.required' => 'City Name is required',
                    ]
                );

                if ($validator->fails()) {
                    $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                    return response()->json($response);
                }

                $city['city_name'] = $params['name'];
            }

            $preCity->update($city);
            $updatedCity = $preCity->fresh();

            $response = ApiFormatter::createJson(200, 'Update city success', $updatedCity);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function delete($id)
    {
        try {
            $city = CityModel::find($id);

            if (is_null($city)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $city->delete();

            $response = ApiFormatter::createJson(200, 'Delete city success');
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }
}
