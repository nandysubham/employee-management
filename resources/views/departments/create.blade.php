<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
</head>
<body>

    <h1>Add Department</h1>

    <form action="{{ route('departments.store') }}" method="POST">

        @csrf

        <div>
            <label>Department Name</label>

            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <br>

        <div>
            <label>Description</label>

            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label>Status</label>

            <select name="status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <br>

        <button type="submit">
            Save Department
        </button>

    </form>

    <br>

    <a href="{{ route('departments.index') }}">
        Back
    </a>

</body>
</html>