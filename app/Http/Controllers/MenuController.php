<?php

namespace App\Http\Controllers;

use App\Entities\MenuFactory;
use App\Services\MenuService;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menuId)
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
