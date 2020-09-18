<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return DB::table('categories')->get();
    }

    public function pagination($per = 10)
    {
        $categories = DB::table('categories')->paginate($per);
        return response($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'lang_id'=>'integer',
                'keyword'=>'string',
                'description'=>'string',
            ]);

            $langId = $request->input('lang_id', 1);

            $userFromToken = request()->user();

            $result = DB::table('categories')->insert([
                'name'=>$request->name,
                'keyword'=>$request->keyword,
                'description'=>$request->description,
                'slug'=>uniqid(),
                'user_id'=>$userFromToken->id,
                'lang_id'=>$langId
            ]);
            return $result == 1 ? response(['status'=>'ok']) : response(['status'=>'unsuccessful']);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        try {
            $request->validate([
                'name' => 'string',
                'lang_id'=>'integer',
                'keyword'=>'string',
                'description'=>'string',
            ]);

            $langId = $request->input('lang_id', 1);

            $userFromToken = request()->user();

            $result = DB::table('categories')->where('slug', $slug)->update([
                'name'=>$request->name,
                'keyword'=>$request->keyword,
                'description'=>$request->description,
                'slug'=>uniqid(),
                'user_id'=>$userFromToken->id,
                'lang_id'=>$langId
            ]);
            return $result == 1 ? response(['status'=>'ok']) : response(['status'=>'unsuccessful']);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $result = DB::table('categories')->where('slug','=',$slug)->delete();
        return $result == 1 ? response(['status'=>'ok']) : response(['status'=>'unsuccessful']);
    }
}
