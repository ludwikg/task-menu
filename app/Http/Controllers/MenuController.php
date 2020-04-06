<?php

namespace App\Http\Controllers;

use App\Entities\MenuFactory;
use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Services\MenuService;

class MenuController extends Controller
{
    /**
     * @var MenuService
     */
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $menu = MenuFactory::fromRequestObject(json_decode($request->getContent()));
        $this->menuService->store($menu);

        return response()->json($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId)
    {
        $menu = $this->menuService->getById($menuId);

        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     *=
     * @param MenuUpdateRequest $request
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function update(MenuUpdateRequest $request, $menuId)
    {
        $menu = MenuFactory::fromRequestObject(json_decode($request->getContent()));
        $this->menuService->update($menuId, $menu);

        return response()->json($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $menuId)
    {
        $this->menuService->destroy($menuId);

        return response()->json(['success' => 'Menu deleted']);
    }
}
