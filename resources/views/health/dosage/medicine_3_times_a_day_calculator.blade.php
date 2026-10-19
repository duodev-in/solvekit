<x-calc.page
    title="Medicine 3 Times a Day Calculator - SolveKit"
    description="Free medicine 3 times a day calculator: evenly spaced dose times across your waking day, or every 8 hours around the clock."
    lede="Space out medicine 3 times a day."
    about="“Three times a day” usually means spread through the waking day, for example on waking, mid-afternoon and at bedtime; “every 8 hours” means around the clock. This planner spaces the times evenly between your wake and bed times, or from a first dose. Always follow the label or your pharmacist if they give specific times, or say to take it with food. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'med_times', 'fields' => ['mode', 'times', 'wake', 'bed', 'first']]"
    :how-to="[
        ['name' => 'Choose how to space doses', 'text' => ''],
        ['name' => 'Enter your day or the first dose', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When should I take a medicine 3 times a day if I wake at 7:00 and sleep at 22:00?', 'answer' => '07:00, 14:30, 22:00.'],
        ['question' => 'And every 8 hours from 06:00?', 'answer' => '06:00, 14:00, 22:00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Spacing" :options="['awake' => 'While awake', 'hourly' => 'Around the clock']" selected="awake" />

    <x-calc.select name="times" label="Times a day" :options="['2' => '2 times', '3' => '3 times', '4' => '4 times']" selected="3" />

    <div data-show-when="mode:awake">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="wake" label="Wake up" value="07:00" type="time" />
            <x-calc.field name="bed" label="Bedtime" value="22:00" type="time" />
        </div>
    </div>

    <div data-show-when="mode:hourly" hidden>
        <x-calc.field name="first" label="First dose" value="06:00" type="time" />
    </div>

    <x-calc.result label="Dose times" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'awake', 'times' => '3', 'wake' => '07:00', 'bed' => '22:00', 'first' => '06:00'],
        'Every 8 hours' => ['mode' => 'hourly', 'times' => '3', 'wake' => '07:00', 'bed' => '22:00', 'first' => '06:00'],
        'Four times' => ['mode' => 'awake', 'times' => '4', 'wake' => '06:30', 'bed' => '22:30', 'first' => '06:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gap' => ['label' => 'Spacing'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Schedule" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gap = (bed − wake) ÷ (n − 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
