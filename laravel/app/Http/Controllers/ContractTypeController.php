<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractType;
use App\Http\Resources\ContractTypeResource;

class ContractTypeController extends Controller
{
    public function getContractTypes(Request $request){
        return ContractType::orderBy('sort')->get();
	}

	public function paginateContractTypes(Request $request)
	{
      	$request->validate([
          	'order_by' => 'required',
          	'per_page' => 'required|numeric',
          	'keyword' => 'required'
      	]);
      	$query = ContractType::query();
        
      	if($request->search!='')
      	{
          	$query->where('contract_type', 'like', "%$request->search%");
      	}
      	$contract_type_types = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
      	return ContractTypeResource::collection($contract_type_types);
	}

	public function addContractType(Request $request)
	{
		$data = $request->validate([
		    'contract_type' => 'required|unique:contract_types,contract_type',
		    'sort' => 'nullable'
		]);

		$contract_type = ContractType::create($data);
		return $contract_type;
	}

	public function getContractType(Request $request)
	{
		$request->validate([
		    'contract_type_id' => 'required|exists:award_types,contract_type_id'
		]);

	    $contract_type = ContractType::where('contract_type_id', $request->contract_type_id)->first();
	    return $contract_type;
	}

	public function updateContractType(Request $request)
	{
	    $data = $request->validate([
	        'contract_type_id' => 'required|exists:contract_types,contract_type_id',
	        'contract_type' => 'required|unique:contract_types,contract_type,'.$request->contract_type_id.',contract_type_id',
	        'sort' => 'nullable'
	    ]);

	    $contract_type = ContractType::where('contract_type_id', $request->contract_type_id)->first();
	    $contract_type->update($data);
	    return $contract_type;
	}

	public function deleteContractType(Request $request)
	{
	    $request->validate([
	        'contract_type_id' => 'required|exists:award_types,contract_type_id'
	    ]);

	    ContractType::where('contract_type_id', $request->contract_type_id)->delete();
	    return response()->json([
	        "message" => 'Award Deleted Successfully'
	    ]);
	}
}
