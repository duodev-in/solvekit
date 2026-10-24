<x-calc.page
    title="Streaming Bitrate Calculator - SolveKit"
    description="Free streaming bitrate calculator: recommended bitrate and upload speed for live streams and uploads by resolution."
    lede="Find a streaming bitrate."
    about="Higher resolutions and frame rates need more bitrate; YouTube publishes its recommendations."
    :calc="['engine' => 'tc-net', 'tool' => 'streaming_bitrate', 'fields' => ['res', 'fps', 'use', 'audio'], 'unitFields' => ['audio' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all()], 'data' => ['units' => collect(config('units'))->only(['data_rate'])->all(), 'technology' => collect(config('technology_data'))->only(['youtube'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What bitrate for a 1080p30 live stream?', 'answer' => '14 Mbit/s, with 21.24 Mbit/s of upload speed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="res" label="Resolution" :options="['2160' => '2160p (4K)', '1440' => '1440p (2K)', '1080' => '1080p', '720' => '720p', '480' => '480p', '360' => '360p']" selected="1080" />
        <x-calc.select name="fps" label="Frame rate" :options="['std' => '24–30 fps', 'high' => '48–60 fps']" selected="std" />
        <x-calc.select name="use" label="For" :options="['upload' => 'Uploading a video (SDR)', 'live' => 'Live streaming (H.264)']" selected="live" />
        <x-calc.field name="audio" label="Audio bitrate" value="160" min="0" placeholder="Audio bitrate">
            <label for="calc-audio-unit" class="sr-only">Audio bitrate unit</label>
            <select id="calc-audio-unit" name="audio-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kbps')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Recommended video bitrate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['res' => '1080', 'fps' => 'std', 'use' => 'live', 'audio' => 160, 'audio-unit' => 'kbps'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Video + audio'],
            'upload' => ['label' => 'Upload speed to have'],
            'perHour' => ['label' => 'Data per hour'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
