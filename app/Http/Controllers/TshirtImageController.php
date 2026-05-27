<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Discipline;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CourseFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CourseController extends Controller implements HasMiddleware
{
    use \App\Traits\CourseImageFileStorage;

    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\Course', only: ['index']),
            new Middleware('can:create,App\Models\Course', only: ['create', 'store']),
            new Middleware('can:viewShowCase,App\Models\Course', only: ['showCase']),
            new Middleware('can:viewCurriculum,App\Models\Course', only: ['showCurriculum']),
            new Middleware('can:view,course', only: ['show']),
            new Middleware('can:update,course', only: ['edit', 'update']),
            new Middleware('can:delete,course', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $allTshirt_images = Tshirt_image::orderBy('type')->orderBy('name')->paginate(20);
        //debug($allTshirt_images);
        return view('tshirt_images.index')->with('tshirt_images', $allTshirt_images);
    }
}