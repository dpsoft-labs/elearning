@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Roles & Permissions')
@endsection

@section('css')
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-semibold mb-4">@lang('l.Roles List')</h4>

        <p class="mb-4">
            @lang('l.A role provided access to predefined menus and features so that depending on') <br />
            @lang('l.assigned role an administrator can have access to what user needs.')
        </p>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <!-- Role cards -->
        <div class="row g-4">
            @can('show roles')
                @foreach ($roles as $role)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-normal mb-2">@lang('l.Total') {{ $role->users->count() }}
                                        @lang('l.users')</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-end mt-1">
                                    {{-- @can('edit roles') --}}
                                        <div class="role-heading">
                                            <h4 class="mb-1" style="text-transform:capitalize;">{{ $role->name }}</h4>
                                            <a href="{{ route('dashboard.admins.roles-edit') }}?id={{ encrypt($role->id) }}"
                                                class="btn btn-dark"><span>@lang('l.Edit Role')</span></a>
                                        </div>
                                    {{-- @endcan --}}
                                    {{-- @can('delete roles') --}}
                                        <a href="javascript:void(0);" class="text-muted delete-role"
                                            data-role-id="{{ encrypt($role->id) }}">
                                            <i class="fa fa-trash ti-md "></i>
                                        </a>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endcan
            {{-- @can('add roles') --}}
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100">
                        <div class="row h-100">
                            <div class="col-sm-5">
                                <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                    <img src="{{ asset('assets/themes/default/img/illustrations/lady-with-laptop-light.png') }}"
                                        class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83" />
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="card-body text-sm-end text-center ps-sm-0">
                                    <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                        class="btn btn-primary mb-2 text-nowrap add-new-role">
                                        @lang('l.Add New Role')
                                    </button>
                                    <p class="mb-0 mt-1">@lang('l.Add role, if it does not exist')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- @endcan --}}
        </div>
        <!--/ Role cards -->

        {{-- @can('add roles') --}}
            <!-- Add Role Modal -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content p-3 p-md-5">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <h3 class="role-title mb-2">@lang('l.Add New Role')</h3>
                                <p class="text-muted">@lang('l.Set role permissions')</p>
                            </div>
                            <!-- Add role form -->
                            <form id="addRoleForm" class="row g-3" method="post"
                                action="{{ route('dashboard.admins.roles-store') }}">@csrf
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="modalRoleName">@lang('l.Role Name')</label>
                                    <input type="text" id="modalRoleName" name="name" class="form-control"
                                        placeholder="@lang('l.Enter a role name')" tabindex="-1" required />
                                </div>
                                <div class="col-12">
                                    <h5>@lang('l.Role Permissions')</h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                <tr>
                                                    <td class="text-nowrap fw-semibold">
                                                        @lang('l.Administrator Access')
                                                        <i class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Allows a full access to the system"></i>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="selectAll" />
                                                            <label class="form-check-label" for="selectAll">
                                                                @lang('l.Select All')
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @foreach ($groupedPermissions as $groupName => $group)
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center">@lang('l.Show')</td>
                                                        <td class="text-center">@lang('l.Add')</td>
                                                        <td class="text-center">@lang('l.Edit')</td>
                                                        <td class="text-center">@lang('l.Delete')</td>
                                                        <td class="text-center">@lang('l.Other')</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap fw-semibold">{{ strtoupper($groupName) }}</td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="show {{ strtolower($groupName) }}"
                                                                    id="show_{{ $groupName }}"
                                                                    name="permissions[]"
                                                                    {{ $group->contains('name', 'show ' . strtolower($groupName)) ? '' : 'disabled' }} />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="add {{ strtolower($groupName) }}"
                                                                    id="add_{{ $groupName }}"
                                                                    name="permissions[]"
                                                                    {{ $group->contains('name', 'add ' . strtolower($groupName)) ? '' : 'disabled' }} />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="edit {{ strtolower($groupName) }}"
                                                                    id="edit_{{ $groupName }}"
                                                                    name="permissions[]"
                                                                    {{ $group->contains('name', 'edit ' . strtolower($groupName)) ? '' : 'disabled' }} />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="delete {{ strtolower($groupName) }}"
                                                                    id="delete_{{ $groupName }}"
                                                                    name="permissions[]"
                                                                    {{ $group->contains('name', 'delete ' . strtolower($groupName)) ? '' : 'disabled' }} />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @foreach($group as $permission)
                                                                @php
                                                                    $permissionName = strtolower($permission->name);
                                                                    $isStandardAction = Str::startsWith($permissionName, ['show ', 'add ', 'edit ', 'delete ']);
                                                                @endphp

                                                                @if(!$isStandardAction)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="{{ $permission->name }}"
                                                                            id="{{ Str::slug($permission->name) }}"
                                                                            name="permissions[]" />
                                                                        <label class="form-check-label" for="{{ Str::slug($permission->name) }}">
                                                                            {{ ucfirst(str_replace($groupName, '', $permission->name)) }}
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                        @lang('l.Create')
                                    </button>
                                    <button type="reset" class="btn btn-label-primary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        @lang('l.Back')
                                    </button>
                                </div>
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add Role Modal -->
        {{-- @endcan --}}
    </div>
@endsection


@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');

            selectAllCheckbox.addEventListener('change', () => {
                checkboxes.forEach((checkbox) => {
                    if (!checkbox.disabled) {
                        checkbox.checked = selectAllCheckbox.checked;
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            const roleId = $(this).data('role-id');

            Swal.fire({
                title: "@lang('l.Are you sure?')",
                text: "@lang('l.You will be delete this forever!')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: "@lang('l.Yes, delete it!')",
                cancelButtonText: "@lang('l.Cancel')"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('dashboard.admins.roles-delete') }}?id=' + roleId;
                }
            });
        });
    </script>
@endsection
