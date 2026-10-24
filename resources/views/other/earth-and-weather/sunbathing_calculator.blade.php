<x-calc.page
    title="Sunbathing Calculator - SolveKit"
    description="Free sunbathing calculator: time until sunburn from the UV index, skin type and sunscreen."
    lede="Find your safe sun time."
    about="Sunburn starts when your skin receives its minimal erythemal dose; the UV index sets how fast."
    :calc="['engine' => 'ot-misc', 'tool' => 'sunbathing', 'fields' => ['uvi', 'skin', 'spf'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['med'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long until skin type III burns at UV 8?', 'answer' => 'about 33.3 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="uvi" label="UV index" value="8" min="0" step="any" />
        <x-calc.select name="skin" label="Skin type (Fitzpatrick)" :options="['I' => 'Type I (always burns, never tans)', 'II' => 'Type II (usually burns, tans little)', 'III' => 'Type III (sometimes burns, tans gradually)', 'IV' => 'Type IV (rarely burns, tans well)', 'V' => 'Type V (very rarely burns)', 'VI' => 'Type VI (never burns)']" selected="III" />
        <x-calc.field name="spf" label="Sunscreen SPF (1 = none)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="Time until sunburn" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['uvi' => 8, 'skin' => 'III', 'spf' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Range for your skin type'],
            'withSpf' => ['label' => 'With sunscreen (applied thickly, ideal)'],
            'med' => ['label' => 'Minimal erythemal dose'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
