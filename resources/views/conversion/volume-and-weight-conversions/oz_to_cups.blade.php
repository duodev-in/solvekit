<x-tool-page-layout
    title="Ounces to Cups Converter - SolveKit"
    description="Professional ounces to cups converter for cooking and baking. Convert fluid ounces (fl oz) to cups with precision for recipe measurements."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Oz to Cups</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700" id="inputLabel">
                                                                                    Enter Volume in Fluid Ounces
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter volume (e.g., 16)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">fl oz</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500" id="conversionHint">1 cup = 8 fluid ounces</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="oz-to-cups" class="text-cyan-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Ounces → Cups</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="cups-to-oz" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Cups → Ounces</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Cup Standard Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Cup Standard
                                                                                </label>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="us" class="text-cyan-600 focus:ring-slate-200" checked>
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">US Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">8 fl oz</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="metric" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Metric Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">8.45 fl oz</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="imperial" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Imperial Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">9.61 fl oz</div>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Recipe Measurements -->
                                                                            

                                                                            <!-- Fraction Display Toggle -->
                                                                            <div class="space-y-2">
                                                                                <label class="flex items-center space-x-2">
                                                                                    <input type="checkbox" id="showFractions" class="text-cyan-600 focus:ring-slate-200 rounded">
                                                                                    <span class="text-sm font-medium text-slate-700">Show fractional cups (e.g., 1/4, 1/2, 3/4)</span>
                                                                                </label>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Volume in US Cups</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Kitchen measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">cups</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Fractional Display -->
                                                                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200" id="fractionDisplay" style="display: none;">
                                                                                <h4 class="text-sm font-semibold text-yellow-800 mb-2 text-center">Fractional Representation</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-xl font-bold text-yellow-700" id="fractionOutput">--</div>
                                                                                    <div class="text-xs text-yellow-600 mt-1">Common cooking fraction</div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Cup Standards Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">US Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="usCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Metric Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="metricCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Imperial Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="imperialCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Related Kitchen Measurements -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-3 text-center">Related Kitchen Measurements</h4>
                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs text-slate-500">
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="tablespoonsOutput">-- tbsp</div>
                                                                                        <div>Tablespoons</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="teaspoonsOutput">-- tsp</div>
                                                                                        <div>Teaspoons</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="pintsOutput">-- pt</div>
                                                                                        <div>Pints</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="mlOutput">-- mL</div>
                                                                                        <div>Milliliters</div>
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
                                                                                                    Common Recipe Measurements
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-slate-700 hover:text-cyan-700 rounded-lg transition-colors" data-value="2" data-direction="oz-to-cups">2 fl oz</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-slate-700 hover:text-cyan-700 rounded-lg transition-colors" data-value="4" data-direction="oz-to-cups">4 fl oz</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-slate-700 hover:text-cyan-700 rounded-lg transition-colors" data-value="8" data-direction="oz-to-cups">8 fl oz</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-slate-700 hover:text-cyan-700 rounded-lg transition-colors" data-value="16" data-direction="oz-to-cups">16 fl oz</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Kitchen Volume Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 US cup = 8 fl oz</div>
                                                        <div>• 1 metric cup = 8.45 fl oz</div>
                                                        <div>• 1/4 cup = 2 fl oz</div>
                                                        <div>• 1/2 cup = 4 fl oz</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Ounces to Cups Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Kitchen Measurements</h4>
                                    <p>Converting fluid ounces to cups is essential for cooking and baking. Different countries use different cup standards, so it's important to know which system your recipe uses for accurate results.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Recipe Applications</h4>
                                    <p>Perfect for scaling recipes, converting between measurement systems, and understanding international cookbooks. Especially useful when your measuring tools don't match the recipe's units.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cooking Tip:</strong> When in doubt, US measurements are most common in American recipes, while metric is standard in most other countries!
                                </p>
                            </div>
                        </div>

                        <!-- Common Recipe Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Recipe Conversions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Recipe</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="4">4 fl oz</div>
                                    <div class="text-[11px] text-slate-500">1/2 cup</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Standard Cup</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="8">8 fl oz</div>
                                    <div class="text-[11px] text-slate-500">1 cup</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Recipe</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="16">16 fl oz</div>
                                    <div class="text-[11px] text-slate-500">2 cups</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Batch Cooking</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="32">32 fl oz</div>
                                    <div class="text-[11px] text-slate-500">4 cups</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const conversionHint = document.getElementById('conversionHint');
                        const directionRadios = document.getElementsByName('direction');
                        const cupTypeRadios = document.getElementsByName('cupType');
                        const showFractions = document.getElementById('showFractions');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const fractionDisplay = document.getElementById('fractionDisplay');
                        const fractionOutput = document.getElementById('fractionOutput');
                        const usCupsOutput = document.getElementById('usCupsOutput');
                        const metricCupsOutput = document.getElementById('metricCupsOutput');
                        const imperialCupsOutput = document.getElementById('imperialCupsOutput');
                        const tablespoonsOutput = document.getElementById('tablespoonsOutput');
                        const teaspoonsOutput = document.getElementById('teaspoonsOutput');
                        const pintsOutput = document.getElementById('pintsOutput');
                        const mlOutput = document.getElementById('mlOutput');

                        // Conversion constants (fl oz per cup)
                        const cupConversions = {
                            us: 8,
                            metric: 8.4535,
                            imperial: 9.6076
                        };

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

                        function getCupConversion() {
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;
                            return cupConversions[cupType];
                        }

                        function findBestFraction(decimal, maxDenominator = 16) {
                            let bestNum = 1, bestDen = 1, bestError = Math.abs(decimal - 1);
                            
                            for (let den = 1; den <= maxDenominator; den++) {
                                let num = Math.round(decimal * den);
                                let error = Math.abs(decimal - num / den);
                                if (error < bestError) {
                                    bestError = error;
                                    bestNum = num;
                                    bestDen = den;
                                }
                            }
                            
                            if (bestNum === bestDen) return "1 cup";
                            if (bestNum > bestDen) {
                                let whole = Math.floor(bestNum / bestDen);
                                let remainder = bestNum % bestDen;
                                if (remainder === 0) return `${whole} cups`;
                                return `${whole} ${remainder}/${bestDen} cups`;
                            }
                            return `${bestNum}/${bestDen} cup`;
                        }

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;
                            const conversionRate = getCupConversion();

                            if (!isNaN(value) && value >= 0) {
                                let flOz, cups;

                                if (direction === 'oz-to-cups') {
                                    flOz = value;
                                    cups = value / conversionRate;
                                    
                                    const cupTypeText = cupType === 'us' ? 'US Cups' : 
                                                      cupType === 'metric' ? 'Metric Cups' : 'Imperial Cups';
                                    
                                    resultTitle.textContent = `Volume in ${cupTypeText}`;
                                    resultDescription.textContent = 'Kitchen measurement';
                                    output.textContent = formatNumber(cups);
                                    unitDisplay.textContent = 'cups';
                                } else {
                                    cups = value;
                                    flOz = value * conversionRate;
                                    
                                    resultTitle.textContent = 'Volume in Fluid Ounces';
                                    resultDescription.textContent = 'Kitchen measurement';
                                    output.textContent = formatNumber(flOz);
                                    unitDisplay.textContent = 'fl oz';
                                }

                                // Always calculate all cup types and other conversions based on fl oz
                                const usCups = flOz / cupConversions.us;
                                const metricCups = flOz / cupConversions.metric;
                                const imperialCups = flOz / cupConversions.imperial;
                                const tablespoons = flOz * 2;
                                const teaspoons = flOz * 6;
                                const pints = usCups / 2;
                                const ml = flOz * 29.5735;

                                usCupsOutput.textContent = formatNumber(usCups) + ' cups';
                                metricCupsOutput.textContent = formatNumber(metricCups) + ' cups';
                                imperialCupsOutput.textContent = formatNumber(imperialCups) + ' cups';
                                tablespoonsOutput.textContent = formatNumber(tablespoons) + ' tbsp';
                                teaspoonsOutput.textContent = formatNumber(teaspoons) + ' tsp';
                                pintsOutput.textContent = formatNumber(pints) + ' pt';
                                mlOutput.textContent = formatNumber(ml) + ' mL';

                                // Fraction display
                                if (showFractions.checked && direction === 'oz-to-cups') {
                                    const fraction = findBestFraction(cups);
                                    fractionOutput.textContent = fraction;
                                    fractionDisplay.style.display = 'block';
                                } else {
                                    fractionDisplay.style.display = 'none';
                                }
                            } else {
                                output.textContent = "--";
                                usCupsOutput.textContent = "--";
                                metricCupsOutput.textContent = "--";
                                imperialCupsOutput.textContent = "--";
                                tablespoonsOutput.textContent = "--";
                                teaspoonsOutput.textContent = "--";
                                pintsOutput.textContent = "--";
                                mlOutput.textContent = "--";
                                fractionDisplay.style.display = 'none';
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;

                            if (direction === 'oz-to-cups') {
                                inputLabel.textContent = 'Enter Volume in Fluid Ounces';
                                inputValue.placeholder = 'Enter volume (e.g., 16)';
                                inputUnit.textContent = 'fl oz';
                                
                                const rate = cupConversions[cupType];
                                const cupName = cupType === 'us' ? 'US cup' : 
                                               cupType === 'metric' ? 'metric cup' : 'Imperial cup';
                                conversionHint.textContent = `1 ${cupName} = ${rate} fl oz`;
                            } else {
                                const cupTypeText = cupType === 'us' ? 'US Cups' : 
                                                  cupType === 'metric' ? 'Metric Cups' : 'Imperial Cups';
                                
                                inputLabel.textContent = `Enter Volume in ${cupTypeText}`;
                                inputValue.placeholder = `Enter ${cupTypeText.toLowerCase()} (e.g., 2)`;
                                inputUnit.textContent = 'cups';
                                
                                const rate = cupConversions[cupType];
                                const cupName = cupType === 'us' ? 'US cup' : 
                                               cupType === 'metric' ? 'metric cup' : 'Imperial cup';
                                conversionHint.textContent = `1 ${cupName} = ${rate} fl oz`;
                            }
                        }

                        function clearInput() {
                            inputValue.value = '';
                            convert();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        
                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        cupTypeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        showFractions.addEventListener('change', convert);
                        clearButton.addEventListener('click', clearInput);

                        // Recipe preset buttons
                        const recipePresets = document.querySelectorAll('.recipe-preset');
                        recipePresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                // Set direction
                                document.querySelector(`input[value="${direction}"]`).checked = true;
                                updateLabels();
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                recipePresets.forEach(btn => btn.classList.remove('bg-cyan-100', 'text-cyan-700'));
                                recipePresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-cyan-100', 'text-cyan-700');
                            });
                        });

                        // Add clickable functionality to example volumes
                        const exampleVolumes = document.querySelectorAll('[data-volume]');
                        exampleVolumes.forEach(element => {
                            element.addEventListener('click', function() {
                                const volumeValue = this.getAttribute('data-volume');
                                
                                // Set to oz-to-cups mode
                                document.querySelector('input[value="oz-to-cups"]').checked = true;
                                document.querySelector('input[value="us"]').checked = true;
                                updateLabels();
                                
                                inputValue.value = volumeValue;
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        updateLabels();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                // Toggle direction
                                const currentDirection = document.querySelector('input[name="direction"]:checked').value;
                                const newDirection = currentDirection === 'oz-to-cups' ? 'cups-to-oz' : 'oz-to-cups';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                convert();
                            } else if (e.ctrlKey && e.key === 'f') {
                                e.preventDefault();
                                // Toggle fractions
                                showFractions.checked = !showFractions.checked;
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
