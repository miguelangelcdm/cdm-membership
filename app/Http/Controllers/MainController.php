<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class MainController extends Controller
{
    public function admin(): Response {
        return Inertia::render('admin/users');
    }
}
