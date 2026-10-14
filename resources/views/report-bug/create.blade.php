<x-app-layout
    title="Report a bug | SolveKit"
    description="Tell the SolveKit development team about a problem you found."
>
    <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-8 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.18em] text-primary-600">Support</p>
            <h1 class="mt-3 text-4xl font-bold text-gray-900">Report a bug</h1>
            <p class="mt-3 text-lg text-gray-600">Tell the development team what went wrong.</p>
        </div>

        <form method="POST" action="{{ route('report-bug.store') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" placeholder="Your name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="you@example.com" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="subject" class="mb-2 block text-sm font-medium text-gray-700">Subject</label>
                <input id="subject" type="text" name="subject" value="{{ old('subject') }}" placeholder="Short summary of the issue" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">What happened?</label>
                <textarea id="description" name="description" rows="6" placeholder="Describe the problem and how to reproduce it" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-primary-700">
                    Send report
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
