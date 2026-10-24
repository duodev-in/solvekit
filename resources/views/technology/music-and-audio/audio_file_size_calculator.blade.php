<x-calc.page
    title="Audio File Size Calculator - SolveKit"
    description="Free audio file size calculator: WAV or compressed file size from duration, sample rate, bit depth and channels."
    lede="Find an audio file size."
    about="Uncompressed audio stores every sample; compressed formats are set by their bitrate."
    :calc="['engine' => 'tc-music', 'tool' => 'audio_size', 'fields' => ['mode', 'rate', 'depth', 'channels', 'kbps', 'minutes'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How big is 4 minutes of CD-quality WAV?', 'answer' => '42.34 MB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Audio" :options="['pcm' => 'Uncompressed (WAV, AIFF)', 'compressed' => 'Compressed (MP3, AAC, Opus …)']" selected="pcm" />
        <div data-show-when="mode:pcm">
            <x-calc.select name="rate" label="Sample rate" :options="['44100' => '44.1 kHz (CD)', '48000' => '48 kHz (video)', '88200' => '88.2 kHz', '96000' => '96 kHz', '192000' => '192 kHz']" selected="44100" />
        </div>
        <div data-show-when="mode:pcm">
            <x-calc.select name="depth" label="Bit depth" :options="['16' => '16-bit', '24' => '24-bit', '32' => '32-bit float']" selected="16" />
        </div>
        <div data-show-when="mode:pcm">
            <x-calc.select name="channels" label="Channels" :options="['1' => 'Mono', '2' => 'Stereo', '6' => '5.1 surround', '8' => '7.1 surround']" selected="2" />
        </div>
        <div data-show-when="mode:compressed">
            <x-calc.field name="kbps" label="Bitrate (kbit/s)" value="320" min="1" step="any" />
        </div>
        <x-calc.field name="minutes" label="Duration (minutes)" value="4" min="0" step="any" />
    </div>

    <x-calc.result label="File size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'pcm', 'rate' => '44100', 'depth' => '16', 'channels' => '2', 'kbps' => 320, 'minutes' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bitrate' => ['label' => 'Bitrate'],
            'perMinute' => ['label' => 'Per minute'],
            'perGb' => ['label' => 'Minutes per GB'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
