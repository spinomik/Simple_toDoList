@extends('layouts.layout')

@section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Welcome to Users List</h1>

        <table class="min-w-full table-auto border-separate border-spacing-0">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Verified</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Blocked</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Privileges</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            <form action="{{ route('users.block_user', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="checkbox" name="blocked" {{ $user->blocked ? 'checked' : '' }}
                                    onchange="this.form.submit()" class="form-checkbox h-4 w-4 text-blue-500">
                            </form>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            <div class="max-h-20 overflow-y-auto">
                                <ul>
                                    @foreach ($privileges as $privilege)
                                        <li class="flex items-center space-x-2">
                                            <input type="checkbox" @if (!auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::PRIVILEGE_CHANGE->value])) disabled @endif
                                                class="privilege-checkbox form-checkbox h-4 w-4 text-blue-500"
                                                data-user-id="{{ $user->id }}" data-privilege-id="{{ $privilege->id }}"
                                                {{ $user->privileges->contains('id', $privilege->id) ? 'checked' : '' }}>
                                            <span>{{ str_replace('_', ' ', $privilege->name) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex space-x-3">
                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::USER_DELETE->value]))
                                    <form action="{{ route('users.delete', ['user' => $user]) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-700 focus:outline-none"
                                            onclick="return confirm('Are you sure?');">Delete</button>
                                    </form>
                                @endif
                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::USER_EDIT->value]))
                                    <a href="{{ route('users.edit', ['user' => $user]) }}"
                                        class="px-4 py-2 text-sm text-yellow-700 border border-yellow-500 rounded-md hover:bg-yellow-100 focus:outline-none">
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.privilege-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const userId = this.dataset.userId;
                const privilegeId = this.dataset.privilegeId;
                const isChecked = this.checked;

                fetch(`/users/${userId}/privileges`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            privilege_id: privilegeId,
                            action: isChecked ? 'add' : 'remove'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Something went wrong!');
                            this.checked = !isChecked;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Server error.');
                        this.checked = !isChecked;
                    });
            });
        });
    </script>
@endsection
