<x-calc.page
    title="Data Usage Calculator - SolveKit"
    description="Free data usage calculator: GB of mobile or home internet data a month from video streaming, music, video calls and browsing, against your plan."
    lede="Estimate how much data you use each month."
    about="Video uses the most: Netflix says up to 1 GB an hour in SD, 3 GB in HD and 7 GB in 4K. Spotify streams at 96 kbit/s (Normal) to 320 kbit/s (Very high), about 43–144 MB an hour. A 720p video call uses about 1.2 Mbit/s each way (Zoom), roughly 1 GB an hour. Browsing and games vary widely, so those rates are yours to set."
    :calc="['engine' => 'ev-home', 'tool' => 'data_usage', 'fields' => ['video', 'video_quality', 'music', 'music_quality', 'calls', 'web', 'web_rate', 'gaming', 'gaming_rate', 'plan'], 'data' => ['streaming' => config('everyday_data.streaming')]]"
    :how-to="[
        ['name' => 'Enter hours a day', 'text' => 'For each activity.'],
        ['name' => 'Pick the qualities', 'text' => 'And your plan allowance.'],
    ]"
    :faqs="[
        ['question' => 'How much data does Netflix use?', 'answer' => 'Up to 1 GB an hour in SD, 3 GB in HD and 7 GB in 4K.'],
        ['question' => 'How much data for 2 hours of HD a day?', 'answer' => 'About 183 GB a month.'],
        ['question' => 'Is 50 GB a month enough?', 'answer' => 'For music and browsing yes; daily HD video needs more.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="video" label="Video streaming" value="2" min="0" step="0.5" suffix="h/day" />
        <x-calc.select name="video_quality" label="Video quality" :options="['low' => 'Low (0.3 GB/h)', 'medium' => 'Medium (0.7 GB/h)', 'sd' => 'SD (1 GB/h)', 'hd' => 'HD (3 GB/h)', 'uhd' => '4K (7 GB/h)']" selected="hd" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="music" label="Music streaming" value="2" min="0" step="0.5" suffix="h/day" />
        <x-calc.select name="music_quality" label="Music quality" :options="['normal' => 'Normal (96 kbit/s)', 'high' => 'High (160 kbit/s)', 'very_high' => 'Very high (320 kbit/s)']" selected="high" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="calls" label="Video calls" value="0.5" min="0" step="0.25" suffix="h/day" />
        <x-calc.field name="web" label="Social media and web" value="2" min="0" step="0.5" suffix="h/day" />
        <x-calc.field name="web_rate" label="Web data rate" value="150" min="0" suffix="MB/h" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gaming" label="Online gaming" value="0" min="0" step="0.5" suffix="h/day" />
        <x-calc.field name="gaming_rate" label="Gaming data rate" value="100" min="0" suffix="MB/h" />
        <x-calc.field name="plan" label="Plan allowance (optional)" value="100" min="0" suffix="GB" />
    </div>

    <x-calc.result label="Data used" />

    <x-calc.options :examples="[
        'Heavy streamer' => ['video' => 2, 'video_quality' => 'hd', 'music' => 2, 'music_quality' => 'high', 'calls' => 0.5, 'web' => 2, 'web_rate' => 150, 'gaming' => 0, 'gaming_rate' => 100, 'plan' => 100],
        'Phone only' => ['video' => 0.5, 'video_quality' => 'medium', 'music' => 1, 'music_quality' => 'normal', 'calls' => 0.25, 'web' => 3, 'web_rate' => 120, 'gaming' => 0, 'gaming_rate' => 100, 'plan' => 30],
        '4K household' => ['video' => 5, 'video_quality' => 'uhd', 'music' => 3, 'music_quality' => 'very_high', 'calls' => 2, 'web' => 4, 'web_rate' => 200, 'gaming' => 2, 'gaming_rate' => 150, 'plan' => 1200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'plan' => ['label' => 'Your plan'],
            'year' => ['label' => 'Per year'],
        ]" />
        <x-calc.quick-ref heading="By activity" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GB a month = Σ hours a day × GB per hour × 30.44</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
