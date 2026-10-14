<x-tool-page-layout
    title="Quarts to Pounds Converter - SolveKit"
    description="Professional quarts to pounds converter for cooking and baking. Convert volume to weight using ingredient density for accurate recipe measurements."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Quarts to Pounds</h1>
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
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-fuchsia-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="quarts-to-pounds" class="text-fuchsia-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Quarts → Pounds</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-fuchsia-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="pounds-to-quarts" class="text-fuchsia-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Pounds → Quarts</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Ingredient Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="ingredient" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Ingredient
                                                                                </label>
                                                                                <select 
                                                                                    id="ingredient" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">Select ingredient</option>
                                                                                    <optgroup label="Liquids">
                                                                                        <option value="Water">Water</option>
                                                                                        <option value="Milk">Milk</option>
                                                                                        <option value="Cream 30% fat">Heavy Cream (30% fat)</option>
                                                                                        <option value="Cream 13% fat">Light Cream (13% fat)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Sweeteners">
                                                                                        <option value="Sugar">Sugar</option>
                                                                                        <option value="Honey">Honey</option>
                                                                                        <option value="Maple syrup">Maple Syrup</option>
                                                                                        <option value="Jam">Jam</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Baking Ingredients">
                                                                                        <option value="Flour">All-Purpose Flour</option>
                                                                                        <option value="Salt">Salt</option>
                                                                                        <option value="Butter">Butter</option>
                                                                                        <option value="Oil">Cooking Oil</option>
                                                                                        <option value="Cacao">Cocoa Powder</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Grains & Nuts">
                                                                                        <option value="Rice (raw)">Rice (raw)</option>
                                                                                        <option value="Oats">Oats</option>
                                                                                        <option value="Nuts and seeds">Nuts and Seeds</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialty">
                                                                                        <option value="Nutella">Nutella</option>
                                                                                        <option value="Custom">Custom Ingredient</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Density Field -->
                                                                            <div id="customDensityContainer" class="space-y-2 hidden">
                                                                                <label for="customDensity" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customDensity" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter density (e.g., 1.15)"
                                                                                        step="0.001"
                                                                                        min="0.001"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">g/mL</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Current Density Display -->
                                                                            <div class="p-3 bg-fuchsia-50 rounded-lg border border-fuchsia-200">
                                                                                <div class="flex items-center justify-between">
                                                                                    <span class="text-sm font-semibold text-fuchsia-800">Current Ingredient Density:</span>
                                                                                    <span class="text-lg font-bold text-fuchsia-700" id="densityDisplay">-- g/mL</span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Values -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="space-y-2">
                                                                                    <label for="quartsInput" class="block text-sm font-semibold text-slate-700" id="volumeLabel">
                                                                                        Volume (Quarts)
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="quartsInput" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter volume (e.g., 2)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium" id="volumeUnit">qt</span>
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
                                                                                            placeholder="Enter weight (e.g., 2.08)"
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

                                                                            <!-- Additional Volume/Weight Conversions -->
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Pints</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="pintsOutput">--</div>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="cupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Calculation Steps -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-2 text-center">Calculation Steps</h4>
                                                                                <div class="text-center text-[11px] text-slate-500 font-mono" id="calculationSteps">
                                                                                    Select ingredient and enter values to see calculation steps
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
                                                    <div class="p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Cooking Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 quart = 946.353 mL</div>
                                                        <div>• 1 quart = 2 pints</div>
                                                        <div>• 1 quart = 4 cups</div>
                                                        <div>• 1 pound = 453.592 grams</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Quarts to Pounds Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Ingredient-Based Conversion</h4>
                                    <p>Converting quarts (volume) to pounds (weight) requires knowing the ingredient's density. Different ingredients have different densities, so the same volume can have very different weights depending on the ingredient.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Cooking Applications</h4>
                                    <p>Perfect for large batch cooking, commercial kitchens, recipe scaling, and converting between volume-based and weight-based recipes. Essential for professional baking where precision matters.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cooking Tip:</strong> Ingredient densities can vary based on factors like temperature, moisture content, and how tightly packed the ingredient is!
                                </p>
                            </div>
                        </div>

                        <!-- Common Cooking Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Cooking Conversions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water/Broth</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ingredient="Water" data-quarts="1">1 quart</div>
                                    <div class="text-[11px] text-slate-500">≈ 2.08 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Milk</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ingredient="Milk" data-quarts="1">1 quart</div>
                                    <div class="text-[11px] text-slate-500">≈ 2.14 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Flour</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ingredient="Flour" data-quarts="1">1 quart</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.23 lbs</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Sugar</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ingredient="Sugar" data-quarts="1">1 quart</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.76 lbs</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ingredientSelect = document.getElementById('ingredient');
                        const customDensityInput = document.getElementById('customDensity');
                        const customDensityContainer = document.getElementById('customDensityContainer');
                        const directionRadios = document.getElementsByName('direction');
                        const quartsInput = document.getElementById('quartsInput');
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
                        const pintsOutput = document.getElementById('pintsOutput');
                        const litersOutput = document.getElementById('litersOutput');
                        const cupsOutput = document.getElementById('cupsOutput');
                        const calculationSteps = document.getElementById('calculationSteps');

                        // Ingredient densities (g/mL)
                        const densities = {
                            "Water": 1.00,
                            "Milk": 1.03,
                            "Flour": 0.593,
                            "Sugar": 0.845,
                            "Salt": 1.20,
                            "Honey": 1.42,
                            "Butter": 0.911,
                            "Oil": 0.92,
                            "Nuts and seeds": 0.60,
                            "Cacao": 0.55,
                            "Rice (raw)": 0.85,
                            "Oats": 0.38,
                            "Jam": 1.34,
                            "Nutella": 1.27,
                            "Maple syrup": 1.33,
                            "Cream 30% fat": 0.994,
                            "Cream 13% fat": 1.012
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

                        function updateDensity() {
                            const ingredient = ingredientSelect.value;

                            if (ingredient === "Custom") {
                                customDensityContainer.classList.remove('hidden');
                                currentDensity = parseFloat(customDensityInput.value) || 1;
                            } else {
                                customDensityContainer.classList.add('hidden');
                                currentDensity = densities[ingredient] || 1;
                            }

                            densityDisplay.textContent = formatNumber(currentDensity) + ' g/mL';
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (direction === 'quarts-to-pounds') {
                                volumeLabel.textContent = 'Volume (Quarts)';
                                weightLabel.textContent = 'Weight (Pounds)';
                                quartsInput.placeholder = 'Enter volume (e.g., 2)';
                                poundsInput.placeholder = 'Weight will be calculated';
                                poundsInput.readOnly = true;
                                quartsInput.readOnly = false;
                                poundsInput.classList.add('bg-gray-100');
                                quartsInput.classList.remove('bg-gray-100');
                            } else {
                                volumeLabel.textContent = 'Volume (Quarts)';
                                weightLabel.textContent = 'Weight (Pounds)';
                                quartsInput.placeholder = 'Volume will be calculated';
                                poundsInput.placeholder = 'Enter weight (e.g., 2.08)';
                                quartsInput.readOnly = true;
                                poundsInput.readOnly = false;
                                quartsInput.classList.add('bg-gray-100');
                                poundsInput.classList.remove('bg-gray-100');
                            }
                        }

                        function convertQuartsToPounds() {
                            const quarts = parseFloat(quartsInput.value);
                            if (!isNaN(quarts) && currentDensity > 0) {
                                const ml = quarts * 946.353;
                                const grams = ml * currentDensity;
                                const pounds = grams / 453.592;
                                
                                poundsInput.value = formatNumber(pounds);
                                updateOutputs(quarts, pounds);
                                updateCalculationSteps(quarts, pounds, 'quarts-to-pounds');
                            } else {
                                clearOutputs();
                            }
                        }

                        function convertPoundsToQuarts() {
                            const pounds = parseFloat(poundsInput.value);
                            if (!isNaN(pounds) && currentDensity > 0) {
                                const grams = pounds * 453.592;
                                const ml = grams / currentDensity;
                                const quarts = ml / 946.353;
                                
                                quartsInput.value = formatNumber(quarts);
                                updateOutputs(quarts, pounds);
                                updateCalculationSteps(quarts, pounds, 'pounds-to-quarts');
                            } else {
                                clearOutputs();
                            }
                        }

                        function updateOutputs(quarts, pounds) {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            
                            if (direction === 'quarts-to-pounds') {
                                output.textContent = formatNumber(pounds);
                                unitDisplay.textContent = 'lbs';
                                resultTitle.textContent = 'Weight in Pounds';
                                resultDescription.textContent = 'Imperial weight measurement';
                            } else {
                                output.textContent = formatNumber(quarts);
                                unitDisplay.textContent = 'qt';
                                resultTitle.textContent = 'Volume in Quarts';
                                resultDescription.textContent = 'Imperial volume measurement';
                            }

                            // Additional conversions
                            const ounces = pounds * 16;
                            const kg = pounds * 0.453592;
                            const grams = pounds * 453.592;
                            const pints = quarts * 2;
                            const liters = quarts * 0.946353;
                            const cups = quarts * 4;

                            ouncesOutput.textContent = formatNumber(ounces) + ' oz';
                            kgOutput.textContent = formatNumber(kg) + ' kg';
                            gramsOutput.textContent = formatNumber(grams) + ' g';
                            pintsOutput.textContent = formatNumber(pints) + ' pt';
                            litersOutput.textContent = formatNumber(liters) + ' L';
                            cupsOutput.textContent = formatNumber(cups) + ' cups';
                        }

                        function updateCalculationSteps(quarts, pounds, direction) {
                            if (direction === 'quarts-to-pounds') {
                                calculationSteps.textContent = `${formatNumber(quarts)} qt × 946.353 mL/qt × ${formatNumber(currentDensity)} g/mL ÷ 453.592 g/lb = ${formatNumber(pounds)} lbs`;
                            } else {
                                calculationSteps.textContent = `${formatNumber(pounds)} lbs × 453.592 g/lb ÷ (946.353 mL/qt × ${formatNumber(currentDensity)} g/mL) = ${formatNumber(quarts)} qt`;
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            ouncesOutput.textContent = '--';
                            kgOutput.textContent = '--';
                            gramsOutput.textContent = '--';
                            pintsOutput.textContent = '--';
                            litersOutput.textContent = '--';
                            cupsOutput.textContent = '--';
                            calculationSteps.textContent = 'Select ingredient and enter values to see calculation steps';
                        }

                        function clearAll() {
                            quartsInput.value = '';
                            poundsInput.value = '';
                            ingredientSelect.selectedIndex = 0;
                            customDensityInput.value = '';
                            customDensityContainer.classList.add('hidden');
                            currentDensity = 1;
                            densityDisplay.textContent = '-- g/mL';
                            clearOutputs();
                            quartsInput.focus();
                        }

                        // Event listeners
                        ingredientSelect.addEventListener('change', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'quarts-to-pounds') {
                                convertQuartsToPounds();
                            } else {
                                convertPoundsToQuarts();
                            }
                        });

                        customDensityInput.addEventListener('input', () => {
                            updateDensity();
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            if (direction === 'quarts-to-pounds') {
                                convertQuartsToPounds();
                            } else {
                                convertPoundsToQuarts();
                            }
                        });

                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                clearOutputs();
                                quartsInput.value = '';
                                poundsInput.value = '';
                            });
                        });

                        quartsInput.addEventListener('input', convertQuartsToPounds);
                        poundsInput.addEventListener('input', convertPoundsToQuarts);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-ingredient]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const ingredient = this.getAttribute('data-ingredient');
                                const quarts = this.getAttribute('data-quarts');
                                
                                ingredientSelect.value = ingredient;
                                updateDensity();
                                
                                document.querySelector('input[value="quarts-to-pounds"]').checked = true;
                                updateLabels();
                                
                                quartsInput.value = quarts;
                                convertQuartsToPounds();
                                quartsInput.focus();
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
                                const newDirection = currentDirection === 'quarts-to-pounds' ? 'pounds-to-quarts' : 'quarts-to-pounds';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                clearOutputs();
                                quartsInput.value = '';
                                poundsInput.value = '';
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
