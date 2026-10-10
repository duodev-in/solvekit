<x-tool-page-layout
    title="Weight Converter - ConvertPro"
    description="Professional weight converter to convert between grams, pounds, kilograms, ounces, and other weight units. Fast and accurate conversions."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Weight Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700">
                                                                                    Enter Weight Value
                                                                                </label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    id="inputValue" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                    placeholder="Enter weight (e.g., 50)"
                                                                                    step="any"
                                                                                    min="0"
                                                                                >
                                                                            </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-slate-700">
                                                                                        From Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="mg">Milligram (mg)</option>
                                                                                        <option value="g" selected>Gram (g)</option>
                                                                                        <option value="kg">Kilogram (kg)</option>
                                                                                        <option value="oz">Ounce (oz)</option>
                                                                                        <option value="lb">Pound (lb)</option>
                                                                                        <option value="t">Tonne (t)</option>
                                                                                        <option value="st">Stone (st)</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-slate-700">
                                                                                        To Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="mg">Milligram (mg)</option>
                                                                                        <option value="g">Gram (g)</option>
                                                                                        <option value="kg" selected>Kilogram (kg)</option>
                                                                                        <option value="oz">Ounce (oz)</option>
                                                                                        <option value="lb">Pound (lb)</option>
                                                                                        <option value="t">Tonne (t)</option>
                                                                                        <option value="st">Stone (st)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
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
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Weight</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select units</div>
                                                                                    </div>
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
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Quick Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 kg = 1000 g</div>
                                                        <div>• 1 lb = 16 oz</div>
                                                        <div>• 1 kg = 2.205 lb</div>
                                                        <div>• 1 oz = 28.35 g</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Weight Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Mass vs Weight</h4>
                                    <p>While technically different (mass is constant, weight varies with gravity), in everyday use these terms are often interchangeable for practical measurements and conversions.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Essential for cooking, shipping, scientific measurements, medical dosages, and international trade where different unit systems are used.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Pro Tip:</strong> For precise scientific work, always consider whether you need mass (kg) or weight (Newtons) measurements!
                                </p>
                            </div>
                        </div>

                        <!-- Common Weight Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Weight Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Paper Clip</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="1" data-unit="g">1 g</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Apple</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="200" data-unit="g">200 g</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Bag of Sugar</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="1" data-unit="kg">1 kg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Person</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="70" data-unit="kg">70 kg</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');

                        const conversionRates = {
                            mg: { toGrams: 0.001, symbol: 'mg', name: 'Milligrams' },
                            g: { toGrams: 1, symbol: 'g', name: 'Grams' },
                            kg: { toGrams: 1000, symbol: 'kg', name: 'Kilograms' },
                            oz: { toGrams: 28.3495, symbol: 'oz', name: 'Ounces' },
                            lb: { toGrams: 453.592, symbol: 'lb', name: 'Pounds' },
                            t: { toGrams: 1000000, symbol: 't', name: 'Tonnes' },
                            st: { toGrams: 6350.29, symbol: 'st', name: 'Stone' }
                        };

                        function formatNumber(num) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function convertWeight() {
                            const value = parseFloat(inputValue.value);
                            const fromUnitValue = fromUnit.value;
                            const toUnitValue = toUnit.value;

                            if (!isNaN(value) && value >= 0) {
                                const grams = value * conversionRates[fromUnitValue].toGrams;
                                const result = grams / conversionRates[toUnitValue].toGrams;
                                
                                output.textContent = formatNumber(result);
                                unitDisplay.textContent = conversionRates[toUnitValue].symbol;
                                resultTitle.textContent = 'Weight in ' + conversionRates[toUnitValue].name;
                                resultDescription.textContent = `${value} ${conversionRates[fromUnitValue].symbol} = ${formatNumber(result)} ${conversionRates[toUnitValue].symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select units";
                                resultTitle.textContent = 'Converted Weight';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function clearInput() {
                            inputValue.value = '';
                            convertWeight();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convertWeight);
                        fromUnit.addEventListener('change', convertWeight);
                        toUnit.addEventListener('change', convertWeight);
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example weights
                        const exampleWeights = document.querySelectorAll('[data-weight]');
                        exampleWeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const weightValue = this.getAttribute('data-weight');
                                const unitValue = this.getAttribute('data-unit');
                                
                                inputValue.value = weightValue;
                                fromUnit.value = unitValue;
                                convertWeight();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        convertWeight();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
