<?php

namespace App\Http\Controllers\Admin;

use App\Models\MeetingRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeetingRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = MeetingRequest::orderBy('created_at', 'desc');

        if ($request->filled('name')) {
            $name = trim($request->input('name'));
            $query->where('name', 'like', "%{$name}%");
        }

        if ($request->filled('email')) {
            $email = trim($request->input('email'));
            $query->where('email', 'like', "%{$email}%");
        }

        if ($request->filled('phone')) {
            $phone = trim($request->input('phone'));
            $query->where('phone', 'like', "%{$phone}%");
        }

        if ($request->filled('company')) {
            $company = trim($request->input('company'));
            $query->where('company', 'like', "%{$company}%");
        }

        if ($request->filled('meeting_type')) {
            $meetingType = trim($request->input('meeting_type'));
            $query->where('meeting_type', $meetingType);
        }

        if ($request->filled('preferred_date')) {
            $query->whereDate('preferred_date', $request->input('preferred_date'));
        }

        $meeting_requests = $query->paginate(20)->appends(
            $request->only([
                'name',
                'email',
                'phone',
                'company',
                'meeting_type',
                'preferred_date',
            ])
        );

        return view('admin.dashboard.meetingrequest.index', compact('meeting_requests'));
    }

    public function destroy(MeetingRequest $meetingRequest)
    {
        $meetingRequest->delete();

        return back()->with('success', 'Meeting request deleted');
    }
}