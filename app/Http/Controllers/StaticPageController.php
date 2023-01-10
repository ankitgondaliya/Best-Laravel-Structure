<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaticPageRequest;
use Exception;
use App\Models\StaticPage;
use phpDocumentor\Reflection\Types\ArrayKey;

class StaticPageController extends Controller
{
    // Show static pages data.
    public function index($page)
    {
        // add static page title and slug
        $pages = [
            'terms-and-conditions' => "Terms and Conditions",
            'privacy-policy' => 'Privacy Policy',
        ];
        if(!in_array($page ,array_keys($pages))){
            abort(404);
        }
        $title = $pages[$page];
        $pageData = ['title' => $title,'slug' => $page,'data' => $title];
        $data = StaticPage::firstOrCreate(['slug' => $page],$pageData);
        return view('static_page.index',compact('data','title'));
    }

    // Store static page data funcation.
    public function store(StaticPageRequest $request)
    {
        try{
            $StaticPage = StaticPage::where('id',$request->id)->first();
            $title = $StaticPage->title;
            $StaticPage->update(['data' => $request->data]);
            return success($title.' updated successfully');
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }
}
