<?php

namespace App\Filament\Resources\AppliedEncashmentResource\Pages;

use App\Filament\Resources\AppliedEncashmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\LeaveEncashmentApprovalCondition;
use App\Models\Level;
use App\Mail\LeaveApplicationMail;
use App\Mail\LeaveEncashmentMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Models\MasEmployee;
use App\Models\encashment;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use App\Models\LeaveEncashmentApprovalRule;

class CreateAppliedEncashment extends CreateRecord
{
    protected static string $resource = AppliedEncashmentResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $currentUser = auth()->user();
        $sectionId = auth()->user()->section_id;
        $departmentId = auth()->user()->department_id;
        $Encashment = encashment:: Where('name','Leave Encashment')->first();
        if ($Encashment) {
            $EncashmentId = $Encashment->id;
            //dd($earnedLeaveId);
        } else {
            // Handle the case where no LeaveType with the specified name is found
            echo "LeaveType with the name 'Earned Leave' not found.";
        }  
        // $sectionHead = MasEmployee::where('section_id', $sectionId)
        // ->where('roles', 'Section Head')->first();
        // Assuming 'Section Head' is the name of the role you want to find

        $sectionHead = FilamentUser::where('section_id', $sectionId)
            ->whereHas('roles', fn ($query) => $query->where('name', 'Section Head'))
            ->first();
        $departmentHead =FilamentUser::where('section_id', $departmentId)
        ->whereHas('roles', fn ($query) => $query->where('name', 'Department Head'))
        ->first();    
       
        $encashment_id = $EncashmentId;
        $approvalRuleId = LeaveEncashmentApprovalRule::where('type_id', $encashment_id)->value('id');
        $approvalType = LeaveEncashmentApprovalCondition::where('approval_rule_id', $approvalRuleId)->first();
        $hierarchy_id = $approvalType->hierarchy_id;
    
        if ($approvalType->approval_type == "Hierarchy") {
                // Fetch the record from the levels table based on the $hierarchy_id
                //$levelRecord = Level::where('hierarchy_id', $hierarchy_id)->first();
                $levelRecord = Level::where('hierarchy_id', $hierarchy_id)
               ->where('level', 1)
               ->first();
    
                if ($levelRecord) {
                    // Access the 'value' field from the level record
                    $levelValue = $levelRecord->value;
    
                    // Determine the recipient based on the levelValue
                    $recipient = '';
    
                    // Check the levelValue and set the recipient accordingly
                    if ($levelValue === "SH") {
                         $recipient = $sectionHead->email; // Replace with the actual field name
                         $approval = $sectionHead;
    
                        Mail::to($recipient)->send(new LeaveEncashmentMail($approval, $currentUser));

                    }elseif($levelValue === "DH"){
                        // Set the recipient to the section head's email address or user ID
                        $recipient = $departmentHead->email; // Replace with the actual field name
                        $approval = $departmentHead;
                        Mail::to($recipient)->send(new LeaveEncashmentMail($approval, $currentUser));
                        
                    }else{
                        // Access the 'value' field from the level record
                        $levelValue = $levelRecord->value;
                        $userID = $levelRecord->emp_id;
                        $approval = FilamentUser::where('id', $userID)->first();
                        // Determine the recipient based on the levelValue
                        $recipient = $approval->email;
                
                        Mail::to($recipient)->send(new LeaveEncashmentMail($approval, $currentUser));  
                    

                    }
                    
                }
            
        }elseif($approvalType->approval_type == "Single User"){

                $userID = $approvalType->employee_id;
                $approval = FilamentUser::where('id', $userID)->first();
                $recipient = $approval->email;
                Mail::to($recipient)->send(new LeaveEncashmentMail($approval, $currentUser));  
        }
        return $data;
     
    } 
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
