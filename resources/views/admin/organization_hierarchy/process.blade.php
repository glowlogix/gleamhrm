@foreach($organization_hierarchies as $organization_hierarchy)
{ 
	"name": "{{ $organization_hierarchy->employee->firstname }}", 
	"title": "{{ $organization_hierarchy->employee->role }}"
	@if(count($organization_hierarchy->childs) > 0)
		,"children": [
			@include("admin.organization_hierarchy.process",["organization_hierarchies" => $organization_hierarchy->childs])
		]
	@endif
},
@endforeach