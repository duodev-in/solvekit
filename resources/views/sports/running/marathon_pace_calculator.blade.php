<x-calc.page
    title="Marathon Pace Calculator - SolveKit"
    description="Free marathon pace calculator: pace per km and mile with 5 km splits for a goal time."
    lede="Find your marathon pace."
    about="Your goal time divided by 42.195 km gives the pace; the splits show where you should be every 5 km. Also known as Half Marathon Pace Calculator."
    :calc="['engine' => 'sp-run', 'tool' => 'marathon_pace', 'fields' => ['which', 'goal'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What pace runs a 4:00:00 marathon?', 'answer' => '5:41 /km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="which" label="Race" :options="['marathon' => 'Marathon (42.195 km)', 'half' => 'Half marathon (21.0975 km)']" selected="marathon" />
        <x-calc.field name="goal" label="Goal time (h:mm:ss)" value="4:00:00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Pace" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['which' => 'marathon', 'goal' => '4:00:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'speed' => ['label' => 'Speed'],
            'mile' => ['label' => 'Per mile'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Splits every 5 km" name="splits" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
