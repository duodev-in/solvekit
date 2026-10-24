<x-calc.page
    title="Blink-free Photo Calculator - SolveKit"
    description="Free blink-free photo calculator: how many group photos to take so that nobody blinks."
    lede="Avoid blinks in group photos."
    about="The more people in a photo, the more likely someone blinks. CSIRO scientists worked out how many shots you need."
    :calc="['engine' => 'tc-photo', 'tool' => 'blink', 'fields' => ['people', 'light', 'blinkMs', 'shutter'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many photos for 20 people in good light?', 'answer' => 'About 3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="people" label="People in the photo" value="20" min="1" step="any" />
        <x-calc.select name="light" label="Light" :options="['good' => 'Good light (about 10 blinks a minute)', 'poor' => 'Poor light (blink more often)']" selected="good" />
        <x-calc.field name="blinkMs" label="Blink duration (ms)" value="250" min="0" step="any" />
        <x-calc.field name="shutter" label="Shutter speed (1/x s)" value="125" min="1" step="any" />
    </div>

    <x-calc.result label="Photos to take" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['people' => 20, 'light' => 'good', 'blinkMs' => 250, 'shutter' => 125],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pPhoto' => ['label' => 'Chance one photo is blink-free'],
            'for90' => ['label' => 'Photos for a 90% chance'],
            'rule' => ['label' => 'Barnes’s rule of thumb'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
