<?php

namespace App\Http\Controllers;

use App\Events\TestUserCreated;
use App\Events\TestUserOut;
use App\Models\Test;
use App\Models\TestUser;
use Illuminate\Http\Request;

class TestController extends Controller
{


    public $variants = [
        [
            'value' => 0,
            'img' => '  <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
             style="fill: rgba(255, 194, 115, 1);">
            <path
                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm4.207 12.793-1.414 1.414L12 13.414l-2.793 2.793-1.414-1.414L10.586 12 7.793 9.207l1.414-1.414L12 10.586l2.793-2.793 1.414 1.414L13.414 12l2.793 2.793z"></path>
        </svg>',
        ],
        [
            'value' => 1,
            'img' => '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
             style="fill: rgba(255, 194, 115, 1);">
            <path
                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm-1.999 14.413-3.713-3.705L7.7 11.292l2.299 2.295 5.294-5.294 1.414 1.414-6.706 6.706z"></path>
        </svg>',
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getTestWithDetails($id)
    {
        $test = Test::query()->where('id', $id)->with(['questions'])->first();
        return view('test.admin.preview', ['test' => $test, 'variants' => $this->variants]);
    }

    public function variants()
    {

        return response()->json([
            'success' => true,
            'variants' => $this->variants
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
                'img' => '  <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
             style="fill: rgba(255, 194, 115, 1);">
            <path
                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm-1.999 14.413-3.713-3.705L7.7 11.292l2.299 2.295 5.294-5.294 1.414 1.414-6.706 6.706z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
             style="fill: rgba(255, 194, 115, 1);">
            <path
                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm4.207 12.793-1.414 1.414L12 13.414l-2.793 2.793-1.414-1.414L10.586 12 7.793 9.207l1.414-1.414L12 10.586l2.793-2.793 1.414 1.414L13.414 12l2.793 2.793z"></path>
        </svg>'
            ],
            [
                'id' => Test::TEST_TYPE_FOUR_VARIANTS,
                'img' => '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="fill: rgba(255, 194, 115, 1);;transform: ;msFilter:;"><path d="m3.553 18.895 4 2a1.001 1.001 0 0 0 .894 0L12 19.118l3.553 1.776a.99.99 0 0 0 .894.001l4-2c.339-.17.553-.516.553-.895v-5c0-.379-.214-.725-.553-.895L17 10.382V6c0-.379-.214-.725-.553-.895l-4-2a1 1 0 0 0-.895 0l-4 2C7.214 5.275 7 5.621 7 6v4.382l-3.447 1.724A.998.998 0 0 0 3 13v5c0 .379.214.725.553.895zM8 12.118l2.264 1.132-2.913 1.457-2.264-1.132L8 12.118zm4-2.5 3-1.5v2.264l-3 1.5V9.618zm6.264 3.632-2.882 1.441-2.264-1.132L16 12.118l2.264 1.132zM8 18.882l-.062-.031V16.65L11 15.118v2.264l-3 1.5zm8 0v-2.264l3-1.5v2.264l-3 1.5zM12 5.118l2.264 1.132-2.882 1.441-2.264-1.132L12 5.118z"></path></svg>'
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

        if (in_array((int)$request->type_id, [Test::TEST_TYPE_FOUR_VARIANTS, Test::TEST_TYPE_TRUE_FALSE])) {
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
