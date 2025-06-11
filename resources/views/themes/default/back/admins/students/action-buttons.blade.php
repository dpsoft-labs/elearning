<div class="d-flex gap-2">
    @can('show students')
        <a href="{{ route('dashboard.admins.students-show', ['id' => encrypt($row->id)]) }}"
            class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('l.Show') }}">
            <i class="fa fa-eye"></i>
        </a>
        <a href="{{ route('dashboard.admins.registrations-show', ['student_id' => encrypt($row->id)]) }}"
            class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('l.Registrations') }}">
            <i class="fa fa-book"></i>
        </a>
    @endcan


    @can('edit students')
        <a href="{{ route('dashboard.admins.students-edit', ['id' => encrypt($row->id)]) }}"
            class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('l.Edit') }}">
            <i class="fa fa-pencil"></i>
        </a>
    @endcan

    @can('edit students')
        <a href="{{ route('impersonate', $row->id) }}" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip"
            title="{{ __('l.Login as') }} {{ $row->firstname }}">
            <i class="fas fa-door-open"></i>
        </a>
    @endcan

    @can('delete students')
        <a href="{{ route('dashboard.admins.students-inactive', ['id' => encrypt($row->id)]) }}"
            class="btn btn-sm btn-icon btn-danger delete-record" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('l.Delete') }}" data-inactive="false">
            <i class="fa fa-trash"></i>
        </a>
    @endcan
</div>
