<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\StaffDecree;
use App\Models\Parameters\StaffDecreeByEstament;
use App\Models\JobPositionProfiles\Role;
use App\Models\JobPositionProfiles\Liability;
use App\Models\JobPositionProfiles\JobPositionProfileLiability;

class JobPositionProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('job_position_profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('job_position_profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobPositionProfile = new JobPositionProfile($request->All());
        $jobPositionProfile->status = 'pending';
        $jobPositionProfile->user()->associate(Auth::user());
        $jobPositionProfile->organizationalUnit()->associate($request->ou_creator_id);
        $jobPositionProfile->estament()->associate($request->estament_id);
        $jobPositionProfile->area()->associate($request->area_id);
        $jobPositionProfile->contractualCondition()->associate($request->contractual_condition_id);

        $jobPositionProfile->save();

        session()->flash('success', 'Estimado Usuario, se ha creado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit', $jobPositionProfile);

        //return view('job_position_profile.edit', compact('jobPositionProfile'))->with('success', 'Estimados Usuario, se ha creado Exitosamente El Perfil de Cargo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function show(JobPositionProfile $jobPositionProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit', compact('jobPositionProfile'));
    }

    public function edit_formal_requirements(JobPositionProfile $jobPositionProfile)
    {
        $staffDecree = StaffDecree::latest()->first();

        $staffDecreeByEstaments = StaffDecreeByEstament::
            where('staff_decree_id', $staffDecree->id)
            ->where('estament_id', $jobPositionProfile->estament_id)
            ->get();

        foreach($staffDecreeByEstaments as $staffDecreeByEstament){
            if($jobPositionProfile->degree >= $staffDecreeByEstament->start_degree
                && $jobPositionProfile->degree <= $staffDecreeByEstament->end_degree){
                $generalRequirements = new StaffDecreeByEstament();
                $generalRequirements = $staffDecreeByEstament;
            }
        }

        return view('job_position_profile.edit_formal_requirements', compact('jobPositionProfile', 'generalRequirements'));
    }

    public function edit_objectives(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit_objectives', compact('jobPositionProfile'));
    }

    public function edit_organization(JobPositionProfile $jobPositionProfile)
    {   
        $tree = $jobPositionProfile->organizationalUnit->treeWithChilds->toJson();
        return view('job_position_profile.edit_organization', compact('jobPositionProfile', 'tree'));
    }

    public function edit_liabilities(JobPositionProfile $jobPositionProfile)
    {
        $liabilities = Liability::all();

        $jppLiabilities = JobPositionProfileLiability::
            where('job_position_profile_id', $jobPositionProfile->id)
            ->get();

        return view('job_position_profile.edit_liabilities', compact('jobPositionProfile', 'liabilities', 'jppLiabilities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPositionProfile $jobPositionProfile)
    {
        //
    }

    public function update_formal_requirements(Request $request, JobPositionProfile $jobPositionProfile, $generalRequirements)
    {
        $jobPositionProfile->staffDecreeByEstament()->associate($generalRequirements);
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();
        
        session()->flash('success', 'Estimado Usuario, se ha actualizado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_formal_requirements', $jobPositionProfile);
    }

    public function update_objectives(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();

        //dd($request);
        if($request->descriptions){
            foreach ($request->descriptions as $key => $description) {
                $role = new Role();
                $role->description = $description;
                $role->jobPositionProfile()->associate($jobPositionProfile->id);
                $role->save();
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente los objetivos Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_objectives', $jobPositionProfile);
    }

    public function update_organization(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();
        
        session()->flash('success', 'Estimado Usuario, se ha actualizado exitosamente la organización y contexto del cargo');
        return redirect()->route('job_position_profile.edit_organization', $jobPositionProfile);
    }

    public function store_liabilities(Request $request, JobPositionProfile $jobPositionProfile)
    {
        foreach($request->values as $key => $value){
            $jppLiabilities = new JobPositionProfileLiability();            
            $jppLiabilities->liability_id = $key;
            $jppLiabilities->value = $request->values[$key];
            $jppLiabilities->job_position_profile_id = $jobPositionProfile->id;

            $jppLiabilities->save();
        }
    
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las responsabilidades del cargo');
        return redirect()->route('job_position_profile.edit_liabilities', $jobPositionProfile);
    }

    public function update_liabilities(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jppLiabilities = JobPositionProfileLiability::
            where('job_position_profile_id', $jobPositionProfile->id)
            ->get();

        foreach($jppLiabilities as $jppLiability){
            foreach($request->values as $key => $value){
                // dd($key.' '.$jppLiability->liability_id, $value.' '.$jppLiability->value);
                if($key == $jppLiability->liability_id && $value != $jppLiability->value){  
                    // dd($jppLiability);  
                    $jppLiability->value = $request->values[$key];
                    $jppLiability->save();
                }
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las responsabilidades del cargo');
        return redirect()->route('job_position_profile.edit_liabilities', $jobPositionProfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPositionProfile $jobPositionProfile)
    {
        //
    }
}
