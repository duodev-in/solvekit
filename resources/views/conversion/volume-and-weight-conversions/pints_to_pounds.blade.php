<x-tool-page-layout
    title="Pints to Pounds Converter - ConvertPro"
    description="Professional pints to pounds converter using substance density. Convert volume to weight for various materials and substances."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Pints to Pounds</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="pints-to-pounds" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Pints → Pounds</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="pounds-to-pints" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Pounds → Pints</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Category Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="category" class="block text-sm font-semibold text-slate-700">
                                                                                    Substance Category
                                                                                </label>
                                                                                <select 
                                                                                    id="category" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select substance category</option>
                                                                                    <option value="liquids">Liquids</option>
                                                                                    <option value="dairy">Dairy Products</option>
                                                                                    <option value="oils">Oils and Fats</option>
                                                                                    <option value="fruits">Fruits & Vegetables</option>
                                                                                    <option value="flour">Flour & Grains</option>
                                                                                    <option value="sweeteners">Sweeteners</option>
                                                                                    <option value="cereals">Cereals</option>
                                                                                    <option value="nuts">Nuts & Seeds</option>
                                                                                    <option value="sauces">Sauces & Condiments</option>
                                                                                    <option value="spices">Herbs & Spices</option>
                                                                                    <option value="custom">Custom Density</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Item Selection -->
                                                                            <div id="itemField" class="space-y-2 hidden">
                                                                                <label for="item" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Specific Item
                                                                                </label>
                                                                                <select 
                                                                                    id="item" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select an item</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Density Field -->
                                                                            <div id="densityField" class="space-y-2 hidden">
                                                                                <label for="manualDensity" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Density
                                                                                </label>
                                                                                <div class="grid grid-cols-3 gap-2">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="manualDensity" 
                                                                                        class="col-span-2 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter density"
                                                                                        step="any"
                                                                                        min="0.001"
                                                                                    >
                                                                                    <select 
                                                                                        id="densityUnit" 
                                                                                        class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="g_cm3">g/cm³</option>
                                                                                        <option value="g_ml">g/mL</option>
                                                                                        <option value="kg_m3">kg/m³</option>
                                                                                        <option value="kg_l">kg/L</option>
                                                                                        <option value="oz_in3">oz/in³</option>
                                                                                        <option value="lb_ft3">lb/ft³</option>
                                                                                        <option value="lb_gal">lb/gal</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Current Density Display -->
                                                                            <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                                                                <div class="flex items-center justify-between">
                                                                                    <span class="text-sm font-semibold text-yellow-800">Current Density:</span>
                                                                                    <span class="text-lg font-bold text-yellow-700" id="densityDisplay">-- g/mL</span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Values -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="space-y-2">
                                                                                    <label for="pintsInput" class="block text-sm font-semibold text-slate-700" id="volumeLabel">
                                                                                        Volume (Pints)
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="pintsInput" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter volume (e.g., 1)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium" id="volumeUnit">pt</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="poundsInput" class="block text-sm font-semibold text-slate-700" id="weightLabel">
                                                                                        Weight (Pounds)
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="poundsInput" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter weight (e.g., 1.04)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium" id="weightUnit">lbs</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + M to switch mode</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Weight in Pounds</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Imperial weight measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">lbs</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Weight/Volume Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="ouncesOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Grams</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="gramsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Volume Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="cupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Milliliters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mlOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Calculation Steps -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-2 text-center">Calculation Steps</h4>
                                                                                <div class="text-center text-[11px] text-slate-500 font-mono" id="calculationSteps">
                                                                                    Select substance and enter values to see calculation steps
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Volume & Weight Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 pint = 473.176 mL</div>
                                                        <div>• 1 pound = 453.592 grams</div>
                                                        <div>• Water density = 1.0 g/mL</div>
                                                        <div>• 1 pint water ≈ 1.04 pounds</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Pints to Pounds Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Density-Based Conversion</h4>
                                    <p>Converting pints (volume) to pounds (weight) requires knowing the substance's density. Different materials have different densities, so the same volume can have very different weights.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for cooking, baking, brewing, chemistry, manufacturing, shipping calculations, and any application where you need to convert between volume and weight measurements.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Density Note:</strong> Density values can vary with temperature and composition. Use appropriate values for your specific application!
                                </p>
                            </div>
                        </div>

                        <!-- Common Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Conversion Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="liquids" data-item="1" data-pints="1">1 pint</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.04 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Milk</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="dairy" data-item="1.03" data-pints="1">1 pint</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.07 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Honey</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="sweeteners" data-item="1.42" data-pints="1">1 pint</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.48 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Olive Oil</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="oils" data-item="0.91" data-pints="1">1 pint</div>
                                    <div class="text-[11px] text-slate-500">≈ 0.95 lbs</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const categoryEl = document.getElementById('category');
                        const itemEl = document.getElementById('item');
                        const itemField = document.getElementById('itemField');
                        const densityField = document.getElementById('densityField');
                        const manualDensityEl = document.getElementById('manualDensity');
                        const densityUnitEl = document.getElementById('densityUnit');
                        const directionRadios = document.getElementsByName('direction');
                        const pintsInput = document.getElementById('pintsInput');
                        const poundsInput = document.getElementById('poundsInput');
                        const volumeLabel = document.getElementById('volumeLabel');
                        const weightLabel = document.getElementById('weightLabel');
                        const volumeUnit = document.getElementById('volumeUnit');
                        const weightUnit = document.getElementById('weightUnit');
                        const densityDisplay = document.getElementById('densityDisplay');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const ouncesOutput = document.getElementById('ouncesOutput');
                        const kgOutput = document.getElementById('kgOutput');
                        const gramsOutput = document.getElementById('gramsOutput');
                        const cupsOutput = document.getElementById('cupsOutput');
                        const litersOutput = document.getElementById('litersOutput');
                        const mlOutput = document.getElementById('mlOutput');
                        const calculationSteps = document.getElementById('calculationSteps');

                        // Density conversion factors to g/mL
                        const densityUnitsToGPerMl = {
                            'g_cm3': 1,
                            'g_ml': 1,
                            'kg_m3': 0.001,
                            'kg_l': 1,
                            'oz_in3': 1.80469,
                            'lb_ft3': 0.0160185,
                            'lb_gal': 0.119826
                        };

                        // Substance densities (g/mL)
                        const densities = {
                            "liquids": {
                                "Water": 1,
                                "Grape soda": 1.03,
                                "Lemonade": 1.05,
                                "Beer": 1.01,
                                "Wine": 0.99
                            },
                            "dairy": {
                                "Whole milk": 1.03,
                                "Heavy cream": 1.01,
                                "Yogurt": 1.04,
                                "Buttermilk": 1.03,
                                "Ice cream": 0.56
                            },
                            "oils": {
                                "Olive oil": 0.91,
                                "Vegetable oil": 0.92,
                                "Coconut oil": 0.92,
                                "Butter (melted)": 0.87,
                                "Lard": 0.92
                            },
                            "fruits": {
                                "Apple puree": 1.05,
                                "Carrot juice": 1.03,
                                "Orange juice": 1.05,
                                "Tomato juice": 1.04
                            },
                            "flour": {
                                "All-purpose flour": 0.53,
                                "Whole wheat flour": 0.55,
                                "Bread flour": 0.54,
                                "Cake flour": 0.52
                            },
                            "sweeteners": {
                                "Honey": 1.42,
                                "Corn syrup": 1.36,
                                "Maple syrup": 1.37,
                                "Molasses": 1.4
                            },
                            "cereals": {
                                "Oats": 0.38,
                                "Rice": 0.75,
                                "Quinoa": 0.85,
                                "Barley": 0.68
                            },
                            "nuts": {
                                "Peanut butter": 1.1,
                                "Almond butter": 1.05,
                                "Tahini": 0.95
                            },
                            "sauces": {
                                "Ketchup": 1.25,
                                "Mayonnaise": 0.94,
                                "Soy sauce": 1.15,
                                "Hot sauce": 1.02
                            },
                            "spices": {
                                "Ground cinnamon": 0.56,
                                "Ground pepper": 0.35,
                                "Paprika": 0.45,
                                "Salt": 2.16
                            }
                        };

                        let currentDensity = 1;

                        function formatNumber(num) {
                            if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function populateItems(category) {
                            itemEl.innerHTML = `<option disabled selected>Select an item</option>`;
                            const items = densities[category];
                            if (items) {
                                for (const [name, density] of Object.entries(items)) {
                                    itemEl.innerHTML += `<option value="${density}">${name}</option>`;
                                }
                            }
                        }

                        function updateDensity() {
                            const category = categoryEl.value;

                            // Hide all conditional fields
                            itemField.classList.add('hidden');
                            densityField.classList.add('hidden');

                            if (category === 'custom') {
                                densityField.classList.remove('hidden');
                                const unit = densityUnitEl.value;
                                const rawDensity = parseFloat(manualDensityEl.value);
                                if (!isNaN(rawDensity)) {
                                    currentDensity = rawDensity * (densityUnitsToGPerMl[unit] || 1);
                                }
                            } else if (category && category !== 'Select substance category') {
                                populateItems(category);
                                itemField.classList.remove('hidden');
                                const selectedDensity = parseFloat(itemEl.value);
                                if (!isNaN(selectedDensity)) {
                                    currentDensity = selectedDensity;
                                }
                            }

                            densityDisplay.textContent = formatNumber(currentDensity) + ' g/mL';
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (direction === 'pints-to-pounds') {
                                volumeLabel.textContent = 'Volume (Pints)';
                                weightLabel.textContent = 'Weight (Pounds)';
                                pintsInput.placeholder = 'Enter volume (e.g., 1)';
                                poundsInput.placeholder = 'Weight will be calculated';
                                poundsInput.readOnly = true;
                                pintsInput.readOnly = false;
                                poundsInput.classList.add('bg-gray-100');
                                pintsInput.classList.remove('bg-gray-100');
                            } else {
                                volumeLabel.textContent = 'Volume (Pints)';
                                weightLabel.textContent = 'Weight (Pounds)';
                                pintsInput.placeholder = 'Volume will be calculated';
                                poundsInput.placeholder = 'Enter weight (e.g., 1.04)';
                                pintsInput.readOnly = true;
                                poundsInput.readOnly = false;
                                pintsInput.classList.add('bg-gray-100');
                                poundsInput.classList.remove('bg-gray-100');
                            }
                        }

                        function convertPintsToPounds() {
                            const pints = parseFloat(pintsInput.value);
                            if (!isNaN(pints) && currentDensity > 0) {
                                const pintToMl = 473.176;
                                const grams = pints * pintToMl * currentDensity;
                                const pounds = grams / 453.592;
                                
                                poundsInput.value = formatNumber(pounds);
                                updateOutputs(pints, pounds);
                                updateCalculationSteps(pints, pounds, 'pints-to-pounds');
                            } else {
                                clearOutputs();
                            }
                        }

                        function convertPoundsToPints() {
                            const pounds = parseFloat(poundsInput.value);
                            if (!isNaN(pounds) && currentDensity > 0) {
                                const grams = pounds * 453.592;
                                const pintToMl = 473.176;
                                const pints = grams / (pintToMl * currentDensity);
                                
                                pintsInput.value = formatNumber(pints);
                                updateOutputs(pints, pounds);
                                updateCalculationSteps(pints, pounds, 'pounds-to-pints');
                            } else {
                                clearOutputs();
                            }
                        }

                        function updateOutputs(pints, pounds) {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            
                            if (direction === 'pints-to-pounds') {
                                output.textContent = formatNumber(pounds);
                                unitDisplay.textContent = 'lbs';
                                resultTitle.textContent = 'Weight in Pounds';
                                resultDescription.textContent = 'Imperial weight measurement';
                            } else {
                                output.textContent = formatNumber(pints);
                                unitDisplay.textContent = 'pt';
                                resultTitle.textContent = 'Volume in Pints';
                                resultDescription.textContent = 'Imperial volume measurement';
                            }

                            // Additional conversions
                            const ounces = pounds * 16;
                            const kg = pounds * 0.453592;
                            const grams = pounds * 453.592;
                            const cups = pints * 2;
                            const liters = pints * 0.473176;
                            const ml = pints * 473.176;

                            ouncesOutput.textContent = formatNumber(ounces) + ' oz';
                            kgOutput.textContent = formatNumber(kg) + ' kg';
                            gramsOutput.textContent = formatNumber(grams) + ' g';
                            cupsOutput.textContent = formatNumber(cups) + ' cups';
                            litersOutput.textContent = formatNumber(liters) + ' L';
                            mlOutput.textContent = formatNumber(ml) + ' mL';
                        }

                        function updateCalculationSteps(pints, pounds, direction) {
                            if (direction === 'pints-to-pounds') {
                                calculationSteps.textContent = `${formatNumber(pints)} pt × 473.176 mL/pt × ${formatNumber(currentDensity)} g/mL ÷ 453.592 g/lb = ${formatNumber(pounds)} lbs`;
                            } else {
                                calculationSteps.textContent = `${formatNumber(pounds)} lbs × 453.592 g/lb ÷ (473.176 mL/pt × ${formatNumber(currentDensity)} g/mL) = ${formatNumber(pints)} pt`;
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            ouncesOutput.textContent = '--';
                            kgOutput.textContent = '--';
                            gramsOutput.textContent = '--';
                            cupsOutput.textContent = '--';
                            litersOutput.textContent = '--';
                            mlOutput.textContent = '--';
                            calculationSteps.textContent = 'Select substance and enter values to see calculation steps';
                        }

                        function clearAll() {
                            pintsInput.value = '';
                            poundsInput.value = '';
                            categoryEl.selectedIndex = 0;
                            itemEl.selectedIndex = 0;
                            manualDensityEl.value = '';
                            itemField.classList.add('hidden');
                            densityField.classList.add('hidden');
                            currentDensity = 1;
                            densityDisplay.textContent = '-- g/mL';
                            clearOutputs();
                            pintsInput.focus();
                        }

                        // Event listeners
                        categoryEl.addEventListener('change', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'pints-to-pounds') {
                                convertPintsToPounds();
                            } else {
                                convertPoundsToPints();
                            }
                        });

                        itemEl.addEventListener('change', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'pints-to-pounds') {
                                convertPintsToPounds();
                            } else {
                                convertPoundsToPints();
                            }
                        });

                        manualDensityEl.addEventListener('input', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'pints-to-pounds') {
                                convertPintsToPounds();
                            } else {
                                convertPoundsToPints();
                            }
                        });

                        densityUnitEl.addEventListener('change', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'pints-to-pounds') {
                                convertPintsToPounds();
                            } else {
                                convertPoundsToPints();
                            }
                        });

                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                clearOutputs();
                                pintsInput.value = '';
                                poundsInput.value = '';
                            });
                        });

                        pintsInput.addEventListener('input', convertPintsToPounds);
                        poundsInput.addEventListener('input', convertPoundsToPints);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-category]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const category = this.getAttribute('data-category');
                                const itemDensity = this.getAttribute('data-item');
                                const pints = this.getAttribute('data-pints');
                                
                                categoryEl.value = category;
                                updateDensity();
                                
                                if (itemDensity) {
                                    itemEl.value = itemDensity;
                                    updateDensity();
                                }
                                
                                document.querySelector('input[value="pints-to-pounds"]').checked = true;
                                updateLabels();
                                
                                pintsInput.value = pints;
                                convertPintsToPounds();
                                pintsInput.focus();
                            });
                        });

                        // Initialize
                        updateLabels();
                        clearOutputs();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                // Toggle direction
                                const currentDirection = document.querySelector('input[name="direction"]:checked').value;
                                const newDirection = currentDirection === 'pints-to-pounds' ? 'pounds-to-pints' : 'pints-to-pounds';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                clearOutputs();
                                pintsInput.value = '';
                                poundsInput.value = '';
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
