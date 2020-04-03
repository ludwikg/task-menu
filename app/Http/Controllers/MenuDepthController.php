<?php

namespace App\Http\Controllers;

use App\Services\MenuDepthService;

class MenuDepthController extends Controller
{
    /**
     * @var MenuDepthService
     */
    private $menuDepthService;

    public function __construct(MenuDepthService $menuDepthService)
    {
        $this->menuDepthService = $menuDepthService;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $menuId
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId)
    {
        $depth = $this->menuDepthService->getDepth($menuId);

        return response()->json(['depth'=>$depth]);
    }
}
