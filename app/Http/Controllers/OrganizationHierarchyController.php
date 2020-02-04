<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Employee;
use App\OrganizationHierarchy;
use App\Traits\MetaTrait;
use Illuminate\Http\Request;

class OrganizationHierarchyController extends Controller
{
    use MetaTrait;
    public $hierarchy = '';
    public $designations = [

    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __constructor()
    {
        $designations = Designation::all();
        foreach ($designations as $designation) {
            $this->designations[$designation->designation_name] = $designation->designation_name;
        }
    }

    public function processHierarchy()
    {
        $hierarchy = $this->hierarchy();

        foreach ($hierarchy as $key => $row) {
            if (isset($row['children'])) {
                foreach ($row['children'] as $child) {
                    // code...
                }
                $this->hierarchy[$key]->children = $row;
            }
        }
    }

    public function index()
    {
        $this->meta['title'] = 'Organization Hierarchy';

        $organization_hierarchies = OrganizationHierarchy::with('employee')
            ->with('lineManager')
            ->with('parentEmployee')
            ->with('childs')
            ->get();
        $hierarchy = '';
        if ($organization_hierarchies->count() > 0) {
            $this->hierarchy .= '[';
            $this->myhire($organization_hierarchies);
            $this->hierarchy .= ']';
            $this->hierarchy = str_replace('},]', '}]', $this->hierarchy);
            $hierarchy = json_decode($this->hierarchy);
            $hierarchy = json_encode($hierarchy[0]);
        }

        return view('admin.organization_hierarchy.index', $this->metaResponse())->with([
            'organization_hierarchies' => $organization_hierarchies,
            'hierarchy'                => $hierarchy,
        ]);
    }

    public function myhire($organization_hierarchies)
    {
        // dd($organization_hierarchies);
        foreach ($organization_hierarchies as $organization_hierarchy) {
            $this->hierarchy .= '{
                "id": "'.$organization_hierarchy->id.'", 
                "employee_id": "'.$organization_hierarchy->employee->id.'", 
                "name": "'.$organization_hierarchy->employee->firstname.' '.$organization_hierarchy->employee->lastname.'", 
                "title": "'.$organization_hierarchy->employee->designation.'"';

            if (count($organization_hierarchy->childs) > 0) {
                $this->hierarchy .= ',"children": [';
                $this->myhire($organization_hierarchy->childs);
                $this->hierarchy .= ']';
            }
            $this->hierarchy .= '},';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Role';
        $all_controllers = [];

        $employees = Employee::where('status', '!=', '0')->get();
        $OrganizationHierarchyCnt = OrganizationHierarchy::all()->count();

        return view('admin.organization_hierarchy.create', $this->metaResponse())->with([
            'employees'                => $employees,
            'OrganizationHierarchyCnt' => $OrganizationHierarchyCnt,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'name' => 'required|unique:roles',
        // ]);

        $OrganizationHierarchy = OrganizationHierarchy::create([
            'employee_id'     => $request->employee_id,
            'line_manager_id' => $request->line_manager_id,
            'parent_id'       => $request->parent_id,
        ]);

        return redirect()->route('organization_hierarchy.index')->with('success', 'Employee added to OrganizationHierarchy succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Edit Organize Employee';

        $employees = Employee::all();
        $organization_hierarchy = OrganizationHierarchy::find($id);

        return view('admin.organization_hierarchy.edit', $this->metaResponse())->with([
            'organization_hierarchy' => $organization_hierarchy,
            'employees'              => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organization_hierarchy = OrganizationHierarchy::find($id);

        $organization_hierarchy->employee_id = $request->employee_id;
        $organization_hierarchy->line_manager_id = $request->line_manager_id;
        $organization_hierarchy->parent_id = $request->parent_id;

        $organization_hierarchy->save();

        return redirect()->route('organization_hierarchy.index')->with('success', 'Employee updated in OrganizationHierarchy succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrganizationHierarchy::where('parent_id', $id)->delete();
        OrganizationHierarchy::where('employee_id', $id)->delete();

        return redirect()->back()->with('success', 'Employee & his subordinates in OrganizationHierarchy are deleted succesfully');
    }
}
