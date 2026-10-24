<x-calc.page
    title="Reorder Point Calculator - SolveKit"
    description="Free reorder point calculator: when to reorder stock, with safety stock from a service level."
    lede="Find the reorder point."
    about="Reorder when stock falls to the demand during the lead time plus safety stock."
    :calc="['engine' => 'ot-misc', 'tool' => 'reorder_point', 'fields' => ['demand', 'lead', 'method', 'safety', 'sdDemand', 'service'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the reorder point in the example?', 'answer' => '333 units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="demand" label="Average daily demand (units)" value="40" min="0" step="any" />
        <x-calc.field name="lead" label="Lead time (days)" value="7" min="0" step="any" />
        <x-calc.select name="method" label="Safety stock" :options="['fixed' => 'A fixed number', 'service' => 'From a service level']" selected="service" />
        <div data-show-when="method:fixed">
            <x-calc.field name="safety" label="Safety stock (units)" value="60" min="0" step="any" />
        </div>
        <div data-show-when="method:service">
            <x-calc.field name="sdDemand" label="Standard deviation of daily demand" value="12" min="0" step="any" />
        </div>
        <div data-show-when="method:service">
            <x-calc.field name="service" label="Service level (%)" value="95" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Reorder point" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['demand' => 40, 'lead' => 7, 'method' => 'service', 'safety' => 60, 'sdDemand' => 12, 'service' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lt' => ['label' => 'Demand during the lead time'],
            'ss' => ['label' => 'Safety stock'],
            'z' => ['label' => 'z for the service level'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
