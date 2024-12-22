@extends('layouts.layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- public tokens -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Your Tokens</h3>
                <div class="mt-4 grid gap-6 md:grid-cols-2">
                    @forelse ($activeTokens->merge($inactiveTokens) as $token)
                        <div
                            class="p-4 border-2 rounded-md 
                            {{ $token->token_expiry > now() ? 'border-green-500' : 'border-red-500' }}">
                            <p><strong>Task:</strong>
                                <a href="{{ route('tasks.show', $token->task_id) }}" class="text-blue-500 underline">
                                    {{ $token->task->name }}
                                </a>
                            </p>
                            <p><strong>Token:</strong> {{ $token->public_token }}</p>
                            <p><strong>Expires:</strong> {{ $token->token_expiry->format('Y-m-d H:i') }}</p>
                            <div class="mt-2 flex gap-3">
                                <!-- Przyciski -->
                                @if ($token->token_expiry > now())
                                    <form action="{{ route('publicTokens.deactivate', $token->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="redirect" value="profile">
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 focus:outline-none">
                                            <i class="fas fa-ban"></i> Deactive
                                        </button>
                                    </form>
                                    <button
                                        class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 focus:outline-none copy-token-btn"
                                        data-token="{{ url('/public/tasks/' . $token->public_token) }}">
                                        <i class="far fa-copy"></i> Copy link
                                    </button>
                                @endif

                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::PUBLIC_TOKEN_DELETE->value]))
                                    <form action="{{ route('publicTokens.delete', $token->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect" value="profile">
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 focus:outline-none">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">{{ __('Brak tokenów do wyświetlenia.') }}</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    <!-- Skrypt JS do kopiowania -->
    <script>
        document.querySelectorAll('.copy-token-btn').forEach(button => {
            button.addEventListener('click', () => {
                const tokenUrl = button.getAttribute('data-token');
                navigator.clipboard.writeText(tokenUrl).then(() => {
                    alert('Link został skopiowany do schowka!');
                }).catch(err => {
                    alert('Nie udało się skopiować linku: ' + err);
                });
            });
        });
    </script>
@endsection
