<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Tools\Md5Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ToolController extends Controller
{
    public $tool;
    public $instance;

    public function __construct()
    {
        $tool = Route::current()->parameter('tool');
        $this->tool = Tool::withTranslation()->slug($tool)->active()->firstOrFail();

        if (!class_exists($this->tool->class_name) && (!method_exists($this->tool->class_name, 'render') || !method_exists($this->tool->class_name, 'handle'))) {
            abort(404);
        }

        $this->instance = new $this->tool->class_name();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return  $this->instance->render($request, $this->tool);
    }

    /**
     *
     */
    public function handle(Request $request)
    {
        return  $this->instance->handle($request, $this->tool);
    }
}
