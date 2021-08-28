<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\SubscriptionInterface;
use App\Http\Resources\SubscriptionResource;
use App\Http\Traits\ApiResponse;
use App\Models\GroupStudent;

class SubscriptionRepository implements SubscriptionInterface
{
    use ApiResponse;

    private $groupStudent;

    public function __construct(GroupStudent $groupStudent)
    {
        $this->groupStudent = $groupStudent;
    }

    public function limitSubscriptions()

    {

//        $id=auth()->id();
//
//        $limitSubscriptions=$this->groupStudent->when('true',function ($q) use ($id) {
//           return $q->where('student_id',3);
//        })->get();
////        dd($limi    tSubscriptions);
//
        $limitSubscriptions = $this->groupStudent->whereIn('count', [1,2])
                                    ->with('student', 'group')->get();


        return $this->apiResponse(200, 'Data', null, SubscriptionResource::collection($limitSubscriptions));
    }

    public function closedSubscriptions()
    {
        $closedSubscriptions = $this->groupStudent->where('count', 0)
                                    ->with('student', 'group')->get();

        return $this->apiResponse(200, 'Data', null, SubscriptionResource::collection($closedSubscriptions));
    }
}
