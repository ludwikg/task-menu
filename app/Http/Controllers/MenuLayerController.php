<?php

namespace App\Http\Controllers;

use App\Services\MenuLayerService;
use Illuminate\Http\Request;

class MenuLayerController extends Controller
{

    /**
     * @var MenuLayerService
     */
    private $menuLayerService;

    public function __construct(MenuLayerService $menuLayerService)
    {
        $this->menuLayerService = $menuLayerService;
    }

    /**
     * Display the specified resource.
     *
     * @param int $menuId
     * @param  int $depth
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId, int $depth)
    {
        $itemCollection = $this->menuLayerService->show($menuId, $depth);

        return response()->json($itemCollection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $menuId
     * @param int $depth
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $menuId, int $depth)
    {
        $this->menuLayerService->destroy($menuId, $depth);

        return response()->json(['success' => 'Layer Removed']);
    }
}
