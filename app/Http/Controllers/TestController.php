<?php

namespace App\Http\Controllers;

use App\Events\TestUserCreated;
use App\Events\TestUserOut;
use App\Models\Test;
use App\Models\TestUser;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function Out(Request $request)
    {
        $test_user = TestUser::query()
            ->where('test_id', $request->test_id)
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->first();
        $test_user->status = TestUser::OUT;
        $test_user->save();
        event(new TestUserOut($test_user->test_id, $test_user->user_id));
        return response()->json(['success' => true]);

    }

    public function In(Request $request)
    {
        if (auth()->check()) {
            $test_user = TestUser::query()
                ->where('test_id', $request->input('test_id'))
                ->where('user_id', auth()->user()->getAuthIdentifier())
                ->with(['user', 'test'])
                ->first();

            if (!$test_user) {
                $test_user = new TestUser();
                $test_user->test_id = $request->input('test_id');
                $test_user->user_id = auth()->user()->getAuthIdentifier();
                $test_user->status = TestUser::IN;
                $test_user->save();
                $test_user->load(['user', 'test']);
            } else {
                $test_user->status = TestUser::IN;
                $test_user->save();
            }
            event(new TestUserCreated($test_user));

            return redirect(url('test/enter/' . $request->input('test_id')));

        } else {

            return redirect('/login');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Test $test
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * //     */
    public function show($id)
    {
        $test_users = TestUser::query()
            ->where('test_id', $id)
            ->where('status', TestUser::IN)
            ->with(['test', 'user'])
            ->get();
        foreach ($test_users as $test_user) {
            if ($test_user->user_id === auth()->user()->getAuthIdentifier()) {
                return view('test.show', ['test_users' => $test_users, 'test' => Test::query()->find($id)]);
            } else {

            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Test $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Test $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Test $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
