<x-calc.page
    title="Video File Size Calculator (by format) - SolveKit"
    description="Free video file size calculator: file size from bitrate and duration, with YouTube presets."
    lede="Find a video file size."
    about="A video’s size is its total bitrate times its duration."
    :calc="['engine' => 'tc-photo', 'tool' => 'video_size', 'fields' => ['preset', 'bitrate', 'audio', 'minutes'], 'unitFields' => ['bitrate' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all(), 'audio' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all()], 'data' => ['units' => collect(config('units'))->only(['data_rate'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How big is 10 minutes of 1080p at YouTube’s bitrate?', 'answer' => 'About 624 MB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="preset" label="Video bitrate" :options="['custom' => 'My own bitrate', 'yt2160' => 'YouTube 4K upload (45 Mbit/s)', 'yt1440' => 'YouTube 1440p upload (16 Mbit/s)', 'yt1080' => 'YouTube 1080p upload (8 Mbit/s)', 'yt720' => 'YouTube 720p upload (5 Mbit/s)', 'yt480' => 'YouTube 480p upload (2.5 Mbit/s)']" selected="yt1080" />
        <div data-show-when="preset:custom">
            <x-calc.field name="bitrate" label="Video bitrate" value="50" min="0" placeholder="Video bitrate">
                <label for="calc-bitrate-unit" class="sr-only">Video bitrate unit</label>
                <select id="calc-bitrate-unit" name="bitrate-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mbps')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="audio" label="Audio bitrate" value="320" min="0" placeholder="Audio bitrate">
            <label for="calc-audio-unit" class="sr-only">Audio bitrate unit</label>
            <select id="calc-audio-unit" name="audio-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kbps')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="minutes" label="Duration (minutes)" value="10" min="0" step="any" />
    </div>

    <x-calc.result label="File size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['preset' => 'yt1080', 'bitrate' => 50, 'bitrate-unit' => 'mbps', 'audio' => 320, 'audio-unit' => 'kbps', 'minutes' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perMinute' => ['label' => 'Per minute'],
            'perGb' => ['label' => 'Minutes per GB'],
            'total' => ['label' => 'Total bitrate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
