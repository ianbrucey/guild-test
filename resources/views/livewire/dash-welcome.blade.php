<div class="px-20">
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="container mx-auto px-5 my-4 text-center">
        <!-- Using utilities: -->
        <a href="{{ route('loan-app') }}">
            <button type="button" href="{{ route('loan-app') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 my-8 rounded">
                Start new loan application
            </button>
        </a>


    </div>

    <table class="table-auto w-full text-center px-20 mb-20">
        <div class="m-4 shadow-xl">
            <hr>
            <h1 class="text-center text-xl p-10">Active Applications</h1>
            <hr>
        </div>
        <thead>
            <tr>
                <th class="px-4 py-2">Application Name</th>
                <th class="px-4 py-2">Progress</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($apps as $app)
            <tr>
                <td class="border px-4 py-2">{{ $app->title }}</td>
                <td class="border px-4 py-2">{{ \App\Models\LoanApplication::PRINT_PROGRESS[$app->progress] }}</td>
                <td class="border px-4 py-2">{{ \App\Models\LoanApplication::PRINT_STATUS[$app->status] }}</td>
            </tr>
        @empty
            <tr>
                <td class="px-4 py-2">You have no active applications at this time</td>
            </tr>
        @endforelse

        </tbody>
    </table>
    <div class="w-full mb-10 text-center">
        <div class="w-3/12 mx-auto mt-5">
            {{ $apps->links() }}
        </div>

    </div>
</div>
