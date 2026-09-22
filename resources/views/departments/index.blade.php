<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
</head>
<body>

    <h1>Departments</h1>

    <a href="{{ route('departments.create') }}">Add Department</a>

    <br><br>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($departments as $department)

                <tr>
                    <td>{{ $department->id }}</td>

                    <td>{{ $department->name }}</td>

                    <td>{{ $department->description }}</td>

                    <td>
                        @if ($department->status)
                            Active
                        @else
                            Inactive
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('departments.show', $department->id) }}">
                            View
                        </a>

                        <a href="{{ route('departments.edit', $department->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('departments.destroy', $department->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf

                            @method('DELETE')

                            <button type="submit">
                                Delete
                            </button>

                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        No departments found.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

    <br>

    {{ $departments->links() }}

</body>
</html>