<x-tool-page-layout
    title="Pounds and Ounces Converter - SolveKit"
    description="Professional pounds and ounces converter for imperial weight measurements. Convert between pounds, ounces, and metric units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Pounds &amp; Ounces</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Imperial Weight Input -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Imperial Weight
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-4">
                                                                                    <div>
                                                                                        <label for="pounds" class="block text-xs font-medium text-slate-500 mb-1">Pounds</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="pounds" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 10"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">lbs</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="ounces" class="block text-xs font-medium text-slate-500 mb-1">Ounces</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="ounces" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 8"
                                                                                                step="any"
                                                                                                min="0"
                                                                                                max="15.999"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">oz</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">16 ounces = 1 pound</p>
                                                                            </div>

                                                                            <!-- Metric Unit Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="metricUnit" class="block text-sm font-semibold text-slate-700">
                                                                                    Metric Unit for Display
                                                                                </label>
                                                                                <select 
                                                                                    id="metricUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="mcg">Micrograms (µg)</option>
                                                                                    <option value="mg">Milligrams (mg)</option>
                                                                                    <option value="g" selected>Grams (g)</option>
                                                                                    <option value="dag">Decagrams (dag)</option>
                                                                                    <option value="kg">Kilograms (kg)</option>
                                                                                    <option value="t">Metric tons (t)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Weight Presets -->
                                                                            

                                                                            <!-- Auto-normalize Toggle -->
                                                                            <div class="space-y-2">
                                                                                <label class="flex items-center space-x-2">
                                                                                    <input type="checkbox" id="autoNormalize" class="text-teal-600 focus:ring-slate-200 rounded" checked>
                                                                                    <span class="text-sm font-medium text-slate-700">Auto-normalize (convert excess ounces to pounds)</span>
                                                                                </label>
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
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Combined Imperial Weight -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Combined Imperial Weight</h4>
                                                                                        <p class="text-[11px] text-slate-500">Pounds and ounces together</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="combinedOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">lbs + oz</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Primary Metric Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="metricTitle">Weight in Grams</h4>
                                                                                        <p class="text-[11px] text-slate-500">Metric weight measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="metricOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="metricUnitDisplay">g</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Weight Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Total Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="totalOuncesOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Decimal Pounds</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="decimalPoundsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Stone & Pounds</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="stoneOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Metric Units Display -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-3 text-center">All Metric Conversions</h4>
                                                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs text-slate-500">
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="mcgOutput">-- µg</div>
                                                                                        <div>Micrograms</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="mgOutput">-- mg</div>
                                                                                        <div>Milligrams</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="gOutput">-- g</div>
                                                                                        <div>Grams</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="dagOutput">-- dag</div>
                                                                                        <div>Decagrams</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="kgOutput">-- kg</div>
                                                                                        <div>Kilograms</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="tOutput">-- t</div>
                                                                                        <div>Metric tons</div>
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
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                                    Common Weight Presets
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-slate-700 hover:text-teal-700 rounded-lg transition-colors" data-pounds="1" data-ounces="0">1 lb</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-slate-700 hover:text-teal-700 rounded-lg transition-colors" data-pounds="2" data-ounces="8">2.5 lbs</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-slate-700 hover:text-teal-700 rounded-lg transition-colors" data-pounds="5" data-ounces="0">5 lbs</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-slate-700 hover:text-teal-700 rounded-lg transition-colors" data-pounds="10" data-ounces="0">10 lbs</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Weight Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 pound = 16 ounces</div>
                                                        <div>• 1 stone = 14 pounds</div>
                                                        <div>• 1 pound = 453.592 grams</div>
                                                        <div>• 1 ounce = 28.3495 grams</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Pounds and Ounces Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Imperial Weight System</h4>
                                    <p>The imperial weight system uses pounds and ounces as primary units. This converter helps you work with mixed units (pounds + ounces) and convert to various metric equivalents with high precision.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for cooking, shipping, body weight tracking, baby weight monitoring, postal services, and any situation requiring conversion between imperial and metric weight systems.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Auto-normalize Feature:</strong> When enabled, excess ounces (16 or more) are automatically converted to additional pounds!
                                </p>
                            </div>
                        </div>

                        <!-- Common Weight Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Weight Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Baby Weight</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pounds="7" data-ounces="8">7 lbs 8 oz</div>
                                    <div class="text-[11px] text-slate-500">≈ 3.4 kg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Bag of Sugar</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pounds="4" data-ounces="6">4 lbs 6 oz</div>
                                    <div class="text-[11px] text-slate-500">≈ 2 kg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Package</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pounds="2" data-ounces="12">2 lbs 12 oz</div>
                                    <div class="text-[11px] text-slate-500">≈ 1.25 kg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Roast</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pounds="12" data-ounces="4">12 lbs 4 oz</div>
                                    <div class="text-[11px] text-slate-500">≈ 5.55 kg</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const poundsEl = document.getElementById('pounds');
                        const ouncesEl = document.getElementById('ounces');
                        const metricUnitEl = document.getElementById('metricUnit');
                        const autoNormalize = document.getElementById('autoNormalize');
                        const clearButton = document.getElementById('clearButton');
                        const combinedOutput = document.getElementById('combinedOutput');
                        const metricOutput = document.getElementById('metricOutput');
                        const metricTitle = document.getElementById('metricTitle');
                        const metricUnitDisplay = document.getElementById('metricUnitDisplay');
                        const totalOuncesOutput = document.getElementById('totalOuncesOutput');
                        const decimalPoundsOutput = document.getElementById('decimalPoundsOutput');
                        const stoneOutput = document.getElementById('stoneOutput');
                        const mcgOutput = document.getElementById('mcgOutput');
                        const mgOutput = document.getElementById('mgOutput');
                        const gOutput = document.getElementById('gOutput');
                        const dagOutput = document.getElementById('dagOutput');
                        const kgOutput = document.getElementById('kgOutput');
                        const tOutput = document.getElementById('tOutput');

                        // Conversion factors from grams
                        const gramsPerUnit = {
                            mcg: 1e6,
                            mg: 1000,
                            g: 1,
                            dag: 0.1,
                            kg: 0.001,
                            t: 1e-6
                        };

                        const unitNames = {
                            mcg: 'Micrograms',
                            mg: 'Milligrams',
                            g: 'Grams',
                            dag: 'Decagrams',
                            kg: 'Kilograms',
                            t: 'Metric tons'
                        };

                        const unitSymbols = {
                            mcg: 'µg',
                            mg: 'mg',
                            g: 'g',
                            dag: 'dag',
                            kg: 'kg',
                            t: 't'
                        };

                        function formatNumber(num, unit = 'g') {
                            if ((unit === 'mcg' || unit === 'mg') && num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 0 });
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function normalizeWeight(pounds, ounces) {
                            if (!autoNormalize.checked) {
                                return { pounds, ounces };
                            }

                            const totalOunces = pounds * 16 + ounces;
                            const normalizedPounds = Math.floor(totalOunces / 16);
                            const normalizedOunces = totalOunces % 16;
                            
                            return { 
                                pounds: normalizedPounds, 
                                ounces: normalizedOunces 
                            };
                        }

                        function convert() {
                            const inputPounds = parseFloat(poundsEl.value) || 0;
                            const inputOunces = parseFloat(ouncesEl.value) || 0;
                            
                            // Normalize if auto-normalize is enabled
                            const { pounds, ounces } = normalizeWeight(inputPounds, inputOunces);
                            
                            // Update inputs if normalization occurred
                            if (autoNormalize.checked && (pounds !== inputPounds || ounces !== inputOunces)) {
                                poundsEl.value = pounds;
                                ouncesEl.value = formatNumber(ounces);
                            }

                            const totalOunces = pounds * 16 + ounces;
                            const totalGrams = totalOunces * 28.3495;
                            const selectedUnit = metricUnitEl.value;
                            const metricResult = totalGrams * gramsPerUnit[selectedUnit];

                            // Update combined output
                            if (pounds > 0 || ounces > 0) {
                                combinedOutput.textContent = `${formatNumber(pounds)} lbs ${formatNumber(ounces)} oz`;
                            } else {
                                combinedOutput.textContent = '--';
                            }

                            // Update primary metric output
                            if (totalGrams > 0) {
                                metricOutput.textContent = formatNumber(metricResult, selectedUnit);
                                metricTitle.textContent = `Weight in ${unitNames[selectedUnit]}`;
                                metricUnitDisplay.textContent = unitSymbols[selectedUnit];
                            } else {
                                metricOutput.textContent = '--';
                                metricTitle.textContent = `Weight in ${unitNames[selectedUnit]}`;
                                metricUnitDisplay.textContent = unitSymbols[selectedUnit];
                            }

                            // Update additional conversions
                            if (totalGrams > 0) {
                                const decimalPounds = totalOunces / 16;
                                const stone = Math.floor(decimalPounds / 14);
                                const remainingPounds = decimalPounds % 14;

                                totalOuncesOutput.textContent = formatNumber(totalOunces) + ' oz';
                                decimalPoundsOutput.textContent = formatNumber(decimalPounds) + ' lbs';
                                
                                if (stone > 0) {
                                    stoneOutput.textContent = `${stone} st ${formatNumber(remainingPounds)} lbs`;
                                } else {
                                    stoneOutput.textContent = formatNumber(decimalPounds) + ' lbs';
                                }

                                // Update all metric units
                                mcgOutput.textContent = formatNumber(totalGrams * gramsPerUnit.mcg, 'mcg') + ' µg';
                                mgOutput.textContent = formatNumber(totalGrams * gramsPerUnit.mg, 'mg') + ' mg';
                                gOutput.textContent = formatNumber(totalGrams * gramsPerUnit.g) + ' g';
                                dagOutput.textContent = formatNumber(totalGrams * gramsPerUnit.dag) + ' dag';
                                kgOutput.textContent = formatNumber(totalGrams * gramsPerUnit.kg) + ' kg';
                                tOutput.textContent = formatNumber(totalGrams * gramsPerUnit.t, 't') + ' t';
                            } else {
                                totalOuncesOutput.textContent = '--';
                                decimalPoundsOutput.textContent = '--';
                                stoneOutput.textContent = '--';
                                mcgOutput.textContent = '--';
                                mgOutput.textContent = '--';
                                gOutput.textContent = '--';
                                dagOutput.textContent = '--';
                                kgOutput.textContent = '--';
                                tOutput.textContent = '--';
                            }
                        }

                        function clearAll() {
                            poundsEl.value = '';
                            ouncesEl.value = '';
                            convert();
                            poundsEl.focus();
                        }

                        // Event listeners
                        poundsEl.addEventListener('input', convert);
                        ouncesEl.addEventListener('input', convert);
                        metricUnitEl.addEventListener('change', convert);
                        autoNormalize.addEventListener('change', convert);
                        clearButton.addEventListener('click', clearAll);

                        // Weight preset buttons
                        const weightPresets = document.querySelectorAll('.weight-preset');
                        weightPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const pounds = this.getAttribute('data-pounds');
                                const ounces = this.getAttribute('data-ounces');
                                
                                poundsEl.value = pounds;
                                ouncesEl.value = ounces;
                                convert();
                                
                                // Update button styles
                                weightPresets.forEach(btn => btn.classList.remove('bg-teal-100', 'text-teal-700'));
                                weightPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-teal-100', 'text-teal-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-pounds][data-ounces]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const pounds = this.getAttribute('data-pounds');
                                const ounces = this.getAttribute('data-ounces');
                                
                                poundsEl.value = pounds;
                                ouncesEl.value = ounces;
                                convert();
                                poundsEl.focus();
                            });
                        });

                        // Initialize
                        poundsEl.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            } else if (e.ctrlKey && e.key === 'n') {
                                e.preventDefault();
                                // Toggle auto-normalize
                                autoNormalize.checked = !autoNormalize.checked;
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
