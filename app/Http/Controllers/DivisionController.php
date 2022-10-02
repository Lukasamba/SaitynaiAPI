<?php

namespace App\Http\Controllers;

use App\Http\Requests\Division\CreateDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;
use App\Http\Responses\Division\DivisionResponse;
use App\Http\Responses\Division\DivisionsTableResponse;
use App\Models\Division;
use Illuminate\Http\JsonResponse;

class DivisionController extends Controller
{
    public function getList(): JsonResponse
    {
        $divisions = DivisionsTableResponse::collection(Division::all());

        return response()->json($divisions);
    }

    public function createDivision(CreateDivisionRequest $request): JsonResponse
    {
        $division = new Division($request->all());

        $division->save();

        return response()->json();
    }

    public function getDivision(Division $division): JsonResponse
    {
        return response()->json(DivisionResponse::from($division));
    }

    public function updateDivision(UpdateDivisionRequest $request, Division $division): JsonResponse
    {
        $division->fill($request->all());

        $division->save();

        return response()->json(DivisionResponse::from($division));
    }

    public function deleteDivision(Division $division): JsonResponse
    {
        $division->delete();

        return response()->json();
    }
}
