<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name ?? '') }}">
</div>

<div class="form-group">
    <label for="polytechnic_name">Polytechnic Name:</label>
    <input type="text" name="polytechnic_name" class="form-control" value="{{ old('polytechnic_name', $employee->polytechnic_name ?? '') }}">
</div>

<div class="form-group">
    <label for="fathers_name">Father's Name:</label>
    <input type="text" name="fathers_name" class="form-control" value="{{ old('fathers_name', $employee->fathers_name ?? '') }}">
</div>

<div class="form-group">
    <label for="mothers_name">Mother's Name:</label>
    <input type="text" name="mothers_name" class="form-control" value="{{ old('mothers_name', $employee->mothers_name ?? '') }}">
</div>

<div class="form-group">
    <label for="roll">Roll Number:</label>
    <input type="number" name="roll" class="form-control" value="{{ old('roll', $employee->roll ?? '') }}">
</div>

<div class="form-group">
    <label for="registration_number">Registration Number:</label>
    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $employee->registration_number ?? '') }}">
</div>

<div class="form-group">
    <label for="image">Image:</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @if(isset($employee) && $employee->image)
        <img src="{{ asset('storage/' . $employee->image) }}" width="50" alt="Employee Image" class="mt-2">
    @endif
</div>

<div class="form-group">
    <label for="status">Status:</label>
    <select name="status" class="form-control">
        <option value="1" {{ old('status', $employee->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $employee->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>




