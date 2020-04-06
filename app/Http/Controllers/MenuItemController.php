<?php

namespace App\Http\Controllers;

use App\Entities\ItemCollectionFactory;
use App\Http\Requests\MenuItemStoreRequest;
use App\Services\MenuItemService;

class MenuItemController extends Controller
{
    /**
     * @var MenuItemService
     */
    private $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuItemStoreRequest $request
     * @param int $menuId
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemStoreRequest $request, int $menuId)
    {
        $payload = json_decode($request->getContent());
        $itemCollection = ItemCollectionFactory::createFromPayload($payload, $menuId);
        $this->menuItemService->store($itemCollection);

        return response()->json($itemCollection);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId)
    {
        $itemCollection = $this->menuItemService->getByMenuId($menuId);

        return response()->json($itemCollection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $menuId)
    {
        $this->menuItemService->deleteByMenuId($menuId);

        return response()->json(['success'=>'Items deleted']);
    }
}
