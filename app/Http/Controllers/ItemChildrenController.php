<?php

namespace App\Http\Controllers;

use App\Dto\ItemChildrenPostPayload;
use App\Services\ItemChildrenService;
use Illuminate\Http\Request;

class ItemChildrenController extends Controller
{

    /**
     * @var ItemChildrenService
     */
    private $itemChildrenService;

    public function __construct(ItemChildrenService $itemChildrenService)
    {
        $this->itemChildrenService = $itemChildrenService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $itemId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $itemId)
    {
        $payload = json_decode($request->getContent());
        $payloadObj = new ItemChildrenPostPayload((int)$itemId, $payload);
        $storedItemCollection = $this->itemChildrenService->store($payloadObj);

        return response()->json($storedItemCollection);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $itemId
     * @return \Illuminate\Http\Response
     */
    public function show(int $itemId)
    {
        $itemCollection = $this->itemChildrenService->show($itemId);

        return response()->json($itemCollection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $itemId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $itemId)
    {
        $this->itemChildrenService->destroy($itemId);

        return response()->json(['success' => 'Items deleted']);
    }
}
