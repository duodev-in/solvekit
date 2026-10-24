<x-calc.page
    title="Bandwidth Calculator - SolveKit"
    description="Free bandwidth calculator: bandwidth and monthly data for a website or downloads, with peak traffic."
    lede="Estimate bandwidth needs."
    about="A site’s bandwidth need comes from how much data visitors download, spread over the month and scaled for busy hours."
    :calc="['engine' => 'tc-net', 'tool' => 'bandwidth', 'fields' => ['mode', 'views', 'page', 'downloads', 'file', 'peak', 'redundancy'], 'unitFields' => ['page' => collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit'])->all(), 'file' => collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit'])->all()], 'data' => ['units' => collect(config('units'))->only(['data'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What bandwidth for 200,000 page views of 3 MB?', 'answer' => '7.2222 Mbit/s at peak.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Estimate for" :options="['website' => 'A website', 'download' => 'Downloads of a file']" selected="website" />
        <div data-show-when="mode:website">
            <x-calc.field name="views" label="Page views per month" value="200000" min="0" step="any" />
        </div>
        <div data-show-when="mode:website">
            <x-calc.field name="page" label="Average page size" value="3" min="0" placeholder="Average page size">
                <label for="calc-page-unit" class="sr-only">Average page size unit</label>
                <select id="calc-page-unit" name="page-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mb')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:download">
            <x-calc.field name="downloads" label="Downloads per month" value="5000" min="0" step="any" />
        </div>
        <div data-show-when="mode:download">
            <x-calc.field name="file" label="File size" value="200" min="0" placeholder="File size">
                <label for="calc-file-unit" class="sr-only">File size unit</label>
                <select id="calc-file-unit" name="file-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mb')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="peak" label="Peak factor (busiest hour vs average)" value="3" min="1" step="any" />
        <x-calc.field name="redundancy" label="Safety margin (%)" value="30" min="0" step="any" />
    </div>

    <x-calc.result label="Bandwidth needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'website', 'views' => 200000, 'page' => 3, 'page-unit' => 'mb', 'downloads' => 5000, 'file' => 200, 'file-unit' => 'mb', 'peak' => 3, 'redundancy' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'monthly' => ['label' => 'Data per month'],
            'average' => ['label' => 'Average rate'],
            'perVisit' => ['label' => 'Data per page view or download'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
