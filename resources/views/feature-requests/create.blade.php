<x-app-layout
    title="Request a feature | SolveKit"
    description="Share a feature idea or improvement request for SolveKit."
>
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-8">
            <p class="text-sm font-medium uppercase tracking-[0.18em] text-primary-600">Product feedback</p>
            <h1 class="mt-3 text-4xl font-bold text-gray-900">Request a feature</h1>
            <p class="mt-3 text-lg text-gray-600">
                Tell us which tool, workflow, or improvement would make SolveKit even more useful for you.
            </p>
        </div>

        <form method="POST" action="{{ route('feature-request.store') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Full name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="title" class="mb-2 block text-sm font-medium text-gray-700">Feature title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="mb-2 block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>
                        <option value="">Select a category</option>
                        <option value="UI" @selected(old('category') === 'UI')>UI</option>
                        <option value="UX" @selected(old('category') === 'UX')>UX</option>
                        <option value="Calculation" @selected(old('category') === 'Calculation')>Calculation</option>
                        <option value="Performance" @selected(old('category') === 'Performance')>Performance</option>
                        <option value="Integration" @selected(old('category') === 'Integration')>Integration</option>
                        <option value="Other" @selected(old('category') === 'Other')>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Describe the feature</label>
                <textarea id="description" name="description" rows="6" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-100" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-500">We review all requests and prioritize the most useful improvements.</p>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-primary-700">
                    Submit request
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
