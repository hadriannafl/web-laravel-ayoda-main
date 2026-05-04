<?php

namespace App\Http\Controllers\calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyCalendarController extends Controller
{
    public function index(Request $request)
    {
        $colors = DB::table('colors')->get();

        $calendarTags = DB::table('calendar_color')
            ->join('colors', 'colors.id', 'calendar_color.id_color')
            ->select('calendar_color.id', 'colors.value_color', 'calendar_color.color_tag', 'colors.name_color', 'colors.id as color')
            ->get();

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

        $filterUserId = $request->input('users_schedule');
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

        $dataCalendarsQuery = DB::table('calendar')
            ->leftJoin('calendar_users', 'calendar.idrec', 'calendar_users.id_calendar')
            ->join('calendar_color', 'calendar_color.id', 'calendar.id_calendar_color')
            ->join('colors', 'colors.id', 'calendar_color.id_color')
            ->select(
                'calendar.idrec',
                'calendar.calendar_name',
                'calendar.start_time',
                'calendar.end_time',
                'calendar.calendar_type',
                'calendar.id_calendar_color',
                'calendar.add_by',
                'calendar.notes',
                'colors.value_color'
            )
            ->groupBy('calendar.idrec');

            if ($filterUserId) {
                $dataCalendarsQuery->whereRaw("calendar.add_by = $filterUserId or calendar_users.id_user in ($filterUserId)");
            } else {
                $dataCalendarsQuery->whereRaw("calendar.add_by = $userId or calendar_users.id_user in ($userId)");
            }

        $dataCalendars = $dataCalendarsQuery->get()->toArray();

        return view('pages.company.companycalendar.companycalendar', compact('calendarTags', 'colors', 'dataUsers', 'dataCalendars'));
    }

    public function createTag(Request $request)
    {
        $dataCalendarTag = [
            'id_color' => $request->input('color'),
            'color_tag' => $request->input('color_tag'),
            'add_by' => Auth::user()->id
        ];

        $insertCalendarTag = DB::table('calendar_color')->insert($dataCalendarTag);

        if ($insertCalendarTag) {
            alert()->success('Success', 'Calendar Tag Has Been Added');
            return to_route('company.calendar');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('company.calendar');
        }
    }

    public function getUpdate($calendarId)
    {
        $calendarsData = DB::table('calendar')
        ->join('users', 'users.id', 'calendar.add_by')
            ->select(
                'calendar.idrec',
                'calendar.calendar_name',
                'calendar.calendar_type',
                'calendar.start_time',
                'calendar.end_time',
                'calendar.notes',
                'calendar.id_calendar_color',
                'users.username',
                'calendar.add_by'
            )
            ->where('calendar.idrec', $calendarId)
            ->first();
        $dataUsers = DB::table('calendar_users')
            ->join('users', 'users.id', 'calendar_users.id_user')
            ->select('calendar_users.id_user', 'users.username')
            ->where('calendar_users.id_calendar', $calendarId)
            ->get()->toArray();

        return response()->json([
            'dataCalendars' => $calendarsData,
            'userLists' => $dataUsers,
        ]);
    }

    public function update(Request $request, $calendarId)
    {
        // return $request->all();
        $data = $request->all();

        $type = $request->input('type1');
        $dataUpdatedCalendars = [
            'calendar_name' => $data['name1'],
            'id_calendar_color' => $data['calender_tag1'],
            'start_time' => $data['start_time1'],
            'end_time' => $data['end_time1'],
            'notes' => $data['notes1'],
        ];
        

        try {
            DB::transaction(function () use ($calendarId, $type, $dataUpdatedCalendars) {
                DB::table('calendar')->where('idrec', $calendarId)->update($dataUpdatedCalendars);
                
                if ($type == "group"){
                    DB::table('calendar_users')->where('id_calendar', $calendarId)->delete();
                }
            });
            alert()->success('Success', 'Schedule has been updated');
            return to_route('calendar');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error('Error', 'Error Occurred');
            return to_route('calendar');
        }
    }

    public function delete($calendarId)
    {
        try {
            DB::table('calendar')->where('idrec', $calendarId)->delete();
            DB::table('calendar_users')->where('id_calendar', $calendarId)->delete();
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

    public function getTag($tagId)
    {
        $calendarsTag = DB::table('calendar_color')
            ->join('colors', 'colors.id', 'calendar_color.id_color')
            ->select(
                'calendar_color.id',
                'calendar_color.id_color',
                'calendar_color.color_tag',
                'calendar_color.add_by',
                'colors.name_color'
            )
            ->where('calendar_color.id', $tagId)
            ->first();

        return response()->json([
            'dataTag' => $calendarsTag
        ]);
    }

    public function deleteTag($tagId)
    {
        try {
            DB::table('calendar_color')->where('calendar_color.id', $tagId)->delete();
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


    public function detail(Request $request)
    {
        $filterUserId = $request->input('users_schedule');
        $startTime = $request->input('start_time');
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

        $dataCalendarsQuery = DB::table('calendar')
            ->leftJoin('calendar_users', 'calendar.idrec', 'calendar_users.id_calendar')
            ->leftJoin('users as invitations', 'invitations.id', 'calendar_users.id_user')
            ->join('calendar_color', 'calendar_color.id', 'calendar.id_calendar_color')
            ->join('users as created_by', 'created_by.id', 'calendar.add_by')
            ->select(
                'calendar.idrec',
                'calendar.calendar_name',
                'calendar.start_time',
                'calendar.end_time',
                'calendar.calendar_type',
                'calendar.id_calendar_color',
                'calendar.add_by',
                'calendar.notes',
                'calendar_color.color_tag',
                'created_by.username',
                DB::raw("GROUP_CONCAT(invitations.username, ', ') as invitations")
            )
            ->whereDate('calendar.start_time', $startTime)
            ->groupBy('calendar.idrec');

        // if ($userRole != '101') {
        //     $dataCalendarsQuery->whereRaw("calendar.add_by = $userId or calendar_users.id_user in ($userId)");
        // } else if ($filterUserId) {
        //     $dataCalendarsQuery->whereRaw("calendar.add_by = $filterUserId or calendar_users.id_user in ($filterUserId)");
        // }

        $dataCalendars = $dataCalendarsQuery->get();

        return view('pages.calendar.calendarsdetail', compact('dataCalendars'));
    }
}
