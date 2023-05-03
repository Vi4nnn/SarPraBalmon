<?php

namespace App\Http\Controllers\Officer;

use App\Models\Student;
use App\Models\Commodity;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Http\Controllers\Controller;
use App\Repositories\BorrowingRepository;

class DashboardController extends Controller
{
    public function __construct(
        private BorrowingRepository $repository
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $counts = [
            'student' => Student::select('id')->count(),
            'administrator' => Administrator::select('id')->count(),
            'commodity' => Commodity::select('id')->count()
        ];

        $latestRegisteredStudents = Student::select('name', 'email')->latest()->take(3)->get();
        $borrowingsNotReturned = $this->repository->getCommoditiesNotReturnedByStudent();

        return view('officer.dashboard', compact('counts', 'latestRegisteredStudents', 'borrowingsNotReturned'));
    }
}
