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

    public function variants(){
        $variants = [
            [
                'value' => 0,
                'img' => asset('assets/images/false.png'),
            ],
            [
                'value' => 1,
                'img' => asset('assets/images/true.png'),
            ]
        ];
        return response()->json([
            'success' => true,
            'variants' => $variants
        ]);
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
        $variants = [
            [
                'id' => Test::TEST_TYPE_TRUE_FALSE,
                'img' => asset('assets/images/truefalse.png')
            ],
            [
                'id' => Test::TEST_TYPE_FOUR_VARIANTS,
                'img' => asset('assets/images/fourvariants.png')
            ]
        ];
        return view('test.admin.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if (in_array( (int)$request->type_id, [Test::TEST_TYPE_FOUR_VARIANTS, Test::TEST_TYPE_TRUE_FALSE])){
            $test = new Test();
            $test->name = $request->input('name');
            $test->user_id = auth()->user()->getAuthIdentifier();
            $test->type_id = $request->input('type_id');
            $res = $test->save();

            return response()->json([
                'success' => true,
                'test' => $test
            ]);
        }

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
