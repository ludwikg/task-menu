<?php

namespace App\Http\Controllers;

use App\Entities\ItemFactory;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // I assumed that every Item has to be connected to the menu, so I decided to also add menuId as a required field in payload
        $payload = json_decode($request->getContent());
        $item = ItemFactory::createFromPayload($payload);
        $this->itemService->store($item);

        return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $itemId
     * @return \Illuminate\Http\Response
     */
    public function show(int $itemId)
    {
        $item = $this->itemService->show($itemId);

        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $itemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
        $item = ItemFactory::createFromPayload(json_decode($request->getContent()));
        $this->itemService->update($itemId, $item);

        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $itemId
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $this->itemService->delete($itemId);

        return response()->json(['success' => 'Item deleted']);
    }
}
