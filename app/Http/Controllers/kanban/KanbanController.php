<?php

namespace App\Http\Controllers\kanban;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KanbanController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }

    public function index(Request $request)
    {
        $todo = 'todo';
        $progress = 'progress';
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

        $kanbanBoard = DB::table('kanban_board')
        ->select('kanban_board.id',
                'kanban_board.BoardName',
                'kanban_board.add_by')
        ->get();

        $dataUsers = DB::table('users')

            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

        $dataListQuery = DB::table('kanban_list')
            ->leftJoin('kanban', 'kanban_list.kanban_id', 'kanban.id')
            ->select(
                'kanban_list.id',
                'kanban_list.kanban_id',
                'kanban_list.ToDoList',
                'kanban_list.status',
                'kanban.id as kanban'
            )->orderBy('kanban_list.id', 'asc');

        $dataList = $dataListQuery->get();

        $dataKanbanQuery = DB::table('kanban')
            ->leftJoin('kanban_user', 'kanban.id', 'kanban_user.kanban_id')
            ->join('kanban_board', 'kanban_board.id', 'kanban.KanBanBoard_ID')
            ->leftJoin('users as invitations', 'invitations.id', 'kanban_user.id_user')
            ->leftJoin('users as created_by', 'created_by.id', 'kanban.created_by')
            ->select(
                'kanban.id',
                'kanban.KanBanBoard_ID',
                'kanban.ToDo',
                'kanban.ToDoType',
                'kanban.ToDoDescription',
                'kanban.ToDoPhoto',
                'kanban.ToDoPhoto_name',
                'kanban.ToDoDate',
                'kanban.ToDoDue',
                'kanban.status',
                'kanban.created_by',
                'kanban.created_date',
                'kanban.lastupdate',
                'kanban_board.id as board',
                'kanban_board.BoardName',
                DB::raw("GROUP_CONCAT(invitations.username, ', ') as invitations")
                )->whereRaw("kanban.created_by = $userId or kanban_user.id_user in ($userId)");

        $dataKanban = $dataKanbanQuery->groupBy('kanban.id')->orderBy('kanban.id', 'desc')->get();

        $dataNote = DB::table('kanban_notes')
        ->select('kanban_notes.id', 'kanban_notes.name', 'kanban_notes.notes', 'kanban_notes.image', 'kanban_notes.image_name', 'kanban_notes.add_by', 'kanban_notes.status')
        ->where('kanban_notes.add_by', $userId)
        ->groupBy('kanban_notes.id')
        ->orderBy('kanban_notes.id', 'desc')->get();

        return view('pages.kan-ban.index', compact('dataKanban', 'dataUsers', 'kanbanBoard', 'dataList', 'dataNote'));
    }

    public function createBoard(Request $request)
    {
        $dataBoard = [
            'BoardName' => $request->input('board_name'),
            'add_by' => Auth::user()->id
        ];

        $insertdataBoard = DB::table('kanban_board')->insert($dataBoard);

        if ($insertdataBoard) {
            alert()->success('Success', 'Calendar Tag Has Been Added');
            return to_route('kan-ban');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('kan-ban');
        }
    }

    public function createKanban(Request $request)
    {
        if ($request->hasFile('photo')) {
            $fileName = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move($this->saveImageUrl . 'kanbanImg/', $fileName);
        } else {
            $fileName = null;
        }

        $type = $request->input('type');
        $board = $request->input('kanbanBoard');

        $dataKanban = [
            'KanBanBoard_ID' => $request->input('kanbanBoard'),
            'ToDo' => $request->input('name'),
            'ToDoType' => $type,
            'ToDoDescription' => $request->input('desc'),
            'ToDoPhoto_name' => $fileName,
            'ToDoDate' => $request->input('date'),
            'ToDoDue' => $request->input('due'),
            'status' => 'todo',
            'created_date' => date('Y-m-d'),
            'created_by' => Auth::user()->id,
            'lastupdate' => date('Y-m-d')
        ];

        try {
            DB::transaction(function () use ($request, $type, $dataKanban, $board) {
                if (!empty($type && $board)) {
                    $idKanban = DB::table('kanban')->insertGetId($dataKanban);
                
                    $dataKanbanList = $request->input('list');
                    foreach ($dataKanbanList as $key => $value) {
                        DB::table('kanban_list')->insert([
                            'kanban_id' => $idKanban,
                            'ToDoList' => $value,
                            'status' => '0'
                        ]);
                    }
                
                    if ($type == "group") {
                        $dataKanbanUsers = $request->input('users');
                        foreach ($dataKanbanUsers as $key => $value) {
                            DB::table('kanban_user')->insert([
                                'kanban_id' => $idKanban,
                                'id_user' => $value
                            ]);
                        }
                    }
                    alert()->success('Success', 'Kanban has been created');
                    return to_route('kan-ban');
                }else {
                    alert()->error('Error', 'Kanban Type and Board must fill');
                    return to_route('kan-ban');
                }
            });
            return to_route('kan-ban');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error('Error', 'Kanban Type and Board must fill');
            return to_route('kan-ban');
        }
    }

    public function delete($kanbanId)
    {
        $statusUpdate = [
            'status' => 'delete',
            'lastupdate' => date('Y-m-d')
        ];

        try {
            DB::table('kanban')->where('id', $kanbanId)->update($statusUpdate);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the data",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function progress($kanbanId)
    {
        $statusUpdate = [
            'status' => 'progress',
            'lastupdate' => date('Y-m-d')
        ];

        try {
            DB::table('kanban')->where('id', $kanbanId)->update($statusUpdate);
            alert()->success('Success', 'Kanban Successfully In Progress');
            return to_route('kan-ban');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error('Error', 'Error Occurred');
            return to_route('kan-ban');
        }
    }

    public function finish($kanbanId)
    {
        $statusUpdate = [
            'status' => 'complete',
            'lastupdate' => date('Y-m-d')
        ];

        $statusList = [
            'status' => '1',
        ];

        try {
            DB::table('kanban')->where('id', $kanbanId)->update($statusUpdate);
            DB::table('kanban_list')->where('kanban_id', $kanbanId)->update($statusList);
            return response()->json([
                'status' => 1,
                'message' => "successfully complete the data",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function undo($kanbanId)
    {
        $statusUpdate = [
            'status' => 'progress',
            'lastupdate' => date('Y-m-d')
        ];

        $statusList = [
            'status' => '0',
        ];

        try {
            DB::table('kanban')->where('id', $kanbanId)->update($statusUpdate);
            DB::table('kanban_list')->where('kanban_id', $kanbanId)->update($statusList);
            return response()->json([
                'status' => 1,
                'message' => "successfully complete the data",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function getUpdate($kanbanId)
    {
        $kanbanBoard = DB::table('kanban_board')
        ->select('kanban_board.id',
                'kanban_board.BoardName',
                'kanban_board.add_by')
        ->get();

        $kanbanData = DB::table('kanban')
            ->leftJoin('kanban_user', 'kanban.id', 'kanban_user.kanban_id')
            ->join('kanban_board', 'kanban_board.id', 'kanban.KanBanBoard_ID')
            ->leftJoin('users as invitations', 'invitations.id', 'kanban_user.id_user')
            ->leftJoin('users as created_by', 'created_by.id', 'kanban.created_by')
            ->select(
                'kanban.id',
                'kanban.KanBanBoard_ID',
                'kanban.ToDo',
                'kanban.ToDoType',
                'kanban.ToDoDescription',
                'kanban.ToDoPhoto',
                'kanban.ToDoPhoto_name',
                'kanban.ToDoDate',
                'kanban.ToDoDue',
                'kanban.status',
                'kanban.created_by',
                'kanban.created_date',
                'kanban.lastupdate',
                DB::raw("GROUP_CONCAT(invitations.username, ', ') as invitations")
            )->where('kanban.id', $kanbanId)->first();

        $dataList = DB::table('kanban_list')
        ->leftJoin('kanban', 'kanban_list.kanban_id', 'kanban.id')
        ->select(
            'kanban_list.id',
            'kanban_list.kanban_id',
            'kanban_list.ToDoList',
            'kanban_list.status',
            'kanban.id as kanban'
        )->where('kanban_list.kanban_id', $kanbanId)->orderBy('kanban_list.id', 'asc')->get();

        $dataUsers = DB::table('kanban_user')
            ->join('users', 'users.id', 'kanban_user.id_user')
            ->select('kanban_user.id_user', 'kanban_user.kanban_id', 'users.username')
            ->where('kanban_user.kanban_id', $kanbanId)
            ->get()->toArray();

        
        return view('pages.kan-ban.updatekanban', compact('kanbanData', 'dataList', 'dataUsers', 'kanbanBoard'));
    }

    public function update(Request $request, $kanbanId)
    {
        $data = $request->all();
         if ($request->hasFile('photo')) {
             $fileName = $request->file('photo')->getClientOriginalName();
             $request->file('photo')->move($this->saveImageUrl . 'kanbanImg/', $fileName);
         } else {
             $fileName = null;
         }

         $dataKanban = [
            'KanBanBoard_ID' => $request->input('board'),
            'ToDo' => $request->input('name'),
            'ToDoDescription' => $request->input('desc'),
            'ToDoPhoto_name' => $fileName,
            'ToDoDate' => $request->input('date'),
            'ToDoDue' => $request->input('due'),
            'created_by' => Auth::user()->id,
            'lastupdate' => date('Y-m-d')
        ];

        $dataKanban1 = [
            'KanBanBoard_ID' => $request->input('board'),
            'ToDo' => $request->input('name'),
            'ToDoDescription' => $request->input('desc'),
            'ToDoDate' => $request->input('date'),
            'ToDoDue' => $request->input('due'),
            'created_by' => Auth::user()->id,
            'lastupdate' => date('Y-m-d')
        ];

        // $id = $request->input('id');
        $check = $request->input('check');
        $uncheck = $request->input('uncheck');
        $photo = $request->file('photo');

        try {
            DB::transaction(function () use ($kanbanId, $dataKanban, $dataKanban1, $check, $uncheck, $photo) {
                if (!empty($photo)) {
                    DB::table('kanban')->where('id', $kanbanId)->update($dataKanban);
                } else {
                    DB::table('kanban')->where('id', $kanbanId)->update($dataKanban1);
                }
              
                if ($check !== null){
                    foreach ($check as $key => $value) {
                        DB::table('kanban_list')->where('id', $key)->update([
                            'status' => $value
                        ]);
                    }
                }
                
                if($uncheck !== null ){
                    foreach ($uncheck as $key => $value) {
                        DB::table('kanban_list')->where('id', $key)->update([
                            'status' => $value
                        ]);
                    }
                }
                
            });
            alert()->success('Success', 'Kanban has been updated');
            return to_route('kan-ban');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error('Error', 'Error Occurred');
            return to_route('kan-ban');
        }
    }

    public function notes(Request $request)
    {
        if ($request->hasFile('photo_note')) {
            $fileName = $request->file('photo_note')->getClientOriginalName();
            $request->file('photo_note')->move($this->saveImageUrl . 'kanbanNoteImg/', $fileName);
        } else {
            $fileName = null;
        }

        $dataNote = DB::table('kanban_notes')->insert([
            'name' => $request->input('noted'),
            'notes' => $request->input('note'),
            'image_name' => $fileName,
            'add_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status' => 'note'
        ]);

        if ($dataNote) {
            alert()->success('Success', 'Kanban Notes Has Been Added');
            return to_route('kan-ban');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('kan-ban');
        }
    }

    public function deleteNotes($noteId)
    {
        $statusUpdate = [
            'status' => 'delete',
            'updated_at' => date('Y-m-d')
        ];

        try {
            DB::table('kanban_notes')->where('id', $noteId)->update($statusUpdate);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the data",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function noteGetUpdate($noteId)
    {
        $noteData = DB::table('kanban_notes')
            ->leftJoin('users as created_by', 'created_by.id', 'kanban_notes.add_by')
            ->select(
                'kanban_notes.id',
                'kanban_notes.name',
                'kanban_notes.notes',
                'kanban_notes.image',
                'kanban_notes.image_name',
                'kanban_notes.add_by',
                'kanban_notes.status',
                'created_by.username'
            )->where('kanban_notes.id', $noteId)->first();

        
        return view('pages.kan-ban.updatenote', compact('noteData'));
    }

    public function noteUpdate(Request $request, $noteId)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $fileName = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move($this->saveImageUrl . 'kanbanNoteImg/', $fileName);
        } else {
            $fileName = null;
        }

        $dataNote = [
           'name' => $request->input('name'),
           'notes' => $request->input('desc'),
           'image_name' => $fileName,
           'updated_at' => date('Y-m-d')
       ];
       
        $dataNote1 = [
           'name' => $request->input('name'),
           'notes' => $request->input('desc'),
           'updated_at' => date('Y-m-d')
       ];

       $photo = $request->file('photo');

       try {
           DB::transaction(function () use ($noteId, $dataNote, $dataNote1, $photo) {
                if (!empty($photo)) {
                    DB::table('kanban_notes')->where('id', $noteId)->update($dataNote);
                } else {
                    DB::table('kanban_notes')->where('id', $noteId)->update($dataNote1);
                }
           });
           alert()->success('Success', 'Note has been updated');
           return to_route('kan-ban');
       } catch (\Throwable $th) {
           dd($th->getMessage());
           alert()->error('Error', 'Error Occurred');
           return to_route('kan-ban');
       }
    }


    
}
